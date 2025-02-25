<script setup>
import { toRefs, onMounted } from 'vue';
import useMenu from '@/Composables/menu.js';
import useGrupoMenu from '@/Composables/GrupoMenu.js';
import useHelper from '@/Helpers';  
const { hideModal, Toast, slugify } = useHelper();
const props = defineProps({
    form: Object,
    currentPage : Number
});
const { form, currentPage } = toRefs(props)
const {
    errors, respuesta, agregarMenu, actualizarMenu, listaMenus, menus
} = useMenu();
const {
    listaGrupos, grupos
} = useGrupoMenu();
const  emit  =defineEmits(['onListar'])
const crud = {
    'nuevo': async() => {
        await agregarMenu(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalmenu')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)

            
        }
    },
    'editar': async() => {
        await actualizarMenu(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalmenu')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)
        }
    }
}
const guardar = () => {
    crud[form.value.estadoCrud]()
}
onMounted(() => {
    listaMenus()
    listaGrupos()
})
</script>
<template>
    <form @submit.prevent="guardar">
    <div class="modal fade" id="modalmenu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalmenuLabel" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalmenuLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" v-model="form.nombre" :class="{ 'is-invalid': form.errors.nombre }" placeholder="Nombre" @keyup="form.slug=slugify(form.nombre)">
                        <small class="text-danger" v-for="error in form.errors.nombre" :key="error">{{ error
                                }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" v-model="form.slug" :class="{ 'is-invalid': form.errors.slug }" placeholder="Slug">
                        <small class="text-danger" v-for="error in form.errors.slug" :key="error">{{ error
                                }}</small>
                    </div>                                    
                    <div class="mb-3">
                        <label for="icono" class="form-label">Icono</label>
                        <input type="text" class="form-control" v-model="form.icono" :class="{ 'is-invalid': form.errors.icono }" placeholder="Icono">
                        <small class="text-danger" v-for="error in form.errors.icono" :key="error">{{ error
                                }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="grupo" class="form-label">Grupo Menu</label>
                        <select v-model="form.grupo_id" class="form-control"
                            :class="{ 'is-invalid': form.errors.grupo_id }">
                            <option value="" disabled>--Seleccione--</option>
                            <option v-for="grupo in grupos" :key="grupo.id" :value="grupo.id"
                                :title="grupo.titulo">
                                {{ grupo.titulo }}
                            </option>
                        </select>
                        <small class="text-danger" v-for="error in form.errors.grupo_id" :key="error">{{ error
                                }}</small>
                    </div>                     
                    <div class="mb-3">
                        <label for="name" class="form-label">Menu Padre</label>
                        <select v-model="form.padre_id" class="form-control"
                            :class="{ 'is-invalid': form.errors.padre_id }">
                            <option value="">--Seleccione--</option>
                            <option v-for="menu in menus" :key="menu.id" :value="menu.id"
                                :title="menu.nombre">
                                {{ menu.nombre }}
                            </option>
                        </select>
                        <small class="text-danger" v-for="error in form.errors.padre_id" :key="error">{{ error
                                }}</small>
                    </div>   
                    <div class="mb-3" v-if="form.orden!=''">
                        <label for="orden" class="form-label">Orden</label>
                        <input type="number" class="form-control" v-model="form.orden" :class="{ 'is-invalid': form.errors.orden }" placeholder="Orden">
                        <small class="text-danger" v-for="error in form.errors.orden" :key="error">{{ error
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