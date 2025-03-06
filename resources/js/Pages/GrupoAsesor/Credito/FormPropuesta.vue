<script setup>
import { toRefs, onMounted, ref } from 'vue';
import usePropuesta from '@/Composables/Propuesta.js'; 
import useHelper from '@/Helpers'; 
const props = defineProps({
    formPropuesta: Object,

});
const { formPropuesta } = toRefs(props);
const {
    agregarPropuesta, actualizarPropuesta, respuesta, errors
    } = usePropuesta();
const { Toast } = useHelper();



const crud = {
    'nuevo': async() => {
        await agregarPropuesta(formPropuesta.value)
        formPropuesta.value.errors = []
        if(errors.value)
        {
            formPropuesta.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            formPropuesta.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            formPropuesta.value.estadoCrud='editar'
        }
    },
    'editar': async() => {
        await actualizarPropuesta(formPropuesta.value)
        formPropuesta.value.errors = []
        if(errors.value)
        {
            formPropuesta.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            formPropuesta.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
        }
    }
}
const guardarPropuesta = () => {
    crud[formPropuesta.value.estadoCrud]();
};
</script>

<template>
    <h3 class=" text-center">Propuesta de Credito</h3>
    <form @submit.prevent="guardarPropuesta">
        <div class="form-group">
            <label class="control-label">UNIDAD FAMILIAR(CONYUGUE, HIJOS)</label>
            <textarea v-model="formPropuesta.unidad_familiar" class="form-control input-sm" placeholder="Unidad Familiar" rows="4"></textarea>
        </div>
        <div class="form-group">
            <label class="">EXPERIENCIA CREDITICIA Y NEGOCIO</label>
            <textarea v-model="formPropuesta.experiencia_cred" class="form-control input-sm" placeholder="Experiencia Crediticia" rows="4"></textarea>
        </div>
        <div class="form-group">
            <label class="">DESTINO DEL PRESTAMO</label>
            <textarea v-model="formPropuesta.destino_prest" class="form-control input-sm" placeholder="Destino del Prestamo" rows="4"></textarea>
        </div>
        <div class="form-group mb-3">
            <label class="">REFERENCIAS PERSONALES Y COMERCIALES</label>
            <textarea v-model="formPropuesta.referencias" class="form-control input-sm" placeholder="Destino del Prestamo" rows="4"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">{{ (formPropuesta.estadoCrud=='nuevo') ? 'Guardar Propuesta' : 'Actualizar Propuesta' }}</button>
    </form>
</template>