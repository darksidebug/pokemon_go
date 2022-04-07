<template>
    <div class='relative group text-center border-2 border-blue-500 rounded bg-gradient-to-b from-white to-gray-50'>
        <div class="flex align-items-center justify-center py-4 overflow-hidden">
            <router-link :to="{path: '/pokemon/details/' + pokemon.id}">
                <img :src="img_sourse + pokemon.id + '.png'" :alt="pokemon.name"
                    class="h-fit w-auto">
                <small class="uppercase text-gray-700 truncate font-semibold">{{pokemon.name}}</small>

                <div class='group-hover:bg-gray-800 group-hover:bg-opacity-20 absolute h-[100%] w-[100%] top-0 left-0 z-10 rounded flex justify-center items-center'>
                    <div class='h-0 w-0 group-hover:h-10 group-hover:w-10 text-white group-hover:bg-[#48CFAD] p-2 rounded-full transition ease-in-out'>
                        <svg class="hidden group-hover:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 17l5-5-5-5"/><path d="M13.8 12H3m9 10a10 10 0 1 0 0-20"/></svg>
                    </div>
                </div>
            </router-link>
        </div>
    </div>
</template>
<script>
export default {
    props: ['pokemon', 'url', 'img_sourse']
}
</script>