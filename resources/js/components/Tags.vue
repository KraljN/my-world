<template>
    <div class="sidebar-box">
        <h3 class="heading">Tags</h3>
        <ul class="tags ">
            <li v-for="tag in tagsWithPosts"><a class="text-decoration-none aside-list" :href="public_path + '/tags/' + tag.id">{{tag.name}}</a></li>
        </ul>
    </div>
</template>

<script>
import {public_path} from "../constants";
export default {
    name: "Tags",
    props: [
        'tags',
        'tag_route'
    ],
    computed:{
        tagsWithPosts(){
            return this.tags_data.filter(tag => tag.posts.length > 0)
        }
    },
    data() {
        return {
            public_path : public_path,
            tags_data: this.tags
        }
    },
    created() {
        this.$root.$on('tagsChanged', () => {
            axios.get(this.tag_route, {
                params: {
                    exceptPagination: true
                }
            }).then(response => {
                this.menu_data = response.data.obj
            })
        })
        axios.get(this.tag_route, {
            params: {
                exceptPagination: true
            }
        }).then(response => {
            this.tags_data = response.data.obj
        })
    }
}
</script>

<style scoped>

</style>
