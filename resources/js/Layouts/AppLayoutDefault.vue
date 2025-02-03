<script setup>
import useDatosSession from '@/Composables/session';
import NavBar from '@/Components/NavBar.vue';
import SideBar from '@/Components/SideBar.vue';
// import { jwtDecode } from 'jwt-decode'
const {usuario, roles, menus, seleccionarRole, role, cambiarRole } = useDatosSession();

// const ls = localStorage.getItem('userSession');
// const desencripado = ls ? JSON.parse( JSON.stringify(jwtDecode(ls).roleid)) : null;


</script>
<template>
    <nav-bar :menus="menus"></nav-bar>
    <div class="content">
        <side-bar :usuario="usuario" :roles="roles" :role="role" @cambiarRole="cambiarRole"></side-bar>
        <router-view></router-view>
        <footer></footer>
    </div>
</template>