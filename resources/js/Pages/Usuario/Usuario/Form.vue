<script setup>
import { toRefs, onMounted } from 'vue';
import useUsuario from '@/Composables/Usuario.js';
import useRol from '@/Composables/Rol.js';
import useHelper from '@/Helpers';  
const { hideModal, Toast, slugify } = useHelper();
const props = defineProps({
    form: Object,
    currentPage : Number
});
const { form, currentPage } = toRefs(props)
const {
    errors, respuesta, agregarUsuario, actualizarUsuario
} = useUsuario();
const {
    listaRoles, roles
} = useRol();
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
            hideModal('#modalusuario')
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
            hideModal('#modalusuario')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)
        }
    }
}
const guardar = () => {
    crud[form.value.estadoCrud]()
}
onMounted(() => {
    listaRoles()
})
</script>
<template>
    <form @submit.prevent="guardar">
    <div class="modal fade" id="modalusuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalusuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-2" id="modalusuarioLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">Datos de Usuario</h6>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" v-model="form.username" :class="{ 'is-invalid': form.errors.username }" placeholder="User Name">
                                <small class="text-danger" v-for="error in form.errors.username" :key="error">{{ error
                                        }}</small>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Rol</label>
                                <select v-model="form.role_id" class="form-control"
                                    :class="{ 'is-invalid': form.errors.role_id }">
                                    <option value="" disabled>--Seleccione--</option>
                                    <option v-for="role in roles" :key="role.id" :value="role.id"
                                        :title="role.nombre">
                                        {{ role.nombre }}
                                    </option>
                                </select>
                                <small class="text-danger" v-for="error in form.errors.role_id" :key="error">{{ error
                                        }}</small>
                            </div>  
                
            
                        </div>
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