<template>
    <section
        v-if="showComponent"
    >
        <h1 class="mb-2 fw-normal mb-4">Edit Navigation</h1>

        <div class="row">
            <div class="sidebar-box mt-4 mb-0">
                <div class="d-flex pb-0 heading mb-3">
                    <div class="col-10">
                        <h2 class="fw-normal h5">Navigation Items</h2>
                    </div>
                    <div class="col-2">
                        <navigation-item-modify
                            :available_menu_items="available_navigation_items_data"
                            :create_navigation_item_route="create_navigation_item_route"
                            :get_navigation_item_api_route="get_navigation_item_api_route"
                        >
                        </navigation-item-modify>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="align-middle" scope="col"><span>Name</span></th>
                        <th class="align-middle" scope="col"><span>Route</span></th>
                        <th class="align-middle" scope="col"><span>Order</span></th>
                        <th class="align-middle" scope="col">
                        <span class="d-flex align-items-center">
                            <span class="me-2">Actions</span>
                        </span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in menu_data">
                        <td>{{item.parties.category != null ? item.parties.category.name : item.parties.menu_item.name}}</td>
                        <td>{{item.route}}</td>
                        <td>{{item.order}}</td>
                        <td>
                            <div class="d-flex">
                                <navigation-item-modify
                                    :available_menu_items="available_navigation_items_data"
                                    :create_navigation_item_route="create_navigation_item_route"
                                    :menu_item="item"
                                    :public_path="public_path"
                                    :get_navigation_item_api_route="get_navigation_item_api_route"
                                >
                                </navigation-item-modify>
                                <button @click="$modal.show('delete ' + item.id)" class="btn text-danger"><font-awesome-icon :icon="['fas', 'trash']" /></button>
                                <modal :scrollable="true" width="60%" height="auto" :clickToClose="true" :name="'delete ' + item.id">
                                    <section class="d-flex p-3 h-100 justify-content-center align-items-center">
                                        <div class="text-center">
                                            <font-awesome-icon class="text-danger display-3 mb-2" :icon="['fas', 'triangle-exclamation']" />
                                            <h6 class="font-weight-normal responsive-09-em">Are you sure you want to remove navigation item with route '{{item.route}}'?</h6>
                                            <div class="mt-4 d-flex align-items-center rounded justify-content-center">
                                                <button @click="removeNavigationItem(item.id)" :class="{ btn: true, 'btn-primary': true, 'me-2': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}">Remove</button>
                                                <button :class="{ btn: true, 'btn-danger': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}" @click.prevent="$modal.hide('delete ' + item.id)">Cancel</button>
                                            </div>
                                        </div>
                                    </section>
                                </modal>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <one-column-object-crud
                title="Menu Items"
                object="menu-items"
                :regexp="/^([A-ZĐŠĆŽČ][a-zšđćžč]{1,14})(\s[A-ZĐŠĆŽČ][a-zšđćžč]{1,14})*$/"
                error_message="Please enter menu item name in format: Contact Us"
            >
            </one-column-object-crud>
        </div>
    </section>
</template>

<script>
import {public_path} from "../../../constants";
export default {
    name: "NavigationEdit",
    props: ['menu', 'available_navigation_items', 'create_navigation_item_route', 'get_navigation_item_route', 'available_menu_items', 'get_navigation_item_api_route'],
    data() {
        return {
            available_navigation_items_data: this.available_navigation_items,
            public_path: public_path,
            showComponent: true,
            menu_data: this.menu
        }
    },
    methods: {
        getResults(){
            axios.get(this.get_navigation_item_route).then( response => {
                this.menu_data = response.data.obj
            })
        },
        removeNavigationItem(id){
            axios.delete(this.public_path + '/menus/' + id)
                .then(() => {
                    this.$root.$emit('NavigationItemChanged')
                    this.$modal.hide('delete ' + id)
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
        this.$root.$on('NavigationItemChanged', () => {
            this.getResults()
        })
        this.$root.$on('menu-itemsDeleted', () => {
            this.$notify({
                group: 'foo',
                type: 'success',
                title: 'Successfully deleted menu item.',
                duration: 5000
            });
        })
        this.$root.$on('menu-itemsChanged', () => {
            axios.get(this.get_navigation_item_api_route ).then(response => {
                this.available_navigation_items_data = response.data.obj
            })
        })
    },

}
</script>

<style scoped>

</style>
