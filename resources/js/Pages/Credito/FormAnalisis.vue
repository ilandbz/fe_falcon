<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useAnalisisCualitativo from '@/Composables/AnalisisCualitativo.js';  
import useHelper from '@/Helpers'; 
const props = defineProps({
    formAnalisis: Object,

});
const { formAnalisis } = toRefs(props);
const {
    agregarRegistro, actualizarRegistro, respuesta, errors
    } = useAnalisisCualitativo();
const { Toast } = useHelper();
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
    control_ingegre: [
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
        Number(formAnalisis.value.control_ingegre) +
        Number(formAnalisis.value.vent_totdec) +
        Number(formAnalisis.value.compsubsector);
       
    formAnalisis.value.total = formAnalisis.value.totunidfamiliar + formAnalisis.value.totunidempresa;
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
const guardarAnalisis = () => {
    crud[formAnalisis.value.estadoCrud]();
};
</script>
<template>
    <h3 class="text-center">Analisis Cualitativo</h3>
    <form @submit.prevent="guardarAnalisis">
        <!-- UNIDAD FAMILIAR -->
        <div class="row mb-3">
            <div class="col">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">I. UNIDAD FAMILIAR</div>
                    <div class="card-body">
                        <p class="text-primary fw-bold">1. TIPO DE GARANTÍA {{ formAnalisis.estadoCrud }}</p>
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
                        <div class="mb-0" v-for="(opcion, index) in opciones.control_ingegre" :key="index">
                            <div class="row">
                                <div class="col-md-10">
                                    <label :for="'control_ingegre' + index" class="form-check-label">
                                        {{ opcion.label }}
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input
                                        class="form-check-input"
                                        :id="'control_ingegre' + index"
                                        v-model="formAnalisis.control_ingegre"
                                        type="radio"
                                        name="control_ingegre"
                                        :value="opcion.value"
                                        @change="calcularAnalisis()"
                                    />
                                    <label :for="'niveldesarr' + index">{{ opcion.value }}</label>
                                </div>
                            </div>
                        </div>         
                        <small class="text-danger" v-for="error in formAnalisis.errors.control_ingegre" :key="error">{{ error  }}</small>                                                 
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
                                    TOTAL PUNTAJE UNIDAD EMPRESARIAL
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
</template>