<template>
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
        <!-- <img src="https://github.com/mdo.png" alt="mdo" class="rounded-circle" width="32" height="32"> -->
        <font-awesome-icon :icon="['fas', 'user-circle']" size="lg" />
      </a>
      <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
        <li><router-link to="/login" class="dropdown-item">Login</router-link></li>
        <li><router-link to="/login" class="dropdown-item">Login</router-link></li>
        <li><router-link to="/login" class="dropdown-item">Login</router-link></li>
        <li><hr class="dropdown-divider"></li>
        <li><router-link to="/login" class="dropdown-item">Login</router-link></li>
      </ul>
    </div>
  </div>
</template>
<script>
export default {
  name: 'Navbar',
  // props: {
  //   msg: String
  // }
}
</script>