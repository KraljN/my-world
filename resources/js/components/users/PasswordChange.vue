<template>
    <section>
        <div class="sidebar-box mt-4 mb-0">
            <h3 class="heading mb-3">Password Change</h3>
        </div>
        <form @submit.prevent="checkForm" name="changePassword" action="#" method="put">
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="password">Current Password</label>
                    <span class="text-danger">*</span>
                    <input type="password" v-model="form.old_password" id="old_password" :class=" {'form-control': true, 'required': true, 'border-danger' : !definition.old_password.valid }"/>
                    <span v-if="!definition.old_password.valid"
                          class="text-danger fw-bold  validation-error">{{ definition.old_password.error_message }}</span>
                </div>
                <div class="col-md-4 form-group">
                    <label for="password">New Password</label>
                    <span class="text-danger">*</span>
                    <input type="password" v-model="form.new_password" id="old_password" :class=" {'form-control': true, 'required': true, 'border-danger' : !definition.new_password.valid }"/>
                    <span v-if="!definition.new_password.valid"
                          class="text-danger fw-bold  validation-error ">{{ definition.new_password.error_message }}</span>
                </div>
                <div class="col-md-4 form-group">
                    <label for="password">Confirm Password</label>
                    <span class="text-danger">*</span>
                    <input type="password" v-model="form.password_confirm" id="old_password" :class=" {'form-control': true, 'required': true, 'border-danger' : !definition.password_confirm.valid }"/>
                    <span v-if="!definition.password_confirm.valid"
                          class="text-danger fw-bold  validation-error">{{ definition.password_confirm.error_message }}</span>
                </div>
            </div>
            <div class="row mt-3 mb-3">
                <div class="col-6 col-sm-3 col-lg-1 form-group">
                    <input type="submit" value="Save"
                           :class="{ btn: true, 'responsive-07-em': true, 'btn-primary': true, 'btn-sm': window.innerWidth < 500}"/>
                </div>
            </div>
        </form>
    </section>
</template>

<script>
export default {
    name: "PasswordChange",
    props:['user', 'public_path'],
    data() {
        return {
            form: {
                old_password: '',
                new_password: '',
                password_confirm: ''
            },
            definition: {
                old_password: {
                    valid: true,
                    regex: /[a-z0-9\W@#\s]{4,15}/,
                    error_message: "Please enter password between 4 and 15 characters"
                },
                new_password: {
                    valid: true,
                    regex: /[a-z0-9\W@#\s]{4,15}/,
                    error_message: "Please enter password between 4 and 15 characters"
                },
                password_confirm: {
                    valid: true,
                    regex: /[a-z0-9\W@#\s]{4,15}/,
                    error_message: "Please enter password between 4 and 15 characters"
                },
            },
        }
    },
    methods: {
        checkForm(){
            //Validate fields for registration
            this.validateFields()

            //Check if all fields are validated
            const areTruthy = this.checkValidatedFields()

            if (areTruthy) {
                this.changePassword()
            }
        },
        validateFields() {
            for (let fieldName in this.form) {
                if (!this.definition[fieldName].regex.test(this.form[fieldName])) {
                    this.definition[fieldName].valid = false;
                } else {
                    this.definition[fieldName].valid = true;
                }
            }
        },
        checkValidatedFields() {
            const validArray = Object.values(this.definition).map(property => property.valid);

            return validArray.every(
                value => value
            );
        },
        changePassword(){
            if(this.form.new_password != this.form.password_confirm){
                this.definition.new_password.valid = false
                this.definition.new_password.error_message = "New passwords doesn't match"
                this.definition.password_confirm.valid = false
                this.definition.password_confirm.error_message = "New passwords doesn't match"
                return false
            }
            else{
                this.definition.new_password.valid = true
                this.definition.password_confirm.valid = true
            }

            axios.put(this.public_path + '/password/' + this.user.id, this.form)
                .then(response => {
                    // this.definition.email.valid = true
                    this.setFieldsAsValid()

                    this.$notify({
                        group: 'foo',
                        type: 'success',
                        title: 'Password successfully changed.',
                        duration: 5000
                    });
                })
                .catch(error => {
                    if(error.response.status == 422 && error.response.data.errors != undefined){
                        //To reset previous errors
                        this.setFieldsAsValid()
                        this.showBackendValidationErrors(error.response.data.errors)
                    }
                    else{
                        this.$notify({
                            group: 'foo',
                            type: error.response.data.type,
                            title: error.response.data.message,
                            duration: 5000
                        });
                        this.setFieldsAsValid()
                    }
                })
        },
        showBackendValidationErrors(errors){
            for(let property in errors){
                this.definition[property].error_message = errors[property].join(' ')
                this.definition[property].valid = false
            }
        },
        setFieldsAsValid(){
            for(let property in this.definition){
                this.definition[property].valid = true
            }
        }
    }
}
</script>

<style scoped>

</style>
