<template>
    <div>
        <button @click="chooseTarget('SetPlayer')">Player</button>
        <button @click="chooseTarget('SetAdmin')">Admin</button>
    </div>
</template>

<script>
    export default {
        name: 'Choose',
        data() {
            return {
                send: {
                    opt: ''
                }
            }
        },
        methods: {
            chooseTarget(value) {
                this.send.opt = value;
                this.$emit('choosedTarget', this.send);
            }
        }
    }
</script>

<style scoped>

</style>