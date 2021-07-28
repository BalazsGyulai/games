<template>
    <div>
        <button v-on:click="clickFunction">Click</button>
    </div>
</template>

<script>
    export default {
        name: 'Child',
        methods: {
            clickFunction() {
                this.$emit('changeTitle', 'Child')
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>