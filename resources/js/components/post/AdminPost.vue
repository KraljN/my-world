<template>
    <section
        v-if="showComponent"
    >
        <div class="row mb-4">
            <div class="col-7 col-sm-8">
                <h1 class="fw-normal mb-2">All <span v-if="roles.includes('writer')">Your</span> Posts</h1>
            </div>
            <div class="col-5 col-sm-4 d-flex justify-content-center align-items-center">
                <a :href="create_post_route">
                    <button :class="{ btn: true, 'btn-success': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}">
                        Add New Post
                    </button>
                </a>
            </div>
        </div>
        <post-horizontal
            v-for="post in posts.data"
            :public_path = public_path
            :post="post"
            :roles="roles"
            :auth_user="auth_user"
        >
        </post-horizontal>

        <div v-if="posts.data != undefined  && posts.data.length == 0" class="alert alert-primary validation-error" role="alert">
            There are currently no posts!
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
import {public_path} from "../../constants";
import Pagination from '../Pagination.vue'
export default {
    name: "AdminPosts",
    components: {
        'pagination': Pagination
    },
    props:[ 'roles', 'auth_user', 'create_post_route', 'all_posts_route'],
    data() {
        return {
            showComponent: true,
            public_path: public_path,
            posts: {}
        }
    },
    methods: {
        getResult(page = 1){
            axios.get(this.all_posts_route, {
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
    created() {
        this.getResult()
        //If search is turned on, we should disable this component
        this.$root.$on('displaySearch', (data) => {
            this.showComponent =  !data.display
        })
        this.$root.$on('deletedPost', () => {
            this.getResult()
            this.$notify({
                group: 'foo',
                type: 'success',
                title: 'Successfully deleted post.',
                duration: 5000
            });
        })
    }
}
</script>

<style scoped>

</style>
