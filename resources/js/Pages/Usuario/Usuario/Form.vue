<script setup>
import { toRefs, onMounted, ref } from 'vue';
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
        let formData = new FormData();
        formData.append('username', form.value.username);
        formData.append('dni', form.value.dni);
        formData.append('role_id', form.value.role_id);
        formData.append('foto', file.value);
        await agregarUsuario(formData)
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
        let formData = new FormData();
        formData.append('id', form.value.id);
        formData.append('username', form.value.username);
        formData.append('dni', form.value.dni);
        formData.append('role_id', form.value.role_id);
        formData.append('foto', file.value);
        await actualizarUsuario(formData)
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
const onlyNumbers=(event)=> {
    if (!/[0-9]/.test(event.key)) {
        event.preventDefault();
    }
}
const file = ref(null);
const cambiarFoto = (e)=>{
    file.value = e.target.files[0]
    if (file) {
        form.value.foto=URL.createObjectURL(file.value);
    }
}
const imagenNoEncontrada = (event)=>{
      event.target.src = "/storage/fotos/default.png"; // Imagen por defecto
    }
const generarUserName = ()=>{
    let username = form.value.primernombre.toUpperCase().substring(0,1)+
    form.value.apepat.toUpperCase().substring(0,5)+
    form.value.apemat.toUpperCase().substring(0,3)

    //form.value.username = slugify(username)
    form.value.username = username
}
onMounted(() => {
    listaRoles()
})
</script>
<template>
    <form @submit.prevent="guardar">
    <div class="modal fade" id="modalusuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalusuarioLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-1" id="modalusuarioLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-2 text-muted">Datos de Usuario</h6>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">DNI</label>
                                        <input type="text" class="form-control" v-model="form.dni" :class="{ 'is-invalid': form.errors.dni }" maxlength="8" placeholder="00000000" @keypress="onlyNumbers">
                                        <small class="text-danger" v-for="error in form.errors.dni" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Apellido Paterno</label>
                                        <input type="text" class="form-control" v-model="form.apepat" :class="{ 'is-invalid': form.errors.apepat }" placeholder="Apellido Paterno">
                                        <small class="text-danger" v-for="error in form.errors.apepat" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Apellido Materno</label>
                                        <input type="text" class="form-control" v-model="form.apemat" :class="{ 'is-invalid': form.errors.apemat }" placeholder="Apellido Materno">
                                        <small class="text-danger" v-for="error in form.errors.apemat" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Primer Nombre</label>
                                        <input type="text" class="form-control" v-model="form.primernombre" :class="{ 'is-invalid': form.errors.primernombre }" placeholder="Primer Nombre">
                                        <small class="text-danger" v-for="error in form.errors.primernombre" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Otros Nombres</label>
                                        <input type="text" class="form-control" v-model="form.otrosnombres" :class="{ 'is-invalid': form.errors.otrosnombres }" placeholder="Otros Nombres">
                                        <small class="text-danger" v-for="error in form.errors.otrosnombres" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3" v-if="form.estadoCrud=='nuevo'">
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
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Username</label>
                                        <input type="text" class="form-control" v-model="form.username" :class="{ 'is-invalid': form.errors.username }"
                                        placeholder="User Name"
                                        @focus="generarUserName()">
                                        <small class="text-danger" v-for="error in form.errors.username" :key="error">{{ error
                                                }}</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="foto" class="form-label">Foto</label>
                                        <input class="form-control" type="file" accept="image/*" @change="cambiarFoto">
                                        <div class="card">
                                            <img id="inputImagen" :src="form.foto" class="img-fluid img-thumbnail" @error="imagenNoEncontrada">
                                        </div>
                                        <small class="text-danger" v-for="error in form.errors.foto" :key="error">{{ error }}<br></small>
                                    </div>     
 
                                </div>
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