<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useHelper from '@/Helpers';  
import useGastoFamiliar from '@/Composables/GastoFamiliar.js'; 
const { hideModal, Toast, openModal, Swal } = useHelper();

const props = defineProps({
    form: Object,
    formPerdidas: Object,
});

const { form, formPerdidas } = toRefs(props);
const {
    agregarGastosFamiliares, respuesta,errors, actualizarGastosFamiliares
    } = useGastoFamiliar();  

const guardar = async() => {
    //crud[form.value.estadoCrud]();
    hideModal('#GastosFamiliar');
    formPerdidas.value.gast_fam= form.value.total
};
const limpiar=()=>{
    if(form.value.estadoCrud == 'nuevo'){
        form.value.credito_id='';
        form.value.alimentacion=0;
        form.value.alquileres=0;
        form.value.educacion=0;
        form.value.servicios=0;
        form.value.transporte=0;
        form.value.salud=0;
        form.value.otros=0;
        form.value.total=0;
        form.value.estadoCrud = '';
    }

}
// const crud = {
//     'nuevo': async() => {
//         await agregarGastosFamiliares(form.value)
//         form.value.errors = []
//         if(errors.value)
//         {
//             form.value.errors = errors.value
//         }
//         if(respuesta.value.ok==1){
//             form.value.errors = []
//             Toast.fire({icon:'success', title:respuesta.value.mensaje})
//             form.value.estadoCrud='editar'
//             hideModal('#GastosFamiliar');
//             formPerdidas.value.gast_fam= form.value.total
//         }
        
//     },
//     'editar': async() => {
//         await actualizarGastosFamiliares(form.value)
//         form.value.errors = []
//         if(errors.value)
//         {
//             form.value.errors = errors.value
//         }
//         if(respuesta.value.ok==1){
//             form.value.errors = []
//             Toast.fire({icon:'success', title:respuesta.value.mensaje})
//             hideModal('#GastosFamiliar');
//             formPerdidas.value.gast_fam= form.value.total
//         }
        
//     }
// }
const calcularTotal = () =>{
    form.value.total=Number(form.value.alimentacion)+
                    Number(form.value.alquileres)+
                    Number(form.value.educacion)+
                    Number(form.value.servicios)+
                    Number(form.value.transporte)+
                    Number(form.value.salud)+
                    Number(form.value.otros);
}
</script>

<template>
    <form @submit.prevent="guardar">
        <div class="modal fade" id="GastosFamiliar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="GastosFamiliarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-1" id="GastosFamiliarLabel">Gastos Familiares</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <label for="" class="control-label col-md-6">Alimentacion</label>
                            <div class="col-md-6">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">S/.</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="0.00" v-model="form.alimentacion">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label for="" class="control-label col-md-6">Alquileres</label>
                            <div class="col-md-6">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">S/.</span>
                                    </div>		
                                    <input type="text" class="form-control" placeholder="0.00" v-model="form.alquileres">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label for="" class="control-label col-md-6">Educacion</label>
                            <div class="col-md-6">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">S/.</span>
                                    </div>			
                                    <input type="text" class="form-control" @change="calcularTotal()" placeholder="0.00" v-model="form.educacion">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label for="" class="control-label col-md-6">Servicios</label>
                            <div class="col-md-6">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">S/.</span>
                                    </div>			
                                    <input type="text" class="form-control" @change="calcularTotal()" placeholder="0.00" v-model="form.servicios">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label for="" class="control-label col-md-6">Transporte</label>
                            <div class="col-md-6">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">S/.</span>
                                    </div>			
                                    <input type="text" class="form-control" @change="calcularTotal()" placeholder="0.00" v-model="form.transporte">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label for="" class="control-label col-md-6">Salud</label>
                            <div class="col-md-6">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">S/.</span>
                                    </div>			
                                    <input type="text" class="form-control" @change="calcularTotal()" placeholder="0.00" v-model="form.salud">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="" class="control-label">Otros</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">S/.</span>
                                    </div>		
                                    <input type="text" class="form-control" @change="calcularTotal()" placeholder="0.00" v-model="form.otros">
                                </div>
                            </div>

                            <div class="col">
                                <label for="" class="control-label">Total</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">S/.</span>
                                    </div>		
                                    <input type="text" class="form-control" placeholder="0.00" v-model="form.total" readonly>
                                </div>
                            </div>
                        </div>
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
