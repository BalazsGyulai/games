<template>
  <div>
    <button @click="newGame()">Új játék</button>
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
</template>

<script>
import axios from "axios";

export default {
  name: "GameAdminStart",
  props: ["gamecode"],
  data() {
    return {
      values: [],
      players: [],
    };
  },
  mounted: function () {
    axios({
      method: "post",
      url: "http://localhost:8080/createuser.php",
      data: {
        showall: this.gamecode,
      },
    }).then((response) => {
      this.players = response.data;
    });
  },
  methods: {
    updateData(name, where, value) {
      axios({
        method: "post",
        url: "http://localhost:8080/createuser.php",
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
          url: "http://localhost:8080/createuser.php",
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
        url: "http://localhost:8080/createuser.php",
        data: {
          restart: this.gamecode,
        },
      })
      .then((resp) => {
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
#users{
    width: 100%;
    overflow-x: scroll;
    display: flex;
}

.user{
    margin: 0 10px;
    width: 320px;
}

.user h1{
    text-align: center;
    padding: 5px 0;
}

.user input{
    width: 100%;
    height: 30px;
    border: 1px solid #bcbcbc;
}

.sum{
    text-align: center;
    padding: 10px 0;
}

</style>