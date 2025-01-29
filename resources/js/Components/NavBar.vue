<script setup>
import { toRefs, ref, onMounted } from 'vue';
const props = defineProps({
    menus: Array
});

const { menus } = toRefs(props);


</script>
<template>
  <nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
    <div class="d-flex align-items-center">
      <div class="toggle-icon-wrapper">
        <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Navegacion"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
      </div><a class="navbar-brand" href="/">
        <div class="d-flex align-items-center py-3"><img class="me-2" src="banner.jpg" alt="" width="220px"></div>
      </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
      <div class="navbar-vertical-content scrollbar">
        <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
          <li class="nav-item">
            <!-- parent pages--><a class="nav-link" href="/" role="button">
              <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-home"></span></span><span class="nav-link-text ps-1">Inicio </span></div>
            </a>
          </li>
          <div v-for="item in menus">
            <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
              <div class="col-auto navbar-vertical-label">{{ item.titulo }}</div>
                <div class="col ps-0">
                  <hr class="mb-0 navbar-vertical-divider">
              </div>
            </div>
            <!-- parent pages--><a v-for="menu in item.menus" class="nav-link" :class="{ 'active': $route.path === '/'+menu.slug }" :href="menu.slug" role="button">
              <div class="d-flex align-items-center"><span class="nav-link-icon"><span :class="menu.icono"></span></span><span class="nav-link-text ps-1">{{ menu.nombre }} </span></div>
            </a>            
          </div>
        </ul>
      </div>
    </div>
  </nav>
</template>