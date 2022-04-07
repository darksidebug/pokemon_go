<template>
    <div class='px-4 sm:px-2 container mx-auto mt-12'>

        <div class="mt-10 flex flex-wrap justify-start items-center">
            <input v-model="form.searchInput" name="name" type="text" class='border-2 border-blue-600 rounded py-2 px-4 outline-0 w-full md:w-[20%]' placeholder='Search pokemon' />
            <button @click.prevent="searchPokemon" :disabled="nxtUrl == null ? true : false" class="ml-2 text-white bg-blue-700 border-2 border-blue-700 hover:border-blue-800 hover:text-white hover:bg-blue-800 focus:ring-4 focus:outline-none 
                            focus:ring-blue-300 font-medium rounded px-5 py-2 text-center mr-1 dark:bg-blue-800 
                            dark:hover:bg-blue-800 dark:focus:ring-blue-800">Search</button>
        </div>

        <div class='grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-10 gap-4 2xs:gap-6 md:gap-4 my-3 mt-10'>
            <div v-if="!this.pokemons.length">
                <lists-of-pokemon :pokemon="pokemon" :url="apiUrl" :img_sourse="imgUrl" />
            </div>
            <div v-for="(pokemon, index) in pokemons" :key="index" class="mt-0 relative group">
                <lists-of-pokemon :pokemon="pokemon" :url="apiUrl" :img_sourse="imgUrl" />
            </div>
        </div>

        <div class="mt-10 flex flex-wrap justify-start items-center">
            <button @click.prevent="getPrevPokemons" :disabled="prevUrl == null ? true : false" class="text-white bg-blue-700 border-2 border-blue-700 hover:border-blue-800 hover:text-white hover:bg-blue-800 focus:ring-4 focus:outline-none 
                            focus:ring-blue-300 font-medium rounded px-5 py-2 text-center mr-1 dark:bg-blue-800 
                            dark:hover:bg-blue-800 dark:focus:ring-blue-800">Previous</button>
            <button @click.prevent="getNextPokemons" :disabled="nxtUrl == null ? true : false" class="text-white bg-blue-700 border-2 border-blue-700 hover:border-blue-800 hover:text-white hover:bg-blue-800 focus:ring-4 focus:outline-none 
                            focus:ring-blue-300 font-medium rounded px-5 py-2 text-center mr-1 dark:bg-blue-800 
                            dark:hover:bg-blue-800 dark:focus:ring-blue-800">Next</button>
        </div>
    </div>
</template>

<script>

import PokemonLists from './PokemonList'

export default {
    components: {
        'lists-of-pokemon': PokemonLists
    },
    data() {
        return {
            apiUrl: process.env.MIX_API_URI_LINK,
            imgUrl: process.env.MIX_IMG_URI_LINK,
            nxtUrl: null,
            prevUrl: null,
            offset: 0,
            limit: 40,
            pokemons: [],
            pokemon:{
                id: null,
                name: null
            },
            form:{
                searchInput: null
            }
        }
    },
    methods: {
        async fetchPokemonData() {
            await axios.get(process.env.MIX_API_URI_LINK + 'pokemon/?offset=' + this.offset + '&limit=' + this.limit)
            .then((res) => {
                console.log(res.data)
                if(res.status === 200){
                    this.nxtUrl = res.data.next;
                    this.prevUrl = res.data.previous;
                    res.data.results.forEach(pokemon => {
                        pokemon.id = pokemon.url.split('/').filter(function(part){ return !!part }).pop();
                        this.pokemons.push(pokemon);
                    })
                }
            })
            .catch((error) => {
                console.log(error)
            })
        },
        async getNextPokemons(){
            this.pokemons = [];
            await axios.get(this.nxtUrl)
            .then((res) => {
                console.log(res.data)
                if(res.status === 200){
                    this.nxtUrl = res.data.next;
                    this.prevUrl = res.data.previous;
                    res.data.results.forEach(pokemon => {
                        pokemon.id = pokemon.url.split('/').filter(function(part){ return !!part }).pop();
                        this.pokemons.push(pokemon);
                    })
                }
            })
            .catch((error) => {
                console.log(error)
            })
        },
        async getPrevPokemons(){
            this.pokemons = [];
            await axios.get(this.prevUrl)
            .then((res) => {
                console.log(res.data)
                if(res.status === 200){
                    this.nxtUrl = res.data.next;
                    this.prevUrl = res.data.previous;
                    res.data.results.forEach(pokemon => {
                        pokemon.id = pokemon.url.split('/').filter(function(part){ return !!part }).pop();
                        this.pokemons.push(pokemon);
                    })
                }
            })
            .catch((error) => {
                console.log(error)
            })
        },
        async searchPokemon(){
            this.pokemons = [];
            await axios.get(process.env.MIX_API_URI_LINK + 'pokemon/' + this.form.searchInput)
            .then((res) => {
                console.log(res.data)
                if(res.status === 200){
                    this.pokemon.id = res.data.id
                    this.pokemon.name = res.data.name
                }
            })
            .catch((error) => {
                console.log(error)
            })
        }
    },
    async created(){
        await this.fetchPokemonData();
    }
}
</script>