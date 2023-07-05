<template>
    <div class="sidebar-box">
        <h3 class="heading mb-0">Admin Tools</h3>
        <ul class="navbar-nav flex-column text-uppercase">
            <li class="nav-item">
                <a class="nav-link" :href="posts_route">Posts</a>
            </li>
            <li v-if="roles.includes('admin')" class="nav-item">
                <a class="nav-link" :href="navigation_route">Navigation</a>
            </li>
            <li v-if="roles.includes('admin')" class="nav-item">
                <a class="nav-link" :href="tag_category_administration_route">Tags and Categories</a>
            </li>
            <li v-if="roles.includes('admin')" class="nav-item">
                <a class="nav-link" :href="contact_messages_route">Contact Messages</a>
            </li>
            <li v-if="roles.includes('admin')" class="nav-item">
                <a class="nav-link" :href="users_route">Users</a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "AdminTools",
    props: ['posts_route', 'roles', 'navigation_route', 'tag_category_administration_route', 'contact_messages_route', 'users_route']
}
</script>

<style scoped>

</style>
