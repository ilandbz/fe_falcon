<script setup>
import { toRefs, onMounted, ref, readonly } from 'vue';
import useHelper from '@/Helpers';  
import usePersona from '@/Composables/Persona.js';
import useUbigeo from '@/Composables/Ubigeo.js';
import useUsuario from '@/Composables/Usuario.js';
const { hideModal, Toast, slugify } = useHelper();
const {
    errors, agregarPersona, respuesta
} = usePersona();
const {
    registro, obtenerUbigeo
} = useUbigeo();
const props = defineProps({
    form: Object,
    profesiones: Array
});
const { form, profesiones } = toRefs(props)
const profesionActivo=ref(false);
const  emit  =defineEmits(['activarDni'])
const activarProfesion=()=>{
    if(form.value.grado_instr=='Superior Completa'){
        profesionActivo.value=true
    }
}
const regUbigeo = ref({
    distrito : 'Dist.',
    provincia : 'Prov.',
    departamento : 'Dep.',
});
const guardar = async() => {
    let formData = new FormData();
    formData.append('dni', form.value.dni);
    formData.append('ape_pat', form.value.ape_pat);
    formData.append('ape_mat', form.value.ape_mat);
    formData.append('primernombre', form.value.primernombre);
    formData.append('otrosnombres', form.value.otrosnombres);
    formData.append('fecha_nac', form.value.fecha_nac);
    formData.append('ubigeo', form.value.ubigeo);
    formData.append('email', form.value.email);
    formData.append('celular', form.value.celular);
    formData.append('genero', form.value.genero);
    formData.append('estado_civil', form.value.estado_civil);
    formData.append('foto', file.value);
    formData.append('persona_id', form.value.persona_id);
    formData.append('grado_instr', form.value.grado_instr);
    formData.append('profesion', form.value.profesion);
    formData.append('usuario_id', form.value.usuario_id);
    formData.append('dniconyugue', form.value.dniconyugue);
    formData.append('tipo_trabajador', form.value.tipo_trabajador);
    
    await agregarPersona(formData)
    form.value.errors = []
    if(errors.value)
    {
        form.value.errors = errors.value
    }
    if(respuesta.value.ok==1){
        form.value.errors = []
        hideModal('#modalPersona')
        Toast.fire({icon:'success', title:respuesta.value.mensaje})
        emit('activarDni')
    }
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
const buscarPorUbigeo=async()=>{
    await obtenerUbigeo(form.value.ubigeo)
    if(regUbigeo.value){
        let distrito = registro.value
        regUbigeo.value.distrito=distrito.nombre
        regUbigeo.value.provincia=distrito.provincia.nombre
        regUbigeo.value.departamento=distrito.provincia.departamento.nombre
    }
}
const imagenNoEncontrada = (event)=>{
    event.target.src = "/storage/fotos/default.png"; // Imagen por defecto
}
</script>
<template>
    <form @submit.prevent="guardar">
    <div class="modal fade" id="modalPersona" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalPersonaLabel">
        <div class="modal-dialog modal-lg bg-primary">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-1" id="modalPersonaLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-2 text-muted">Datos Personales</h6>
                                    <div class="mb-3">
                                        <div class="form-floating is-invalid">
                                            <input type="text" class="form-control form-control-sm" v-model="form.dni" 
                                            maxlength="8" placeholder="00000000" @keypress="onlyNumbers"
                                            :class="{ 'is-invalid': form.errors.dni }">
                                            <label for="dni">DNI</label>
                                        </div>
                                        <div class="invalid-feedback" v-for="error in form.errors.dni" :key="error">
                                            {{ error }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-floating is-invalid">
                                            <input type="text" class="form-control form-control-sm" v-model="form.ape_pat" 
                                            @input="form.ape_pat = form.ape_pat.toUpperCase()" placeholder="Apellido Paterno"
                                            :class="{ 'is-invalid': form.errors.ape_pat }">
                                            <label for="ape_pat">Apellido Paterno</label>
                                        </div>
                                        <div class="invalid-feedback" v-for="error in form.errors.ape_pat" :key="error">
                                            {{ error }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-floating is-invalid">
                                            <input type="text" class="form-control form-control-sm" v-model="form.ape_mat" 
                                            @input="form.ape_mat = form.ape_mat.toUpperCase()" placeholder="Apellido Materno"
                                            :class="{ 'is-invalid': form.errors.ape_mat }">
                                            <label for="ape_mat">Apellido Materno</label>
                                        </div>
                                        <div class="invalid-feedback" v-for="error in form.errors.ape_mat" :key="error">
                                            {{ error }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-floating is-invalid">
                                            <input type="text" class="form-control form-control-sm" v-model="form.primernombre" 
                                            @input="form.primernombre = form.primernombre.toUpperCase()" placeholder="Primer Nombre"
                                            :class="{ 'is-invalid': form.errors.primernombre }">
                                            <label for="primernombre">Primer Nombre</label>
                                        </div>
                                        <div class="invalid-feedback" v-for="error in form.errors.primernombre" :key="error">
                                            {{ error }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-floating is-invalid">
                                            <input type="text" class="form-control form-control-sm" v-model="form.otrosnombres" 
                                            @input="form.otrosnombres = form.otrosnombres.toUpperCase()" placeholder="Otros Nombres"
                                            :class="{ 'is-invalid': form.errors.otrosnombres }">
                                            <label for="otrosnombres">Otros Nombres</label>
                                        </div>
                                        <div class="invalid-feedback" v-for="error in form.errors.otrosnombres" :key="error">
                                            {{ error }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-floating is-invalid">
                                            <input type="date" class="form-control form-control-sm" v-model="form.fecha_nac" 
                                            :class="{ 'is-invalid': form.errors.fecha_nac }">
                                            <label for="fecha_nac">Fecha de Nacimiento</label>
                                        </div>
                                        <div class="invalid-feedback" v-for="error in form.errors.fecha_nac" :key="error">
                                            {{ error }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="input-group input-group-sm pb-1">
                                            <div class="form-floating is-invalid">
                                                <input type="text" class="form-control form-control-sm" v-model="form.ubigeo"
                                                @keypress="onlyNumbers" placeholder="090101"
                                                @change="buscarPorUbigeo"
                                                >
                                                <label for="floatingInputGroup1">UBIGEO</label>
                                            </div>
                                            <span class="input-group-text">{{ regUbigeo.distrito }} - {{ regUbigeo.provincia }} - {{ regUbigeo.departamento }}</span>
                                            <div class="invalid-feedback" v-for="error in form.errors.ubigeo" :key="error">
                                                {{ error }}
                                            </div>                                    
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-floating is-invalid">
                                            <input type="email" class="form-control form-control-sm" v-model="form.email" 
                                            placeholder="email"
                                            :class="{ 'is-invalid': form.errors.email }">
                                            <label for="email">Email</label>
                                        </div>
                                        <div class="invalid-feedback" v-for="error in form.errors.email" :key="error">
                                            {{ error }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="input-group has-validation">
                                            <div class="form-floating is-invalid">
                                                <input type="text" class="form-control form-control-sm" v-model="form.celular" 
                                                placeholder="000000000"
                                                @keypress="onlyNumbers"
                                                :class="{ 'is-invalid': form.errors.celular }">
                                                <label for="celular">Celular</label>
                                            </div>
                                            <div class="invalid-feedback" v-for="error in form.errors.celular" :key="error">
                                                {{ error }}
                                            </div>
                                        </div>

                                    </div>
                                    <div class="mb-3">
                                        <div class="form-floating is-invalid">
                                            <select class="form-select" aria-label="Floating" v-model="form.genero">
                                                <option selected disabled value="">Seleccione</option>
                                                <option value="F">Femenino</option>
                                                <option value="M">Masculino</option>
                                            </select>
                                            <label for="genero">Genero</label>
                                        </div>
                                        <div class="invalid-feedback" v-for="error in form.errors.genero" :key="error">
                                            {{ error }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-floating is-invalid">
                                            <select class="form-select" aria-label="Floating" v-model="form.estado_civil" :readonly="form.estado_civil=='Casado' || form.estado_civil=='Conviviente'">
                                                <option value="" selected disabled>Seleccione</option>
                                                <option value="Conviviente">Conviviente</option>
                                                <option value="Soltero">Soltero</option>
                                                <option value="Casado">Casado</option>
                                                <option value="Divorciado">Divorciado</option>
                                            </select>
                                            <label for="estadocivil">Estado Civil</label>
                                        </div>
                                        <div class="invalid-feedback" v-for="error in form.errors.estado_civil" :key="error">
                                            {{ error }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="foto" class="form-label">Foto</label>
                                        <input class="form-control" type="file" accept="image/*" @change="cambiarFoto">
                                        <div class="card">
                                            <img id="inputImagen" :src="form.foto" class="img-fluid img-thumbnail">
                                        </div>
                                        <small class="text-danger" v-for="error in form.errors.foto" :key="error">{{ error }}<br></small>
                                    </div>   
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-2 text-muted">Actividades</h6>
                                    <div class="mb-3">
                                        <div class="form-floating is-invalid">
                                            <select class="form-select" aria-label="Floating" v-model="form.grado_instr" @change="activarProfesion">
                                                <option value="" selected disabled>Seleccione</option>
                                                <option value="Sin Estudio">Sin Estudio</option>
                                                <option value="Primaria Incompleta">Primaria Incompleta</option>
                                                <option value="Primaria Completa">Primaria Completa</option>
                                                <option value="Secundaria Incompleta">Secundaria Incompleta</option>
                                                <option value="Secundaria Completa">Secundaria Completa</option>
                                                <option value="Superior Incompleta">Superior Incompleta</option>
                                                <option value="Superior Completa">Superior Completa</option>
                                            </select>
                                            <label for="gradoinstruccion">Grado Instruccion</label>
                                        </div>
                                        <div class="invalid-feedback" v-for="error in form.errors.grado_instr" :key="error">
                                            {{ error }}
                                        </div>
                                    </div>
                                    <div class="mb-3" v-if="profesionActivo">
                                        <div class="form-floating is-invalid">
                                            <select class="form-select" id="profesion" aria-label="Floating" v-model="form.profesion">
                                                <option selected disabled>Seleccione</option>
                                                <option :value="profesion.nombre" v-for="profesion in profesiones" :key="profesion.id">{{ profesion.nombre }}</option>
                                            </select>
                                            <label for="profesion">Profesion</label>
                                        </div>
                                        <div class="invalid-feedback" v-for="error in form.errors.profesion" :key="error">
                                            {{ error }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-floating is-invalid">
                                            <select class="form-select" aria-label="Floating" v-model="form.tipo_trabajador">
                                                <option selected disabled value="">Seleccione</option>
                                                <option value="Independiente">Independiente</option>
                                                <option value="Dependiente">Dependiente</option>
                                            </select>
                                            <label for="tipo_trabajador">Tipo de Trabajador</label>
                                        </div>
                                        <div class="invalid-feedback" v-for="error in form.errors.tipo_trabajador" :key="error">
                                            {{ error }}
                                        </div>
                                    </div>
                                    <div class="mb-3" v-if="form.tipo_trabajador=='Dependiente'">
                                        <div class="form-floating">
                                            <select class="form-select" aria-label="Floating" v-model="form.ocupacion">
                                                <option selected disabled value="">Seleccione</option>
                                                <option value="Independiente">Independiente</option>
                                                <option value="Dependiente">Dependiente</option>
                                            </select>
                                            <label for="ocupacion">Ocupacion</label>
                                        </div>
                                        <div class="invalid-feedback" v-for="error in form.errors.ocupacion" :key="error">
                                            {{ error }}
                                        </div>
                                    </div>
                                    <div class="mb-3" v-if="form.tipo_trabajador=='Dependiente'">
                                        <div class="form-floating is-invalid">
                                            <input type="text" class="form-control form-control-sm" v-model="form.tipodomicilio" 
                                            placeholder="000000000"
                                            :class="{ 'is-invalid': form.errors.tipodomicilio }">
                                            <label for="celular">Institucion donde Labora</label>
                                        </div>
                                        <div class="invalid-feedback" v-for="error in form.errors.tipodomicilio" :key="error">
                                            {{ error }}
                                        </div>
                                    </div>                                  
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</template>