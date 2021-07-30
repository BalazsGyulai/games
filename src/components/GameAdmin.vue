<template>
    <div>
        <p>Oszd meg a kóddot a barátaiddal: {{gamecode}}</p>
        <h1>GameAdmin</h1>
        <ul>
            <li v-for="player in players" :key="player.name">
                {{player.name}}
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
                        this.players = {name: response.data};
                        console.log(this.players);
                    })
                }, 1000)
            }
        },
        created () {
            this.refreshPlayers();
        },
    }
</script>

<style scoped>

</style>