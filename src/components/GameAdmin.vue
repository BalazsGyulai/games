<template>
    <div>
        <p>Oszd meg a kóddot a barátaiddal:</p>
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
        data() {
             return {
                players: [
                    { name: 'Bali'},
                    { name: 'Geri'},
                    { name: 'Atis'}
                ],
             }
        },
        methods: {
            refreshPlayers(){
                this.players = setInterval(() => {
                    axios({
                        method: "post",
                        url: "http://localhost:8080/createuser.php",
                        data: {
                            order: 'players'
                        },
                    })
                    .then((response) => {
                        console.log(response.data);
                    })
                }, 0)
            }
        },
        ceated () {
            this.refreshPlayers();
        }
    }
</script>

<style scoped>

</style>