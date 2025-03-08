<script setup>
  import { ref, onMounted, toRefs } from 'vue';
  import NegocioView from '@/Pages/Cliente/negocios/Inicio.vue'
  import ClienteView from '@/Pages/Cliente/clientes/Inicio.vue'
  const props = defineProps({
        agencia: Object,
        role: Object,
        usuario: Object
    });
const vista = ref("Clientes")
const { agencia, role, usuario } = toRefs(props);

const cambiarVista = (nueva_vista) => {
    vista.value = nueva_vista
}


</script>
<template>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <ul class="nav nav-pills" id="pill-myTab" role="tablist">
                    <li class="nav-item">
                        <a href="#" class="nav-link" :class="vista=='Clientes' ? 'active' : ''" @click="cambiarVista('Clientes')">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" :class="vista=='Negocios' ? 'active' : ''" @click="cambiarVista('Negocios')">Negocios</a>
                    </li>
                </ul>
                <div class="tab-content border p-3 mt-3">
                    <div class="tab-pane fade show active" role="tabpanel">
                        <cliente-view v-if="vista=='Clientes'"></cliente-view>
                        <negocio-view v-else></negocio-view>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</template>