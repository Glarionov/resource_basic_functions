<template>
    <div class="error-list text-danger mt-3" v-if="Object.keys(this.$props.validationErrors).length">
        <ul v-for="(errorMessages, errorIndex) in this.$props.validationErrors" :key="errorIndex">
            <li v-for="(errorMessage, errorMessageIndex) in errorMessages" :key="errorMessageIndex" v-html="errorMessage.message">
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "ValidationErrorList",
    props: ['validationErrors']
}
</script>

<style scoped>

</style>
