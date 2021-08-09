<template>
  <div>
    <div id="btn" @click="showMenu()">
      <img src="../assets/menu.svg">
    </div>  
    <transition enter-active-class="animate__animated animate__fadeInLeft" leave-active-class="animate__animated animate__fadeOutLeft">
    <div class="menu" v-if="menuOpt">
      <button @click="newGame()">Új játék</button>
    </div>
    </transition>
    <div class="box">
    <div id="users">
      <div class="user" v-for="player in players" :key="player">
        <h1 class="username">{{player.username}}</h1>
        <input type="number" class="number" @blur="updateData(player.playerID, 'one', player.one)" v-on:input="player.one = $event.target.value" v-bind:value="player.one">
        <input type="number" class="number" @blur="updateData(player.playerID, 'two', player.two)" v-on:input="player.two = $event.target.value" v-bind:value="player.two">
        <input type="number" class="number" @blur="updateData(player.playerID, 'three', player.three)" v-on:input="player.three = $event.target.value" v-bind:value="player.three">
        <input type="number" class="number" @blur="updateData(player.playerID, 'four', player.four)" v-on:input="player.four = $event.target.value" v-bind:value="player.four">
        <input type="number" class="number" @blur="updateData(player.playerID, 'five', player.five)" v-on:input="player.five = $event.target.value" v-bind:value="player.five">
        <input type="number" class="number" @blur="updateData(player.playerID, 'six', player.six)" v-on:input="player.six = $event.target.value" v-bind:value="player.six">
        <input type="number" class="number" @blur="updateData(player.playerID, 'seven', player.seven)" v-on:input="player.seven = $event.target.value" v-bind:value="player.seven">
        <input type="number" class="number" @blur="updateData(player.playerID, 'eight', player.eight)" v-on:input="player.eight = $event.target.value" v-bind:value="player.eight">
        <input type="number" class="number" @blur="updateData(player.playerID, 'nine', player.nine)" v-on:input="player.nine = $event.target.value" v-bind:value="player.nine">
        <input type="number" class="number" @blur="updateData(player.playerID, 'ten', player.ten)" v-on:input="player.ten = $event.target.value" v-bind:value="player.ten">
        <p class="sum"></p>
      </div>
    </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "GameAdminStart",
  props: ["gamecode"],
  data() {
    return {
      menuOpt: false,
      values: [],
      players: [],
    };
  },
  mounted: function () {
    axios({
      method: "post",
      url: "api/createuser.php",
      data: {
        showall: this.gamecode,
      },
    }).then((response) => {
      this.players = response.data;
    });
  },
  methods: {
    showMenu() {
      if(!this.menuOpt){
        this.menuOpt = true;
      } else{
        this.menuOpt = false;
      }
    },

    updateData(name, where, value) {
      axios({
        method: "post",
        url: "api/createuser.php",
        data: {
          name: name,
          column: where,
          value: value,
        },
      });
    },

    sum() {
      this.values = setInterval(() => {
        var sum = document.getElementsByClassName("sum");

        axios({
          method: "post",
          url: "api/createuser.php",
          data: {
            getnumbers: this.gamecode,
          },
        }).then((response) => {
          this.values = response.data;
        });

        for (var i = 0; i < this.values.length; i++) {
          var sumValue = 0;
          for (var x = 3; x < 13; x++) {
            sumValue += this.values[i][x];
          }
          sum[i].innerHTML = sumValue;
        }
      }, 250);
    },

    newGame() {
      axios({
        method: "post",
        url: "api/createuser.php",
        data: {
          restart: this.gamecode,
        },
      }).then((resp) => {
        this.players = resp.data;
      });
    },
  },
  created() {
    this.sum();
  },
};
</script>

<style scoped>

.box {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
}

#btn{
  margin: 5px;
  position: relative;
  box-sizing: border-box;
  width: 35px;
  height: 35px;
  border: 3px solid #000000;
  border-radius: 9px;
  cursor: pointer;
}

#btn img{
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.menu{
  box-sizing: border-box;
  padding: 5px;
  position: absolute;
  width: 100%;
  height: auto;
  max-width: 200px;
  background: #fff;
  border-top: 1px solid #000;
  border-right: 1px solid #000;
  border-bottom: 1px solid #000;
}

.menu button {
  width: 100%;
  height: 40px;
  border: none;
  border-radius: 9px;
  background: #00e0ff;
  font-size: 1em;
  font-weight: bold;
  color: #fff;
}

#users {
  width: 100%;
  display: grid;
  grid-template-columns: repeat(auto-fit, 320px);
  grid-gap: 15px;
}

.user {
  margin: 0 10px;
  width: 320px;
  border-radius: 30px;
  box-shadow: 4px 4px 8px #cacaca;
}

.user h1 {
  text-align: center;
  padding: 20px 0;
  background: #00ffb2;
  font-weight: bold;
  text-align: center;
  font-size: 1.2em;
  color: #fff;
  border-radius: 30px 30px 0 0;
}

.user input {
  box-sizing: border-box;
  width: 100%;
  height: 30px;
  text-align: center;
  border: none;
  border-bottom: 1px solid #bcbcbc;
  padding: 5px 10px;
}

.sum {
  box-sizing: border-box;
  text-align: center;
  padding: 10px 0;
  font-weight: bold;
  color: #fff;
  background: #00e0ff;
  border-radius: 0 0 30px 30px;
  padding: 15px 0;
  font-size: 1.2em;
}
</style>