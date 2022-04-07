<template>
    <div class="container mx-auto flex items-center justify-center mb-10">
        <img v-bind:src="pokemon" v-bind:alt="'Pokemon Go'" class="h-32 block">
    </div>
</template>
<script>
export default {
    data(){
        return {
            pokemon: 'img/Pokemon.png'
        }
    }
}
</script>