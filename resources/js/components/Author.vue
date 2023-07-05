<template>
    <div v-if="show === '1'">
        <div class="sidebar-box">
            <div class="bio text-center">
                <img :src="public_path + '/assets/img/autor.jpg'" alt="Image Placeholder" class="img-fluid"/>
                <div class="bio-body text-start">
                    <h2 class="text-center responsive-10-em">Nikola Kralj</h2>
                    <div class="container">
                        <ul id="info" class="p-0 m-0 list-unstyled validation-error">
                            <li class="my-3">Email: nikola.kralj.76.18@ict.edu.rs</li>
                            <li class="my-3">Index number: 76/18</li>
                            <li class="my-3">Year of study: Final</li>
                            <li class="mt-3">Site made for graduation thesis on Web Programing PHP 2 </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- END sidebar-box -->
    </div>
</template>

<script>
import {public_path} from "../constants";
export default {
    name: "Author",
    props: ['show'],
    data() {
        return {
            public_path: public_path,
        }
    },
}
</script>

<style scoped>

</style>
