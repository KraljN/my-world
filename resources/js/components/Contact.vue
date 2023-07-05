<template>
    <section
        v-if="showComponent"
    >
        <div class="row mb-4">
            <div class="col-md-6">
                <h1>Contact Us</h1>
            </div>
        </div>
        <div class="row blog-entries">
            <div class="col-12 main-content">

                <form @submit.prevent="checkForm" name="contact" action="#" method="post">
                    <div class="row">
                        <div class="col-md-12 mt-2 form-group">
                            <label for="name">Name</label>
                            <input v-model="form.name" type="text" id="name" :class=" {'form-control': true, 'border-danger' : !definition.name.valid }"/>
                            <span v-if="!definition.name.valid"
                                  class="text-danger fw-bold validation-error responsive-06-em">{{ definition.name.error_message }}
                            </span>
                        </div>
                        <div class="col-md-12 mt-2 form-group">
                            <label for="email">Email</label>
                            <input v-model="form.email" type="email" id="email" :class=" {'form-control': true, 'border-danger' : !definition.email.valid }"/>
                            <span v-if="!definition.email.valid"
                                  class="text-danger fw-bold validation-error responsive-06-em">{{ definition.email.error_message }}
                            </span>
                            <div class="alert alert-info mt-2 validation-error responsive-06-em" role="alert">
                                Please enter valid address, because our response will be sent to your mail.
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="text">Write Message</label>
                            <textarea v-model="form.text" name="text" id="text" :class=" {'form-control': true, 'border-danger' : !definition.text.valid }" cols="30" rows="8"></textarea>
                            <span v-if="!definition.text.valid"
                                  class="text-danger fw-bold validation-error responsive-06-em">{{ definition.text.error_message }}
                            </span>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6 form-group">
                            <input type="submit" value="Send Message"
                               :class="{ btn: true, 'btn-primary': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}"
                            />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "Contact",
    data() {
        return {
            showComponent: true,
            form: {
                name: '',
                email: '',
                text: ''
            },
            definition: {
                name: {
                    valid: true,
                    regex: /^([A-ZĐŠĆŽČ][a-zšđćžč]{1,14})(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/,
                    error_message: "Please enter first name in format: Nikola"
                },
                email: {
                    valid: true,
                    regex: /^([a-z0-9]{2,15}@[a-z]{2,10}\.[a-z]{2,5})(\.[a-z]{2,5})?$/,
                    error_message: "Please enter first name in format: nikola@gmail.com"
                },
                text: {
                    valid: true,
                    regex: /.{1,255}/,
                    error_message: "Text is required, not longer than 255 characters"
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
                this.sendContactMessage()
            }
        },
        validateFields() {
            for (let fieldName in this.form) {
                if (!this.definition[fieldName].regex.test(this.form[fieldName])) {
                    // $('#' + fieldName).addClass('border-danger')
                    this.definition[fieldName].valid = false;
                } else {
                    // $('#' + fieldName).removeClass('border-danger')
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
        sendContactMessage() {
            axios.post('contact-messages', this.form)
                .then(response => {
                    this.setFieldsAsValid()
                    this.$notify({
                        group: 'foo',
                        type: response.data.type,
                        title: response.data.message,
                        duration: 5000
                    });
                    this.emptyFields()
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
        },
        emptyFields(){
          this.form = {
              name: '',
              email: '',
              text: ''
          }
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
