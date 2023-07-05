<template>
    <section>
        <div class="card">
            <div class="card-header">
                Email Verified
            </div>
            <div class="card-body">
                <h5 class="card-title">Congratulations</h5>
                <p class="card-text">You verified your email. You can now start exploring our beautiful portal!</p>
                <a href="#" :class="{ btn: true, 'btn-primary': true, 'responsive-07-em': true, 'btn-sm': window.innerWidth < 500}">Explore Posts</a>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "VerifiedEmail"
}
</script>

<style scoped>

</style>
