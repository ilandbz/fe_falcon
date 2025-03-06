<script setup>
import { toRefs, onMounted, ref } from 'vue';
import usePerdidas from '@/Composables/Perdidas.js'; 
import useVenta from '@/Composables/Venta.js'; 
import useGastoNegocio from '@/Composables/GastoNegocio.js'; 
import useGastoFamiliar from '@/Composables/GastoFamiliar.js'; 
import DetVentasForm from './FormDetVentas.vue'
import GastoNegocioForm from './FormGastoNegocio.vue'
import GastoFamiliarForm from './FormGastosFamiliares.vue'
import useHelper from '@/Helpers'; 
const props = defineProps({
    formPerdidas: Object,
});
const { formPerdidas } = toRefs(props);
const {
    agregarPerdidas, actualizarPerdidas, respuesta, errors
    } = usePerdidas();
const {
    regventa, obtenerVenta, agregarVenta, actualizarVenta
    } = useVenta();    
const {
    gastos, obtenerGastos, agregarGastos, actualizarGastos
    } = useGastoNegocio();    
const {
    gastosfamiliares, obtenerGastosFamiliares, agregarGastosFamiliares, actualizarGastosFamiliares
    } = useGastoFamiliar();        
const { Toast, openModal } = useHelper();


const venta = ref({
    credito_id: '',
    tot_ing_mensual:0,
    tot_cosprimo_m:0,
    margen_tot:0,
    ventas_cred:0,
    irrecuperable:0,
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
        prodmensual: 26,
        ventastotales: 0,
        totcostoprimo: 0,
        margenventas: 0,            
    }],
    estadoCrud: '', 
    errors: []
});

const limpiarVenta = () => {
    venta.value = {
        credito_id: '',
        tot_ing_mensual: 0,
        tot_cosprimo_m: 0,
        margen_tot: 0,
        ventas_cred: 0,
        irrecuperable: 0,
        cantproductos: 1,
        costoprimovent: 0,
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
            prodmensual: 26,
            ventastotales: 0,
            totcostoprimo: 0,
            margenventas: 0,            
        }],
        estadoCrud: '',
        errors: []
    };
};
const formGastoNegocio = ref({
    credito_id : '',
    alquiler : '',
    servicios : '',
    personal : '',
    sunat : '',
    transporte : '',
    gastosfinancieros : '',
    otros : '',
    total : '',
    estadoCrud: '', 
    errors: []
});


const formGastoFamiliar = ref({
    idsolicitud : '',
    alimentacion : '',
    alquileres : '',
    educacion : '',
    servicios : '',
    transporte : '',
    salud : '',
    otros : '',
    total : '',
    estadoCrud: '', 
    errors: []
});


const obtenerDatosGastoNegocio = async(credito_id)=>{
    if(formGastoNegocio.value.estadoCrud != ''){
        return true;
    }
    formGastoNegocio.value.credito_id=credito_id;
    await obtenerGastos(credito_id)
    if(gastos.value){
        formGastoNegocio.value.alquiler=gastos.value.alquiler;
        formGastoNegocio.value.servicios=gastos.value.servicios;
        formGastoNegocio.value.personal=gastos.value.personal;
        formGastoNegocio.value.sunat=gastos.value.sunat;
        formGastoNegocio.value.transporte=gastos.value.transporte;
        formGastoNegocio.value.gastosfinancieros=gastos.value.gastosfinancieros;
        formGastoNegocio.value.otros = gastos.value.otros;
        formGastoNegocio.value.total = Number(gastos.value.alquiler) + Number(gastos.value.servicios) + Number(gastos.value.personal) + Number(gastos.value.sunat) + 
        Number(gastos.value.transporte) + Number(gastos.value.gastosfinancieros) + Number(gastos.value.otros);
        formGastoNegocio.value.estadoCrud= 'editar'; 
    }else{
        formGastoNegocio.value.alquiler=0;
        formGastoNegocio.value.servicios=0;
        formGastoNegocio.value.personal=0;
        formGastoNegocio.value.sunat=0;
        formGastoNegocio.value.transporte=0;
        formGastoNegocio.value.gastosfinancieros=0;
        formGastoNegocio.value.otros=0;
        formGastoNegocio.value.total = 0;
        formGastoNegocio.value.estadoCrud = 'nuevo';
    }
}
const obtenerDatosGastoFamiliares = async(credito_id)=>{
    if(formGastoFamiliar.value.estadoCrud != ''){
        return true;
    }
    await obtenerGastosFamiliares(credito_id)
    formGastoFamiliar.value.credito_id=credito_id;
    if(gastosfamiliares.value){
        formGastoFamiliar.value.alimentacion=gastosfamiliares.value.alimentacion;
        formGastoFamiliar.value.alquileres=gastosfamiliares.value.alquileres;
        formGastoFamiliar.value.educacion=gastosfamiliares.value.educacion;
        formGastoFamiliar.value.servicios=gastosfamiliares.value.servicios;
        formGastoFamiliar.value.transporte=gastosfamiliares.value.transporte;
        formGastoFamiliar.value.salud=gastosfamiliares.value.salud;
        formGastoFamiliar.value.otros=gastosfamiliares.value.otros;
        formGastoFamiliar.value.total=Number(gastosfamiliares.value.alimentacion)+
                                      Number(gastosfamiliares.value.alquileres)+
                                      Number(gastosfamiliares.value.educacion)+
                                      Number(gastosfamiliares.value.servicios)+
                                      Number(gastosfamiliares.value.transporte)+
                                      Number(gastosfamiliares.value.salud)+
                                      Number(gastosfamiliares.value.otros);
        formGastoFamiliar.value.estadoCrud= 'editar'; 
    }else{
        formGastoFamiliar.value.alimentacion=0;
        formGastoFamiliar.value.alquileres=0;
        formGastoFamiliar.value.educacion=0;
        formGastoFamiliar.value.servicios=0;
        formGastoFamiliar.value.transporte=0;
        formGastoFamiliar.value.salud=0;
        formGastoFamiliar.value.otros=0;
        formGastoFamiliar.value.total=0;
        formGastoFamiliar.value.estadoCrud = 'nuevo';
    }
}
const obtenerDatos = async(credito_id)=>{
    
    venta.value.credito_id=credito_id;


    if(venta.value.estadoCrud!=''){
        return true;
    }
    limpiarVenta()
    await obtenerVenta(credito_id)
    if(regventa.value){
        venta.value.tot_ing_mensual=regventa.value.tot_ing_mensual;
        venta.value.tot_cosprimo_m=regventa.value.tot_cosprimo_m;
        venta.value.margen_tot=regventa.value.margen_tot;
        venta.value.ventas_cred=regventa.value.ventas_cred;
        venta.value.irrecuperable=regventa.value.irrecuperable;
        venta.value.cantproductos=regventa.value.cantproductos;
        venta.value.detalles = regventa.value.detalles;
        venta.value.estadoCrud= 'editar'; 
    }else{
        venta.value.estadoCrud = 'nuevo';
    }
}

const buscarDetVenta=()=>{
    obtenerDatos(formPerdidas.value.credito_id)
    openModal('#modaldetVentas')
    document.getElementById("modaldetVentasLabel").innerHTML = 'Detalle de Ventas';
}
const buscarGastoNegocio=()=>{
    obtenerDatosGastoNegocio(formPerdidas.value.credito_id)
    openModal('#GastosNegocio')
    document.getElementById("GastosNegocioLabel").innerHTML = 'Gasto Negocio';
}
const buscarGastoFamiliar=()=>{
    obtenerDatosGastoFamiliares(formPerdidas.value.credito_id)
    openModal('#GastosFamiliar')
    document.getElementById("GastosFamiliarLabel").innerHTML = 'Gasto Familiar';
}
const crud = {
    'nuevo': async() => {
        await agregarPerdidas(formPerdidas.value)
        formPerdidas.value.errors = []
        if(errors.value)
        {
            formPerdidas.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            formPerdidas.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            formPerdidas.value.estadoCrud='editar'
            await agregarVenta(venta.value)
            await agregarGastos(formGastoNegocio.value)
            await agregarGastosFamiliares(formGastoFamiliar.value)
            limpiarVenta()
        }
    },
    'editar': async() => {
        await actualizarPerdidas(formPerdidas.value)
        formPerdidas.value.errors = []
        if(errors.value)
        {
            formPerdidas.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            formPerdidas.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            if(venta.value.estadoCrud=='editar'){
                await actualizarVenta(venta.value)
            }else{
                await agregarVenta(venta.value)
            }
            if(formGastoNegocio.value.estadoCrud=='editar'){
                await agregarGastos(formGastoNegocio.value)
            }else{
                await actualizarGastos(formGastoNegocio.value)
            }
            if(formGastoFamiliar.value.estadoCrud=='editar'){
                await agregarGastosFamiliares(formGastoFamiliar.value)
            }else{
                await actualizarGastosFamiliares(formGastoFamiliar.value)
            }
            limpiarVenta()
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
                                <input type="text" title="OTROS EGRESOS" class="form-control" v-model="formPerdidas.otrosegr"
                                placeholder="OTROS EGRESOS">
                                <label>OTROS EGRESOS</label>
                            </div>
                            <div class="invalid-feedback" v-for="error in formPerdidas.errors.otrosegr" :key="error">
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
    <DetVentasForm :venta="venta" :formPerdidas="formPerdidas" @limpiarVenta="limpiarVenta"></DetVentasForm>
    <GastoNegocioForm :form="formGastoNegocio" :formPerdidas="formPerdidas"></GastoNegocioForm>
    <GastoFamiliarForm :form="formGastoFamiliar" :formPerdidas="formPerdidas"></GastoFamiliarForm>

</template>