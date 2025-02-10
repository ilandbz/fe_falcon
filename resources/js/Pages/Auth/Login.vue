<script setup>
import {useAutenticacion} from '@/Composables/autenticacion';
import { ref, onMounted } from 'vue';
const {errors, loginUsuario } = useAutenticacion();
    const user = ref({
        username:'',
        password:'',
        remember:false,
    });
    const autenticar = async() => {
        await loginUsuario(user.value);
    }
</script>

<template>



<div class="container-fluid">
    <div class="row min-vh-100 bg-100 flex-center g-0">
        <div class="col-lg-8 col-xxl-5 py-3 position-relative">
            <img class="bg-auth-circle-shape" src="falcon316/assets/img/icons/spot-illustrations/bg-shape.png" alt="Background Shape" width="250">
            <img class="bg-auth-circle-shape-2" src="falcon316/assets/img/icons/spot-illustrations/shape-1.png" alt="Background Shape 2" width="150">
            <div class="card overflow-hidden z-1">
            <div class="card-body p-0">
                <div class="row g-0 h-100">
                <div class="col-md-5 text-center bg-card-gradient">
                    <div class="position-relative p-4 pt-md-5 pb-md-7" data-bs-theme="light">
                    <div class="bg-holder bg-auth-card-shape" style="background-image:url(falcon316/assets/img/icons/spot-illustrations/half-circle.png);"></div>
                    <div class="z-1 position-relative">
                        <a class="link-light mb-4 font-sans-serif fs-4 d-inline-block fw-bolder" href="#">
                        <img src="imagenes/logo_emprender.png" alt="Logo Emprender">
                        </a>
                        <p class="opacity-75 text-white">TU SOCIO EN LOS NEGOCIOS</p>
                    </div>
                    </div>

                </div>
                <div class="col-md-7 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                    <div class="row flex-between-center">
                        <div class="col-auto">
                        <h3>Iniciar Sesión</h3>
                        </div>
                    </div>
                    <form action="" @submit.prevent="autenticar">
                        <div class="mb-3">
                            <label class="form-label" for="split-login-email">Nombre de Usuario</label>
                            <input class="form-control" id="split-login-email" type="text" v-model="user.username"
                            :class="{ 'is-invalid' : errors.username }">
                            <small class="text-danger" v-for="error in errors.username"
                                :key="error">{{ error }}</small>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Contraseña</label>
                            </div>
                            <input class="form-control" id="split-login-password" type="password" v-model="user.password"
                            :class="{ 'is-invalid' : errors.password }">
                            <small class="text-danger" v-for="error in errors.password"
                                :key="error">{{ error }}</small>
                        </div>
                        <div class="mb-3">
                        <button class="btn btn-primary d-block w-100 mt-3" type="submit">Iniciar Sesión</button>
                        </div>
                    </form>

                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>


    <!-- <div class="row min-vh-100 bg-100">
        <div class="col-6 d-none d-lg-block position-relative">
            <div class="bg-holder d-flex align-items-center justify-content-center" style="background-image:url(/imagenes/textura.jpg); height: 100vh;">
                <img class="img-fluid rounded" src="banner.jpg" alt="Logo">
            </div>
        </div>
        <div class="col-sm-10 col-md-6 px-sm-0 align-self-center mx-auto py-5">
        <div class="row justify-content-center g-0">
            <div class="col-lg-9 col-xl-8 col-xxl-6">
            <div class="card">
                <div class="card-header bg-circle-shape bg-shape text-center p-2">
                    <a class="font-sans-serif fw-bolder fs-4 z-1 position-relative link-light" href="#" data-bs-theme="light">
                    INGRESAR AL SISTEMA
                    </a>
                </div>
                <div class="card-body p-4">
                <div class="row flex-between-center">
                    <div class="col-auto">
                    <h3>Login</h3>
                    </div>
                </div>
                <form action="" @submit.prevent="autenticar">
                    <div class="mb-3">
                        <label class="form-label" for="split-login-email">Nombre de Usuario</label>
                        <input class="form-control" id="split-login-email" type="text" v-model="user.username"
                        :class="{ 'is-invalid' : errors.username }">
                        <small class="text-danger" v-for="error in errors.username"
                            :key="error">{{ error }}</small>
                    </div>
                    <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="split-login-password">Password</label></div>
                        <input class="form-control" id="split-login-password" type="password" v-model="user.password"
                        :class="{ 'is-invalid' : errors.password }">
                        <small class="text-danger" v-for="error in errors.password"
                            :key="error">{{ error }}</small>
                    </div>
                    <div class="row flex-between-center">
                    <div class="col-auto">
                        <div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="split-checkbox"><label class="form-check-label mb-0" for="split-checkbox">Recuerdame</label></div>
                    </div>
                    <div class="col-auto"><a class="fs--1" href="forgot-password.html">Olvidaste la Clave?</a></div>
                    </div>
                    <div class="mb-3"><button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Ingresar</button></div>
                </form>


                </div>
            </div>
            </div>
        </div>
        </div>
    </div> -->
</template>
