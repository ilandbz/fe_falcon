<script setup>
import { toRefs, onMounted } from 'vue';
import useUsuario from '@/Composables/Usuario.js';
import useRol from '@/Composables/Rol.js';
import useHelper from '@/Helpers';  
const { hideModal, Toast } = useHelper();
const props = defineProps({
    atencion: Object,
    diagnosticos : Object,
    medicamentos : Object,
    procedimientos : Object,
    insumos : Object,
});
const { atencion, diagnosticos, medicamentos, insumos } = toRefs(props)
const {
    errors, respuesta, agregarUsuario, actualizarUsuario
} = useUsuario();

const  emit  =defineEmits(['onListar'])
const crud = {
    'nuevo': async() => {
        await agregarUsuario(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalatencion')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)

            
        }
    },
    'editar': async() => {
        await actualizarUsuario(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalatencion')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)
        }
    }
}
const guardar = () => {
    crud[form.value.estadoCrud]()
}
onMounted(() => {

})
</script>
<template>
    <form @submit.prevent="guardar">
    <div class="modal fade" id="modalatencion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalatencionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-2" id="modalatencionLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-8">
                            <h5>PACIENTE : {{ atencion.paciente.ape_paterno + ' ' + atencion.paciente.ape_materno + ' ' + atencion.paciente.primer_nombre + '' + atencion.paciente.otros_nombres }}</h5>
                        </div>
                        <div class="col-md-4">
                            <h5>{{ atencion.codigo + ' - ' + atencion.lote + ' - ' + atencion.numero }}</h5>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-8">
                            <h5>FECHA : {{ atencion.fecha_atencion }}</h5>
                        </div>
                        <div class="col-md-4">
                        </div>
                    </div>                    
                    <div class="card mb-2">
                        <div class="card-header">
                            <h3 class="card-title">DIAGNOSTICOS</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive scrollbar">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="small p-0" scope="col">#</th>
                                        <th class="small p-0" scope="col">Codigo</th>
                                        <th class="small p-0" scope="col">Descripcion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(registro,index) in diagnosticos">
                                            <td class="small p-0">{{ index+1 }}</td>
                                            <td class="small p-0">{{ registro.diagnostico.codigo }}</td>
                                            <td class="small p-0">{{ registro.diagnostico.descripcion }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2" v-if="medicamentos.registros?.length>0">
                        <div class="card-header">
                            <h3 class="card-title">MEDICAMENTOS</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive scrollbar">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="small p-0" scope="col">#</th>
                                        <th class="small p-0" scope="col">Codigo</th>
                                        <th class="small p-0" scope="col">Nombre</th>
                                        <th class="small p-0" scope="col">Cantidad Preescrita</th>
                                        <th class="small p-0" scope="col">Cantidad Entregada</th>
                                        <th class="small p-0" scope="col">Valor (S/.)</th>
                                        <th class="small p-0" scope="col">Sub Total (S/.)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(registro,index) in medicamentos.registros">
                                            <td class="small p-0">{{ index+1 }}</td>
                                            <td class="small p-0">{{ registro.codigo }}</td>
                                            <td class="small p-0">{{ registro.med_Nombre }}</td>
                                            <td class="small p-0">{{ registro.cantidad_preescrita }}</td>
                                            <td class="small p-0">{{ registro.cantidad_entregada }}</td>
                                            <td class="small p-0">{{ registro.valor }}</td>
                                            <td class="small p-0">{{ registro.valor*registro.cantidad_entregada }}</td>
                                        </tr>
                                        <tr>
                                            <th class="small p-1 text-end" colspan="5">
                                                TOTAL
                                            </th>
                                            <th class="small p-1 ">
                                                S/. {{ parseFloat(medicamentos.total).toFixed(2) }}
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2" v-if="procedimientos.registros?.length>0">
                        <div class="card-header">
                            <h3 class="card-title">INSUMOS</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive scrollbar">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="small p-0" scope="col">#</th>
                                        <th class="small p-0" scope="col">Codigo</th>
                                        <th class="small p-0" scope="col">Nombre</th>
                                        <th class="small p-0" scope="col">Cantidad</th>
                                        <th class="small p-0" scope="col">Valor (S/.)</th>
                                        <th class="small p-0" scope="col">Sub Total (S/.)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(registro,index) in insumos.registros">
                                            <td class="small p-0">{{ index+1 }}</td>
                                            <td class="small p-0">{{ registro.codigo }}</td>
                                            <td class="small p-0">{{ registro.ins_Nombre }}</td>
                                            <td class="small p-0">{{ registro.cantidad_entregada }}</td>
                                            <td class="small p-0">{{ registro.valor }}</td>
                                            <td class="small p-0">{{ registro.valor*registro.cantidad_entregada }}</td>
                                        </tr>
                                        <tr>
                                            <th class="small p-1 text-end" colspan="5">
                                                TOTAL
                                            </th>
                                            <th class="small p-1 ">
                                                S/. {{ parseFloat(insumos.total).toFixed(2) }}
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2" v-if="procedimientos.registros?.length>0">
                        <div class="card-header">
                            <h3 class="card-title">PROCEDIMIENTOS</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive scrollbar">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="small p-0" scope="col">#</th>
                                        <th class="small p-0" scope="col">Codigo</th>
                                        <th class="small p-0" scope="col">Nombre</th>
                                        <th class="small p-0" scope="col">Cantidad</th>
                                        <th class="small p-0" scope="col">Valor (S/.)</th>
                                        <th class="small p-0" scope="col">Sub Total (S/.)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(registro,index) in procedimientos.registros">
                                            <td class="small p-0">{{ index+1 }}</td>
                                            <td class="small p-0">{{ registro.codigo }}</td>
                                            <td class="small p-0">{{ registro.cantidad }}</td>
                                            <td class="small p-0">{{ registro.nombre }}</td>
                                            <td class="small p-0">{{ registro.valor }}</td>
                                            <td class="small p-0">{{ registro.valor*registro.cantidad }}</td>
                                        </tr>
                                        <tr>
                                            <th class="small p-1 text-end" colspan="5">
                                                TOTAL
                                            </th>
                                            <th class="small p-1 ">
                                                S/. {{ parseFloat(procedimientos.total).toFixed(2) }}
                                            </th>
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