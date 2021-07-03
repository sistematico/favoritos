<template>
  <div class="col-lg-8 mx-auto p-3 py-md-5">
    <Navbar />

    <router-view/>

    <footer class="pt-5 my-5 text-muted border-top">
      Created by Lucas Saliés Brum &middot; &copy; 2021
    </footer>
  </div>
</template>
<script>
import Navbar from '@/components/Navbar.vue'

export default {
  name: 'Main',
  components: {
    Navbar
  },
  data() {
    return {
      api_url: process.env.VUE_APP_API_URL || 'https://favoritos-api.lucasbrum.net'
    }
  },
  mounted () {
    console.log(this.api_url)
  }
}
</script>
<style lang="scss">
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap');

#app {
  font-family: 'Nunito', Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

.nav {
  li a {
    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
