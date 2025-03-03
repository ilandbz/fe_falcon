<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useUsuario from '@/Composables/Usuario.js';
import useDesembolso from '@/Composables/Desembolso.js';
import DescuentosForm from './FormDescuentos.vue'  
import useHelper from '@/Helpers';  
const { hideModal, openModal, Toast, Swal } = useHelper();
const props = defineProps({
    form: Object,
});
const { form } = toRefs(props);
const  emit  =defineEmits(['onListar', 'observar', 'obtenerDatos'])

</script>
<template>
    <div class="modal fade" id="modalcalendariopagos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-1" id="modalcalendariopagosLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <iframe v-if="form.url" :src="form.url" width="100%" height="700px"></iframe>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
</template>