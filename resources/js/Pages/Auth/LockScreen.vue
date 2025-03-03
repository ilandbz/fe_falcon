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
    <div class="row min-vh-100 flex-center g-0">
          <div class="col-lg-8 col-xxl-5 py-3 position-relative"><img class="bg-auth-circle-shape" src="../../../assets/img/icons/spot-illustrations/bg-shape.png" alt="" width="250"><img class="bg-auth-circle-shape-2" src="../../../assets/img/icons/spot-illustrations/shape-1.png" alt="" width="150">
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
                      <div class="row justify-content-center">
                        <div class="col-auto">
                          <div class="d-flex align-items-center">
                            <div class="avatar avatar-4xl me-4">
                              <img class="rounded-circle" src="falcon316/assets/img/team/1.jpg" alt="">
                            </div>
                            <div class="flex-1">
                              <h4>Hi! Emma</h4>
                              <p class="mb-0">Enter your password <br>to access.</p>
                            </div>
                          </div>
                          <form class="mt-4 row gx-2">
                            <div class="col"><input class="form-control" type="password" placeholder="Password" aria-label="User's password" aria-describedby="user-password"></div>
                            <div class="col-4"><button class="btn btn-primary d-block w-100" id="user-password" type="button">Login</button></div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
</div>
</template>
