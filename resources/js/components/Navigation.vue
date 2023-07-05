<template>
    <header role="banner">
        <div class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-9 social d-flex">
                        <a class="d-block d-md-none me-3" data-bs-toggle="collapse" data-bs-target="#navbarMenu" role="button" aria-expanded="false" aria-controls="navbarMenu" ><font-awesome-icon icon="fa-solid fa-bars" /></a>
                        <a target="_blank" href="https://twitter.com/"><font-awesome-icon icon="fa-brands fa-twitter" /></a>
                        <a target="_blank" href="https://www.facebook.com/"><font-awesome-icon icon="fa-brands fa-facebook" /></a>
                        <a target="_blank" href="https://instagram.com/"><font-awesome-icon icon="fa-brands fa-instagram" /></a>
                    </div>
                    <div class="col-3 search-top">
                        <!-- <a href="#"><span class="fa fa-search"></span></a> -->
                        <form action="#" class="search-top-form">
                            <span class="icon"><font-awesome-icon icon="fa-solid fa-magnifying-glass" /></span>
                            <input v-model="query" @keyup="searchAfterTypingStopped" type="text" id="search" placeholder="Type keyword to search..."/>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="container logo-wrap">
            <div class="row pt-1">
                <div class="col-12 text-center">
                    <div class="col-3 mx-auto">
                        <a :href="public_path + '/home'"><img class="img-fluid" :src="public_path + '/assets/img/logo.png'" alt="logo"/></a>
                    </div>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-md  navbar-light bg-light">
            <div class="container">


                <div class="collapse navbar-collapse" id="navbarMenu">
                    <ul class="navbar-nav mx-auto">
                        <li v-for="(item, index) in menu_data" class="nav-item">
                            <a :class="{ 'border-sm-end border-dark' : index == menu.length - 1}" class="nav-link" :href="public_path + item.route">
                                {{item.parties.category != null ? item.parties.category.name : item.parties.menu_item.name}}
                            </a>
                        </li>
                        <li class="nav-item d-flex flex-column flex-sm-row">
                            <a v-if="auth_user" :href="public_path + '/users/' + auth_user.id + '/edit'" class="nav-link"><font-awesome-icon :icon="['fas', 'user']" /></a>
                            <a v-if="!auth_user" :href="login_route" class="nav-link"><font-awesome-icon icon="fa-solid fa-arrow-right-to-bracket" /></a>
                            <a v-else :href="logout_route" class="nav-link"><font-awesome-icon :icon="['fas', 'right-from-bracket']" /></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
import {public_path} from "../constants";
export default {
    name: "Navigation",
    props: [
        'menu',
        'login_route',
        'auth_user',
        'logout_route',
        'get_navigation_item_route'
    ],
    data() {
        return {
            query: '',
            public_path: public_path,
            menu_data: this.menu
        }
    },
    methods: {
        activateSearch(){
            //When search field is empty we will hide search component and show current one
            let display = this.query === '' ? false : true
            this.$root.$emit('displaySearch', {
                display: display,
                value: this.query
            })
        },
        getResults(){
            axios.get(this.get_navigation_item_route).then( response => {
                this.menu_data = response.data.obj
            })
        },
        searchAfterTypingStopped: _.debounce(function(){
            this.activateSearch()
        }, 300)
    },
    created() {
        this.$root.$on('NavigationItemChanged', () => {
            console.log('Uhvatili smo event u navigaciji')
            this.getResults()
        })
    }
}
</script>

<style scoped>
</style>
