<template>
    <section>
        <div class="sidebar-box mt-4 mb-0">
            <h3 class="heading mb-3">Basic Info</h3>
        </div>
        <form @submit.prevent="checkForm" name="editUser" action="#" method="post">
            <div class="row">
                <div class="container form-group d-flex justify-content-between align-items-center">
                    <div class="col-md-2">
                        <img :src="public_path + '/assets/img/' + user_data.image.src" class="img-fluid rounded-circle profile-picture" :alt="user_data.image.alt"/>
                    </div>
                    <div class="mb-3 col-md-9">
                        <input class="form-control" @change="uploadFile" ref="file" type="file" id="formFile"/>
                        <span v-if="!image.valid"
                              class="text-danger fw-bold  validation-error">{{image.error_message}}</span>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6 form-group">
                        <label for="first_name">First Name</label>
                        <span class="text-danger">*</span>
                        <input type="text" v-model="form.first_name" id="first_name" :class=" {'form-control': true, 'required': true, 'border-danger' : !definition.first_name.valid }"/>
                        <span v-if="!definition.first_name.valid"
                              class="text-danger fw-bold  validation-error">{{ definition.first_name.error_message }}</span>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="last_name">Last Name</label>
                        <span class="text-danger">*</span>
                        <input type="text" v-model="form.last_name" id="last_name" :class=" {'form-control': true, 'required': true, 'border-danger' : !definition.last_name.valid }"/>
                        <span v-if="!definition.last_name.valid"
                              class="text-danger fw-bold  validation-error">{{ definition.last_name.error_message }}</span>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12 form-group">
                        <label for="username">Username</label>
                        <span class="text-danger">*</span>
                        <input type="text" v-model="form.username" id="username" :class=" {'form-control': true, 'required': true, 'border-danger' : !definition.username.valid }"/>
                        <span v-if="!definition.username.valid"
                              class="text-danger fw-bold  validation-error">{{ definition.username.error_message }}</span>
                    </div>
                </div>
                <div v-if="is_admin" class="col-12 mt-3">
                    <div  class="col-12 d-flex flex-column flex-sm-row form-group">
                        <label>Role: </label>
                        <span v-for="role in all_roles" class="ms-0 ms-sm-2">
                            <input type="radio" @change="form.role_name = $event.target.value" :checked="user.roles[0].name == role.name ? 'checked' : ''" :value="role.name" name="role" />
                            <label class="form-check-label">
                                {{role.name | capitalize}}
                            </label>
                        </span>
                    </div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-6 col-sm-3 col-lg-1 form-group">
                        <input type="submit" value="Save"
                               :class="{ btn: true, 'btn-primary': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}"/>
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>

<script>
export default {
    name: "UserBasicInfoEdit",
    props: ['user', 'public_path', 'all_roles', 'is_admin'],
    data() {
        return {
            user_data: this.user,
            image: {
                file: null,
                valid: true,
                error_message: 'Image must be in .jpg, .jpeg, .png format and not bigger than 1MB'
            },
            form: {
                first_name: this.user.first_name,
                last_name: this.user.last_name,
                username: this.user.username,
                role_name: this.user.roles[0].name
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
                username: {
                    valid: true,
                    regex: /[a-z0-9]{4,15}/,
                    error_message: "Username should contain only letters and numbers, between 4 and 15 characters"
                }
            },
        }
    },
    methods: {
        uploadFile(){
            this.image.file = this.$refs.file.files[0];
        },
        checkForm() {
            this.validateImage();
            //Validate fields for registration
            this.validateFields()

            //Check if all fields are validated
            const areTruthy = this.checkValidatedFields()

            if (areTruthy) {
                this.changeData()
            }

        },
        validateFields() {
            for (let fieldName in this.definition) {
                if (!this.definition[fieldName].regex.test(this.form[fieldName])) {
                    this.definition[fieldName].valid = false;
                } else {
                    this.definition[fieldName].valid = true;
                }
            }

        },
        validateImage(){
            if(this.image.file){
                const extension = this.image.file.name.split(".").pop();
                if(!['jpg', 'jpeg', 'png'].includes(extension) || (this.image.file.size > 1024 * 1024)){
                    this.image.valid = false
                    return false
                }

                this.image.valid = true
                return true
            }
            return true
        },
        checkValidatedFields() {
            const validArray = Object.values(this.definition).map(property => property.valid);

            //If image is not validated don't send request for update
            if(!this.validateImage()){
                return false
            }

            return validArray.every(
                value => value
            );
        },
        showBackendValidationErrors(errors){
            for(let property in errors){
                if(this.definition[property] != undefined){
                    this.definition[property].error_message = errors[property].join(' ')
                    this.definition[property].valid = false
                }
            }

            if(errors.image != undefined){
                this.image.valid = false
                this.image.error_message = errors.image.join('. ')
            }
        },
        changeData() {
            let formData = new FormData();
            if(this.image.file){
                formData.append('image', this.image.file);
            }
            formData.append('first_name', this.form.first_name);
            formData.append('last_name', this.form.last_name);
            formData.append('username', this.form.username);
            formData.append('role_name', this.form.role_name);
            //We need id to check in form request (Laravel) if that username is taken from some other user
            formData.append('id', this.user.id);
            //Multipart form data doesn't work with put request, this is way to declare it to be put without losing request data
            formData.append('_method', 'PUT')

            axios.post(this.public_path + '/users/' + this.user.id, formData)
                .then(response => {
                    this.setFieldsAsValid()
                    this.$notify({
                        group: 'foo',
                        type: response.data.type,
                        title: response.data.message,
                        duration: 5000
                    });
                    this.image.file = null
                    this.$refs.file.value = null
                    this.user_data.image = response.data.obj.image
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
        setFieldsAsValid(){
            for(let fieldName in this.definition){
                this.definition[fieldName].valid = true;
            }
            this.image.valid = true
        }
    }
}
</script>

<style scoped>

</style>
