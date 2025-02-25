<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useHelper from '@/Helpers';  
import useGastoNegocio from '@/Composables/GastoNegocio.js'; 
const { hideModal, Toast, openModal, Swal } = useHelper();

const props = defineProps({
    form: Object,
    formPerdidas: Object
});

const { form, formPerdidas } = toRefs(props);
const {
    agregarGastos, respuesta, errors, actualizarGastos
    } = useGastoNegocio();   

const guardar = async() => {
    //crud[form.value.estadoCrud]();
    hideModal('#GastosNegocio');
    formPerdidas.value.costonegocio= form.value.total
};
const calcularTotal = () =>{
    form.value.total=Number(form.value.alquiler)+
                    Number(form.value.servicios)+
                    Number(form.value.personal)+
                    Number(form.value.sunat)+
                    Number(form.value.transporte)+
                    Number(form.value.gastosfinancieros)+
                    Number(form.value.otros);
}
const limpiar=()=>{
    if(form.value.estadoCrud == 'nuevo'){
        form.value.credito_id='';
        form.value.alquiler=0;
        form.value.servicios=0;
        form.value.personal=0;
        form.value.sunat=0;
        form.value.transporte=0;
        form.value.gastosfinancieros=0;
        form.value.otros=0;
        form.value.total = 0;
        form.value.estadoCrud = '';
    }

}
// const crud = {
//     'nuevo': async() => {
//         await agregarGastos(form.value)
//         form.value.errors = []
//         if(errors.value)
//         {
//             form.value.errors = errors.value
//         }
//         if(respuesta.value.ok==1){
//             form.value.errors = []
//             Toast.fire({icon:'success', title:respuesta.value.mensaje})
//             form.value.estadoCrud='editar'
//             hideModal('#GastosNegocio');
//             formPerdidas.value.costonegocio= form.value.total
//         }
        
//     },
//     'editar': async() => {
//         await actualizarGastos(form.value)
//         form.value.errors = []
//         if(errors.value)
//         {
//             form.value.errors = errors.value
//         }
//         if(respuesta.value.ok==1){
//             form.value.errors = []
//             Toast.fire({icon:'success', title:respuesta.value.mensaje})
//             hideModal('#GastosNegocio');
//             formPerdidas.value.costonegocio= form.value.total
//         }
        
//     }
// }

</script>

<template>
    <form @submit.prevent="guardar">
        <div class="modal fade" id="GastosNegocio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="GastosNegocioLabel" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-1" id="GastosNegocioLabel">Registrar Crédito</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" class="form-horizontal">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="" class="control-label">Alquiler</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/.</span>
                                        </div>
                                        <input type="text" class="form-control" @change="calcularTotal()" placeholder="0.00" v-model="form.alquiler">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="control-label col-md-6">Servicios</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/.</span>
                                        </div>	
                                        <input type="text" class="form-control" @change="calcularTotal()" placeholder="0.00" v-model="form.servicios">
                                    </div>
                                </div>				
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="" class="control-label">Personal</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/.</span>
                                        </div>		
                                        <input type="text" class="form-control" @change="calcularTotal()" placeholder="0.00" v-model="form.personal">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="control-label">Sunat</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/.</span>
                                        </div>			
                                        <input type="text" class="form-control" @change="calcularTotal()" placeholder="0.00" v-model="form.sunat">
                                    </div>
                                </div>				
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="" class="control-label">Transporte</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/.</span>
                                        </div>			
                                        <input type="text" class="form-control" @change="calcularTotal()" placeholder="0.00" v-model="form.transporte">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="control-label">Gastos Financieros</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/.</span>
                                        </div>			
                                        <input type="text" class="form-control" @change="calcularTotal()" placeholder="0.00" v-model="form.gastosfinancieros">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="" class="control-label">Otros</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/.</span>
                                        </div>		
                                        <input type="text" class="form-control" @change="calcularTotal()" placeholder="0.00" v-model="form.otros">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="control-label">Total</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/.</span>
                                        </div>		
                                        <input type="text" class="form-control" placeholder="0.00" v-model="form.total" readonly>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="limpiar()">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>
