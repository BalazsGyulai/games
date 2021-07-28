<template>
  <div>
    <div id="mainmenu" v-if="optmenu">

      <!--     <div id="back">
      <router-link><img src="../assets/back.svg"></router-link>
    </div> -->

      <div id="links">
        <h1><span :style="{color: color}">&lt;</span>Játékok<span :style="{color: color}">&gt;</span></h1>
        <router-link to="/dobokockas" @click="optmenu = false"><span :style="{color: color}">&lt;</span>Dobókockás<span :style="{color: color}">&gt;</span></router-link>
        <router-link to="/okros" @click="optmenu = false"><span :style="{color: color}">&lt;</span>Ökrös<span :style="{color: color}">&gt;</span></router-link>
        <!--     <router-link to="/snapszer">Snapszer</router-link>
    <router-link to="/torpedo">Torpedo</router-link> -->
      </div>
    </div>

    <router-view v-if="!optmenu"></router-view>
  </div>
</template>

<script>
export default {
  name: "Nav",
  data() {
    return {
      color: "#ff0000",
      optmenu: true,
    };
  },
  provide() {
    return {
      menu: this.menu,
    };
  },
};
</script>

<style scoped>
#back {
  position: relative;
  margin: 5px;
  width: 40px;
  height: 40px;
}

#back a {
  position: absolute;
  width: 100%;
  height: 100%;
  transition: 0.5s;
}

#back a img {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

#links {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  min-width: 150px;
  display: grid;
  grid-template-columns: 100%;
  grid-auto-rows: auto;
}

#links h1 {
  text-align: center;
  font-size: 2.5em;
  margin-bottom: 20px;
}

#links a {
  text-align: center;
  text-decoration: none;
  color: #4d4d4d;
  padding: 10px 5px;
  font-size: 1.5em;
  transition: 0.5s;
}

#links a:hover,
#back a:hover {
  letter-spacing: 1px;
  background: #e4e4e4;
  transition: 0.5s;
}
</style>