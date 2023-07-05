<template>
    <div>
        <div class="row mb-2">
            <div class="container">
                <h1 class="fw-normal">Login</h1>
            </div>
        </div>
        <form @submit.prevent="checkForm" action="#" method="post">
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="username">Username</label>
                    <span class="text-danger">*</span>
                    <input type="text" v-model="form.username" id="username" :class=" {'form-control': true, 'border-danger' : !valid.username }"/>
                </div>
                <div class="col-md-12 form-group">
                    <label for="password">Password</label>
                    <span class="text-danger">*</span>
                    <input type="password" v-model="form.password" id="password" :class=" {'form-control': true, 'border-danger' : !valid.password }"/>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-6 col-sm-3 col-lg-1 form-group">
                    <input type="submit" value="Login" :class="{ btn: true, 'btn-primary': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}"/>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: "Authentication",
    props: ["login_route"],
    data() {
        return {
            form: {
                username: '',
                password: ''
            },
            valid: {
                username: true,
                password: true
            }
        }
    },
    methods: {
        checkForm(){
            this.validateFields()

            if(this.valid.username && this.valid.password){
                    axios.post(this.login_route, this.form)
                        .then(response => {
                            location.href = response.data.url
                        })
                        .catch(error => {
                            this.$notify({
                                group: 'foo',
                                type: error.response.data.type,
                                title: error.response.data.message,
                                duration: 5000
                            });
                        });
            }
        },
        validateFields() {
            for (let fieldName in this.form) {
                if (this.form[fieldName] == '') {
                    $('#' + fieldName).addClass('border-danger')
                    this.valid[fieldName] = false;
                } else {
                    $('#' + fieldName).removeClass('border-danger')
                    this.valid[fieldName] = true;
                }
            }
        },
        setFieldsAsValid(){
            for(let fieldName in this.form){
                this.valid[fieldName].valid = true;
            }
        }
    },
    created() {
    }
}
</script>

<style scoped>

</style>
