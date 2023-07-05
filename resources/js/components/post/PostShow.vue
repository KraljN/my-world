<template>
    <section v-if="showComponent" class="blog-entries">
        <img :src="public_path + '/assets/img/' + post.image.src" :alt="post.image.alt" class="img-fluid mb-5"/>
        <div class="mb-4 align-items-center d-flex flex-column flex-sm-row justify-content-between">
<!--            We forward post_object instead of post because after we delete comment, we need to update number of comments for this post. It is not advisable to mutate properties directly-->
            <post-info
                :post="post_object"
                :public_path="public_path"
            >
            </post-info>
            <rating
                :ratings="post.ratings"
                :auth_user="auth_user"
                :obj="post"
                type="post"
                :public_path="public_path"
            >
            </rating>
        </div>
        <h1 class="mb-4">{{post.title}}</h1>
        <a v-for="category in post.categories" class="text-decoration-none category mb-5" :href="public_path + '/categories/' + category.id">
            {{category.name}}
        </a>
        <div class="mb-5" id="post-text" v-html="post.text">
        </div>
        <div class="row">
            <div class="container mb-5 responsive-08-em">
                Tags:
                <span  v-for="(tag, index) in post.tags">
                    <span v-if="index > 0">,</span> <a class="text-decoration-none" :href="public_path + '/tags/' + tag.id">#{{(tag.name)}}</a>
                </span>
            </div>
        </div>
<!--            We forward post_object instead of post because after we delete comment, we need to update number of comments for this post. It is not advisable to mutate properties directly-->
        <h3 class="responsive-09-em">{{post_object.comments.length}} Comment<span v-if="post.comments.length != 1">s</span></h3>
        <div class="mb-5" id="leaveComment">
            <div class="comment-form-wrap pt-5">
                <h3 class="mb-5 responsive-09-em">Leave a comment</h3>
                <div class="p-5 bg-light">
                    <form v-if="auth_user" action="#">
                        <div class="form-group mb-2">
                            <label for="message">Message</label>
                            <textarea name="" v-model="form.comment_text" id="message" cols="30" rows="10" :class=" {'form-control': true, 'border-danger' : !validation.comment_text.valid }"></textarea>
                            <span v-if="!validation.comment_text.valid"
                                  class="text-danger fw-bold validation-error">{{ validation.comment_text.error_message }}</span>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Post Comment"  @click.prevent="postComment()"  :class="{ btn: true, 'btn-primary': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}"/>
                        </div>
                    </form>
                    <div v-else>
                        <p>
                            Please <a class="text-decoration-none" :href="login_route">login</a> so you can comment.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <ul class="comment-list">
            <li v-for="comment in post_object.comments" class="comment">
                <comment
                :public_path="public_path"
                :comment="comment"
                :auth_user="auth_user"
                >
                </comment>
            </li>
        </ul>
    </section>
</template>

<script>
import {public_path} from "../../constants";

export default {
    name: "PostShow",
    props: ['post', 'auth_user', 'comments_route', 'login_route'],
    data() {
        return {
            showComponent: true,
            public_path: public_path,
            post_object: this.post,
            form: {
                comment_text: '',
                post_id: this.post.id,
                //If there is no logged-in user auth_user.id will throw error (can't read id from null)
                user_id: this.auth_user != undefined ? this.auth_user.id : null
            },
            validation:{
                comment_text: {
                    valid: true,
                    error_message: ''
                }
            }
        }
    },
    created(){
        this.$root.$on('deletedComment', (commentId) => {
            let index = this.post_object.comments.findIndex(obj => obj.id === commentId);
            this.post_object.comments.splice(index, 1)
            this.$notify({
                group: 'foo',
                type: 'success',
                title: 'Successfully deleted comment.',
                duration: 5000
            });
        })
        //If search is turned on, we should disable this component
        this.$root.$on('displaySearch', (data) => {
            this.showComponent =  !data.display
        })
    },
    methods: {
        postComment(){
            if(this.form.comment_text.trim().length == 0){
                this.showErrorMessage("Comment text can't be empty")
            }
            else{
                axios.post( this.comments_route, this.form)
                    .then((response) => {
                        this.removeValidationError()
                        this.post_object.comments.push(response.data.obj)
                        this.$notify({
                            group: 'foo',
                            type: response.data.type,
                            title: response.data.message,
                            duration: 5000
                        });
                        this.form.comment_text = ''
                    })
                    .catch((error) => {
                        if(error.response.status == 500){
                            this.$notify({
                                group: 'foo',
                                type: error.response.data.type,
                                title: error.response.data.message,
                                duration: 5000
                            });
                            this.removeValidationError()
                        }
                        else if(error.response.status == 422 && error.response.data.errors != undefined){
                            this.showErrorMessage(error.response.data.errors.comment_text.join(' '))
                        }
                    });
            }
        },
        showErrorMessage(message){
            this.validation.comment_text.valid = false
            this.validation.comment_text.error_message = message
        },
        removeValidationError(){
            this.validation.comment_text.valid = true
            this.validation.comment_text.error_message = ''
        }
    }
}
</script>
