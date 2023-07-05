<template>
    <section v-if="showSearch">
        <h1 class="mb-3 fw-normal responsive-08-em">{{ type | capitalize}}: {{type == 'search' ? value : object.name }}</h1>
        <post-horizontal
            v-for="post in posts.data"
            :public_path = public_path
            :post="post"
            :query="value"
            :roles="roles"
            :auth_user="auth_user"
        >
        </post-horizontal>

        <div v-if="posts.data != undefined  && posts.data.length == 0" class="alert alert-primary validation-error" role="alert">
            No results for given search!
        </div>

        <pagination
            class="mb-0 mb-sm-4"
            v-if="posts.last_page > 1"
            :current="posts.current_page"
            :total="posts.total"
            :per-page="posts.per_page"
            @page-changed="getResult"
        >
        </pagination>
    </section>
</template>

<script>
import {public_path} from "../constants";
import Pagination from './Pagination.vue'
export default {
    name: "HorizontalPostList",
    components: {
        'pagination': Pagination
    },
    props: {
        type:{
            type: String,
            default: 'search'
        },
        object:{
            required: false
        },
        auth_user:{
            type: Object
        },
        roles:{
            type: Array,
            default: () => {return []}
        }
    },
    data() {
        return {
            showSearch: this.type == 'search' ? false : true,
            value: '',
            public_path: public_path,
            posts: []
        }
    },
    methods: {
        getResult(page = 1){
            //If it is type categories or tags we will add id in route for example /tags/1
            let id = this.type != 'search' ? '/' + this.object.id : ''
            axios.get(public_path + '/' + this.type + id, {
                params : { query: this.value, page }
            })
                .then(response => {
                    this.posts = response.data.obj
                })
                .catch(error => {
                    console.error(error);
                });
        }

    },
    created(){
        if(this.showSearch){
            this.getResult()
        }
        // this.getResult()
        this.$root.$on('displaySearch', (data) => {
            //When this component is type search, we will show component if we detect this event, otherwise we will hide component of other type so search can be shown
            this.showSearch =  this.type =='search' ? data.display : !data.display
            this.value = data.value
            this.getResult()
        })
    }
}
</script>

<style scoped>

</style>
