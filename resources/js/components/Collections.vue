<template>
    <div>
        <navigation-bar />
        
        <div class='px-4 sm:px-2 container mx-auto mt-12'>
            <h2 class="text-blue-700 text-xl font-semibold">Pokemon Collections</h2>
            <div class='grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4 2xs:gap-6 md:gap-4 my-5'>
                <div v-for="(pokemon, index) in pokemons" :key="index" class="mt-0 relative group">
                    <collection-list :pokemon="pokemon" :img_sourse="imgUrl" />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import CollectionLists from './CollectionList'
import Navbar from './Navbar'

export default {
    components: {
        'collection-list' : CollectionLists,
        'navigation-bar': Navbar
    },
    data(){
        return{
            apiUrl: process.env.MIX_API_URI_LINK,
            imgUrl: process.env.MIX_IMG_URI_LINK,
            pokemons: [],
            id: null
        }
    },
    methods: {
        async getAuthenticatedUser(){
            await axios.get('/api/user')
            .then((res) => {

                this.id = res.data.id;
            })
            .catch((error) => {
                console.log(error)
                alert('Warning: Please contact the developer.')
            })
        },
        async fetchPokemonCollection() {
            await axios.post('api/my-collections', {user_id: this.id})
            .then((res) => {

                if(res.status === 200){
                    res.data.pokemons.forEach(pokemon => {
                        this.pokemons.push({id: '', name: '', pokemon_id: pokemon.pokemon_id, like: pokemon.isLike, loved: pokemon.isFavorate})
                        this.fetchPokemonDetails(pokemon.pokemon_id)
                    })
                }
            })
            .catch((error) => {
                console.log(error)
            })
        },
        async fetchPokemonDetails(id){
            await axios.get(this.apiUrl + 'pokemon/' + id)
            .then((res) => {

                if(res.status === 200){
                    this.pokemons.forEach(pokemon => {

                        if(pokemon.pokemon_id === res.data.id){
                            pokemon.id = res.data.id
                            pokemon.name = res.data.name
                            
                        }
                    })
                }
                console.log(this.pokemons)
            })
            .catch((error) => {
                console.log(error)
            })
        }
    },
    async created() {
        await this.getAuthenticatedUser()
        await this.fetchPokemonCollection()
    },
}
</script>