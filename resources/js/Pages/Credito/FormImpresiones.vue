<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useHelper from '@/Helpers';  
import { onlyNumbers } from '@/Helpers'
import FormAnalisis from './FormAnalisis.vue'
import FormBalance from './FormBalance.vue'
import FormPerdidasGanancias from './FormPerdidasGanancias.vue'
import FormPropuesta from './FormPropuesta.vue'
import useCredito from '@/Composables/Credito.js';
const emit = defineEmits(['buscarCredito']);
const {
    replicarEvaluacion, respuesta, errors, generarPdf, pdfUrl
    } = useCredito();

const { hideModal, Toast, openModal } = useHelper();


const props = defineProps({
    credito: Object,
});
const { credito } = toRefs(props);

const data=ref({
    credito_id : '',
    tipo : '',
})

const generarPDF = async(archivo)=>{
    data.value.credito_id = credito.value.id;
    data.value.tipo = archivo;
    await generarPdf(data.value);
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
                            SELECCIONE
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Botón Solicitud -->
                                <div class="col">
                                    <button @click="generarPDF('solicitud')" class="btn btn-primary btn-lg w-100 p-4">
                                        <i class="fas fa-file-alt fa-2x"></i> <br> Solicitud
                                    </button>
                                </div>
    
                                <!-- Botón Análisis Cualitativo -->
                                <div class="col">
                                    <button @click="generarPDF('Analisis Cualitativo')" class="btn btn-secondary btn-lg w-100 p-4">
                                        <i class="fas fa-chart-line fa-2x"></i> <br> Análisis Cualitativo
                                    </button>
                                </div>
    
                                <!-- Botón Estados Financieros -->
                                <div class="col">
                                    <button @click="generarPDF('Estados Financieros')" class="btn btn-success btn-lg w-100 p-4">
                                        <i class="fas fa-balance-scale fa-2x"></i> <br> Estados Financieros
                                    </button>
                                </div>
    
                                <!-- Botón Seguro Desgravamen -->
                                <div class="col">
                                    <button @click="generarPDF('Seguro')" class="btn btn-warning btn-lg w-100 p-4">
                                        <i class="fas fa-shield-alt fa-2x"></i> <br> Seguro Desgravamen
                                    </button>
                                </div>
    
                                <!-- Botón Propuesta de Crédito -->
                                <div class="col">
                                    <button class="btn btn-danger btn-lg w-100 p-4" onclick="imprimir('propuesta')">
                                        <i class="fas fa-hand-holding-usd fa-2x"></i> <br> Propuesta de Crédito
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer"></div>
                    </div>

                    <div class="card border-info">
                        <div class="card-header bg-info text-white">VISUALIZACION</div>
                        <div class="card-body">
                            <iframe v-if="pdfUrl" :src="pdfUrl" width="100%" height="500px"></iframe>
                            <p v-else>Seleccione un documento para visualizar.</p>
                        </div>
                        <div class="card-footer">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</template>
