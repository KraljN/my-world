<template>
    <section
    v-if="showComponent"
    >
        <h1 class="mb-2 fw-normal">Latest Posts</h1>
        <div class="row blog-entries d-flex">
            <home-post
            v-for="post in posts.data"
            :post="post"
            >
            </home-post>
        </div>
    </section>
</template>

<script>
export default {

    name: "Home",
    props: [
        'posts'
    ],
    data() {
        return {
            showComponent: true
        }
    },
    created() {
        //If search is turned on, we should disable this component
        this.$root.$on('displaySearch', (data) => {
            this.showComponent =  !data.display
        })
    }
}
</script>

<style scoped>

</style>
