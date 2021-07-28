<template>
  <div>
    <input type="text" maxlength="255" placeholder="Név" v-model="send.username">
    <input type="password" maxlength="255" placeholder="Jelszó" v-model="password">
    <button @click="chooseTarget()">Start</button>

    <teleport to="body">
      <div v-if="modalOpen" class="modal">
        <p>Rossz jelszó vagy felhaználónév</p>
        <button @click="modalOpen = false">X</button>
      </div>
    </teleport>
  </div>
</template>

<script>
import axios from "axios"

export default {
  name: "SetAdmin",
  data() {
    return {
      password: "",
      send: {
        username: "",
        opt: "GameAdmin",
      },
      login: null,
      modalOpen: false
    };
  },
  methods: {
    chooseTarget() {
      axios({
        method: "post",
        url: "http://localhost:8080/createuser.php",
        data: {
          username: this.send.username,
          pwd: this.password,
          opt: this.send.opt,
        },
      })
        .then((response) => {
          this.login = response.data["login"];

          this.sendData();
        })
    },

    sendData() {
      if (this.login == 'true') {
        this.$emit("choosedTarget", this.send);
      } else if (this.login == 'false') {
        this.modalOpen = true;
      }
    },
  },
};
</script>

<style scoped>
</style>