<template>
    <section
        v-if="showComponent"
    >
        <h1 class="mb-2 fw-normal mb-4">{{componentUsedForUpdatingPost ? 'Update' : 'Create'}} Post</h1>

        <form @submit.prevent="createPost" name="postForm" action="#" method="post">
            <div class="row">
                <div class="row mb-3">
                    <div v-if="componentUsedForUpdatingPost" class="col-md-6">
                        <img :src="public_path + '/assets/img/' + post_data.image.src" class="img-fluid" :alt="post_data.image.alt"/>
                    </div>
                    <div :class="{'form-group': true, 'col-12': !componentUsedForUpdatingPost, 'col-md-6': componentUsedForUpdatingPost, 'd-flex': true, 'flex-column': true, 'justify-content-center': true}">
                        <span class="d-flex flex-row me-2">
                            <label for="formFile">Image</label>
                            <span class="text-danger">*</span>
                        </span>
                        <input class="form-control" @change="uploadFile" ref="file" type="file" id="formFile"/>
                        <span v-if="!image.valid"
                              class="text-danger fw-bold  validation-error">{{image.error_message}}</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div :class="{'form-group': true, 'col-12': !componentUsedForUpdatingPost, 'col-md-6': componentUsedForUpdatingPost && userIsAdmin}">
                        <label for="title">Title</label>
                        <span class="text-danger">*</span>
                        <input class="form-control" v-model="form.title" :class=" {'form-control': true, 'required': true, 'border-danger' : !definition.title.valid }" type="text" id="title"/>
                        <span v-if="!definition.title.valid"
                              class="text-danger fw-bold  validation-error">{{definition.title.error_message}}</span>
                    </div>
                    <div v-if="componentUsedForUpdatingPost && userIsAdmin" class="col-md-6 form-group">
                        <label for="author">Author</label>
                        <span class="text-danger">*</span>
                        <select v-model="form.user_id" id="author" class="form-select">
                            <option :value="user.id" :selected="post_data.user_id == user.id ? 'selected' : ''" v-for="user in users">{{user.first_name + ' ' + user.last_name + ' (' + user.username + ')'}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="categories">Categories</label>
                        <span class="text-danger">*</span>
                        <select v-model="form.categories" id="categories" :class=" {'form-select': true, 'required': true, 'border-danger' : !definition.categories.valid }" multiple="multiple" size="3" aria-label="size 3">
                            <option :value="category.id" v-for="category in categories">{{category.name}}</option>
                        </select>
                        <span v-if="!definition.categories.valid"
                              class="text-danger fw-bold  validation-error">{{definition.categories.error_message}}</span>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="tags">Tags</label>
                        <span class="text-danger">*</span>
                        <select v-model="form.tags" id="tags" :class=" {'form-select': true, 'required': true, 'border-danger' : !definition.tags.valid }" multiple="multiple" size="3" aria-label="size 3">
                            <option :value="tag.id" v-for="tag in tags">{{tag.name}}</option>
                        </select>
                        <span v-if="!definition.tags.valid"
                              class="text-danger fw-bold  validation-error">{{definition.tags.error_message}}</span>
                    </div>
                </div>
                <div class="row mt-4">
                    <span class="d-flex">
                        <label class="me-2" for="text">Text</label>
                        <span class="text-danger">*</span>
                    </span>
                    <span v-if="!definition.text.valid"
                          class="text-danger fw-bold  validation-error">{{definition.text.error_message}}</span>
                    <div class="row">
                        <vue-editor :editor-toolbar="customToolbar"  v-model="form.text" />
                    </div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-6 col-sm-3 col-lg-1 form-group">
                        <input type="submit" id="confirmPost" :value="post ? 'Update Post' : 'Create Post'"
                               :class="{ btn: true, 'btn-primary': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}"/>
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>

<script>
import { VueEditor } from "vue2-editor";
import {public_path} from "../../constants";

export default {
    name: "PostModify",
    components: { VueEditor },
    props: ['tags', 'categories', 'auth_user', 'create_post_path', 'post', 'users', 'roles'],
    data() {
        return {
            showComponent: true,
            public_path: public_path,
            post_data: this.post,
            customToolbar: [
                [{ header: [false, 1, 2, 3, 4, 5, 6] }],
                ["bold", "italic", "underline"],
                [{ list: "ordered" }, { list: "bullet" }],
                ["blockquote","code-block"],
                ["clean"]
            ],
            image: {
                file: null,
                valid: true,
                error_message: 'Image must be in .jpg, .jpeg, .png format and not bigger than 1MB'
            },
            definition: {
                title: {
                    valid: true,
                    error_message: "Title is required"
                },
                categories: {
                    valid: true,
                    error_message: "You must choose at least one category"
                },
                tags: {
                    valid: true,
                    error_message: "You must choose at least one tag"
                },
                text: {
                    valid: true,
                    error_message: "Text is required"
                }
            },
            form:{
                title: '',
                categories: [],
                tags: [],
                text: '',
                user_id: ''
            }
        }
    },
    computed:{
      componentUsedForUpdatingPost(){
          return Boolean(this.post)
      },
      userIsAdmin(){
          return this.roles.includes('admin')
      }

    },
    methods:{
        uploadFile(){
            this.image.file = this.$refs.file.files[0];
        },
        createPost(){
            let formData = new FormData();
            let route
            formData.append('title', this.form.title);
            formData.append('categories', this.form.categories);
            formData.append('tags', this.form.tags);
            formData.append('text',  this.form.text);
            if(this.componentUsedForUpdatingPost){
                formData.append('author_id', this.form.user_id);
                //Multipart form data doesn't work with put request, this is way to declare it to be put without losing request data
                formData.append('_method', 'PUT')
                route = this.public_path + '/posts/' + this.post.id
                if(this.image.file){
                    formData.append('image', this.image.file);
                }
            }
            //If component is used for creating post
            else{
                route = this.create_post_path
                formData.append('image', this.image.file);
            }
            if(this.validateFields()){
                    axios.post(route, formData)
                        .then(response => {
                            this.setFieldsAsValid()
                            this.$notify({
                                group: 'foo',
                                type: response.data.type,
                                title: response.data.message,
                                duration: 5000
                            });
                            if(!this.componentUsedForUpdatingPost){
                                this.resetData()
                            }
                            else{
                                this.post_data = response.data.obj
                                this.setDataFromPostObject()
                            }
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
            }
        },
        validateFields() {
            let valid = true;
            if (!this.componentUsedForUpdatingPost && !this.validateImage()) {
                valid = false
            }

            //Validate title
            if (this.form.title == '') {
                this.definition.title.valid = false
                valid = false
            } else {
                this.definition.title.valid = true
            }

            //Validate text
            if (this.removeTags(this.form.text) == '') {
                this.definition.text.valid = false
                valid = false
            } else {
                this.definition.text.valid = true
            }

            //Validate categories
            if (this.form.categories.length == 0) {
                this.definition.categories.valid = false
                valid = false
            } else {
                this.definition.categories.valid = true
            }

            //Validate tags
            if (this.form.tags.length == 0) {
                this.definition.tags.valid = false
                valid = false
            } else {
                this.definition.tags.valid = true
            }

            return valid
        },
        removeTags(str) {
            if ((str === null) || (str === ''))
                return false;
            else
                str = str.toString();

            // Regular expression to identify HTML tags in
            // the input string. Replacing the identified
            // HTML tag with a null string.
            return str.replace(/(<([^>]+)>)/ig, '');
        },
        setFieldsAsValid() {
            for (let property in this.definition) {
                this.definition[property].valid = true
            }
        },
        resetData(){
            this.image.file = null
            this.$refs.file.value = null
            this.form.categories = []
            this.form.tags = []
            this.form.text = ''
            this.form.title = ''
        },
        validateImage(){
            if(this.image.file){
                const extension = this.image.file.name.split(".").pop();
                if(!['jpg', 'jpeg', 'png'].includes(extension) || (this.image.file.size > 2 * 1024 * 1024)){
                    this.image.valid = false
                    return false
                }

                this.image.valid = true
                return true
            }
            this.image.valid = false
            return false
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
        setDataFromPostObject(){
            this.form.title = this.post_data.title
            this.form.text = this.post_data.text
            this.form.tags = this.post_data.tags.map(tag => tag.id);
            this.form.user_id = this.post_data.user_id
            this.form.categories = this.post_data.categories.map(category => category.id);
        }
    },
    created() {
        //If search is turned on, we should disable this component
        this.$root.$on('displaySearch', (data) => {
            this.showComponent =  !data.display
        })

        if(this.componentUsedForUpdatingPost){
            this.setDataFromPostObject()
        }
    }
}
</script>

<style scoped>

</style>
