<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useCliente from '@/Composables/Cliente.js';
import useHelper from '@/Helpers';  
import ClientesSearch from '@/Components/ClientesSearch.vue'
import UbicacionForm from './Ubicacion.vue'
import useNegocio from '@/Composables/Negocio.js';
import useEntidad from '@/Composables/Entidad.js';
import useTipoActividad from '@/Composables/TipoActividad.js';
import { onlyNumbers } from '@/Helpers'
const { hideModal, Toast, openModal, Swal } = useHelper();

const negociosPosee = ref([]);

const form=ref({
    cliente_id : '',
    razonsocial : '',
    dni_cliente : '',
    apenom:'',
    ruc : '',
    tel_cel : '',
    tipo_actividad_id : '',
    descripcion : '',
    inicioactividad : '',
    ubicacion_id : '',
    direccion: '',
    errors:[],
});
const limpiar=()=>{
    form.value.cliente_id = '';
    form.value.razonsocial = '';
    form.value.ruc = '';
    form.value.dni_cliente = '';
    form.value.apenom = '';
    form.value.tel_cel = '';
    form.value.tipo_actividad_id = '';
    form.value.descripcion = '';
    form.value.inicioactividad = '';
    form.value.ubicacion_id = '';
    form.value.direccion = '';        
    form.value.errors =[];
};
const limpiarNegocio=()=>{
    form.value.razonsocial = '';
    form.value.ruc = '';
    form.value.tel_cel = '';
    form.value.tipo_actividad_id = '';
    form.value.descripcion = '';
    form.value.inicioactividad = '';
    form.value.ubicacion_id = '';
    form.value.direccion = '';        
    form.value.errors =[];    
}

const esCasa = ref(false);
const {
    buscarEntidad, entidad
} = useEntidad();
const {
    errors, respuesta, agregarNegocio
} = useNegocio();
const {
    tiposActividades, listaTipoActividades
} = useTipoActividad();

const {
    obtenerClientePorDni, cliente
} = useCliente();
const emit = defineEmits(['onListar', 'evaluar']);
const examinarClientes = ()=>{
    document.getElementById("modalClienteLabel").innerHTML = 'Buscar Cliente';
    openModal('#modalCliente')
}
const guardar = async () => {
    await agregarNegocio(form.value);
    form.value.errors = [];
    if (errors.value) {
        form.value.errors = errors.value;
    }
    if (respuesta.value.ok == 1) {
        form.value.errors = []
        Toast.fire({icon:'success', title:respuesta.value.mensaje})
        cargarDatosPorCliente(form.value.dni_cliente)
        limpiarNegocio()
    }
};
const activarCasaNegocio=()=>{
    if(esCasa.value){
        form.value.ubicacion_id=cliente.value.persona.ubicacion_domicilio_id
    }else{
        form.value.ubicacion_id = ''
    }
}
const buscarCliente = async(dni) =>{
    form.value.dni_cliente=dni
    cargarDatosPorCliente(dni)
}

const cargarDatosPorCliente = async(dni)=>{
    await obtenerClientePorDni(dni)
    form.value.apenom = cliente.value.persona.apenom
    form.value.cliente_id=cliente.value.id
    negociosPosee.value = cliente.value.negocios
    //form.value.direccion=cliente.value.persona?.ubicacion.direccion
}
const nuevaUbicacion=()=>{
    document.getElementById("modalUbicacionFormLabel").innerHTML = 'Ubicacion';
    openModal('#modalUbicacionForm')
}
const busarRuc= async(ruc)=>{
    let formData = new FormData();
    formData.append('tipo', 'ruc');
    formData.append('numero', ruc);
    await buscarEntidad(formData)
    form.value.razonsocial=entidad.value.razonSocial
}

onMounted(() => {
    listaTipoActividades()
});
</script>

<template>
    <form @submit.prevent="guardar">
        <div class="card mb-3">
            <div class="card-header">
                Buscar Cliente
            </div>
            <div class="card-body">
                <div class="input-group has-validation input-group-sm pb-1">
                    <button class="btn btn-outline-secondary" title="Seleccionar" type="button" @click="examinarClientes">
                        <i class="fas fa-search"></i>
                    </button>
                    <div class="form-floating is-invalid">
                        <input type="text" class="form-control form-control-sm" v-model="form.dni_cliente" @keypress="onlyNumbers"
                        @change="buscarCliente(form.dni_cliente)"
                        @keyup.enter="buscarCliente(form.dni_cliente)" placeholder="DNI Cliente">
                        <label for="floatingInputGroup1">DNI Cliente</label>
                    </div>
                    <span class="input-group-text">{{ form.apenom }}</span>
                    <div class="invalid-feedback" v-for="error in form.errors.dni_cliente" :key="error">
                        {{ error }}
                    </div>  
                    <div class="invalid-feedback" v-for="error in form.errors.cliente_id" :key="error">
                        {{ error }}
                    </div>                                                                    
                </div>  

            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                Nuevo Negocio
            </div>
            <div class="card-body">
                <div class="mb-3 d-flex gap-3">
                    <div class="input-group has-validation input-group-sm pb-1">
                        <div class="form-floating is-invalid">
                            <input type="text" class="form-control form-control-sm" v-model="form.ruc" @keypress="onlyNumbers" placeholder="RUC"
                            @change=""
                            >
                            <label for="ruc">RUC</label>
                        </div>
                        <div class="invalid-feedback" v-for="error in form.errors.ruc" :key="error">
                            {{ error }}
                        </div>
                    </div>
                    <div class="input-group has-validation input-group-sm pb-1">
                        <div class="form-floating is-invalid">
                            <input type="text" class="form-control form-control-sm" v-model="form.razonsocial" placeholder="Razon Social">
                            <label for="razonsocial">Razon Social</label>
                        </div>
                        <div class="invalid-feedback" v-for="error in form.errors.razonsocial" :key="error">
                            {{ error }}
                        </div>
                    </div>
                    <div class="input-group has-validation input-group-sm pb-1">
                        <div class="form-floating is-invalid">
                            <input type="text" class="form-control form-control-sm" v-model="form.tel_cel" @keypress="onlyNumbers" maxlength="9" placeholder="Telefono">
                            <label for="tel_cel">Telefono</label>
                        </div>
                        <div class="invalid-feedback" v-for="error in form.errors.tel_cel" :key="error">
                            {{ error }}
                        </div>
                    </div>

                </div>
                <div class="mb-3 d-flex gap-3">
                    <div class="input-group has-validation input-group-sm pb-1">
                        <div class="form-floating is-invalid">
                            <select class="form-select" aria-label="Floating" v-model="form.tipo_actividad_id">
                                <option selected disabled value="">Seleccione</option>
                                <option v-for="tipoactividad in tiposActividades" :value="tipoactividad.id" :key="tipoactividad.id">{{ tipoactividad.nombre }}</option>
                            </select>
                            <label for="tipoactividad">Tipo Actividad</label>
                        </div>
                        <div class="invalid-feedback" v-for="error in form.errors.tipo_actividad_id" :key="error">
                            {{ error }}
                        </div>
                    </div>
                    <div class="input-group has-validation input-group-sm pb-1">
                        <div class="form-floating is-invalid">
                            <input type="text" class="form-control form-control-sm" v-model="form.descripcion" placeholder="Descripcion">
                            <label for="descripcion">Descripcion</label>
                        </div>
                        <div class="invalid-feedback" v-for="error in form.errors.descripcion" :key="error">
                            {{ error }}
                        </div>
                    </div>
                    <div class="input-group has-validation input-group-sm pb-1">
                        <div class="form-floating is-invalid">
                            <input type="date" class="form-control form-control-sm" v-model="form.inicioactividad">
                            <label for="inicioactividad">Inicio Actividad</label>
                        </div>
                        <div class="invalid-feedback" v-for="error in form.errors.inicioactividad" :key="error">
                            {{ error }}
                        </div>
                    </div>
                </div>
                <div class="mb-3" v-if="form.dni_cliente">
                    <div class="input-group has-validation input-group-sm pb-1">
                        <button class="btn btn-outline-secondary" title="Registrar Ubicacion" type="button" @click="nuevaUbicacion">
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="form-floating is-invalid">
                            <input type="text" class="form-control form-control-sm" v-model="form.ubicacion_id"
                            readonly
                                @keypress="onlyNumbers" placeholder="090101"
                                @change="buscarPorUbigeo">
                            <label for="floatingInputGroup1">UBICACION</label>
                        </div>
                        
                        <span class="input-group-text">
                            <input type="checkbox" v-model="esCasa" @change="activarCasaNegocio()">
                        </span>
                        <span class="input-group-text">Casa / Negocio</span>
                        <div class="invalid-feedback" v-for="error in form.errors.ubicacion_id" :key="error">
                            {{ error }}
                        </div>
                    </div>  
                </div>
                <div class="mb-3">
                    {{ form.direccion }}
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
        <div class="card" v-if="negociosPosee.length>0">
            <div class="card-header">Negocios que Posee</div>
            <div class="card-body">
                <div class="table-responsive small">
                    <table class="table table-sm small table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>NRO</th>
                                <th>RUC</th>
                                <th>RAZON SOCIAL</th>
                                <th>Telefono</th>
                                <th>Tipo Activ.</th>
                                <th>Descripcion</th>
                                <th>Inicio</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(negocio, index) in negociosPosee" :key="negocio.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ negocio.ruc }}</td>
                                <td>{{ negocio.razonsocial }}</td>
                                <td>{{ negocio.tel_cel }}</td>
                                <td>{{ negocio.tipo_actividad.nombre }}</td>
                                <td>{{ negocio.descripcion }}</td>
                                <td>{{ negocio.inicio_actividad }}</td>
                                <td>
                                    <button class="btn btn-danger btn-xs" title="Enviar a Papelera" @click.prevent="eliminar(negocio.id)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="alert alert-danger" v-for="error in form.errors.creditos_seleccionados" :key="error">
                    {{ error }}
                </div>
            </div>
        </div>  
    </form>
    <ClientesSearch @cargarPersona="buscarCliente"></ClientesSearch>
    <UbicacionForm :formNegocio="form"></UbicacionForm>
</template>
