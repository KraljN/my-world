<template>
    <section
        v-if="showComponent"
    >
        <div class="row mb-2 mt-4">
            <div class="container">
                <h1 class="fw-normal">Edit Profile</h1>
            </div>
        </div>
        <user-basic-info-edit
            :user="user"
            :public_path="public_path"
            :all_roles="all_roles"
            :is_admin="roles.includes('admin')"
        >
        </user-basic-info-edit>
        <email-edit
            :user="user"
            :public_path="public_path"
            :singed_route_for_resend_mail="singed_route_for_resend_mail"
        >
        </email-edit>
        <password-change
            :user="user"
            :public_path="public_path"
        >
        </password-change>
    </section>
</template>

<script>
import {public_path} from "../../constants";

export default {
    name: "EditUser",
    props: ['user','message', 'roles', 'all_roles', 'singed_route_for_resend_mail'],
    data(){
        return {
            public_path: public_path,
            showComponent: true
        }
    },
    created() {
        if(this.message) {
            setTimeout(function(scope){
                scope.$notify({
                    group: 'foo',
                    type: 'success',
                    title: scope.message,
                    duration: 5000
                })
            }, 500, this)
        }

        //If search is turned on, we should disable this component
        this.$root.$on('displaySearch', (data) => {
            this.showComponent =  !data.display
        })

    },
    methods: {

    }
}
</script>

<style scoped>

</style>
