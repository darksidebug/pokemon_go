<template>
    <div>
        <navigation-bar />
        <pokemons />
    </div>
</template>
<script>
import Pokemons from './PokemonView'
import Navbar from './Navbar.vue'

export default {
    components: {
        'pokemons': Pokemons,
        'navigation-bar': Navbar
    }
}
</script>