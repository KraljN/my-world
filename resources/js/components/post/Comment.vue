<template>
    <section>
        <div class="vcard rounded">
            <img :src="public_path + '/assets/img/' + comment.user.image.src" :alt="comment.user.image.alt"/>
        </div>
        <div class="comment-body">
            <span class="d-flex justify-content-between"><h3 class="responsive-09-em" >{{comment.user.first_name}} {{comment.user.last_name}} ({{comment.user.username}})</h3>
<!--                If logged user posted this comment, he can remove it-->
<!--                If there is no logged-in user auth_user.id will throw error (can't read id from null)-->
                <button v-if="comment.user.id == (auth_user != undefined ? auth_user.id : null) " @click="$modal.show('confirm ' + comment.id)" class="btn">
                    <font-awesome-icon class="text-danger" :icon="['fas', 'trash']" />
                </button></span>
            <div class="meta">{{comment.created_at | formatDate}}</div>
            <p>{{comment.text}}</p>
            <rating
                :ratings="comment.ratings"
                :auth_user="auth_user"
                :obj="comment"
                type="comment"
                :public_path="public_path"
            >
            </rating>
        </div>
        <modal :scrollable="true" height="auto" width="60%" :clickToClose="true" :name="'confirm ' + comment.id">
            <section class="d-flex p-3 h-100 justify-content-center align-items-center">
                <div class="text-center">
                    <font-awesome-icon class="text-danger display-3 mb-2" :icon="['fas', 'triangle-exclamation']" />
                    <h6 class="font-weight-normal responsive-09-em">Are you sure you want to remove this comment?</h6>
                    <div class="mt-4 d-flex align-items-center rounded justify-content-center">
                        <button @click="removeComment" :class="{ btn: true, 'btn-primary': true, 'me-2': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}">Remove</button>
                        <button :class="{ btn: true, 'btn-danger': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}" @click.prevent="$modal.hide('confirm ' + comment.id)">Cancel</button>
                    </div>
                </div>
            </section>
        </modal>
    </section>
</template>

<script>
export default {
    name: "Comment",
    props: ['public_path', 'comment', 'auth_user'],
    methods: {
        removeComment(){
            axios.delete(this.public_path + '/comments/' + this.comment.id)
                .then(response => {
                    //Show message in parent component because this one will be deleted
                    this.$root.$emit('deletedComment', this.comment.id)
                    this.$modal.hide('confirm ' + this.comment.id)
                    //Destroy this component after deleting it
                    setTimeout(function(scope){
                        scope.$destroy
                        scope.$el.parentNode.removeChild(scope.$el);
                    }, 100, this)
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }
}
</script>

<style scoped>

</style>
