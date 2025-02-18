<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useHelper from '@/Helpers';  
import { onlyNumbers } from '@/Helpers'
import FormAnalisis from './FormAnalisis.vue'
import useAnalisisCualitativo from '@/Composables/AnalisisCualitativo.js'; 
import usePerdidas from '@/Composables/Perdidas.js'; 
import useBalance from '@/Composables/Balance.js'; 
import usePropuesta from '@/Composables/Propuesta.js'; 

const { hideModal, Toast, openModal } = useHelper();

const props = defineProps({
    formAnalisis: Object,
    formBalance: Object,
    formPerdidas: Object,
    formPropuesta: Object,
    credito: Object,
});
const {
        agregarRegistro, actualizarRegistro, errors, respuesta
    } = useAnalisisCualitativo();





const guardarBalance = ()=>{

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
                                    <h3 class="text-center mb-3">Balance General</h3>
                                    <form @submit.prevent="guardarBalance">
                                        <div class="row">
                                            <div class="col">
                                                <div class="card border-info mb-3">
                                                    <div class="card-header bg-info text-white">ACTIVO</div>
                                                    <div class="card-body">
                                                        <h5 class="mb-4">CORRIENTE</h5>
                                                        <div class="row mb-2">
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.activocaja"
                                                                        placeholder="ACTIVO CAJA">
                                                                        <label>ACTIVO CAJA</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.activocaja" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                           <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.activobancos"
                                                                        placeholder="ACTIVO BANCOS">
                                                                        <label>ACTIVO BANCOS</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.activobancos" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div>                                                        
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.activoctascobrar"
                                                                        placeholder="CUENTAS POR COBRAR">
                                                                        <label>CUENTAS POR COBRAR</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.activoctascobrar" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div> 
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.activoinventarios"
                                                                        placeholder="INVENTARIOS">
                                                                        <label>INVENTARIOS</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.activoinventarios" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div> 
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.totalacorriente"
                                                                        placeholder="TOTAL ACTIVO CORRIENTE">
                                                                        <label>TOTAL ACTIVO CORRIENTE</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.totalacorriente" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div> 
                                                        </div>
                                                        <h5>NO CORRIENTE</h5>
                                                        <div class="row mb-2">
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input title="MUEBLES, MAQUINARIA Y EQUIPO" type="text" class="form-control form-control-sm" v-model="formBalance.activomueble"
                                                                        placeholder="MUEBLES, MAQUINARIA Y EQUIPO">
                                                                        <label>MUEBLES, MAQUINARIA Y EQUIPO</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.activomueble" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div> 
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input title="OTROS ACTIVOS" type="text" class="form-control form-control-sm" v-model="formBalance.activootrosact"
                                                                        placeholder="OTROS ACTIVOS">
                                                                        <label>OTROS ACTIVOS</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.activootrosact" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div> 
    
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input title="DEPRECIACION, AMORTIZACION Y AGOTAMIENTO ACUMULADO" type="text" class="form-control form-control-sm" v-model="formBalance.activodepre"
                                                                        placeholder="DEPRECIACION, AMORTIZACION Y AGOTAMIENTO ACUMULADO">
                                                                        <label>DEPRECIACION, AMORTIZACION Y AGOTAMIENTO ACUMULADO</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.activodepre" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div> 
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input title="TOTAL ACTIVO NO CORRIENTE" type="text" class="form-control form-control-sm" v-model="formBalance.totalancorriente"
                                                                        placeholder="TOTAL ACTIVO NO CORRIENTE">
                                                                        <label>TOTAL ACTIVO NO CORRIENTE</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.totalancorriente" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div>                                                            
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input title="TOTAL ACTIVO" type="text" class="form-control form-control-sm" v-model="formBalance.total_activo"
                                                                        placeholder="TOTAL ACTIVO">
                                                                        <label>TOTAL ACTIVO</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.total_activo" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="card">
                                                    <div class="card-header bg-danger text-white">PASIVO</div>
                                                    <div class="card-body">
                                                        <h5 class="mb-4">CORRIENTE</h5>
                                                        <div class="row mb-2">
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.pasivodeudaprove"
                                                                        placeholder="PROVEEDORES">
                                                                        <label>PROVEEDORES</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.pasivodeudaprove" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.pasivodeudaent"
                                                                        placeholder="DEUDAS CON ENTIDADES FINANCIERAS">
                                                                        <label>DEUDAS CON ENTIDADES FINANCIERAS</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.pasivodeudaent" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>
                                                            </div>                                                         
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.pasivodeudaempre"
                                                                        placeholder="DEUDAS CON EMPRENDER">
                                                                        <label>DEUDAS CON EMPRENDER</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.pasivodeudaempre" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div>
                                                            <div class="col">
                                                         
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.totalpcorriente"
                                                                        placeholder="TOTAL PASIVO CORRIENTE">
                                                                        <label>TOTAL PASIVO CORRIENTE</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.totalpcorriente" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div>
                                                        </div>
                                                        <h5>NO CORRIENTE</h5>
                                                        <div class="row mb-2">
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input title="PASIVO LARGO PLAZO" type="text" class="form-control form-control-sm" v-model="formBalance.pasivolargop"
                                                                        placeholder="PASIVO LARGO PLAZO">
                                                                        <label>PASIVO LARGO PLAZO</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.pasivolargop" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div>
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input title="OTRAS CUENTAS POR PAGAR<" type="text" class="form-control form-control-sm" v-model="formBalance.otrascuentaspagar"
                                                                        placeholder="OTRAS CUENTAS POR PAGAR<">
                                                                        <label>OTRAS CUENTAS POR PAGAR<</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.otrascuentaspagar" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.totalpncorriente"
                                                                        placeholder="TOTAL PASIVO NO CORRIENTE" readonly>
                                                                        <label>TOTAL PASIVO NO CORRIENTE</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.totalpncorriente" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.total_pasivo"
                                                                        placeholder="TOTAL PASIVO" readonly>
                                                                        <label>TOTAL PASIVO</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.total_pasivo" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="card border-primary">
                                                    <div class="card-header bg-primary text-white">PATRIMONIO</div>
                                                    <div class="card-body">
                                                        <div class="row mb-2 align-items-center">
                                                            <label for="patrimonio" class="col-md-6 col-form-label text-end">PATRIMONIO EMPRESARIAL</label>
                                                            <div class="col-md-4">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm w-75" v-model="formBalance.patrimonio"
                                                                        placeholder="PATRIMONIO EMPRESARIAL">
                                                                        <label>PATRIMONIO EMP.</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.patrimonio" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>
                                                            </div> 
                                                        </div>
    
                                                        <div class="row mb-2 align-items-center">
                                                            <label for="totpatrimonio" class="col-md-6 col-form-label text-end">TOTAL PATRIMONIO</label>
                                                            <div class="col-md-4">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm w-75" v-model="formBalance.patrimonio"
                                                                        placeholder="TOTAL PATRIMONIO">
                                                                        <label>TOTAL PATR.</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.patrimonio" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>
                                                            </div> 
                                                        </div>
    
                                                        <div class="row mb-2 align-items-center">
                                                            <label for="paspatrimonio" class="col-md-6 col-form-label text-end">PASIVO Y PATRIMONIO</label>
                                                            <div class="col-md-4">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm w-75" :value="Number(formBalance.patrimonio) + Number(formBalance.total_pasivo)"
                                                                        placeholder="PASIVO Y PATRIMONIO">
                                                                        <label>PASIVO Y PATR.</label>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                        <div class="row mb-2 align-items-center">
                                                            <label for="captrabajo" class="col-md-6 col-form-label text-end">CAPITAL DE TRABAJO</label>
                                                            <div class="col-md-4">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm w-75" :value="Number(formBalance.totalacorriente)-Number(formBalance.totalpcorriente)"
                                                                        placeholder="CAPITAL DE TRABAJO">
                                                                        <label>CAP. TRAB.</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.captrabajo" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">{{ (formBalance.estadoCrud=='nuevo') ? 'Guardar Balance' : 'Actualizar Balance' }}</button>
                                    </form>
                                </div>
                                <div class="tab-pane  px-sm-3 px-md-1" role="tabpanel" aria-labelledby="bootstrap-wizard-tab3" id="bootstrap-wizard-tab3">
                                    <h3 class="text-center">Perdidas y Ganancias</h3>
                                    <form @submit.prevent="guardarPerdidas">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <div class="input-group has-validation">
                                                            <span class="input-group-text">S/.</span>
                                                            <div class="form-floating is-invalid">
                                                                <input type="text" class="form-control" v-model="formPerdidas.ventaspg"
                                                                placeholder="VENTAS">
                                                                <label>VENTAS</label>
                                                            </div>
                                                            <button class="btn btn-outline-secondary" title="Seleccionar" type="button" @click="buscar">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                            <div class="invalid-feedback" v-for="error in formPerdidas.errors.ventaspg" :key="error">
                                                                {{ error }}
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="input-group has-validation">
                                                            <span class="input-group-text">S/.</span>
                                                            <div class="form-floating is-invalid">
                                                                <input type="text" class="form-control" v-model="formPerdidas.costopg"
                                                                placeholder="COSTOS">
                                                                <label>COSTOS</label>
                                                            </div>
                                                            <button class="btn btn-outline-secondary" title="Seleccionar" type="button" @click="buscar">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                            <div class="invalid-feedback" v-for="error in formPerdidas.errors.costopg" :key="error">
                                                                {{ error }}
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <div class="input-group has-validation">
                                                            <span class="input-group-text">S/.</span>
                                                            <div class="form-floating is-invalid">
                                                                <input type="text" class="form-control" v-model="formPerdidas.utilidadbpg"
                                                                placeholder="UTILIDAD">
                                                                <label>UTILIDAD</label>
                                                            </div>
                                                            <button class="btn btn-outline-secondary" title="Seleccionar" type="button" @click="buscar">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                            <div class="invalid-feedback" v-for="error in formPerdidas.errors.utilidadbpg" :key="error">
                                                                {{ error }}
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="input-group has-validation">
                                                            <span class="input-group-text">S/.</span>
                                                            <div class="form-floating is-invalid">
                                                                <input type="text" class="form-control" v-model="formPerdidas.gastoneg"
                                                                placeholder="GASTO NEGOCIO">
                                                                <label>GASTO NEGOCIO</label>
                                                            </div>
                                                            <button class="btn btn-outline-secondary" title="Seleccionar" type="button" @click="buscar">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                            <div class="invalid-feedback" v-for="error in formPerdidas.errors.gastoneg" :key="error">
                                                                {{ error }}
                                                            </div> 
                                                        </div>
                                                    </div>
    
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col"></div>
                                                    <div class="col">
                                                        <div class="input-group has-validation">
                                                            <span class="input-group-text">S/.</span>
                                                            <div class="form-floating is-invalid">
                                                                <input type="text" class="form-control" v-model="formPerdidas.utilidopera"
                                                                placeholder="UTILIDAD OPERATIVA">
                                                                <label>UTILIDAD OPERATIVA</label>
                                                            </div>
                                                            <button class="btn btn-outline-secondary" title="Seleccionar" type="button" @click="buscar">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                            <div class="invalid-feedback" v-for="error in formPerdidas.errors.utilidopera" :key="error">
                                                                {{ error }}
                                                            </div> 
                                                        </div>
                                                    </div>
    
    
                
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <div class="input-group has-validation">
                                                            <span class="input-group-text">S/.</span>
                                                            <div class="form-floating is-invalid">
                                                                <input type="text" title="OTROS INGRESOS" class="form-control" v-model="formPerdidas.otrosing"
                                                                placeholder="OTROS INGRESOS">
                                                                <label>OTROS INGRESOS</label>
                                                            </div>
                                                            <button class="btn btn-outline-secondary" title="Seleccionar" type="button" @click="buscar">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                            <div class="invalid-feedback" v-for="error in formPerdidas.errors.otrosing" :key="error">
                                                                {{ error }}
                                                            </div> 
                                                        </div>
                                                    </div>
    
                                                    <div class="col">
                                                        <div class="input-group has-validation">
                                                            <span class="input-group-text">S/.</span>
                                                            <div class="form-floating is-invalid">
                                                                <input type="text" title="OTROS EGRESOS" class="form-control" v-model="formPerdidas.otrosegre"
                                                                placeholder="OTROS EGRESOS">
                                                                <label>OTROS EGRESOS</label>
                                                            </div>
                                                            <button class="btn btn-outline-secondary" title="Seleccionar" type="button" @click="buscar">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                            <div class="invalid-feedback" v-for="error in formPerdidas.errors.otrosegre" :key="error">
                                                                {{ error }}
                                                            </div> 
                                                        </div>
                                                    </div>
    
                                                </div>										
                                                <div class="row mb-3">
                                                    <div class="col"></div>
    
                                                    <div class="col">
                                                        <div class="input-group has-validation">
                                                            <span class="input-group-text">S/.</span>
                                                            <div class="form-floating is-invalid">
                                                                <input type="text" title="GASTOS FAMILIARES" class="form-control" v-model="formPerdidas.gastfamiliares"
                                                                placeholder="GASTOS FAMILIARES">
                                                                <label>GASTOS FAMILIARES</label>
                                                            </div>
                                                            <button class="btn btn-outline-secondary" title="Seleccionar" type="button" @click="buscar">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                            <div class="invalid-feedback" v-for="error in formPerdidas.errors.gastfamiliares" :key="error">
                                                                {{ error }}
                                                            </div> 
                                                        </div>
                                                    </div>
    
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <div class="input-group has-validation">
                                                            <span class="input-group-text">S/.</span>
                                                            <div class="form-floating is-invalid">
                                                                <input type="text" title="UTILIDAD NETA" class="form-control" v-model="formPerdidas.utilneta"
                                                                placeholder="UTILIDAD NETA">
                                                                <label>UTILIDAD NETA</label>
                                                            </div>
                                                            <button class="btn btn-outline-secondary" title="Seleccionar" type="button" @click="buscar">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                            <div class="invalid-feedback" v-for="error in formPerdidas.errors.utilneta" :key="error">
                                                                {{ error }}
                                                            </div> 
                                                        </div>
                                                    </div>
    
                                                    <div class="col">
                                                        <div class="input-group has-validation">
                                                            <span class="input-group-text">S/.</span>
                                                            <div class="form-floating is-invalid">
                                                                <input type="text" title="UTILIDAD NETA DIARIA" class="form-control" v-model="formPerdidas.utilnetadiaria"
                                                                placeholder="UTILIDAD NETA DIARIA">
                                                                <label>UTILIDAD NETA DIARIA</label>
                                                            </div>
                                                            <button class="btn btn-outline-secondary" title="Seleccionar" type="button" @click="buscar">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                            <div class="invalid-feedback" v-for="error in formPerdidas.errors.utilnetadiaria" :key="error">
                                                                {{ error }}
                                                            </div> 
                                                        </div>
                                                    </div>						
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">{{ (formPerdidas.estadoCrud=='nuevo') ? 'Guardar Perdidas' : 'Actualizar Perdidas' }}</button>
                                    </form>
                                </div>
                                <div class="tab-pane px-sm-3 px-md-1" role="tabpanel" aria-labelledby="bootstrap-wizard-tab4" id="bootstrap-wizard-tab4">
                                    <h3 class=" text-center">Propuesta de Credito</h3>
                                    <form @submit.prevent="guardarPropuesta">
                                        <div class="form-group">
                                            <label class="control-label">UNIDAD FAMILIAR(CONYUGUE, HIJOS)</label>
                                            <textarea v-model="formPropuesta.unidfam" class="form-control input-sm" placeholder="Unidad Familiar" rows="4"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="">EXPERIENCIA CREDITICIA Y NEGOCIO</label>
                                            <textarea v-model="formPropuesta.expcred" class="form-control input-sm" placeholder="Experiencia Crediticia" rows="4"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="">DESTINO DEL PRESTAMO</label>
                                            <textarea v-model="formPropuesta.destprest" class="form-control input-sm" placeholder="Destino del Prestamo" rows="4"></textarea>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="">REFERENCIAS PERSONALES Y COMERCIALES</label>
                                            <textarea v-model="formPropuesta.refper" class="form-control input-sm" placeholder="Destino del Prestamo" rows="4"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">{{ (formPropuesta.estadoCrud=='nuevo') ? 'Guardar Propuesta' : 'Actualizar Propuesta' }}</button>
                                    </form>
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
