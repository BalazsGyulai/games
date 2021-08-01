<template>
  <div>
    <div class="game">
      <h1>Indíts saját játékod</h1>
      <input type="text" maxlength="255" placeholder="Név" v-model="send.username">
      <input type="password" maxlength="255" placeholder="Jelszó" v-model="password">
      <button @click="chooseTarget()">Start</button>
    </div>

    <teleport to="body">
      <transition name="fade">
        <div v-if="modalOpen" class="modal">
          <div id="error">
            <img src="../assets/error.svg">
          </div>
          <p>Rossz jelszó vagy felhaználónév</p>
        </div>
      </transition>
    </teleport>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "SetAdmin",
  data() {
    return {
      password: "",
      send: {
        username: "",
        opt: "GameAdmin",
        gamecode: "",
      },
      login: null,
      modalOpen: false,
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
      }).then((response) => {
        this.login = response.data["login"];
        this.send.gamecode = response.data["gamecode"];
        this.sendData();
      });
    },

    sendData() {
      if (this.login == "true") {
        this.$emit("choosedTarget", this.send);
      } else if (this.login == "false") {
        this.modalOpen = true;

        setTimeout(() => {
          this.modalOpen = false;
        }, 3000);
      }
    },
  },
};
</script>

<style scoped>
.game {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  max-width: 320px;
  width: 100%;
}

h1 {
  box-sizing: border-box;
  padding: 5px 10px;
  max-width: 320px;
  width: 100%;
  text-align: center;
}

input {
  box-sizing: border-box;
  margin: 5px 0;
  width: 100%;
  height: 60px;
  max-width: 320px;
  border: 1px solid #bcbcbc;
  padding: 5px 30px;
  border-radius: 30px;
  transition: 0.3s;
  font-size: 1em;
  outline: none;
  transition: 0.3s;
}

input:focus {
  border: 1px solid #00ffb2;
  transition: 0.3s;
}

button {
  margin: 5px 0;
  max-width: 320px;
  width: 100%;
  height: 60px;
  background: #00ffb2;
  font-size: 1.3em;
  font-weight: bold;
  color: #fff;
  border: none;
  border-radius: 30px;
  transition: 0.3s;
  cursor: pointer;
  outline: none;
}

button:hover {
  background: #7effd8;
  transition: 0.3s;
}

.modal {
  box-sizing: border-box;
  position: absolute;
  top: 10px;
  left: calc(100% - 10px);
  transform: translate(-100%, 0);
  max-width: 320px;
  width: 320px;
  height: 100px;
  background: #c34a43;
  display: flex;
  border-radius: 5px;
}

#error {
  position: relative;
  padding: 0 10px;
  width: 30px;
  height: 100px;
}

#error img {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.modal p {
  position: absolute;
  top: 50%;
  left: 50px;
  transform: translateY(-50%);
  color: #fff;
  padding: 0 10px;
}

.fade-enter-active {
  transition: all 0.3s ease;
}

.fade-leave-active {
  transition: all 0.3s ease;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>