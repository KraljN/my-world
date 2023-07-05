<template>
    <div class="col-sm-6 mb-4">
        <a :href=" public_path + '/posts/' + post.id" class="blog-entry element-animated text-decoration-none mb-0 h-100 d-flex flex-column justify-content-between">
            <div>
                <img class="small-post-images" :src="'assets/img/' + post.image.src" :alt="post.image.src"/>
            </div>
            <div class="blog-content-body h-100">
                <div class="mb-2">
                    <post-info
                        :post="post"
                        :public_path="public_path">
                    </post-info>
                </div>
                <h2>{{post.title}}</h2>
            </div>
        </a>
    </div>
</template>

<script>
import {public_path} from "../../constants";
export default {
    name: "HomePost",
    props: [
        'post'
    ],
    data() {
        return {
            public_path: public_path
        }
    }
}
</script>
