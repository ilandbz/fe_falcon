<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { useRouter } from 'vue-router';
import useDatosSession from '@/Composables/session';
import NavBar from '@/Components/NavBar.vue';
import SideBar from '@/Components/SideBar.vue';
// import { jwtDecode } from 'jwt-decode'
const {usuario, roles, menus, cambiarAgencia, role, cambiarRole, agencia } = useDatosSession();

// const ls = localStorage.getItem('userSession');
// const desencripado = ls ? JSON.parse( JSON.stringify(jwtDecode(ls).roleid)) : null;

const router = useRouter();

const tiempoRestante = ref(6); // 10 minutos en segundos
let temporizador;

const resetearTemporizador = () => {
    tiempoRestante.value = 6; // Reinicia el tiempo cada vez que el usuario interactúa
};

const iniciarTemporizador = () => {
    temporizador = setInterval(() => {
        tiempoRestante.value--;
        if (tiempoRestante.value <= 0) {
            clearInterval(temporizador);
            alert("Sesión suspendida por inactividad.");
            localStorage.removeItem('userSession');
            router.push('/login');
        }
    }, 1000);
};

onMounted(() => {
    iniciarTemporizador();
    
    window.addEventListener('mousemove', resetearTemporizador);
    window.addEventListener('keydown', resetearTemporizador);
    window.addEventListener('click', resetearTemporizador);
});

onUnmounted(() => {
    clearInterval(temporizador);
    window.removeEventListener('mousemove', resetearTemporizador);
    window.removeEventListener('keydown', resetearTemporizador);
    window.removeEventListener('click', resetearTemporizador);
});



</script>
<template>
    <nav-bar :menus="menus"></nav-bar>
    <div class="content">
        <side-bar :usuario="usuario" :roles="roles" :role="role" :agencia="agencia"
        @cambiarRole="cambiarRole" @cambiarAgencia="cambiarAgencia"></side-bar>
        <router-view :usuario="usuario" :agencia="agencia" :role="role"></router-view>
        <footer></footer>
    </div>
</template>