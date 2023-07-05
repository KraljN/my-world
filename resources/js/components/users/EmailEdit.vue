<template>
    <section>
        <div class="sidebar-box mt-4 mb-0">
            <h3 class="heading mb-3">Email</h3>
        </div>
        <form  @submit.prevent="changeMail" action="#" name="emailEdit" method="put">
            <div class="row d-flex align-items-center">
                <div class="col-md-6 form-group">
                    <input type="email" v-model="form.email" id="first_name" :class=" {'form-control': true, 'required': true, 'border-danger' : !definition.email.valid }"/>
                    <span v-if="!definition.email.valid"
                          class="text-danger fw-bold  validation-error">{{ definition.email.error_message }}</span>
                </div>
                <div class="col-md-6 mt-2 mt-md-0">
                    <div class="alert alert-info validation-error" role="alert">
                        Verification required after changing email address.
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-sm-3 col-lg-1 d-flex form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="submit" value="Save"
                                   :class="{ btn: true, 'btn-primary': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}"/>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <input @click.prevent="resendVerficationMail"  type="submit" value="Resend Verification Mail"
                                    :class="{ btn: true, 'btn-primary': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}"/>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>

<script>
export default {
    name: "EmailEdit",
    props:['user', 'public_path', 'singed_route_for_resend_mail'],
    data(){
        return {
            form: {
                email: this.user.email,
            },
            definition: {
                email: {
                    valid: true,
                    regex: /^([a-z0-9]{2,15}@[a-z]{2,10}\.[a-z]{2,5})(\.[a-z]{2,5})?$/,
                    error_message: "Please enter first name in format: nikola@gmail.com"
                },
            }
        }
    },
    methods: {
        changeMail(){
            if (!this.definition.email.regex.test(this.form.email)) {
                this.definition.email.valid = false;
            } else {
                this.definition.email.valid = true;
            }

            //this.definition.email.valid
            if(true){
                axios.put(this.public_path + '/email/' + this.user.id, this.form)
                    .then(response => {
                        this.definition.email.valid = true
                        this.$notify({
                            group: 'foo',
                            type: response.data.type,
                            title: response.data.message,
                            duration: 5000
                        });
                    })
                    .catch(error => {
                        if(error.response.status == 422 && error.response.data.errors != undefined){
                            this.definition.email.error_message = error.response.data.errors.email.join(' ')
                            this.definition.email.valid = false
                        }
                        else{
                            this.$notify({
                                group: 'foo',
                                type: error.response.data.type,
                                title: error.response.data.message,
                                duration: 5000
                            });
                        }
                    })
            }
        },
        resendVerficationMail(){
            axios.post(this.singed_route_for_resend_mail).then((response) => {
                this.$notify({
                    group: 'foo',
                    type: response.data.type,
                    title: response.data.message,
                    duration: 5000
                });
            })
        }
    }
}
</script>

<style scoped>

</style>
