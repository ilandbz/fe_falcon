<script setup>
    import { ref } from 'vue';
    // import ContentHeader from '@/Components/ContentHeader.vue';
    import UsuarioView from '@/Pages/Usuario/Usuario/Inicio.vue';
    import RoleView from '@/Pages/Usuario/Rol/Inicio.vue';
    import PrivilegioView from '@/Pages/Usuario/Privilegio/Inicio.vue';
    const vista = ref("Usuario")
    const titleHeader = ref({
        titulo: "Usuarios",
        subTitulo: "Usuarios",
        icon: "fa fa-users",
        vista: "Menus"
    });

    const cambiarVista = (nueva_vista) => {
        vista.value = nueva_vista
    }

</script>
<template>
    <!-- <ContentHeader :titleHeader="titleHeader"></ContentHeader> -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col md-12">
                            <div class="panel panel-primary tabs-style-3">
                                <div class="tab-menu-heading">
                                    <div class="tabs-menu mb-2">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs">
                                            <li class=""><a href="" class="btn btn-app btn-primary me-1 mb-1" @click="cambiarVista('Usuario')" data-bs-toggle="tab"><i class="fas fa-users"></i> Usuario</a></li>
                                            <li class=""><a href="" class="btn btn-app btn-primary me-1 mb-1" @click="cambiarVista('Rol')" data-bs-toggle="tab"><i class="fas fa-shield-alt"></i> Rol</a></li>
                                            <li class=""><a href="" class="btn btn-app btn-primary me-1 mb-1" @click="cambiarVista('Privilegio')" data-bs-toggle="tab"><i class="fas fa-lock-open"></i> Privilegio</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab11">
                                            <usuario-view v-if="vista=='Usuario'"></usuario-view>
                                            <role-view v-else-if="vista=='Rol'"></role-view>
                                            <privilegio-view v-else-if="vista=='Privilegio'"></privilegio-view>
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