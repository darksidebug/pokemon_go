<template>
    <div>
        <navigation-bar />

        <div class="container mx-auto px-4 sm:px-2 mt-12">
            <div class="md:flex md:justify-start">
                <div class="h-auto w-full md:w-[16%] py-6 rounded border-2 border-blue-500 bg-gradient-to-b from-white to-gray-50">
                    <img :src="this.imgUrl" alt="Pokemon" class="h-full w-full">
                </div>
                <div class="md:px-6 mt-4 md:mt-0">
                    <h2 class="uppercase text-4xl font-bold text-blue-800">{{this.name}}</h2>
                    <div class="mt-4">
                        <h4 class="text-gray-700">Experience: {{this.exp}}</h4>
                        <h4 class="text-gray-700">Weight: {{this.weight}}</h4>
                        <h4 class="text-gray-700">Height: {{this.height}}</h4>
                        <h4 class="text-gray-700">Total Moves: {{this.moves.length}}</h4>
                    </div>
                    <div class="mt-10">
                        <button @click.prevent="addToLike" class="text-white bg-blue-700 border-2 border-blue-700 hover:border-blue-800 hover:text-white hover:bg-blue-800 focus:ring-4 focus:outline-none 
                            focus:ring-blue-300 font-medium rounded px-5 py-1 text-center mr-1 dark:bg-blue-800 
                            dark:hover:bg-blue-800 dark:focus:ring-blue-800" :disabled="this.isLikeSubmitted ? true : false">{{ this.isLikeSubmitted ? '...' : 'Like' }}</button>
                        <button @click.prevent="addToDislike" class="text-white bg-red-500 border-2 border-red-500 hover:border-red-600 hover:text-white hover:bg-red-600 focus:ring-4 focus:outline-none 
                            focus:ring-red-300 font-medium rounded px-5 py-1 text-center mr-1 dark:bg-red-600 
                            dark:hover:bg-red-600 dark:focus:ring-red-600" :disabled="this.isDislikeSubmitted ? true : false">{{ this.isDislikeSubmitted ? '...' : 'Dislike' }}</button><br>
                        
                        <div class="flex items-center justify-start mt-4">
                            <div class="flex items-center justify-between">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="#000000" 
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                                </svg>
                                {{this.usersLikeThisPokemon.length}}
                            </div>
                            <div class="flex items-center justify-between pl-12">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="#000000" 
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path>
                                </svg>
                                {{this.usersDislikeThisPokemon.length}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="md:flex md:justify-start mt-10">
                <div class="w-full sm:w-[40%] md:w-[20%] mr-6">
                    <h4 class="text-gray-700 text-lg font-semibold">
                        People who likes:
                    </h4>
                    <div class="bg-white text-gray-700 py-1 px-2 rounded border border-gray-200 my-4">
                        <span v-if="!this.usersLikeThisPokemon.length" class="text-muted text-center">- None -</span>
                        <div v-for="(user, index) in this.usersLikeThisPokemon" :key="index">
                            <span>- {{ user.firstname + ' ' + user.lastname }}</span><br>
                        </div>
                    </div>
                </div>
                <div class="w-full sm:w-[40%] md:w-[20%]">
                    <h4 class="text-gray-700 text-lg font-semibold">
                        People who hates:
                    </h4>
                    <div class="bg-white text-gray-700 py-1 px-2 rounded border border-gray-200 my-4">
                        <span v-if="!this.usersDislikeThisPokemon.length" class="text-muted text-center">- None -</span>
                        <div v-for="(user, index) in this.usersDislikeThisPokemon" :key="index">
                            <span>- {{ user.firstname + ' ' + user.lastname }}</span><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Navbar from './Navbar.vue'

export default {
    components: {
        'navigation-bar': Navbar
    },
    data() {
        return {
            apiUrl: process.env.MIX_API_URI_LINK,
            imgUrl: process.env.MIX_IMG_URI_LINK + this.$route.params.id + '.png',
            name: null,
            exp: null,
            weight: null,
            height: null,
            moves: [],
            isLikeSubmitted: false,
            isDislikeSubmitted: false,
            form: {
                id: this.$route.params.id,
                name: null
            },
            usersLikeThisPokemon: [],
            usersDislikeThisPokemon: [],
            errors:[]
        }
    },
    methods: {
        async fetchPokemonDetails() {

            await axios.get(this.apiUrl + 'pokemon/' + this.$route.params.id)
            .then((res) => {

                if(res.status === 200){

                    console.log(res.data);
                    this.name = res.data.name;
                    this.exp = res.data.base_experience;
                    this.weight = res.data.weight;
                    this.height = res.data.height;
                    this.moves = res.data.moves;
                }
            })
            .catch((error) => {

                console.log(error)
            })
        },
        async addToLike(){

            this.isLikeSubmitted = true;
            await axios.post('/api/add-to-like', this.form)
            .then((res) =>{

                if(res.data.status === 406 && res.data.statusText == 'Not Allowed'){
                    if(confirm('Warning: ' + res.data.err)){

                        this.changeToLikePokemon();
                    }
                    return;
                }

                if(res.data.status === 405 && res.data.statusText == 'Not Allowed'){

                    alert('Warning: ' + res.data.err);
                    this.isLikeSubmitted = false;
                    return;
                }

                if(res.status === 200 && res.statusText == 'OK'){
                    this.isLikeSubmitted = false;
                    alert('Pokemon added to likes.')
                }
            })
            .catch((error) => {

                this.isLikeSubmitted = false;
                alert("Error: Please contact the developer.");
            })
        },
        async addToDislike(){

            this.isDisikeSubmitted = true;
            await axios.post('/api/add-to-dislike', this.form)
            .then((res) =>{

                if(res.data.status === 405 && res.data.statusText == 'Not Allowed'){

                    alert('Warning: ' + res.data.err);
                    this.isDisikeSubmitted = false;
                    return;
                }

                if(res.data.status === 406 && res.data.statusText == 'Not Allowed'){

                    if(confirm('Warning: ' + res.data.err)){

                        this.changeToDislikePokemon();
                    }
                    return;
                }

                if(res.status === 200 && res.statusText == 'OK'){

                    alert('Pokemon added to dislikes.')
                }
            })
            .catch((error) => {

                this.isDisikeSubmitted = false;
                alert("Error: Please contact the developer.");
            })
        },
        async changeToDislikePokemon(){

            await axios.post('/api/change-to-dislike', this.form)
            .then((res) =>{

                if(res.status === 200 && res.statusText == 'OK'){

                    this.isDislikeSubmitted = false;
                    alert('Pokemon where added to dislikes.')
                }
            })
            .catch((error) => {

                this.isDislikeSubmitted = false;
                alert("Error: Please contact the developer.");
            })
        },
        async changeToLikePokemon(){

            await axios.post('/api/change-to-like', this.form)
            .then((res) =>{

                if(res.status === 200 && res.statusText == 'OK'){

                    this.isLikeSubmitted = false;
                    alert('Pokemon where added to dislikes.')
                }
            })
            .catch((error) => {

                this.isLikeSubmitted = false;
                alert("Error: Please contact the developer.");
            })
        },
        async getUser(){

            await axios.get('/api/user')
            .then((res)=>{

                this.form.name = this.name
            })
        },
        async getUsersLikedThisPokemon(){

            await axios.post('/api/users-liked-this-pokemon', this.form)
            .then((res) => {

                this.usersLikeThisPokemon = res.data.users;
            })
            .catch((error) => {

                alert("Error: Please contact the developer.");
            })
        },
        async getUsersDislikedThisPokemon(){

            await axios.post('/api/users-disliked-this-pokemon', this.form)
            .then((res) => {

                this.usersDislikeThisPokemon = res.data.users;
            })
            .catch((error) => {

                alert("Error: Please contact the developer.");
            })
        }
    },
    async created(){
        await this.fetchPokemonDetails();
        await this.getUser();
        await this.getUsersLikedThisPokemon();
        await this.getUsersDislikedThisPokemon();
    }
}
</script>