<script setup>
import { toRefs, onMounted } from 'vue';
import useGrupoMenu from '@/Composables/GrupoMenu.js';
import useHelper from '@/Helpers';  
const { hideModal, Toast, slugify } = useHelper();
const props = defineProps({
    form: Object,
    currentPage : Number
});
const { form, currentPage } = toRefs(props)
const {
    errors, respuesta, agregarGrupo, actualizarGrupo, listaGrupos, grupos
} = useGrupoMenu();
const  emit  =defineEmits(['onListar'])
const crud = {
    'nuevo': async() => {
        await agregarGrupo(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalGrupo')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)

            
        }
    },
    'editar': async() => {
        await actualizarGrupo(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalGrupo')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)
        }
    }
}
const guardar = () => {
    crud[form.value.estadoCrud]()
}
onMounted(() => {
    listaGrupos()
})
</script>
<template>
    <form @submit.prevent="guardar">
    <div class="modal fade" id="modalGrupo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalGrupoLabel" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalGrupoLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Titulo</label>
                        <input type="text" class="form-control" v-model="form.titulo" :class="{ 'is-invalid': form.errors.titulo }" placeholder="Titulo">
                        <small class="text-danger" v-for="error in form.errors.titulo" :key="error">{{ error
                                }}</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">{{ (form.estadoCrud=='nuevo') ? 'Guardar' : 'Actualizar' }}</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</template>