<template>
    <card class="text-center">
        <h3 class="mb-4">
            <h2>page not found</h2>
        </h3>

        <div class="links">
            <router-link :to="{ name:'Dashboard' }">
                go to home
            </router-link>
        </div>
    </card>

</template>

<script>
export default {
    name: "404"
}
</script>

<style scoped>

</style>
