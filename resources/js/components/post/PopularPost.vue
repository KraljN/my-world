<template>
    <div class="sidebar-box">
        <h3 class="heading">Popular Posts</h3>
        <div class="post-entry-sidebar">
            <ul>
                <li v-for="post in posts">
                    <a class="text-decoration-none" :href=" public_path + '/posts/' + post.id">
                        <img :src="public_path + '/assets/img/' + post.image.src" :alt="post.image.alt" class="me-4"/>
                        <div class="text">
                            <h4 class="responsive-08-em">{{post.title}}</h4>
                            <div class="post-meta">
                                <span class="me-2">{{post.created_at | formatDate}} </span>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>

    </div>
</template>

<script>
import {public_path} from "../../constants";

export default {
    name: "PopularPost",
    props: ["posts"],
    data() {
        return {
            public_path: public_path
        }
    },
}
</script>

<style scoped>

</style>
