<template>
    <section
        v-if="showComponent"
    >
        <h1 class="mb-2 fw-normal">Edit Tags and Categories</h1>
        <one-column-object-crud
            title="Tags"
            object="tags"
            :regexp="/^([A-ZĐŠĆŽČ][a-zšđćžč]{1,14})(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/"
            error_message="Please enter Tag name in format: Adventure"
        >
        </one-column-object-crud>
        <one-column-object-crud
            title="Categories"
            object="categories"
            :regexp="/^([A-ZĐŠĆŽČ][a-zšđćžč]{1,14})(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/"
            error_message="Please enter Category name in format: Kids"
        >
        </one-column-object-crud>
    </section>
</template>

<script>
export default {
    name: "AdminTagsCategories",
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
        this.$root.$on('tagsDeleted', () => {
            this.$notify({
                group: 'foo',
                type: 'success',
                title: 'Successfully deleted tag.',
                duration: 5000
            });
        })
        this.$root.$on('categoriesDeleted', () => {
            this.$notify({
                group: 'foo',
                type: 'success',
                title: 'Successfully deleted category.',
                duration: 5000
            });
        })
    }
}
</script>

<style scoped>

</style>
