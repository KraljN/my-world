<template>
    <section
        v-if="showComponent"
    >
    <h1 class="mb-2 fw-normal mb-4">Edit Users</h1>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th scope="col"><span>Name</span></th>
                        <th scope="col"><span>Username</span></th>
                        <th scope="col"><span>Email</span></th>
                        <th scope="col"><span>Role</span></th>
                        <th scope="col"><span>Activated</span></th>
                        <th class="text-center" scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users_data.data">
                        <td>{{user.first_name + ' ' + user.last_name}}</td>
                        <td>{{user.username}}</td>
                        <td>{{user.email}}</td>
                        <td>{{user.roles[0].name}}</td>
<!--                        <td>-->
<!--                            <div class="d-flex">-->
<!--                                <navigation-item-modify-->
<!--                                    :available_menu_items="available_navigation_items_data"-->
<!--                                    :create_navigation_item_route="create_navigation_item_route"-->
<!--                                    :menu_item="item"-->
<!--                                    :public_path="public_path"-->
<!--                                    :get_navigation_item_api_route="get_navigation_item_api_route"-->
<!--                                >-->
<!--                                </navigation-item-modify>-->
<!--                                <button @click="$modal.show('delete ' + item.id)" class="btn text-danger"><font-awesome-icon :icon="['fas', 'trash']" /></button>-->
<!--                                <modal :scrollable="true" width="60%" height="auto" :clickToClose="true" :name="'delete ' + item.id">-->
<!--                                    <section class="d-flex p-3 h-100 justify-content-center align-items-center">-->
<!--                                        <div class="text-center">-->
<!--                                            <font-awesome-icon class="text-danger display-3 mb-2" :icon="['fas', 'triangle-exclamation']" />-->
<!--                                            <h6 class="font-weight-normal responsive-09-em">Are you sure you want to remove navigation item with route '{{item.route}}'?</h6>-->
<!--                                            <div class="mt-4 d-flex align-items-center rounded justify-content-center">-->
<!--                                                <button @click="removeNavigationItem(item.id)" :class="{ btn: true, 'btn-primary': true, 'me-2': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}">Remove</button>-->
<!--                                                <button :class="{ btn: true, 'btn-danger': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}" @click.prevent="$modal.hide('delete ' + item.id)">Cancel</button>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </section>-->
<!--                                </modal>-->
<!--                            </div>-->
<!--                        </td>-->
                        <td class="text-center">
                            <span v-if="user.activated" class="text-success"><font-awesome-icon :icon="['fas', 'circle-check']" /></span>
                            <span v-else class="text-danger"><font-awesome-icon :icon="['fas', 'circle-xmark']" /></span>
                        </td>
                        <td>
                            <button class="btn ">
                                <a class="text-warning" :href="public_path + '/users/' + user.id + '/edit'">
                                    <font-awesome-icon :icon="['fas', 'pen-to-square']"/>
                                </a>
                            </button>
                            <button @click="$modal.show('delete ' + user.id)" class="btn text-danger"><font-awesome-icon :icon="['fas', 'trash']" /></button>
                            <modal :scrollable="true" width="60%" height="auto" :clickToClose="true" :name="'delete ' + user.id">
                                <section class="d-flex p-3 h-100 justify-content-center align-items-center">
                                    <div class="text-center">
                                        <font-awesome-icon class="text-danger display-3 mb-2" :icon="['fas', 'triangle-exclamation']" />
                                        <h6 class="font-weight-normal responsive-09-em">Are you sure you want to remove {{user.first_name + ' ' + user.last_name + '(' + user.username + ')'}} user?</h6>
                                        <div class="mt-4 d-flex align-items-center rounded justify-content-center">
                                            <button @click="removeUser(user.id)" :class="{ btn: true, 'btn-primary': true, 'me-2': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}">Delete</button>
                                            <button :class="{ btn: true, 'btn-danger': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}" @click.prevent="$modal.hide('delete ' + user.id)">Cancel</button>
                                        </div>
                                    </div>
                                </section>
                            </modal>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <pagination
                    class="mb-0 mt-3 mb-sm-4"
                    v-if="users_data.last_page > 1"
                    :current="users_data.current_page"
                    :total="users_data.total"
                    :per-page="users_data.per_page"
                    @page-changed="getResult"
                >
                </pagination>
            </div>
        </div>

    </section>
</template>

<script>
import {public_path} from "../../constants";
import Pagination from '../Pagination.vue';

export default {
    name: "Users",
    components: {
        'pagination': Pagination
    },
    props: ['users', 'users_route'],
    data() {
        return {
            showComponent: true,
            users_data: this.users,
            public_path: public_path
        }
    },
    created() {
        //If search is turned on, we should disable this component
        this.$root.$on('displaySearch', (data) => {
            this.showComponent =  !data.display
        })
    },
    methods: {
        removeUser(id){
            axios.delete(this.public_path + '/users/' + id).then(() => {
                this.$modal.hide('delete ' + id)
                this.getResult()
                this.$notify({
                    group: 'foo',
                    type: 'success',
                    title: 'Successfully deleted User.',
                    duration: 5000
                });
            }).catch(error => {
                this.$notify({
                    group: 'foo',
                    type: error.response.data.type,
                    title: error.response.data.message,
                    duration: 5000
                });
            });
        },
        getResult(page = 1) {
            axios.get(this.users_route, {
                params: {page}
            }).then(response => {
                this.users_data = response.data.obj
            }).catch(error => {
                console.error(error);
            });
        }
    }
}
</script>

<style scoped>

</style>
