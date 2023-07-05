<template>
    <section v-if="showComponent">
        <authentication
            :login_route="login_route"
        >
        </authentication>
        <registration
            :register_route="register_route"
        >
        </registration>
    </section>
</template>

<script>
export default {
    name: "Login",
    props: ['login_route', 'register_route'],
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
