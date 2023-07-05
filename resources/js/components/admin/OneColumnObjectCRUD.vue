<template>
    <section>
        <div class="row">
            <div class="sidebar-box mt-4 mb-0">
                <div class="d-flex pb-3 heading mb-3">
                    <div class="col-10">
                        <h2 class="fw-normal h5">{{title}}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 form-group">
                <input class="form-control em-08" v-model="value" :class=" {'form-control': true, 'required': true, 'border-danger' : !valid }" type="text" id="title"/>
                <span v-if="!valid"
                      class="text-danger fw-bold  validation-error">{{error_message}}</span>
            </div>
            <div class="col-md-3 d-flex d-sm-block justify-content-center mt-3 mt-sm-0">
                <button @click="add" :class="{ btn: true, 'btn-success': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}">
                    <font-awesome-icon :icon="['fas', 'circle-plus']" />
                </button>
            </div>
        </div>
        <div v-for="menu_item_row in objectsFromPagination">
            <one-column-object-row
                :object="menu_item_row"
                :type="object"
                :regexp="regexp"
                :error_message="error_message"
                :public_path="public_path"
            >
            </one-column-object-row>
        </div>
        <pagination
            class="mb-0 mt-3 mb-sm-4"
            v-if="objects_data.last_page > 1"
            :current="objects_data.current_page"
            :total="objects_data.total"
            :per-page="objects_data.per_page"
            @page-changed="getResult"
        >
        </pagination>
    </section>
</template>

<script>
import {public_path} from "../../constants";
import Pagination from '../Pagination.vue'
export default {
    name: "OneColumnObjectCRUD",
    components: {
        'pagination': Pagination
    },
    props: ['title', 'object', 'regexp', 'error_message'],
    computed: {
      objectsFromPagination(){
          return  this.objects_data.data
      }
    },
    data(){
        return {
            value: '',
            valid: true,
            public_path: public_path,
            objects_data: {
                data: []
            }
        }
    },
    methods: {
        getResult(page = 1){
            axios.get(this.public_path + '/' + this.object, {
                params : { query: this.value, page }
            }).then(response => {
                this.objects_data = response.data.obj
            }).catch(error => {

            })
        },
        add(){
            if(this.validateField()){
                axios.post(this.public_path + '/' + this.object, {value : this.value}).then(response => {
                    this.valid = true
                    this.$notify({
                        group: 'foo',
                        type: response.data.type,
                        title: response.data.message,
                        duration: 5000
                    });
                    this.value = ''
                    this.$root.$emit(this.object + 'Changed')
                    this.getResult(this.page)

                }).catch(error => {
                    if(error.response.status == 422)this.valid = false
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
        validateField(){
            if(!this.regexp.test(this.value)){
                this.valid = false
                return
            }
            this.valid = true
            return true
        }
    },
    created() {
        this.getResult()
    }
}
</script>

<style scoped>

</style>
