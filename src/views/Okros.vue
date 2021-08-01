<template>
  <div id="okros">
    <component :username="user.username" :gamecode="user.gamecode" v-on:choosedTarget="chooseTarget($event);" @startGame="startGame($event);" :is="activeTab" />
  </div>

</template>

<script>
import Choose from '../components/Choose.vue'
import SetAdmin from '../components/SetAdmin.vue'
import SetPlayer from '../components/SetPlayer.vue'
import GamePlayer from '../components/GamePlayer.vue'
import GameAdmin from '../components/GameAdmin.vue'
import GameAdminStart from '../components/GameAdminStart.vue'

export default {
  name: "Okros",
  components: {
    Choose,
    SetAdmin,
    SetPlayer,
    GamePlayer,
    GameAdmin,
    GameAdminStart
  },
  data() {
    return {
      activeTab: 'Choose',
      user: {
        username: '',
        gamecode: ''
      },
    };
  },
  methods: {
    chooseTarget(value){
      this.activeTab = value.opt;
      if(value.username){
        this.user.username = value.username;
        this.user.gamecode = value.gamecode;
      }
    },
    startGame(value){
      this.activeTab = value
    }
  },
};
</script>

<style scoped>


</style>