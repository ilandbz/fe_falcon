<script setup>
    import { ref } from 'vue';
    // import ContentHeader from '@/Components/ContentHeader.vue';
    import GrupoView from '@/Pages/Menu/Grupo/Inicio.vue';
    import MenuView from '@/Pages/Menu/Menu/Inicio.vue';

    const vista = ref("Menus")
    const titleHeader = ref({
        titulo: "Usuarios",
        subTitulo: "Usuarios",
        icon: "fa fa-users",
        vista: "Menus"
    });

    const cambiarVista = (nueva_vista,icono) => {
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
                                            <li class=""><a href="" class="btn btn-app btn-primary me-1 mb-1" @click="cambiarVista('Menus','fas fa-bars')" data-bs-toggle="tab"><i class="fas fa-bars"></i> Menus</a></li>
                                            <li class=""><a href="" class="btn btn-app btn-primary me-1 mb-1" @click="cambiarVista('Grupos','fa-solid fa-tags')" data-bs-toggle="tab"><i class="fa-solid fa-tags"></i> Grupos</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab11">
                                            <grupo-view v-if="vista=='Grupos'"></grupo-view>
                                            <menu-view v-else-if="vista=='Menus'"></menu-view>
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