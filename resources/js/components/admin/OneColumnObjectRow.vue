<template>
    <section>
        <div class="row mt-4">
            <div class="col-md-9 form-group">
                <input class="form-control em-08" v-model="value" :class=" {'form-control': true, 'required': true, 'border-danger' : !valid }" type="text" id="title"/>
                <span v-if="!valid"
                      class="text-danger fw-bold  validation-error">{{error_message}}</span>
            </div>
            <div class="col-md-3 d-flex d-sm-block justify-content-center mt-3 mt-sm-0">
                <button @click="edit" :class="{ btn: true, 'btn-warning': true, 'float-left': true, 'responsive-07-em': true, 'me-2': true, 'btn-sm': window.innerWidth < 500}">
                    <font-awesome-icon :icon="['fas', 'pen-to-square']"/>
                </button>
                <button @click="$modal.show('confirm ' + object.id)" :class="{ btn: true, 'btn-danger': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}">
                    <font-awesome-icon :icon="['fas', 'trash']" />
                </button>
            </div>
        </div>
        <modal :scrollable="true" height="auto" width="60%" :clickToClose="true" :name="'confirm ' + object.id">
            <section class="d-flex p-3 h-100 justify-content-center align-items-center">
                <div class="text-center">
                    <font-awesome-icon class="text-danger display-3 mb-2" :icon="['fas', 'triangle-exclamation']" />
                    <h6 class="font-weight-normal responsive-09-em">Are you sure you want to remove this item?</h6>
                    <div class="mt-4 d-flex align-items-center rounded justify-content-center">
                        <button @click="remove" :class="{ btn: true, 'btn-primary': true, 'me-2': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}">Remove</button>
                        <button :class="{ btn: true, 'btn-danger': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}" @click.prevent="$modal.hide('confirm ' + object.id)">Cancel</button>
                    </div>
                </div>
            </section>
        </modal>
    </section>
</template>

<script>
export default {
    name: "OneColumnObjectRow",
    props: ['object', 'error_message', 'regexp', 'public_path', 'type'],
    data(){
        return {
            value: this.object.name,
            valid: true
        }
    },
    watch: {
        object: function(newVal){
            this.value = newVal.name
        }
    },
    methods: {
        validateField(){
            if(!this.regexp.test(this.value)){
                this.valid = false
                return
            }
            this.valid = true
            return true
        },
        edit(){
            if(this.validateField()){
                axios.put(this.public_path + '/' + this.type + '/' + this.object.id, {value : this.value}).then(response => {
                    this.valid = true
                    this.$notify({
                        group: 'foo',
                        type: response.data.type,
                        title: response.data.message,
                        duration: 5000
                    });
                    this.$root.$emit(this.type + 'Changed')

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
        remove(){
            axios.delete(this.public_path + '/' + this.type +'/' + this.object.id)
                .then(() => {
                    this.$root.$emit(this.type + 'Changed')
                    this.$root.$emit(this.type + 'Deleted')
                    this.$modal.hide('confirm ' + this.object.id)
                    //Destroy this component after deleting it
                    setTimeout(function(scope){
                        scope.$destroy
                        scope.$el.parentNode.removeChild(scope.$el);
                    }, 100, this)
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

    }
}
</script>

<style scoped>

</style>
