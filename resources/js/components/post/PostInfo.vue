<template>
        <div class="post-meta mb-0">
                    <span class="author">
                        <img :src="public_path + '/assets/img/' + post.author.image.src" class="img-fluid rounded-circle" :alt="post.author.image.alt"/>
                        {{post.author.username}}
                    </span>•
            <span class="me-2">{{ post.created_at | formatDate}} </span> •
            <font-awesome-icon :icon="['fas', 'comments']" /> {{post.comments.length}}
        </div>
</template>

<script>
export default {
    name: "PostInfo",
    props: ['post', 'public_path']
}
</script>

<style scoped>

</style>
