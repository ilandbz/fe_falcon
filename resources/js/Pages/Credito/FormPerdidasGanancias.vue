<script setup>
import { toRefs, onMounted, ref } from 'vue';
import usePerdidas from '@/Composables/Perdidas.js'; 
import DetVentasForm from './FormDetVentas.vue'
import GastoNegocioForm from './FormGastoNegocio.vue'
import GastoFamiliarForm from './FormGastosFamiliares.vue'
import useHelper from '@/Helpers'; 
const props = defineProps({
    formPerdidas: Object,

});
const { formPerdidas } = toRefs(props);
const {
    agregarRegistro, actualizarRegistro, respuesta, errors
    } = usePerdidas();
const { Toast, openModal } = useHelper();


const venta = ref({
    credito_id: '',
    tot_ing_mensual:'',
    tot_cosprimo_m:'',
    margen_tot:'',
    ventas_cred:'',
    irrecuperable:'',
    cantproductos:1,
    costoprimovent:0,//totcostoprimo/totingmensual
    detalles: [{
        nroproducto: 1,
        descripcion: '',
        unidadmedida: 'Diario',
        preciounit: 0,
        primaprincipal: 0,
        primasecundaria: 0,
        primacomplement: 0,
        matprima: 0,
        manoobra1: 0,
        manoobra2: 0,
        manoobra: 0,
        costoprimount: 0,
        prodmensual: 0,
        ventastotales: 0,
        totcostoprimo: 0,
        margenventas: 0,            
    }],
    estadoCrud: '', 
    errors: []
});

const obtenerDatos = async(credito_id)=>{

}

const buscarDetVenta=()=>{
    //limpiar()
    // form.value.estadoCrud = 'nuevo'
    openModal('#modaldetVentas')
    document.getElementById("modaldetVentasLabel").innerHTML = 'Detalle de Ventas';
}

const buscarGastoNegocio=()=>{
    openModal('#GastosNegocio')
    document.getElementById("GastosNegocioLabel").innerHTML = 'Gasto Negocio';
}

const buscarGastoFamiliar=()=>{
    openModal('#GastosFamiliar')
    document.getElementById("GastosFamiliarLabel").innerHTML = 'Gasto Familiar';
}


const crud = {
    'nuevo': async() => {
        await agregarRegistro(formPerdidas.value)
        formPerdidas.value.errors = []
        if(errors.value)
        {
            formPerdidas.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            formPerdidas.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            formPerdidas.value.estadoCrud='editar'
        }
    },
    'editar': async() => {
        await actualizarRegistro(formPerdidas.value)
        formPerdidas.value.errors = []
        if(errors.value)
        {
            formPerdidas.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            formPerdidas.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
        }
    }
}
const guardarPerdidas = () => {
    crud[formPerdidas.value.estadoCrud]();
};
</script>
<template>
    <h3 class="text-center">Perdidas y Ganancias</h3>
    <form @submit.prevent="guardarPerdidas">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <div class="input-group has-validation">
                            <span class="input-group-text">S/.</span>
                            <div class="form-floating is-invalid">
                                <input type="text" class="form-control" v-model="formPerdidas.ventas"
                                placeholder="VENTAS">
                                <label>VENTAS</label>
                            </div>
                            <button class="btn btn-outline-secondary" title="Detalles" type="button" @click="buscarDetVenta()">
                                <i class="fas fa-plus"></i>
                            </button>
                            <div class="invalid-feedback" v-for="error in formPerdidas.errors.ventas" :key="error">
                                {{ error }}
                            </div> 
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group has-validation">
                            <span class="input-group-text">S/.</span>
                            <div class="form-floating is-invalid">
                                <input type="text" class="form-control" v-model="formPerdidas.costo"
                                placeholder="COSTOS">
                                <label>COSTOS</label>
                            </div>
                            <button class="btn btn-outline-secondary" title="Detalles" type="button" @click="buscarDetVenta()">
                                <i class="fas fa-plus"></i>
                            </button>
                            <div class="invalid-feedback" v-for="error in formPerdidas.errors.costo" :key="error">
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
                                <input type="text" class="form-control" v-model="formPerdidas.utilidad"
                                placeholder="UTILIDAD">
                                <label>UTILIDAD</label>
                            </div>
                            <div class="invalid-feedback" v-for="error in formPerdidas.errors.utilidad" :key="error">
                                {{ error }}
                            </div> 
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group has-validation">
                            <span class="input-group-text">S/.</span>
                            <div class="form-floating is-invalid">
                                <input type="text" class="form-control" v-model="formPerdidas.costonegocio"
                                placeholder="GASTO NEGOCIO">
                                <label>GASTO NEGOCIO</label>
                            </div>
                            <button class="btn btn-outline-secondary" title="Seleccionar" type="button" @click="buscarGastoNegocio()">
                                <i class="fas fa-plus"></i>
                            </button>
                            <div class="invalid-feedback" v-for="error in formPerdidas.errors.costonegocio" :key="error">
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
                                <input type="text" class="form-control" v-model="formPerdidas.utiloperativa"
                                placeholder="UTILIDAD OPERATIVA">
                                <label>UTILIDAD OPERATIVA</label>
                            </div>
                            <div class="invalid-feedback" v-for="error in formPerdidas.errors.utiloperativa" :key="error">
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
                                <input type="text" title="GASTOS FAMILIARES" class="form-control" v-model="formPerdidas.gast_fam"
                                placeholder="GASTOS FAMILIARES">
                                <label>GASTOS FAMILIARES</label>
                            </div>
                            <button class="btn btn-outline-secondary" title="Seleccionar" type="button" @click="buscarGastoFamiliar()">
                                <i class="fas fa-plus"></i>
                            </button>
                            <div class="invalid-feedback" v-for="error in formPerdidas.errors.gast_fam" :key="error">
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
                                <input type="text" title="UTILIDAD NETA" class="form-control" v-model="formPerdidas.utilidadneta"
                                placeholder="UTILIDAD NETA">
                                <label>UTILIDAD NETA</label>
                            </div>
                            <div class="invalid-feedback" v-for="error in formPerdidas.errors.utilidadneta" :key="error">
                                {{ error }}
                            </div> 
                        </div>
                    </div>

                    <div class="col">
                        <div class="input-group has-validation">
                            <span class="input-group-text">S/.</span>
                            <div class="form-floating is-invalid">
                                <input type="text" title="UTILIDAD NETA DIARIA" class="form-control" v-model="formPerdidas.utilnetdiaria"
                                placeholder="UTILIDAD NETA DIARIA">
                                <label>UTILIDAD NETA DIARIA</label>
                            </div>
                            <div class="invalid-feedback" v-for="error in formPerdidas.errors.utilnetdiaria" :key="error">
                                {{ error }}
                            </div> 
                        </div>
                    </div>						
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ (formPerdidas.estadoCrud=='nuevo') ? 'Guardar Perdidas' : 'Actualizar Perdidas' }}</button>
    </form>
    <DetVentasForm :venta="venta"></DetVentasForm>
    <GastoNegocioForm></GastoNegocioForm>
    <GastoFamiliarForm></GastoFamiliarForm>
</template>