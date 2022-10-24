<template>
    <div class="main">
        <div class="not-found" v-if="!success && error_type === 'not_found'">
            Not found
        </div>
        <div class="found" v-else>
            Here is an apple. It's color = {{data.color}}
        </div>
    </div>
</template>

<script>
export default {
    name: "Show",
    props: ['success', 'error_type', 'data']
}
</script>

<style scoped>

</style>
