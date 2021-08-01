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
        <input type="text" v-model="newplayer">
        <button @click="addPlayer">Új játékos</button>
        <button @click="startgame">START</button>
        <ul>
            <li v-for="player in players" :key="player.username">
                {{player.username}}
                <button @click="deletePlayer(player.username)">-</button>
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
                        url: "http://localhost:8080/createuser.php",
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
                    url: "http://localhost:8080/createuser.php",
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
                   url: "http://localhost:8080/createuser.php",
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



</style>