<template>
    <div>
        <div class="row mb-2 mt-4">
            <div class="container">
                <h1 class="fw-normal">Register</h1>
            </div>
        </div>
        <form @submit.prevent="checkForm" name="registration" action="#" method="post">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="first_name">First Name</label>
                    <span class="text-danger">*</span>
                    <input type="text" v-model="form.first_name" id="first_name" :class=" {'form-control': true, 'required': true, 'border-danger' : !definition.first_name.valid }"/>
                    <span v-if="!definition.first_name.valid"
                          class="text-danger fw-bold  validation-error responsive-06-em">{{ definition.first_name.error_message }}</span>
                </div>
                <div class="col-md-6 form-group">
                    <label for="last_name">Last Name</label>
                    <span class="text-danger">*</span>
                    <input type="text" v-model="form.last_name" id="last_name" :class=" {'form-control': true, 'required': true, 'border-danger' : !definition.last_name.valid }"/>
                    <span v-if="!definition.last_name.valid"
                          class="text-danger fw-bold  validation-error responsive-06-em">{{ definition.last_name.error_message }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="username">Username</label>
                    <span class="text-danger">*</span>
                    <input type="text" v-model="form.username" id="username" :class=" {'form-control': true, 'required': true, 'border-danger' : !definition.username.valid }"/>
                    <span v-if="!definition.username.valid"
                          class="text-danger fw-bold  validation-error responsive-06-em">{{ definition.username.error_message }}</span>
                </div>
                <div class="col-md-6 form-group">
                    <label for="password">Password</label>
                    <span class="text-danger">*</span>
                    <input type="password" v-model="form.password" id="password" :class=" {'form-control': true, 'required': true, 'border-danger' : !definition.password.valid }"/>
                    <span v-if="!definition.password.valid"
                          class="text-danger fw-bold  validation-error responsive-06-em">{{ definition.password.error_message }}</span>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label for="email">Email</label>
                <span class="text-danger">*</span>
                <input type="email" id="email" v-model="form.email" :class=" {'form-control': true, 'required': true, 'border-danger' : !definition.email.valid }"/>
                <span v-if="!definition.email.valid"
                      class="text-danger fw-bold  validation-error responsive-06-em">{{ definition.email.error_message }}</span>
            </div>
            <div class="row mt-3 mb-3">
                <div class="col-6 col-sm-3 col-lg-1 form-group">
                    <input type="submit" value="Register"
                           :class="{ btn: true, 'btn-primary': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}"/>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: "Registration",
    props: ["register_route"],
    data() {
        return {
            form: {
                first_name: '',
                last_name: '',
                username: '',
                password: '',
                email: ''
            },
            definition: {
                first_name: {
                    valid: true,
                    regex: /^([A-ZĐŠĆŽČ][a-zšđćžč]{1,14})(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/,
                    error_message: "Please enter first name in format: Nikola"
                },
                last_name: {
                    valid: true,
                    regex: /^([A-ZĐŠĆŽČ][a-zšđćžč]{1,14})(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/,
                    error_message: "Please enter first name in format: Kralj"
                },
                email: {
                    valid: true,
                    regex: /^([a-z0-9]{2,15}@[a-z]{2,10}\.[a-z]{2,5})(\.[a-z]{2,5})?$/,
                    error_message: "Please enter first name in format: nikola@gmail.com"
                },
                username: {
                    valid: true,
                    regex: /[a-z0-9]{4,15}/,
                    error_message: "Username should contain only letters and numbers, between 4 and 15 characters"
                },
                password: {
                    valid: true,
                    regex: /[a-z0-9\W@#\s]{4,15}/,
                    error_message: "Please enter password between 4 and 15 characters"
                }
            },
        }
    },
    methods: {
        checkForm() {
            //Validate fields for registration
            this.validateFields()

            //Check if all fields are validated
            const areTruthy = this.checkValidatedFields()

            if (areTruthy) {
                this.makeRegistrationRequest()
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
        makeRegistrationRequest() {
            axios.post(this.register_route, this.form)
                .then(response => {
                    this.setFieldsAsValid()
                    this.$notify({
                        group: 'foo',
                        type: response.type,
                        title: 'Successful Registration',
                        text: response.message,
                        duration: 5000
                    });
                })
                .catch(error => {
                    if(error.response.status == 500){
                        this.$notify({
                            group: 'foo',
                            type: error.response.data.type,
                            title: error.response.data.message,
                            duration: 5000
                        });
                        this.setFieldsAsValid()
                    }
                    else if(error.response.status == 422 && error.response.data.errors != undefined){
                        //To reset previous errors
                        this.setFieldsAsValid()
                        this.showBackendValidationErrors(error.response.data.errors)
                    }
                });
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
    },
    created() {
        // setTimeout(function(scope){
        //     console.log('Prosla sekunda')
        //     scope.$notify({
        //         group: 'foo',
        //         type: 'success',
        //         title: 'Successful Registration',
        //         text: 'Account successfully created! Please check your email for account activation.',
        //         duration: 5000
        //     });
        // }, 1000, this)
    }
}
</script>

<style scoped>

</style>
