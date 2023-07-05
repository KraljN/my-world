<template>
    <div class="d-flex">
        <div class="me-2">
            <button v-if="auth_user" @click="reacted('like')" :class="['btn', window.innerWidth < 500 ? 'btn-sm' : 'btn-lg', liked ? 'liked' : 'like']">
                <font-awesome-icon :icon="['fas', 'heart']" />
            </button>
            <span class="text-success" v-else>
                <font-awesome-icon :icon="['fas', 'heart']" />
            </span>
            <span>{{likes}}</span>
        </div>
        <div>
            <button v-if="auth_user" @click="reacted('dislike')"   :class="['btn',  window.innerWidth < 500 ? 'btn-sm' : 'btn-lg', disliked ? 'disliked' : 'dislike']">
                <font-awesome-icon :icon="['fas', 'heart-broken']" />
            </button>
            <span class="text-danger"  v-else>
                <font-awesome-icon :icon="['fas', 'heart-broken']" />
            </span>
            <span>{{dislikes}}</span>
        </div>
    </div>
</template>

<script>
import {rating} from '../constants'
export default {
    name: "Rating",
    props: ['ratings', 'auth_user', 'type', 'public_path','obj'],
    data(){
        return{
            rating_const : rating,
            ratings_data: this.ratings
        }
    },
    computed: {
        //Number of likes
        likes(){
            let array = this.ratings_data.filter(value => value.index == this.rating_const.liked);
            return array.length
        },
        //Number of dislikes
        dislikes(){
            let array = this.ratings_data.filter(value => value.index == this.rating_const.disliked);
            return array.length
        },
        liked(){
            return this.rated('like')
        },
        disliked(){
            return this.rated('dislike')
        }
    },
    methods: {
        //Determines if user liked / disliked
        rated(action){
            if(!this.auth_user){
                return false
            }
            const indexToCheck = action == 'like' ? this.rating_const.liked : this.rating_const.disliked
            return this.ratings_data.find(rating => rating.user_id == this.auth_user.id && rating.index == indexToCheck);
        },
        reacted(reaction){
            axios.get(this.public_path + '/rate/' + this.type + '/' + this.obj.id + '/' + reaction)
                .then(response => {
                    this.ratings_data = response.data.obj
                })
                .catch(error => {
                    this.$notify({
                        group: 'foo',
                        type: error.response.data.type,
                        title: error.response.data.message,
                        duration: 5000
                    });
                });
        }
    }
}
</script>

<style scoped>

</style>
