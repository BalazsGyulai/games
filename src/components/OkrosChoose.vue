<template>
    <div>
        <h1>Ki vagy?</h1>
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
div{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    max-width: 320px;
    width: 100%;
}

h1{
    max-width: 320px;
    width: 100%;
    text-align: center;
    padding: 5px 10px;
}

button{
    margin: 5px 0;
    max-width: 320px;
    width: 100%;
    height: 60px;
    background: #00FFB2;
    font-size: 1.3em;
    font-weight: bold;
    color: #fff;
    border: none;
    border-radius: 30px;
    transition: 0.3s;
    cursor: pointer;
    outline: none;
}

button:hover{
    background: #7effd8;
    transition: 0.3s;
}
</style>