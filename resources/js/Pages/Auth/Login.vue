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
    <div class="row min-vh-100 bg-100">
        <div class="col-6 d-none d-lg-block position-relative">
            <div class="bg-holder d-flex align-items-center justify-content-center" style="background-image:url(/imagenes/textura.jpg); height: 100vh;">
                <img class="img-fluid rounded" src="banner.jpg" alt="Logo">
            </div>
        <!--/.bg-holder-->
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
    </div>
</template>
