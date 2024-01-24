<template>
    <v-app>
        <v-data-table :items="items"></v-data-table>

      <router-view/>
    </v-app>
</template>
<script setup>
    const items = [
    {
      name: 'African Elephant',
      species: 'Loxodonta africana',
      diet: 'Herbivore',
      habitat: 'Savanna, Forests',
    },
    // ... more items
  ]
  console.log(items)
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;

  color: #2c3e50;
}


</style>
