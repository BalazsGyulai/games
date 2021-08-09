<template>
    <div class="game">
        <div class="code">
            <div class="img">
            <img src="../assets/code.svg">
            </div>
            <div class="content">
            <span>Oszd meg a kóddot a barátaiddal: {{gamecode}}</span>
            </div>
        </div>
        <input type="text" v-model="newplayer" placeholder="Új játékos neve">
        <button id="newplayer" @click="addPlayer">Új játékos</button>
        <button @click="startgame">START</button>
        <h1>Játékosok:</h1>
        <ul>
            <li v-for="player in players" :key="player.username">
                {{player.username}}
                <button @click="deletePlayer(player.username)"><img src="../assets/delete.svg"></button>
            </li>
        </ul>
    </div>
</template>

<script>
    import axios from 'axios'
    
    export default {
        name: 'GameAdmin',
        props: ['gamecode'],
        data() {
             return {
                players: [],
                newplayer: '',
                opt: 'GameAdminStart'
             }
        },
        methods: {
            refreshPlayers(){
                this.players = setInterval(() => {
                    axios({
                        method: "post",
                        url: "api/createuser.php",
                        data: {
                            order: this.gamecode
                        },
                    })
                    .then((response) => {
                        this.players = response.data;
                    })
                }, 1000)
            },
            addPlayer(){
                axios({
                    method: "post",
                    url: "api/createuser.php",
                    data: {
                        newplayer: this.newplayer,
                        gamecode: this.gamecode
                    }
                })
                .then(() => {
                    this.newplayer = '';
                })
            },
            deletePlayer(name){
                axios({
                   method: "post",
                   url: "api/createuser.php",
                   data: {
                       delplayer: name
                   }
                })
            },
            startgame(){
                this.$emit("startGame", this.opt);
            }
        },
        created () {
            this.refreshPlayers();
        },
    }
</script>

<style scoped>
.game{
    position: absolute;
    top: 10px;
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    max-width: 320px;
}

.code{
    display: grid;
    grid-template-columns: 30px auto;
    background: #43a0bb;
    height: 100px;
    border-radius: 5px;
    margin-bottom: 10px;
}

.img{
    position: relative;
}

.img img{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.content{
    position: relative;
}

.content span{
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    padding: 0 10px;
    color: #fff;
}

input{
    position: relative;
    width: 100%;
    height: 60px;
    padding: 5px 30px;
    box-sizing: border-box;
    max-width: 320px;
    border: 1px solid #bcbcbc;
    border-radius: 30px;
    outline: none;
    font-size: 1em;
    transition: 0.3s;
}

input:focus {
  border: 1px solid #00ffb2;
  transition: 0.3s;
}

.game > button {
    position: relative;
    width: 100%;
    max-width: 320px;
    height: 60px;
    margin: 5px 0;
    border-radius: 30px;
    border: none;
    background: #00ffb2;
    outline: none;
    font-size: 1.3em;
    font-weight: bold;
    color: #fff;
    cursor: pointer;
    transition: 0.3s;
}

.game > #newplayer {
    background: #00E0FF;
}

.game > button:hover {
  background: #7effd8;
  transition: 0.3s;
}

.game > #newplayer:hover {
  background: #8ff2ff;
  transition: 0.3s;
}

h1 {
    padding: 5px;
    text-align: center;
    font-weight: normal;
    font-size: 1.2em;
}

ul li{
    box-sizing: border-box;
    position: relative;
    width: 100%;
    min-width: 100px;
    max-width: 320px;
    list-style: none;
    text-align: center;
    padding: 10px 5px;
    border-bottom: 1px solid #bcbcbc;
}

ul li button{
    position: absolute;
    top: 50%;
    left: calc(100% - 5px);
    transform: translate(-100%, -50%);
    box-sizing: border-box;
    padding: 3px;
    border: none;
    background: #c34a43;
    border-radius: 3px;
    cursor: pointer;
    transition: 0.3s;
}

ul li button:hover {
    background: #e07772;
    transition: 0.3s;
}
</style>