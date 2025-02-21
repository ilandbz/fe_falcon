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
    replicarEvaluacion, respuesta, errors
    } = useCredito();

const { hideModal, Toast, openModal } = useHelper();

const props = defineProps({
    formAnalisis: Object,
    formBalance: Object,
    formPerdidas: Object,
    formPropuesta: Object,
    credito: Object,
});

const formData = ref({
    cliente_id : '',
    credito_id : '',
})
const copiarEvaluacionAnterior=async() =>{
    formData.value.cliente_id=credito.value.cliente_id;
    formData.value.credito_id = credito.value.id;
    await replicarEvaluacion(formData.value)
    if(respuesta.value.ok==1){
        Toast.fire({icon:'success', title:respuesta.value.mensaje})
    }
    emit('buscarCredito', credito.value.id);
}

const { formAnalisis, credito, formBalance, formPerdidas, formPropuesta } = toRefs(props);

onMounted(() => {
    
});
</script>

<template>
    <div class="modal fade" id="modalevaluacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-1" id="modalevaluacionLabel">Evaluacion Crédito</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card mb-3">
                        <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png);"></div> <!--/.bg-holder-->
                        <div class="card-body position-relative">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h3>{{ credito.cliente?.persona.apenom }}</h3>
                                </div>
                                <div class="col">
                                    <h4 class="mt-2"><small>Monto :</small> S/.{{ credito.monto }}</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <h4 class="mt-2"><small>TIPO : </small>{{ credito.tipo }}</h4>
                                    <h4 class="mt-2"><small>PRODUCTO : </small>{{ credito.producto }}</h4>
                                    <button type="button"
                                    v-if="['Recurrente Sin Saldo', 'Recurrente Con Saldo', 'Paralelo'].includes(credito.tipo)"
                                     class="mt-3 btn btn-sm btn-info" title="Copiar Anterior Evaluacion" @click="copiarEvaluacionAnterior()"><i class="fa-solid fa-paste"></i></button>
                                </div>
                                <div class="col">
                                    <h4 class="mt-2"><small>FRECUENCIA : </small>{{ credito.frecuencia }}</h4>
                                    <h4 class="mt-2"><small>PLAZO : </small>{{ credito.plazo }}</h4>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card theme-wizard mb-5">
                        <div class="card-header bg-light pt-3 pb-2">
                            <ul class="nav justify-content-between nav-wizard">
                            <li class="nav-item"><a class="nav-link active fw-semi-bold" href="#bootstrap-wizard-tab1" data-bs-toggle="tab" data-wizard-step="data-wizard-step"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-chart-line"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Analisis Cualitativo</span></a></li>
                            <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab2" data-bs-toggle="tab" data-wizard-step="data-wizard-step"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-balance-scale"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Balance General</span></a></li>
                            <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab3" data-bs-toggle="tab" data-wizard-step="data-wizard-step"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-file-invoice-dollar"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Perdidas y Ganancias</span></a></li>
                            <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab4" data-bs-toggle="tab" data-wizard-step="data-wizard-step"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-hand-holding-usd"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Propuesta de Credito</span></a></li>
                            </ul>
                        </div>
                        <div class="card-body py-4" id="wizard-controller">
                            <div class="tab-content">
                                <div class="tab-pane active px-sm-3 px-md-1" role="tabpanel" aria-labelledby="bootstrap-wizard-tab1" id="bootstrap-wizard-tab1">
                                    <FormAnalisis :formAnalisis="formAnalisis"></FormAnalisis>
                                </div>
                                <div class="tab-pane px-sm-3 px-md-1" role="tabpanel" aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2">
                                    <FormBalance :formBalance="formBalance"></FormBalance>
                                </div>
                                <div class="tab-pane  px-sm-3 px-md-1" role="tabpanel" aria-labelledby="bootstrap-wizard-tab3" id="bootstrap-wizard-tab3">
                                    <FormPerdidasGanancias :formPerdidas="formPerdidas"></FormPerdidasGanancias>
                                </div>
                                <div class="tab-pane px-sm-3 px-md-1" role="tabpanel" aria-labelledby="bootstrap-wizard-tab4" id="bootstrap-wizard-tab4">
                                    <FormPropuesta :formPropuesta="formPropuesta"></FormPropuesta>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <div class="px-sm-3 px-md-5">

                            </div>
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
