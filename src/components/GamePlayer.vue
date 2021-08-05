<template>
  <div>
    <div id="player" v-for="player in players" :key="player">
      <h1><span>{{player.username}}</span></h1>
      <div class="box">
        <p>{{player.one}}</p>
        <p v-if="player.two != '0'">{{player.two}}</p>
        <p v-if="player.three != '0'">{{player.three}}</p>
        <p v-if="player.four != '0'">{{player.four}}</p>
        <p v-if="player.five != '0'">{{player.five}}</p>
        <p v-if="player.six != '0'">{{player.six}}</p>
        <p v-if="player.seven != '0'">{{player.seven}}</p>
        <p v-if="player.eight != '0'">{{player.eight}}</p>
        <p v-if="player.nine != '0'">{{player.nine}}</p>
        <p v-if="player.ten != '0'">{{player.ten}}</p>
        <p class="sum">{{
          player.one +
          player.two +
          player.three +
          player.four +
          player.five +
          player.six +
          player.seven +
          player.eight +
          player.nine +
          player.ten
          }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "GamePlayer",
  props: ["username"],
  data() {
    return {
      players: [],
    };
  },
  mounted: function () {
    axios({
      method: "post",
      url: "api/createuser.php",
      data: {
        getcurrentplayer: this.username,
      },
    }).then((response) => {
      this.players = response.data;
    });
  },
  methods: {
    getplayer() {
      setInterval(() => {
        axios({
          method: "post",
          url: "api/createuser.php",
          data: {
            getcurrentplayer: this.username,
          },
        }).then((response) => {
          this.players = response.data;
        });
      }, 250);
    },
  },
  created() {
    this.getplayer();
  },
};
</script>

<style scoped>
#player {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  width: 100%;
  max-width: 320px;
}

h1 {
  box-sizing: border-box;
  margin: 10px 0;
  padding: 20.8px 30px;
  width: 100%;
  max-width: 320px;
  background: #00ffb2;
  border-radius: 30px;
  font-size: 1.2em;
  font-weight: bold;
  text-align: center;
  color: #fff;
}

.box {
  width: 100%;
  max-width: 320px;
  box-shadow: 4px 4px 8px #dddddd;
  border-radius: 30px;
}

.box p {
  box-sizing: border-box;
  padding: 20.8px 30px;
  text-align: center;
  font-size: 1.2em;
}

.sum {
  font-weight: bold;
  color: #fff;
  background: #00e0ff;
  border-radius: 0 0 30px 30px;
}
</style>