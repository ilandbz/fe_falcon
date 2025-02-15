<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useHelper from '@/Helpers';  
import { onlyNumbers } from '@/Helpers'
import useAnalisisCualitativo from '@/Composables/AnalisisCualitativo.js'; 
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
const calcularAnalisis = () => {
    formAnalisis.value.totunidfamiliar = 
        Number(formAnalisis.value.tipogarantia) +
        Number(formAnalisis.value.cargafamiliar) +
        Number(formAnalisis.value.riesgoedadmax);

    formAnalisis.value.totunidempresa = 
        Number(formAnalisis.value.antecedentescred) +
        Number(formAnalisis.value.recorpagoult) +
        Number(formAnalisis.value.niveldesarr) +
        Number(formAnalisis.value.tiempo_neg) +
        Number(formAnalisis.value.control_integre) +
        Number(formAnalisis.value.vent_totdec) +
        Number(formAnalisis.value.compsubsector);
       
    formAnalisis.value.total = formAnalisis.value.totunidfamiliar + formAnalisis.value.totunidempresa;
};
const opciones = ref({
    tipogarantia: [
        { label: "REAL CONSTITUIDA A FAVOR DE LA INSTITUCIÓN (HIPOTECA Y/O PRENDA)", value: 4 },
        { label: "SIMPLE", value: 2 }
    ],
    cargafamiliar: [
        { label: "NO TIENE DEPENDIENTES", value: 4 },
        { label: "TIENE DEPENDIENTES NO VULNERABLES", value: 2 },
        { label: "TIENE DEPENDIENTES MENORES A 5 AÑOS", value: 1 },
        { label: "TIENE ALGÚN DEPENDIENTE CON ENFERMEDADES FRECUENTES Y/O GRAVES", value: 0 }
    ],
    riesgoedadmax: [
        { label: "MENOR DE 64 AÑOS", value: 3 },
        { label: "MAYOR O IGUAL A 64 AÑOS", value: 1 }
    ],
    antecedentescred: [
        { label: "CRÉDITOS EN NUESTRA ENTIDAD", value: 5 },
        { label: "CRÉDITOS EN OTRAS ENTIDADES DEL SISTEMA FINANCIERO", value: 4 },
        { label: "CRÉDITO CON PROVEEDORES", value: 3 },
        { label: "NO HA TENIDO CRÉDITOS", value: 1 }
    ],
    recorpagoult: [
        { label: "FUE CON PAGOS OPORTUNOS EN SU FECHA DE PAGO", value: 7 },
        { label: "FUE CON RETRASO MENOR A 8 DÍAS", value: 5 },
        { label: "FUE CON RETRASO ENTRE 9 Y 30 DÍAS", value: 2 },
        { label: "FUE CON RETRASO MAYOR A 30 DÍAS O NO HA TENIDO PRÉSTAMOS", value: 0 }
    ],
    niveldesarr: [
        { label: "ACUMULACION AMPLIADA", value: 4 },
        { label: "ACUMULACION SIMPLE", value: 3 },
        { label: "EMERGENTE", value: 2 },
        { label: "SOBREVIVENCIA", value: 1 }
    ],
    tiempo_neg: [
        { label: "MAYOR A 3 AÑOS", value: 3 },
        { label: "ENTRE 1 Y 3 AÑOS", value: 2 },
        { label: "MENOR A 1 AÑO", value: 1 },
    ],
    control_integre: [
        { label: "SUFICIENTE Y ADECUADAMENTE REGISTRADA", value: 3 },
        { label: "SUFICIENTE PERO INADECUADAMENTE REGISTRADA", value: 2 },
        { label: "INSUFICIENTE", value: 1 },
    ],    
    vent_totdec: [
        { label: "FORMALMENTE DE MANERA PARCIAL", value: 2 },
        { label: "NO LAS DECLARA", value: 0 },
    ],        
    compsubsector: [
        { label: "BAJO RIESGO", value: 4 },
        { label: "MEDIANO RIESGO", value: 2 },
        { label: "ALTO RIESGO", value: 0 },
    ],     
});


const guardarAnalisis = () => {
    crud[formAnalisis.value.estadoCrud]();
};
const crud = {
    'nuevo': async() => {
        await agregarRegistro(formAnalisis.value)
        formAnalisis.value.errors = []
        if(errors.value)
        {
            formAnalisis.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            formAnalisis.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            formAnalisis.value.estadoCrud='editar'
        }
    },
    'editar': async() => {
        await actualizarRegistro(formAnalisis.value)
        formAnalisis.value.errors = []
        if(errors.value)
        {
            formAnalisis.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            formAnalisis.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
        }
    }
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
                                    <h3 class="text-center">Analisis Cualitativo</h3>
                                    <form @submit.prevent="guardarAnalisis">
                                        <!-- UNIDAD FAMILIAR -->
                                        <div class="row mb-3">
                                            <div class="col">
                                                <div class="card border-info">
                                                    <div class="card-header bg-info text-white">I. UNIDAD FAMILIAR</div>
                                                    <div class="card-body">
                                                        <p class="text-primary fw-bold">1. TIPO DE GARANTÍA</p>
                                                        <div class="mb-0" v-for="(opcion, index) in opciones.tipogarantia" :key="index">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label :for="'tipogarantia' + index" class="form-check-label">
                                                                        {{ opcion.label }}
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input
                                                                        class="form-check-input"
                                                                        :id="'tipogarantia' + index"
                                                                        v-model="formAnalisis.tipogarantia"
                                                                        type="radio"
                                                                        name="tipogarantia"
                                                                        :value="opcion.value"
                                                                        @change="calcularAnalisis()"
                                                                    />
                                                                    <label :for="'tipogarantia' + index">{{ opcion.value }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <small class="text-danger" v-for="error in formAnalisis.errors.tipogarantia" :key="error">{{ error  }}</small>
                                                        <p class="text-primary fw-bold">2. CARGA FAMILIAR</p>
                                                        <div class="mb-0" v-for="(opcion, index) in opciones.cargafamiliar" :key="index">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label :for="'cargafamiliar' + index" class="form-check-label">
                                                                        {{ opcion.label }}
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input
                                                                        class="form-check-input"
                                                                        :id="'cargafamiliar' + index"
                                                                        v-model="formAnalisis.cargafamiliar"
                                                                        type="radio"
                                                                        name="cargafamiliar"
                                                                        :value="opcion.value"
                                                                        @change="calcularAnalisis()"
                                                                    />
                                                                    <label :for="'cargafamiliar' + index">{{ opcion.value }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <small class="text-danger" v-for="error in formAnalisis.errors.cargafamiliar" :key="error">{{ error  }}</small>
                                                        <p class="text-primary fw-bold">3. RIESGO POR EDAD MÁXIMA</p>
                                                        <div class="mb-0" v-for="(opcion, index) in opciones.riesgoedadmax" :key="index">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label :for="'riesgoedadmax' + index" class="form-check-label">
                                                                        {{ opcion.label }}
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input
                                                                        class="form-check-input"
                                                                        :id="'riesgoedadmax' + index"
                                                                        v-model="formAnalisis.riesgoedadmax"
                                                                        type="radio"
                                                                        name="riesgoedadmax"
                                                                        :value="opcion.value"
                                                                        @change="calcularAnalisis()"
                                                                    />
                                                                    <label :for="'riesgoedadmax' + index">{{ opcion.value }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <small class="text-danger" v-for="error in formAnalisis.errors.riesgoedadmax" :key="error">{{ error  }}</small>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <label for="totalunidadfam" class="form-label">TOTAL PUNTAJE UNIDAD FAMILIAR</label>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control" v-model="formAnalisis.totunidfamiliar" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- UNIDAD EMPRESARIAL -->
                                            <div class="col">
                                                <div class="card border-info">
                                                    <div class="card-header bg-info text-white">II. UNIDAD EMPRESARIAL</div>
                                                    <div class="card-body">
                                                        <p class="text-primary fw-bold">1. TIENE ANTECEDENTES CREDITICIOS</p>
                                                        <div class="mb-0" v-for="(opcion, index) in opciones.antecedentescred" :key="index">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label :for="'antecedentes' + index" class="form-check-label">
                                                                        {{ opcion.label }}
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input
                                                                        class="form-check-input"
                                                                        :id="'antecedentes' + index"
                                                                        v-model="formAnalisis.antecedentescred"
                                                                        type="radio"
                                                                        name="antecedentescred"
                                                                        :value="opcion.value"
                                                                        @change="calcularAnalisis()"
                                                                    />
                                                                    <label :for="'antecedentes' + index">{{ opcion.value }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <small class="text-danger" v-for="error in formAnalisis.errors.antecedentescred" :key="error">{{ error  }}</small>
                                                        <p class="text-primary fw-bold">2. RÉCORD DE PAGO DEL ÚLTIMO PRÉSTAMO</p>
                                                        <div class="mb-0" v-for="(opcion, index) in opciones.recorpagoult" :key="index">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label :for="'recorpagoult' + index" class="form-check-label">
                                                                        {{ opcion.label }}
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input
                                                                        class="form-check-input"
                                                                        :id="'recorpagoult' + index"
                                                                        v-model="formAnalisis.recorpagoult"
                                                                        type="radio"
                                                                        name="recorpagoult"
                                                                        :value="opcion.value"
                                                                        @change="calcularAnalisis()"
                                                                    />
                                                                    <label :for="'recorpagoult' + index">{{ opcion.value }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <small class="text-danger" v-for="error in formAnalisis.errors.recorpagoult" :key="error">{{ error  }}</small>
                                                        <p class="text-primary fw-bold">3. NIVEL DE DESARROLLO DEL NEGOCIO</p>
                                                        <div class="mb-0" v-for="(opcion, index) in opciones.niveldesarr" :key="index">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label :for="'niveldesarr' + index" class="form-check-label">
                                                                        {{ opcion.label }}
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input
                                                                        class="form-check-input"
                                                                        :id="'niveldesarr' + index"
                                                                        v-model="formAnalisis.niveldesarr"
                                                                        type="radio"
                                                                        name="niveldesarr"
                                                                        :value="opcion.value"
                                                                        @change="calcularAnalisis()"
                                                                    />
                                                                    <label :for="'niveldesarr' + index">{{ opcion.value }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <small class="text-danger" v-for="error in formAnalisis.errors.niveldesarr" :key="error">{{ error  }}</small>
                                                        <p class="text-primary fw-bold">4. TIEMPO FUNCIONAMIENTO DEL NEGOCIO</p> 
                                                        <div class="mb-0" v-for="(opcion, index) in opciones.tiempo_neg" :key="index">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label :for="'tiempo_neg' + index" class="form-check-label">
                                                                        {{ opcion.label }}
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input
                                                                        class="form-check-input"
                                                                        :id="'tiempo_neg' + index"
                                                                        v-model="formAnalisis.tiempo_neg"
                                                                        type="radio"
                                                                        name="tiempo_neg"
                                                                        :value="opcion.value"
                                                                        @change="calcularAnalisis()"
                                                                    />
                                                                    <label :for="'niveldesarr' + index">{{ opcion.value }}</label>
                                                                </div>
                                                            </div>
                                                        </div>                                    
                                                        <small class="text-danger" v-for="error in formAnalisis.errors.tiempo_neg" :key="error">{{ error  }}</small>                    
                                                        <p class="text-primary fw-bold">5. CONTROLA SUS INGRESOS Y EGRESOS</p>
                                                        <div class="mb-0" v-for="(opcion, index) in opciones.control_integre" :key="index">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label :for="'control_integre' + index" class="form-check-label">
                                                                        {{ opcion.label }}
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input
                                                                        class="form-check-input"
                                                                        :id="'control_integre' + index"
                                                                        v-model="formAnalisis.control_integre"
                                                                        type="radio"
                                                                        name="control_integre"
                                                                        :value="opcion.value"
                                                                        @change="calcularAnalisis()"
                                                                    />
                                                                    <label :for="'niveldesarr' + index">{{ opcion.value }}</label>
                                                                </div>
                                                            </div>
                                                        </div>         
                                                        <small class="text-danger" v-for="error in formAnalisis.errors.control_integre" :key="error">{{ error  }}</small>                                                 
                                                        <p class="text-primary fw-bold">6. LAS VENTAS TOTALES SE DECLARAN</p>
                                                        <div class="mb-0" v-for="(opcion, index) in opciones.vent_totdec" :key="index">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label :for="'vent_totdec' + index" class="form-check-label">
                                                                        {{ opcion.label }}
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input
                                                                        class="form-check-input"
                                                                        :id="'vent_totdec' + index"
                                                                        v-model="formAnalisis.vent_totdec"
                                                                        type="radio"
                                                                        name="vent_totdec"
                                                                        :value="opcion.value"
                                                                        @change="calcularAnalisis()"
                                                                    />
                                                                    <label :for="'niveldesarr' + index">{{ opcion.value }}</label>
                                                                </div>
                                                            </div>
                                                        </div>            
                                                        <small class="text-danger" v-for="error in formAnalisis.errors.vent_totdec" :key="error">{{ error  }}</small>                                             
                                                        <p class="text-primary fw-bold">7. COMPORTAMIENTO DEL SUBSECTOR</p>
                                                        <div class="mb-0" v-for="(opcion, index) in opciones.compsubsector" :key="index">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label :for="'compsubsector' + index" class="form-check-label">
                                                                        {{ opcion.label }}
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input
                                                                        class="form-check-input"
                                                                        :id="'compsubsector' + index"
                                                                        v-model="formAnalisis.compsubsector"
                                                                        type="radio"
                                                                        name="compsubsector"
                                                                        :value="opcion.value"
                                                                        @change="calcularAnalisis()"
                                                                    />
                                                                    <label :for="'niveldesarr' + index">{{ opcion.value }}</label>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                        <small class="text-danger" v-for="error in formAnalisis.errors.compsubsector" :key="error">{{ error  }}</small>                                                                                         
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <label for="totalunidademp" class="form-label">
                                                                    TOTAL PUNTAJE UNIDAD EMPRESARIAL {{ formAnalisis.estadoCrud }}
                                                                </label>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control" v-model="formAnalisis.totunidempresa" readonly />
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-md-9"></div>
                                            <div class="col">
                                                <div class="mb-3 has-validation">
                                                    <div class="form-floating is-invalid">
                                                        <input type="total" class="form-control form-control-sm" v-model="formAnalisis.total" 
                                                        placeholder="total"
                                                        :class="{ 'is-invalid': formAnalisis.errors.total }"
                                                        readonly>
                                                        <label for="total">PUNTAJE TOTAL</label>
                                                    </div>
                                                    <div class="invalid-feedback" v-for="error in formAnalisis.errors.total" :key="error">
                                                        {{ error }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">{{ (formAnalisis.estadoCrud=='nuevo') ? 'Guardar Analisis' : 'Actualizar Analisis' }}</button>
                                    </form>
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
                                                                        <input type="text" class="form-control form-control-sm" name="activocaja" id="activocaja"
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
                                                                        <input type="text" class="form-control form-control-sm" name="activobancos" id="activobancos"
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
                                                                        <input type="text" class="form-control form-control-sm" name="activoctascobrar" id="activoctascobrar"
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
                                                                        <input type="text" class="form-control form-control-sm" name="activoinventarios" id="activoinventarios"
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
                                                                        <input type="text" class="form-control form-control-sm" name="totalactivocorr" id="totalactivocorr"
                                                                        placeholder="TOTAL ACTIVO CORRIENTE">
                                                                        <label>TOTAL ACTIVO CORRIENTE</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.totalactivocorr" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div> 
                                                        </div>
                                                        <h5>NO CORRIENTE</h5>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input title="MUEBLES, MAQUINARIA Y EQUIPO" type="text" class="form-control form-control-sm" name="activomueble" id="activomueble"
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
                                                                        <input title="OTROS ACTIVOS" type="text" class="form-control form-control-sm" name="activootrosact" id="activootrosact"
                                                                        placeholder="OTROS ACTIVOS">
                                                                        <label>OTROS ACTIVOS</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.activootrosact" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div> 
    
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input title="DEPRECIACION, AMORTIZACION Y AGOTAMIENTO ACUMULADO" type="text" class="form-control form-control-sm" name="activodepre" id="activodepre"
                                                                        placeholder="DEPRECIACION, AMORTIZACION Y AGOTAMIENTO ACUMULADO">
                                                                        <label>DEPRECIACION, AMORTIZACION Y AGOTAMIENTO ACUMULADO</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.activodepre" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div> 
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input title="TOTAL ACTIVO NO CORRIENTE" type="text" class="form-control form-control-sm" name="totalactivonocorr" id="totalactivonocorr"
                                                                        placeholder="TOTAL ACTIVO NO CORRIENTE">
                                                                        <label>TOTAL ACTIVO NO CORRIENTE</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.totalactivonocorr" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div>
    
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="has-validation">
                                                            <div class="form-floating is-invalid">
                                                                <input title="TOTAL ACTIVO" type="text" class="form-control form-control-sm" name="totalactivo" id="totalactivo"
                                                                placeholder="TOTAL ACTIVO">
                                                                <label>TOTAL ACTIVO</label>
                                                            </div>
                                                            <div class="invalid-feedback" v-for="error in formBalance.errors.totalactivo" :key="error">
                                                                {{ error }}
                                                            </div> 
                                                        </div>                                                            
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
                                                                        <input type="text" class="form-control form-control-sm" name="pasivoproveedores" id="pasivoproveedores"
                                                                        placeholder="PROVEEDORES">
                                                                        <label>PROVEEDORES</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.pasivoproveedores" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm" name="pasivodocpagar" id="pasivodocpagar"
                                                                        placeholder="DOCUMENTOS POR PAGAR">
                                                                        <label>DOCUMENTOS POR PAGAR</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.pasivodocpagar" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>
                                                            </div>                                                         
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm" name="pasivoctaspagar" id="pasivoctaspagar"
                                                                        placeholder="CUENTAS POR PAGAR">
                                                                        <label>CUENTAS POR PAGAR</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.pasivoctaspagar" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div>
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm" name="pasivoimpuestos" id="pasivoimpuestos"
                                                                        placeholder="IMPUESTOS POR PAGAR">
                                                                        <label>IMPUESTOS POR PAGAR</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.pasivoimpuestos" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm" name="totalpasivocorr" id="totalpasivocorr"
                                                                        placeholder="TOTAL PASIVO CORRIENTE" readonly>
                                                                        <label>TOTAL PASIVO CORRIENTE</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.totalpasivocorr" :key="error">
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
                                                                        <input title="OBLIGACIONES FINANCIERAS" type="text" class="form-control form-control-sm" name="pasivofinancieras" id="pasivofinancieras"
                                                                        placeholder="OBLIGACIONES FINANCIERAS">
                                                                        <label>OBLIGACIONES FINANCIERAS</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.pasivofinancieras" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div>
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input title="OTROS PASIVOS" type="text" class="form-control form-control-sm" name="pasivootros" id="pasivootros"
                                                                        placeholder="OTROS PASIVOS">
                                                                        <label>OTROS PASIVOS</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.pasivootros" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>                                                            
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm" name="totalpasivoNOcorr" id="totalpasivoNOcorr"
                                                                        placeholder="TOTAL PASIVO CORRIENTE" readonly>
                                                                        <label>TOTAL PASIVO NO CORRIENTE</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.totalpasivoNOcorr" :key="error">
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
                                                            <label for="patrimonioemp" class="col-md-6 col-form-label text-end">PATRIMONIO EMPRESARIAL</label>
                                                            <div class="col-md-4">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm w-75" name="patrimonioemp" id="patrimonioemp"
                                                                        placeholder="PATRIMONIO EMPRESARIAL">
                                                                        <label>PATRIMONIO EMP.</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.patrimonioemp" :key="error">
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
                                                                        <input type="text" class="form-control form-control-sm w-75" name="totpatrimonio" id="totpatrimonio"
                                                                        placeholder="TOTAL PATRIMONIO">
                                                                        <label>TOTAL PATR.</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.totpatrimonio" :key="error">
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
                                                                        <input type="text" class="form-control form-control-sm w-75" name="paspatrimonio" id="paspatrimonio"
                                                                        placeholder="PASIVO Y PATRIMONIO">
                                                                        <label>PASIVO Y PATR.</label>
                                                                    </div>
                                                                    <div class="invalid-feedback" v-for="error in formBalance.errors.paspatrimonio" :key="error">
                                                                        {{ error }}
                                                                    </div> 
                                                                </div>
                                                            </div> 
                                                        </div>
    
                                                        <div class="row mb-2 align-items-center">
                                                            <label for="captrabajo" class="col-md-6 col-form-label text-end">CAPITAL DE TRABAJO</label>
                                                            <div class="col-md-4">
                                                                <div class="has-validation">
                                                                    <div class="form-floating is-invalid">
                                                                        <input type="text" class="form-control form-control-sm w-75" name="captrabajo" id="captrabajo"
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
                                    <form @submit.prevent="guardarPerdidas">
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
