<script setup>
import useDatosSession from '@/Composables/session';
import NavBar from '@/Components/NavBar.vue';
import SideBar from '@/Components/SideBar.vue';
import Footer from '@/Components/Footer.vue';
const {usuario, roles, menus } = useDatosSession();
</script>

<template>
    <nav-bar :menus="menus"></nav-bar>
    <div class="content">
        <side-bar :usuario="usuario" :roles="roles"></side-bar>
        <router-view></router-view>
        <footer></footer>
    </div>
    
</template>