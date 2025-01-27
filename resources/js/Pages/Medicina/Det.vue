<script setup>
import { toRefs, onMounted } from 'vue';
import useUsuario from '@/Composables/Usuario.js';
import useRol from '@/Composables/Rol.js';
import useHelper from '@/Helpers';  
const { hideModal, Toast } = useHelper();
const props = defineProps({
    medicamento: Object,
});
const { medicamento } = toRefs(props)


onMounted(() => {

})
</script>
<template>
    <form @submit.prevent="guardar">
    <div class="modal fade" id="modalmedicamento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalmedicamentoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-2" id="modalmedicamentoLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-8">
                            <h5>MED : {{ medicamento.nombre + ' ' + medicamento.med_FormaFarmaceutica + ' ' + medicamento.Concen }}</h5>
                        </div>
                        <div class="col-md-4">
                        
                        </div>
                    </div>                 
                    <div class="card mb-2">
                        <div class="card-header">
                            <h3 class="card-title">Precios</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive scrollbar">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="small p-0" scope="col">#</th>
                                        <th class="small p-0" scope="col">Codigo DUE</th>
                                        <th class="small p-0" scope="col">Codigo Med</th>
                                        <th class="small p-0" scope="col">Descripcion</th>
                                        <th class="small p-0" scope="col">PRECIOADJ</th>
                                        <th class="small p-0" scope="col">PREOPE</th>
                                        <th class="small p-0" scope="col">PERIODO</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(registro,index) in medicamento.registros">
                                            <td class="small p-0">{{ index+1 }}</td>
                                            <td class="small p-0">{{ registro.CCODUE }}</td>
                                            <td class="small p-0">{{ registro.medicamento.med_CodMed }}</td>
                                            <td class="small p-0">{{ registro.medicamento.med_Nombre }}</td>
                                            <td class="small p-0">{{ registro.PREADJ }}</td>
                                            <td class="small p-0">{{ registro.PREOPE }}</td>
                                            <td class="small p-0">{{ registro.CPERIODO }}</td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                 </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</template>