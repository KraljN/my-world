<template>
    <section>
        <button v-if="!componentUsedForUpdatingMenuItem" @click="$modal.show('createNavigationItem')" class="btn text-success"><font-awesome-icon :icon="['fas', 'circle-plus']" /></button>
        <button v-if="componentUsedForUpdatingMenuItem" @click="$modal.show('createNavigationItem' + menu_item.id)" class="btn text-warning"><font-awesome-icon :icon="['fas', 'pen-to-square']"/></button>
        <modal @before-open="componentUsedForUpdatingMenuItem ? setDataFromMenuItemObject() : ''"  height="auto" width="60%" :name="componentUsedForUpdatingMenuItem ? 'createNavigationItem' + menu_item.id : 'createNavigationItem'" :scrollable="true" :clickToClose="true">
            <div class="card">
                <div class="card-header">
                    Create Navigation Item
                </div>
                <div class="card-body">

                    <form @submit.prevent="checkForm" name="createNavigationItem" action="#" method="post">

                    <div class="col-12 form-group">
                        <label for="name">Name</label>
                        <span class="text-danger">*</span>
                        <select v-model="form.name_id" id="name" class="form-select">
                            <option
                                :selected="componentUsedForUpdatingMenuItem && menu_item.menu_party_id == available_menu_item.menu_party_id ? 'selected' : ''"
                                :value="available_menu_item.menu_party_id"
                                v-for="available_menu_item in available_menu_items">
                                {{available_menu_item.name}}
                            </option>
                        </select>
                    </div>
                    <div class="alert alert-info mt-2 validation-error responsive-06-em" role="alert">
                        Only menu items and categories are available to be in navigation
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-8 form-group">
                            <label for="route">Route</label>
                            <span class="text-danger">*</span>
                            <input type="text" v-model="form.route" id="route" :class=" {'form-control': true, 'required': true, 'border-danger' : !definition.route.valid }"/>
                                                    <span v-if="!definition.route.valid"
                                                          class="text-danger fw-bold  validation-error">{{ definition.route.error_message }}</span>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="route">Order</label>
                            <span class="text-danger">*</span>
                            <input type="number" min="0" v-model="form.order" id="route" :class=" {'form-control': true, 'required': true, 'border-danger' : !definition.order.valid }"/>
                                                    <span v-if="!definition.order.valid"
                                                          class="text-danger fw-bold  validation-error">{{ definition.order.error_message }}</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" :class="{ btn: true, 'btn-primary': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}">Create</button>
                        <button @click.prevent="componentUsedForUpdatingMenuItem ? $modal.hide('createNavigationItem' + menu_item.id)  :  $modal.hide('createNavigationItem')"  :class="{ btn: true, 'btn-danger': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}">Cancel</button>
                    </div>

                    </form>
                </div>
            </div>
        </modal>
    </section>
</template>

<script>
export default {
    name: "NavigationItemModify",
    props: ['available_menu_items', 'create_navigation_item_route', 'menu_item', 'public_path'],
    data(){
        return {
            form: {
                name_id: this.available_menu_items[0].menu_party_id,
                route: '',
                order: ''
            },
            definition: {
                route: {
                    valid: true,
                    error_message: "You must set route for navigation item"
                },
                order: {
                    valid: true,
                    error_message: "You must enter order number(negative numbers not allowed)"
                }
            }
        }
    },
    computed:{
        componentUsedForUpdatingMenuItem(){
            return Boolean(this.menu_item)
        }
    },
    methods: {
        checkForm(){
            //this.validateFields()
            if(true){
                let method = this.componentUsedForUpdatingMenuItem ? 'put' : 'post'
                let url = this.componentUsedForUpdatingMenuItem ? this.public_path + '/menus/' + this.menu_item.id : this.create_navigation_item_route

                axios({method, url, data: this.form})
                // axios.post(this.create_navigation_item_route, this.form)
                    .then(response => {
                        this.setFieldsAsValid()
                        this.$notify({
                            group: 'foo',
                            type: response.data.type,
                            title: response.data.message,
                            duration: 5000
                        });
                        this.clearFields()
                        this.$root.$emit('NavigationItemChanged')

                        let modalName = this.componentUsedForUpdatingMenuItem ? 'createNavigationItem' + this.menu_item.id : 'createNavigationItem'
                        this.$modal.hide(modalName)

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
        setDataFromMenuItemObject(){
            this.form.name_id = this.menu_item.menu_party_id
            this.form.route = this.menu_item.route
            this.form.order = this.menu_item.order
        },
        validateFields(){
            let valid = true

            if(this.form.route == ''){
                this.definition.route.valid = false
                valid = false
            }
            else{
                this.definition.route.valid = true

            }

            if(this.form.order == '' || this.form.order < 0){
                this.definition.order.valid = false
                valid = false
            }
            else{
                this.definition.order.valid = true
            }

            return valid
        },
        clearFields(){
            this.form.order = ''
            this.form.route = ''
            this.form.name_id = this.available_menu_items[0].menu_party_id
        },
        setFieldsAsValid(){
            for (let property in this.definition) {
                this.definition[property].valid = true
            }
        },
        showBackendValidationErrors(errors){
            for(let property in errors){
                if(this.definition[property] != undefined){
                    this.definition[property].error_message = errors[property].join(' ')
                    this.definition[property].valid = false
                }
            }
        }
    }
}
</script>

<style scoped>

</style>
