<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useHelper from '@/Helpers';  
import useVenta from '@/Composables/Venta.js';

const { hideModal, Toast, openModal, Swal } = useHelper();
const {
    agregarVenta, respuesta, errors
    } = useVenta();   

const props = defineProps({
    venta: Object,
});

const { venta } = toRefs(props);

const emit = defineEmits([ 'evaluar']);

const guardar = async() => {
    crud[venta.value.estadoCrud]();
};
const crud = {
    'nuevo': async() => {
        await agregarVenta(venta.value)
        venta.value.errors = []
        if(errors.value)
        {
            venta.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            venta.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            venta.value.estadoCrud='editar'
        }
    },
    'editar': async() => {
        await actualizarVenta(venta.value)
        venta.value.errors = []
        if(errors.value)
        {
            venta.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            venta.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
        }
    }
}
const agregarProducto = () => {
    venta.value.detalles.push({
        nroproducto: venta.value.detalles.length + 1, // Número correlativo
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
    });
};
const eliminarUltimoProducto = () => {
    if (venta.value.detalles.length > 1) { // Evita eliminar si hay solo un producto
        venta.value.detalles.pop();
    }
};

const calcularDatos = (indice) => {
    let detalle = venta.value.detalles[indice];
    const prodMensualMap = {
        'Semanal': 4,
        'Mensual': 1
    };
    detalle.prodmensual = prodMensualMap[detalle.unidadmedida] ?? 26;
    detalle.ventastotales = Number(detalle.preciounit) * Number(detalle.prodmensual);
    detalle.totcostoprimo = (Number(detalle.primaprincipal)+Number(detalle.manoobra1))*detalle.prodmensual
    detalle.margenventas = (detalle.ventastotales - detalle.totcostoprimo)/Number(detalle.ventastotales)
    detalle.matprima = Number(detalle.primaprincipal) + Number(detalle.primasecundaria) + Number(detalle.primacomplement)
    detalle.manoobra = Number(detalle.manoobra1) + Number(detalle.manoobra2)
    detalle.costoprimount = Number(detalle.matprima)+Number(detalle.manoobra)
    venta.value.tot_ing_mensual = venta.value.detalles.reduce(
    (total, detalle) => total + Number(detalle.ventastotales), 0);
    venta.value.tot_cosprimo_m = venta.value.detalles.reduce(
    (total, detalle) => total + Number(detalle.totcostoprimo), 0);    
    venta.value.costoprimovent = (venta.value.tot_cosprimo_m)/(venta.value.tot_ing_mensual);
    venta.value.margen_tot = (venta.value.tot_ing_mensual-venta.value.costoprimovent)/(venta.value.tot_ing_mensual);
};


</script>

<template>
    <form @submit.prevent="guardar">
        <div class="modal fade" id="modaldetVentas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="modaldetVentasLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-1" id="modaldetVentasLabel">Registrar Crédito</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header">
                                Detalle Venta 
                                <button class="btn btn-info btn-sm" type="button" @click="agregarProducto()" title="Agregar Producto"><i class="fas fa-plus"></i></button>
                                <button @click="eliminarUltimoProducto" type="button" class="btn btn-danger btn-sm" title="Eliminar Último"><i class="fas fa-trash"></i></button>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col" v-for="(det, indice) in venta.detalles">
                                        <div class="card border-info mb-3">
                                            <div class="card-header bg-info text-white">
                                                PRODUCTO {{ det.nroproducto }}
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3 has-validation">
                                                    <div class="form-floating is-invalid">
                                                        <input type="text" class="form-control" v-model="venta.detalles[indice].descripcion"
                                                        placeholder="DESCRIPCION">
                                                        <label>DESCRIPCION</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3 has-validation">
                                                    <div class="form-floating is-invalid">
                                                        <select class="form-select" v-model="venta.detalles[indice].unidadmedida"
                                                            @change="calcularDatos(indice)">
                                                            <option value="Diario">Diario</option>
                                                            <option value="Semanal">Semanal</option>
                                                            <option value="Mensual">Mensual</option>
                                                    </select>
                                                        <label>UNIDAD DE MEDIDA</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3 has-validation">
                                                    <div class="form-floating is-invalid">
                                                        <input type="text" class="form-control" v-model="venta.detalles[indice].preciounit"
                                                        placeholder="PRECIO VENTA UNIT."
                                                        @change="calcularDatos(indice)">
                                                        <label>PRECIO VENTA UNIT.</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3 has-validation">
                                                    <div class="form-floating is-invalid">
                                                        <input type="text" class="form-control" v-model="venta.detalles[indice].primaprincipal"
                                                        placeholder="MATERIA PRIMA PRINCIPAL"
                                                        @change="calcularDatos(indice)">
                                                        <label>MATERIA PRIMA PRINCIPAL</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3 has-validation">
                                                    <div class="form-floating is-invalid">
                                                        <input type="text" class="form-control" v-model="venta.detalles[indice].primasecundaria"
                                                        placeholder="MATERIA PRIMA SECUNDARIA"
                                                        @change="calcularDatos(indice)">
                                                        <label>MATERIA PRIMA SECUNDARIA</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3 has-validation">
                                                    <div class="form-floating is-invalid">
                                                        <input type="text" class="form-control" v-model="venta.detalles[indice].primacomplement"
                                                        placeholder="MATERIA PRIMA COMPLEMENTARIA"
                                                        @change="calcularDatos(indice)">
                                                        <label>MATERIA PRIMA COMPLEMENTARIA</label>
                                                    </div>
                                                </div> 
                                                <div class="mb-3 has-validation">
                                                    <div class="form-floating is-invalid">
                                                        <input type="text" class="form-control" v-model="venta.detalles[indice].matprima"
                                                        placeholder="MATERIA PRIMA" readonly>
                                                        <label>MATERIA PRIMA</label>
                                                    </div>
                                                </div>                                 
                                                <div class="mb-3 has-validation">
                                                    <div class="form-floating is-invalid">
                                                        <input type="text" class="form-control" v-model="venta.detalles[indice].manoobra1"
                                                        placeholder="MANO DE OBRA 1"
                                                        @change="calcularDatos(indice)">
                                                        <label>MANO DE OBRA 1</label>
                                                    </div>
                                                </div>  
                                                <div class="mb-3 has-validation">
                                                    <div class="form-floating is-invalid">
                                                        <input type="text" class="form-control" v-model="venta.detalles[indice].manoobra2"
                                                        placeholder="MANO DE OBRA 2"
                                                        @change="calcularDatos(indice)">
                                                        <label>MANO DE OBRA 2</label>
                                                    </div>
                                                </div>                                                              
                                                <div class="mb-3 has-validation">
                                                    <div class="form-floating is-invalid">
                                                        <input type="text" class="form-control" v-model="venta.detalles[indice].manoobra"
                                                        placeholder="MANO DE OBRA" readonly>
                                                        <label>MANO DE OBRA</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3 has-validation">
                                                    <div class="form-floating is-invalid">
                                                        <input type="text" class="form-control" v-model="venta.detalles[indice].costoprimount"
                                                        placeholder="COSTO PRIMO UNITARIO">
                                                        <label>COSTO PRIMO UNITARIO</label>
                                                    </div>
                                                </div>                                
                                                <div class="mb-3 has-validation">
                                                    <div class="form-floating is-invalid">
                                                        <input type="text" class="form-control" v-model="venta.detalles[indice].prodmensual"
                                                        placeholder="PRODUCCION MENSUAL POR PRODUCTO" readonly>
                                                        <label>PRODUCCION MENSUAL POR PRODUCTO</label>
                                                    </div>
                                                </div>                                  
                                                <div class="mb-3 has-validation">
                                                    <div class="form-floating is-invalid">
                                                        <input type="text" class="form-control" v-model="venta.detalles[indice].ventastotales"
                                                        placeholder="VENTAS TOTALES POR PRODUCTO">
                                                        <label>VENTAS TOTALES POR PRODUCTO</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3 has-validation">
                                                    <div class="form-floating is-invalid">
                                                        <input type="text" class="form-control" v-model="venta.detalles[indice].totcostoprimo"
                                                        placeholder="COSTO PRIMO POR PRODUCTO">
                                                        <label>COSTO PRIMO POR PRODUCTO</label>
                                                    </div>
                                                </div> 
                                                <div class="mb-3 has-validation">
                                                    <div class="form-floating is-invalid">
                                                        <input type="text" class="form-control" v-model="venta.detalles[indice].margenventas"
                                                        placeholder="MARGEN DE VENTAS POR PRODUCTO">
                                                        <label>MARGEN DE VENTAS POR PRODUCTO</label>
                                                    </div>
                                                </div>                                 
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                Valores Generales
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                    <label for="" class="control-label">TOTAL INGRESO MENSUAL</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">S/.</span>
                                            </div>
                                            <input type="text" class="form-control" v-model="venta.tot_ing_mensual" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <label for="margtontal" class="control-label">MARGEN TOTAL</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">S/.</span>
                                            </div>
                                            <input type="text" class="form-control" v-model="venta.margen_tot" readonly>
                                        </div>					
                                    </div>			
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="totcostoprimo" class="control-label">TOTAL COSTO PRIMO MENSUAL</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">S/.</span>
                                            </div>
                                            <input type="text" class="form-control" v-model="venta.tot_cosprimo_m" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <label for="" class="control-label">VENTAS AL CREDITO</label>						
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" v-model="venta.ventas_cred">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon1">%</span>
                                            </div>						
                                        </div>
                                    </div>			
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="" class="control-label">COSTO PRIMO/VENTAS</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">S/.</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" v-model="venta.costoprimovent" readonly>
                                        </div>	
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="control-label">IRRECUPERABILIDAD</label>	
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control form-control-sm"  v-model="venta.irrecuperable">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon1">%</span>
                                            </div>						
                                        </div>
                                    </div>			
                                </div>        
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</template>
