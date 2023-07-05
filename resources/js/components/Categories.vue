<template>
    <div class="sidebar-box">
        <h3 class="heading">Categories</h3>
        <ul class="categories">
            <li v-for="category in categoriesWithPosts"><a class="text-decoration-none aside-list" :href="public_path + '/categories/' + category.id">{{category.name}} <span>({{category.count}})</span></a></li>
        </ul>
    </div>
</template>

<script>
import {public_path} from "../constants";
export default {
    name: "Categories",
    props: [
        'categories',
        'category_route'
    ],
    computed:{
        categoriesWithPosts(){
            return this.categories_data.filter(category => category.posts.length > 0)
        }
    },
    data() {
        return {
            public_path : public_path,
            categories_data: this.categories
        }
    },
    created(){
        this.$root.$on('categoriesChanged', () => {
            axios.get(this.category_route, {
                params: {
                    exceptPagination: true
                }
            }).then(response => {
                this.categories_data = response.data.obj
            })
        })
    }
}
</script>

<style scoped>

</style>
