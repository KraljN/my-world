<template>
    <section
        v-if="showComponent"
    >
        <h1 class="mb-2 fw-normal mb-4">Contact Messages</h1>
        <div class="mb-3" v-for="contact_message in contact_messages_data.data">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{contact_message.name}}</h5>
                        <h6 class="card-subtitle text-muted responsive-07-em">{{contact_message.email}}</h6>
                        <span v-if="contact_message.reply" class="fw-bold text-success responsive-07-em">{{contact_message.reply.user.username}} replied <font-awesome-icon :icon="['fas', 'circle-check']" /></span>
                        <p class="card-text">{{contact_message.text}}</p>
                        <a v-if="!contact_message.reply" @click.pre.prevent="openReplyModal(contact_message.id)" href="#" class="card-link responsive-08-em">Reply</a>
                    </div>
                </div>
            </div>
            <div v-if="contact_message.reply" class="row d-flex flex-row-reverse mt-2">
                <div class="card col-10 border-success">
                    <div class="card-body">
                        <h5 class="card-title">{{contact_message.reply.user.first_name + ' ' + contact_message.reply.user.last_name}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted responsive-07-em">{{contact_message.reply.user.username}}</h6>
                        <p class="card-text">{{contact_message.reply.text}}</p>
                        <p class="blockquote-footer mb-0 mt-2">Rest of conversation is done through mail</p>
                    </div>
                </div>
            </div>
        </div>
        <pagination
            class="mb-0 mt-3 mb-sm-4"
            v-if="contact_messages_data.last_page > 1"
            :current="contact_messages_data.current_page"
            :total="contact_messages_data.total"
            :per-page="contact_messages_data.per_page"
            @page-changed="getResult"
        >
        </pagination>
        <modal :scrollable="true" height="auto" width="60%" :clickToClose="true" name="reply">
            <div class="row mt-2 d-flex justify-content-center">
                <div class="col-10 form-group">
                    <label for="text">Write Message</label>
                    <textarea v-model="text" name="text" id="text" :class=" {'form-control': true, 'border-danger' : !valid }" cols="30" rows="8"></textarea>
                    <span v-if="!valid"
                          class="text-danger fw-bold validation-error responsive-06-em">{{ error_message }}
                            </span>
                </div>
            </div>
                <div class="mt-4 d-flex align-items-center rounded justify-content-center mb-2">
                    <button @click="reply()" :class="{ btn: true, 'btn-primary': true, 'me-2': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}">Reply</button>
                    <button :class="{ btn: true, 'btn-danger': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}" @click.prevent="$modal.hide('reply')">Cancel</button>
                </div>
        </modal>
    </section>
</template>

<script>
import {public_path} from "../../constants";
import Pagination from '../Pagination.vue'
export default {
    name: "ContactMessage",
    components: {
        'pagination': Pagination
    },
    props: ['contact_messages', 'contact_messages_route'],
    data() {
        return {
            showComponent: true,
            contact_messages_data: this.contact_messages,
            text: '',
            valid: true,
            message_id: null,
            error_message: 'You must enter some text',
            public_path: public_path
        }
    },
    methods: {
        reply(){
            if(!/.{1,255}/.test(this.text)){
                this.valid = false
            }
            else{
                this.valid = true
                axios.post(`${this.public_path}/contact-messages/${this.message_id}/reply`, {
                    text: this.text
                }).then(response => {
                    this.getResult()
                    this.text = ''
                    this.$modal.hide('reply')
                    this.$notify({
                        group: 'foo',
                        type: response.data.type,
                        title: response.data.message,
                        duration: 5000
                    });
                }).catch(error => {
                    if(error.response.status == 422){
                        this.valid = false
                        this.error_message = error.response.data.errors.text.join('. ')
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
        openReplyModal(id){
            this.valid = true
            this.message_id = id
            this.$modal.show('reply')
        },
        getResult(page = 1){
            axios.get(this.contact_messages_route, {
                params : { page }
            })
            .then(response => {
                this.contact_messages_data = response.data.obj
            })
            .catch(error => {
                console.error(error);
            });
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
