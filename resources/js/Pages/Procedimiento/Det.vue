<script setup>
import { toRefs, onMounted } from 'vue';
import useHelper from '@/Helpers';  
const { hideModal, Toast } = useHelper();
const props = defineProps({
    objeto: Object,
});
const { objeto } = toRefs(props)

</script>
<template>
    <form @submit.prevent="guardar">
    <div class="modal fade" id="modalprocedimiento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalprocedimientoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-2" id="modalprocedimientoLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <h5>CPT : {{ objeto.PRCD_ID_PROCEDIMIENTO + ' ' + objeto.PRCD_V_CODPRO_MINSA + ' ' + objeto.PRCD_V_DESPROCEDIMIENTO }}</h5>
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
                                        <th class="small p-0" scope="col">Codigo</th>
                                        <th class="small p-0" scope="col">Descripcion</th>
                                        <th class="small p-0" scope="col">NIVEL 2</th>
                                        <th class="small p-0" scope="col">NIVEL 3</th>
                                        <th class="small p-0" scope="col">PERIODO</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(registro,index) in objeto.registros">
                                            <td class="small p-0">{{ index+1 }}</td>
                                            <td class="small p-0">{{ registro.procedimiento.PRCD_V_CODPRO_MINSA }}</td>
                                            <td class="small p-0">{{ registro.procedimiento.PRCD_V_DESPROCEDIMIENTO }}</td>
                                            <td class="small p-0">{{ registro.nivel2 }}</td>
                                            <td class="small p-0">{{ registro.nivel2 }}</td>
                                            <td class="small p-0">{{ registro.periodo }}</td>
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