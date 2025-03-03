<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useHelper from '@/Helpers';  
import useDesembolso from '@/Composables/Desembolso.js';
const emit = defineEmits(['buscarCredito']);
const {
    respuesta, errors, generarPdf, pdfUrl
    } = useDesembolso();


const props = defineProps({
    form: Object,
});
const { form } = toRefs(props);


const generarPDF = async(archivo)=>{
    form.value.tipo = archivo;
    await generarPdf(form.value);
    form.value.url = pdfUrl.value;
}

</script>
<template>
    <div class="modal fade" id="modalimpresiones" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-1" id="modalimpresionesLabel">Impresiones</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card mb-3">
                        <div class="card-header">
                            IMPRESIONES
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <button @click="generarPDF('calendario')" class="btn btn-primary btn-sm w-100 p-4">
                                            <i class="fas fa-file-alt fa-2x"></i> <br> Calendario de Pagos
                                        </button>
                                    </div>

                                </div>
                                <div class="col-md-9 p-0">
                                    <div class="card border-info">
                                        <div class="card-header bg-info text-white">PRE VISUALIZACION</div>
                                        <div class="card-body">
                                            <iframe v-if="form.url" :src="form.url" width="100%" height="500px"></iframe>
                                            <p v-else>CREDITO ID: {{ form.credito_id }}</p>
                                        </div>
                                        <div class="card-footer">
                                            
                                        </div>
                                    </div>
                                </div>

                                <!-- Botón Solicitud -->

                            </div>
                        </div>
                        <div class="card-footer"></div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</template>
