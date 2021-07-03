<template>
  <div class="col-lg-8 mx-auto p-3 py-md-5">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-5 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <img src="./assets/bookmark.svg" alt="Favoritos" width="30" height="30">
        <span class="fs-4">Favoritos</span>
      </a>

      <ul class="nav nav-pills">
        <li class="nav-item"><router-link to="/" class="nav-link active" aria-current="page">Início</router-link></li>
        <li class="nav-item"><router-link to="/about" class="nav-link">Sobre</router-link></li>
      </ul>
    </header>

    <router-view/>

    <footer class="pt-5 my-5 text-muted border-top">
      Created by Lucas Saliés Brum &middot; &copy; 2021
    </footer>
  </div>
</template>

<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

#nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
