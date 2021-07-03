<template>
  <div class="col-lg-8 mx-auto p-3 py-md-5">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start mb-3">
      <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
        <img src="./assets/bookmark.svg" alt="Favoritos" width="30" height="30">
      </a>

      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <!-- <li><a href="#" class="nav-link px-2 link-secondary">Overview</a></li> -->
        <li><router-link to="/" class="nav-link px-2 link-dark">Início</router-link></li>
        <li><router-link to="/about" class="nav-link px-2 link-dark">Sobre</router-link></li>
      </ul>

      <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
        <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
      </form>

      <div class="dropdown text-end">
        <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://github.com/mdo.png" alt="mdo" class="rounded-circle" width="32" height="32">
        </a>
        <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
          <li><a class="dropdown-item" href="#">New project...</a></li>
          <li><a class="dropdown-item" href="#">Settings</a></li>
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="#">Sign out</a></li>
        </ul>
      </div>
    </div>

    <router-view/>

    <footer class="pt-5 my-5 text-muted border-top">
      Created by Lucas Saliés Brum &middot; &copy; 2021
    </footer>
  </div>
</template>

<style lang="scss">
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap');

#app {
  font-family: 'Nunito', Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

.nav {
  // padding: 30px;

  li a {
    // font-weight: bold;
    // color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
