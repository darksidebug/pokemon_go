<template>
    <div class='px-4 sm:px-2 container mx-auto mt-12'>

        <div class='grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-10 gap-4 2xs:gap-6 md:gap-4 my-3'>
            <div v-for="(pokemon, index) in pokemons" :key="index" class="mt-0 relative group">
                <lists-of-pokemon :pokemon="pokemon" :url="apiUrl" :img_sourse="imgUrl" />
            </div>
        </div>

        <div class="mt-10 flex flex-wrap justify-start items-center">
            <button :disabled="prevUrl == null ? true : false" class="text-white bg-blue-700 border-2 border-blue-700 hover:border-blue-800 hover:text-white hover:bg-blue-800 focus:ring-4 focus:outline-none 
                            focus:ring-blue-300 font-medium rounded px-5 py-2 text-center mr-1 dark:bg-blue-800 
                            dark:hover:bg-blue-800 dark:focus:ring-blue-800">Previous</button>
            <button :disabled="nxtUrl == null ? true : false" class="text-white bg-blue-700 border-2 border-blue-700 hover:border-blue-800 hover:text-white hover:bg-blue-800 focus:ring-4 focus:outline-none 
                            focus:ring-blue-300 font-medium rounded px-5 py-2 text-center mr-1 dark:bg-blue-800 
                            dark:hover:bg-blue-800 dark:focus:ring-blue-800">Next</button>
        </div>
    </div>
</template>