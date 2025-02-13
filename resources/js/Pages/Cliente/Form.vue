<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useCliente from '@/Composables/Cliente.js';
import useHelper from '@/Helpers';  
import usePersona from '@/Composables/Persona.js';
import useUbigeo from '@/Composables/Ubigeo.js';
import useUsuario from '@/Composables/Usuario.js';
import useProfesion from '@/Composables/Profesion.js';
import PersonaForm from './PersonaForm.vue'
import UbigeoForm from '@/Components/UbigeoForm.vue'
import { onlyNumbers } from '@/Helpers'
const { hideModal, Toast, openModal } = useHelper();
const props = defineProps({
    form: Object,
    currentPage : Number
});
const {
    persona, obtenerPorDni
} = usePersona();
const {
    profesiones, listaProfesiones
} = useProfesion();
const {
    usuarios, obtenerUsuariosTipoAgencia
} = useUsuario();
const {
    registro, obtenerUbigeo
} = useUbigeo();
const { form, currentPage } = toRefs(props)
const {
    errors, respuesta, agregarCliente, actualizarCliente
} = useCliente();
const regUbigeo = ref({
    distrito : 'Dist.',
    provincia : 'Prov.',
    departamento : 'Depart.',
});
const regUbigeo2 = ref({
    distrito : 'Dist.',
    provincia : 'Prov.',
    departamento : 'Depart.',
});
const imagenNoEncontrada = (event)=>{
    event.target.src = "/storage/fotos/default.png"; // Imagen por defecto
}
const aval=ref(false);
const datosAval=ref({
    id: '',
    dni:'',
    ape_pat:'',
    ape_mat:'',
    primernombre:'',
    otrosnombres:'',
    fecha_nac:'',
    ubigeo:'',
    email:'',
    celular:'',
    genero:'',
    estado_civil:'',
})
const datosConyugue=ref({
    id: '',
    dni:'',
    ape_pat:'',
    ape_mat:'',
    primernombre:'',
    otrosnombres:'',
    fecha_nac:'',
    ubigeo:'',
    email:'',
    celular:'',
    genero:'',
    estado_civil:'',
})
const datosPersona=ref({
    id: '',
    dni:'',
    ape_pat:'',
    ape_mat:'',
    primernombre:'',
    otrosnombres:'',
    fecha_nac:'',
    ubigeo:'',
    email:'',
    celular:'',
    genero:'',
    estado_civil:'',
    ruc:'',
    agencia_id: '',
    foto : '/storage/fotos/default.png',
    persona_id: '',
    grado_instr: '',
    profesion:'',
    usuario_id: '',
    dniaval:'',
    tipo_trabajador: '',
    ocupacion: '',
    institucion_lab: '',
    tipodomicilio: '',
    ubigeodomicilio: '',
    tipovia:'',
    nombrevia:'',
    nro:'',
    interior:'',
    mz:'',
    lote:'',
    tipozona:'',
    nombrezona: '',
    referencia:'',
    latitud_longitud:'',
    errors: []
})
const limpiar = () => {
    datosPersona.value.id = '';
    datosPersona.value.dni = '';
    datosPersona.value.ape_pat = '';
    datosPersona.value.ape_mat = '';
    datosPersona.value.primernombre = '';
    datosPersona.value.otrosnombres = '';
    datosPersona.value.fecha_nac = '';
    datosPersona.value.ubigeo = '';
    datosPersona.value.email = '';
    datosPersona.value.celular = '';
    datosPersona.value.genero = '';
    datosPersona.value.estado_civil = '';
    datosPersona.value.ruc = '';
    datosPersona.value.agencia_id = '';
    datosPersona.value.foto = '/storage/fotos/default.png';
    datosPersona.value.persona_id = '';
    datosPersona.value.grado_instr = '';
    datosPersona.value.profesion = '';
    datosPersona.value.usuario_id = '';
    datosPersona.value.dniaval = '';
    datosPersona.value.tipo_trabajador = '';
    datosPersona.value.ocupacion = '';
    datosPersona.value.institucion_lab = '';
    datosPersona.value.tipodomicilio = '';
    datosPersona.value.ubigeodomicilio = '';
    datosPersona.value.tipovia = '';
    datosPersona.value.nombrevia = '';
    datosPersona.value.nro = '';
    datosPersona.value.interior = '';
    datosPersona.value.mz = '';
    datosPersona.value.lote = '';
    datosPersona.value.tipozona = '';
    datosPersona.value.nombrezona = '';
    datosPersona.value.referencia = '';
    datosPersona.value.latitud_longitud = '';
    datosPersona.value.estado = 'REGISTRADO';
    datosPersona.value.fecha_reg = '';
    datosPersona.value.hora_reg = '';
    datosPersona.value.estadoCrud = '';
    datosPersona.value.errors = [];
    errors.value = [];
};
const tipoRelacionPersona=ref('');
const cambiarAval=()=>{
    aval.value = !aval.value;
}
const  emit  =defineEmits(['onListar'])
const crud = {
    'nuevo': async() => {
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
        formData.append('ruc', form.value.ruc);
        formData.append('agencia_id', form.value.agencia_id ?? 1);
        formData.append('foto', file.value);
        formData.append('persona_id', form.value.persona_id);
        formData.append('grado_instr', form.value.grado_instr);
        formData.append('profesion', form.value.profesion);
        formData.append('usuario_id', form.value.usuario_id);
        formData.append('dniconyugue', form.value.dniconyugue);
        formData.append('conyugue_id', form.value.conyugue_id);
        formData.append('dniaval', form.value.dniaval);
        formData.append('aval_id', form.value.aval_id);
        formData.append('tipo_trabajador', form.value.tipo_trabajador);
        formData.append('ocupacion', form.value.ocupacion);
        formData.append('institucion_lab', form.value.institucion_lab);
        formData.append('tipodomicilio', form.value.tipodomicilio);
        formData.append('ubigeodomicilio', form.value.ubigeodomicilio);
        formData.append('tipovia', form.value.tipovia);
        formData.append('nombrevia', form.value.nombrevia);
        formData.append('nro', form.value.nro);
        formData.append('interior', form.value.interior);
        formData.append('mz', form.value.mz);
        formData.append('lote', form.value.lote);
        formData.append('tipozona', form.value.tipozona);
        formData.append('nombrezona', form.value.nombrezona);
        formData.append('referencia', form.value.referencia);
        formData.append('latitud_longitud', form.value.latitud_longitud);
        formData.append('estado', form.value.estado);
        formData.append('fecha_reg', form.value.fecha_reg);
        formData.append('hora_reg', form.value.hora_reg);
        await agregarCliente(formData)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalCliente')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)
        }
    },
    'editar': async() => {
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
        formData.append('ruc', form.value.ruc);
        formData.append('foto', file.value);
        formData.append('persona_id', form.value.persona_id);
        formData.append('grado_instr', form.value.grado_instr);
        formData.append('profesion', form.value.profesion);
        formData.append('usuario_id', form.value.usuario_id);
        formData.append('dniconyugue', form.value.dniconyugue);
        formData.append('conyugue_id', form.value.conyugue_id);
        formData.append('dniaval', form.value.dniaval);
        formData.append('aval_id', form.value.aval_id);
        formData.append('tipo_trabajador', form.value.tipo_trabajador);
        formData.append('ocupacion', form.value.ocupacion);
        formData.append('institucion_lab', form.value.institucion_lab);
        formData.append('tipodomicilio', form.value.tipodomicilio);
        formData.append('ubigeodomicilio', form.value.ubigeodomicilio);
        formData.append('tipovia', form.value.tipovia);
        formData.append('nombrevia', form.value.nombrevia);
        formData.append('nro', form.value.nro);
        formData.append('interior', form.value.interior);
        formData.append('mz', form.value.mz);
        formData.append('lote', form.value.lote);
        formData.append('tipozona', form.value.tipozona);
        formData.append('nombrezona', form.value.nombrezona);
        formData.append('referencia', form.value.referencia);
        formData.append('latitud_longitud', form.value.latitud_longitud);
        formData.append('estado', form.value.estado);
        formData.append('fecha_reg', form.value.fecha_reg);
        formData.append('hora_reg', form.value.hora_reg);
        formData.append('agencia_id', form.value.agencia_id ?? 1);
        await actualizarCliente(formData)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalCliente')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)
        }
    }
}
const guardar = () => {
    crud[form.value.estadoCrud]()
}
const buscarPersona= async(dni)=>{
    await obtenerPorDni(dni)
    if(persona.value){
        form.value.id = persona.value.id
        form.value.ape_pat = persona.value.ape_pat
        form.value.ape_mat = persona.value.ape_mat
        form.value.primernombre = persona.value.primernombre
        form.value.otrosnombres = persona.value.otrosnombres
        form.value.fecha_nac = persona.value.fecha_nac
        form.value.ubigeo = persona.value.ubigeo_nac
        buscarPorUbigeo()
        form.value.email = persona.value.email
        form.value.celular = persona.value.celular
        form.value.ruc = persona.value.ruc
        form.value.estado_civil = persona.value.estado_civil
        form.value.grado_instr = persona.value.grado_instr
        form.value.profesion = persona.value.profesion
        form.value.tipo_trabajador = persona.value.tipo_trabajador
    }
}
const file = ref(null);
const cambiarFoto = (e)=>{
    file.value = e.target.files[0]
    if (file) {
        form.value.foto=URL.createObjectURL(file.value);
    }
}
const nuevoPersona = (tipo) => {
    limpiar()
    tipoRelacionPersona.value=tipo
    if(tipo=='Conyugue'){
        datosPersona.value.estado_civil=form.value.estado_civil
        document.getElementById("modalPersonaLabel").innerHTML = 'Conyugue';
    }else{
        document.getElementById("modalPersonaLabel").innerHTML = 'Aval';
    }
    openModal('#modalPersona')
}

const activarPersonaRelacionado = () =>{
    if(tipoRelacionPersona.value=='Conyugue'){

        buscarPersonaConyugue(datosPersona.value.dni)
        form.value.dniconyugue=datosPersona.value.dni
    }else{
        buscarPersonaAval(datosPersona.value.dni)
        form.value.dniaval =datosPersona.value.dni
    }
}
const buscarPersonaAval= async(dni)=>{
    await obtenerPorDni(dni)
    if(persona.value){
        datosAval.value.id = persona.value.id
        form.value.aval_id = datosAval.value.id
        datosAval.value.ape_pat = persona.value.ape_pat
        datosAval.value.ape_mat = persona.value.ape_mat
        datosAval.value.primernombre = persona.value.primernombre
        datosAval.value.otrosnombres = persona.value.otrosnombres
        datosAval.value.fecha_nac = persona.value.fecha_nac
    }
}
const buscarPersonaConyugue=async(dni)=>{
    await obtenerPorDni(dni)
    if(persona.value){
        datosConyugue.value.id = persona.value.id
        form.value.conyugue_id = datosConyugue.value.id
        datosConyugue.value.ape_pat = persona.value.ape_pat
        datosConyugue.value.ape_mat = persona.value.ape_mat
        datosConyugue.value.primernombre = persona.value.primernombre
        datosConyugue.value.otrosnombres = persona.value.otrosnombres
        datosConyugue.value.fecha_nac = persona.value.fecha_nac
    }    
}
const buscarPorUbigeo=async()=>{
    await obtenerUbigeo(form.value.ubigeo)
    if(regUbigeo.value){
        let distrito = registro.value
        regUbigeo.value.distrito=distrito.nombre
        regUbigeo.value.provincia=distrito.provincia?.nombre
        regUbigeo.value.departamento=distrito.provincia?.departamento.nombre
    }
}
const listarProfesiones=async()=>{
    await listaProfesiones()
}
const listaAsesores = async()=>{
    await obtenerUsuariosTipoAgencia(5, 0)
}
const buscarUbigeo = ()=>{
    document.getElementById("modalUbigeoLabel").innerHTML = 'Buscar Ubigeo';
    openModal('#modalUbigeo')
}
onMounted(() => {
    listaAsesores()
    listarProfesiones()
})
</script>
<template>
    <form @submit.prevent="guardar">
        <div class="modal fade" id="modalCliente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="modalClienteLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-1" id="modalClienteLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted">Datos de Cliente</h6>
                                        <div class="mb-3 has-validation">
                                            <div class="form-floating is-invalid">
                                                <input type="text" class="form-control form-control-sm" v-model="form.dni" 
                                                maxlength="8" placeholder="00000000" @keypress="onlyNumbers" @change="buscarPersona(form.dni)"
                                                :class="{ 'is-invalid': form.errors.dni }">
                                                <label for="dni">DNI</label>
                                            </div>
                                            <div class="invalid-feedback" v-for="error in form.errors.dni" :key="error">
                                                {{ error }}
                                            </div>
                                        </div>
                                        <div class="mb-3 has-validation">
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
                                        <div class="mb-3 has-validation">
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
                                        <div class="mb-3 has-validation">
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
                                        <div class="mb-3 has-validation">
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
                                        <div class="mb-3 has-validation">
                                            <div class="form-floating is-invalid">
                                                <input type="date" class="form-control form-control-sm" v-model="form.fecha_nac" 
                                                :class="{ 'is-invalid': form.errors.fecha_nac }">
                                                <label for="fecha_nac">Fecha de Nacimiento</label>
                                            </div>
                                            <div class="invalid-feedback" v-for="error in form.errors.fecha_nac" :key="error">
                                                {{ error }}
                                            </div>
                                        </div>
                                        <div class="mb-3 has-validation">
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
                                        <div class="mb-3 has-validation">
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
                                        <div class="mb-3 has-validation">
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
                                        <div class="mb-3 has-validation">
                                            <div class="form-floating is-invalid">
                                                <select class="form-select" aria-label="Floating" v-model="form.genero"
                                                    :class="{ 'is-invalid': form.errors.genero }">
                                                    <option selected disabled value="">Seleccione</option>
                                                    <option value="F">Femenino</option>
                                                    <option value="M">Masculino</option>
                                                </select>
                                                <label for="genero">Genero</label>
                                            </div>
                                            <div class="invalid-feedback" v-for="error in form.errors.email" :key="error">
                                                {{ error }}
                                            </div>
                                        </div>
                                        <div class="mb-3 has-validation">
                                            <div class="form-floating is-invalid">
                                                <select class="form-select" aria-label="Floating" v-model="form.estado_civil">
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
                                        <div class="mb-3 has-validation" v-if="form.estado_civil=='Conviviente' || form.estado_civil=='Casado'">
                                            <div class="input-group">
                                                <div class="form-floating is-invalid">
                                                    <input type="text" class="form-control form-control-sm" v-model="form.dniconyugue" 
                                                    maxlength="8" placeholder="00000000"
                                                    @keypress="onlyNumbers"
                                                    @change="buscarPersonaConyugue(form.dniconyugue)"
                                                    :class="{ 'is-invalid': form.errors.dniconyugue }">
                                                    <label for="dni">DNI Conyugue</label>
                                                </div>
                                                <div class="invalid-feedback" v-for="error in form.errors.dniconyugue" :key="error">
                                                    {{ error }}
                                                </div>
                                                <button class="btn btn-secondary" type="button" @click="realizarAccion" @click.prevent="buscarPersonaConyugue(form.dniconyugue)">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                </button>
                                            </div>
                                            <div v-if="datosConyugue.ape_pat==''">
                                                <button class="btn btn-falcon-info me-1 mb-1" type="button" @click.prevent="nuevoPersona('Conyugue')">Registrar Nuevo</button>
                                            </div>
                                            <div v-else>
                                                <div class="alert alert-success border-0 d-flex align-items-center p-2" role="alert">
                                                    <div class="bg-success me-3 icon-item" style="height: 1.5rem; width: 1.5rem;"><span class="fas fa-check-circle text-white fs-1"></span></div>
                                                    <p class="mb-0 flex-1 small">
                                                        {{ datosConyugue.ape_pat + ' ' + datosConyugue.ape_mat + ', ' + datosConyugue.primernombre + ' ' + datosConyugue.otrosnombres}}
                                                    </p>
                                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="mb-3 has-validation">
                                            <label for="foto" class="form-label">Foto</label>
                                            <input class="form-control" type="file" accept="image/*" @change="cambiarFoto">
                                            <div class="card">
                                                <img id="inputImagen" :src="form.foto" class="img-fluid img-thumbnail" @error="imagenNoEncontrada">
                                            </div>
                                            <small class="text-danger" v-for="error in form.errors.foto" :key="error">{{ error }}<br></small>
                                        </div>   
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted">Actividades</h6>
                                        <div class="mb-3 has-validation">
                                            <div class="form-floating is-invalid">
                                                <input type="text" class="form-control form-control-sm" v-model="form.ruc" 
                                                maxlength="11" placeholder="00000000" @keypress="onlyNumbers"
                                                :class="{ 'is-invalid': form.errors.ruc }">
                                                <label for="ruc">RUC</label>
                                            </div>
                                            <div class="invalid-feedback" v-for="error in form.errors.ruc" :key="error">
                                                {{ error }}
                                            </div>
                                        </div>
                                        <div class="mb-3 has-validation">
                                            <div class="form-floating is-invalid">
                                                <select class="form-select" id="gradoinstruccion" aria-label="Floating" v-model="form.grado_instr" @change="activarProfesion">
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
                                        <div class="mb-3 has-validation" v-if="form.grado_instr=='Superior Completa'">
                                            <div class="form-floating is-invalid">
                                                <select class="form-select" id="profesion" aria-label="Floating" v-model="form.profesion">
                                                    <option selected disabled value="">Seleccione</option>
                                                    <option :value="profesion.nombre" v-for="profesion in profesiones" :key="profesion.id">{{ profesion.nombre }}</option>
                                                </select>
                                                <label for="profesion">Profesion</label>
                                            </div>
                                            <div class="invalid-feedback" v-for="error in form.errors.profesion" :key="error">
                                                {{ error }}
                                            </div>
                                        </div>
                                        <div class="mb-3 has-validation">
                                            <div class="form-floating is-invalid">
                                                <select class="form-select" id="usuario" aria-label="Floating" v-model="form.usuario_id">
                                                    <option selected disabled value="">Seleccione</option>
                                                    <option v-for="usuario in usuarios" :value="usuario.id" :key="usuario.id">{{ usuario.name }}</option>
                                                </select>
                                                <label for="usuario">Asesor</label>
                                            </div>
                                            <div class="invalid-feedback" v-for="error in form.errors.usuario_id" :key="error">
                                                {{ error }}
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group has-validation">
                                                <span class="input-group-text">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" @change="cambiarAval">
                                                </span>
                                                <div class="form-floating is-invalid">
                                                    <input type="text" class="form-control form-control-sm" :disabled="!aval" v-model="form.dniaval" 
                                                    maxlength="8" placeholder="00000000"
                                                    @keypress="onlyNumbers"
                                                    @change="buscarPersonaAval(form.dniaval)"
                                                    :class="{ 'is-invalid': form.errors.dniaval }">
                                                    <label for="dni">DNI AVAL</label>
                                                </div>
                                                <div class="invalid-feedback" v-for="error in form.errors.dniaval" :key="error">
                                                    {{ error }}
                                                </div>
                                                <button class="btn btn-secondary" type="button" @click="realizarAccion" :disabled="!aval" @click.prevent="buscarPersonaAval(form.dniaval)">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                </button>
                                            </div>
                                            <div v-if="aval">
                                                <div v-if="datosAval.ape_pat==''">
                                                    <button class="btn btn-falcon-info me-1 mb-1" type="button" @click.prevent="nuevoPersona('Aval')">Registrar Nuevo</button>
                                                </div>
                                                <div v-else>
                                                    <div class="alert alert-success border-0 d-flex align-items-center p-2" role="alert">
                                                        <div class="bg-success me-3 icon-item" style="height: 1.5rem; width: 1.5rem;"><span class="fas fa-check-circle text-white fs-1"></span></div>
                                                        <p class="small mb-0 flex-1">{{ datosAval.ape_pat + ' ' + datosAval.ape_mat + ', ' + datosAval.primernombre + ' ' + datosAval.otrosnombres}}</p><button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                                </div>                                                
                                            </div>
                                        </div>
                                        <div class="mb-3 has-validation">
                                            <div class="form-floating is-invalid">
                                                <select class="form-select" aria-label="Floating" v-model="form.tipo_trabajador">
                                                    <option selected disabled value="">Seleccione</option>
                                                    <option value="INDEPENDIENTE">INDEPENDIENTE</option>
                                                    <option value="DEPENDIENTE">DEPENDIENTE</option>
                                                </select>
                                                <label for="tipo_trabajador">Tipo de Trabajador</label>
                                            </div>
                                            <div class="invalid-feedback" v-for="error in form.errors.tipo_trabajador" :key="error">
                                                {{ error }}
                                            </div>
                                        </div>
                                        <div class="mb-3 has-validation" v-if="form.tipo_trabajador=='Dependiente'">
                                            <div class="form-floating is-invalid">
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
                                        <div class="mb-3 has-validation" v-if="form.tipo_trabajador=='Dependiente'">
                                            <div class="form-floating is-invalid">
                                                <input type="text" class="form-control form-control-sm" v-model="form.institucion_lab" 
                                                placeholder="000000000"
                                                :class="{ 'is-invalid': form.errors.institucion_lab }">
                                                <label for="institucion_lab">Institucion donde Labora</label>
                                            </div>
                                            <div class="invalid-feedback" v-for="error in form.errors.institucion_lab" :key="error">
                                                {{ error }}
                                            </div>
                                        </div>                                  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Domicilio</h6>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-4 has-validation">
                                            <div class="form-floating is-invalid">
                                                <select class="form-select" aria-label="Floating" v-model="form.tipodomicilio">
                                                    <option selected disabled value="">Seleccione</option>
                                                    <option value="Independiente">Independiente</option>
                                                    <option value="Dependiente">Dependiente</option>
                                                </select>
                                                <label for="tipodomicilio">Tipo De Domicilio</label>
                                            </div>
                                            <div class="invalid-feedback" v-for="error in form.errors.tipodomicilio" :key="error">
                                                {{ error }}
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group has-validation input-group-sm pb-1">
                                                <button class="btn btn-outline-secondary" title="Seleccionar" type="button" @click="buscarUbigeo">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                                <div class="form-floating is-invalid">
                                                    <input type="text" class="form-control form-control-sm" v-model="form.ubigeodomicilio"
                                                    @keypress="onlyNumbers" placeholder="090101"
                                                    @change="buscarPorUbigeo"
                                                    >
                                                    <label for="floatingInputGroup1">UBIGEO</label>
                                                </div>
                                                <span class="input-group-text">{{ regUbigeo2.distrito }} - {{ regUbigeo2.provincia }} - {{ regUbigeo2.departamento }}</span>
                                                <div class="invalid-feedback" v-for="error in form.errors.ubigeodomicilio" :key="error">
                                                    {{ error }}
                                                </div>                                    
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 has-validation">
                                    <div class="form-floating is-invalid">
                                        <select class="form-select" v-model="form.tipovia" required>
                                            <option selected disabled value="">Seleccione</option>
                                            <option value="Av.">Av.</option>
                                            <option value="Jr.">Jr.</option>
                                            <option value="Psj">Pasaje</option>
                                            <option value="Call.">Calle</option>
                                            <option value="Prol.">Prolongacion</option>
                                            <option value="Carr.">Carretera</option>
                                            <option value="Alam.">Alameda</option>
                                        </select>
                                        <label for="tipovia">Tipo de Vía</label>
                                    </div> 
                                </div>
                                <div class="mb-3 has-validation">
                                    <div class="form-floating is-invalid">
                                        <input type="text" class="form-control" v-model="form.nombre_via" placeholder="Nombre de la Vía">
                                        <label for="nombre_via">Nombre de la Vía</label>
                                    </div>
                                </div>
                                <div class="mb-3 has-validation d-flex gap-2">
                                    <div class="form-floating is-invalid">
                                        <input type="text" class="form-control" v-model="form.nro" placeholder="Nro">
                                        <label for="nro">Nro</label>
                                    </div>
                                    <div class="form-floating is-invalid">
                                        <input type="text" class="form-control" v-model="form.interior" placeholder="Interior">
                                        <label for="interior">Interior</label>
                                    </div>
                                    <div class="form-floating is-invalid">
                                        <input type="text" class="form-control" v-model="form.mz" placeholder="Nro">
                                        <label for="Mz">Manzana</label>
                                    </div>
                                    <div class="form-floating is-invalid">
                                        <input type="text" class="form-control" v-model="form.lote" placeholder="Interior">
                                        <label for="lote">Lote</label>
                                    </div>                        
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-4 has-validation">
                                            <div class="form-floating is-invalid">
                                                <select class="form-select" v-model="form.tipozona" required>
                                                    <option selected disabled value="">Seleccione</option>
                                                    <option value="Urb">Urb</option>
                                                    <option value="A.H.">A.H.</option>
                                                    <option value="Cooperativa">Cooperativa</option>
                                                    <option value="PP.JJ.">PP.JJ.</option>
                                                    <option value="Otro">Otro</option>
                                                </select>
                                                <label for="zona">Tipo de Zona</label>
                                            </div>                                                
                                        </div>
                                        <div class="col-md-8 has-validation">
                                            <div class="form-floating is-invalid">
                                                <input type="text" class="form-control" v-model="form.nombre_zona" placeholder="Nombre de la Zona">
                                                <label for="nombre_zona">Nombre de la Zona</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-8 has-validation">
                                            <div class="form-floating is-invalid">
                                                <input type="text" class="form-control" v-model="form.referencia" placeholder="Referencia">
                                                <label for="referencia">Referencia</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 has-validation">
                                            <div class="form-floating is-invalid">
                                                <input type="text" class="form-control" v-model="form.latitud_longitud" placeholder="-9.930238, -76.243637">
                                                <label for="referencia">Latitud Longitud</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 text-center">
                                    <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d1389.472705542119!2d-76.24521300428613!3d-9.932101491122813!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2spe!4v1738981027678!5m2!1ses-419!2spe" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> -->
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
    <PersonaForm :form="datosPersona" :profesiones="profesiones" @activarDni="activarPersonaRelacionado"></PersonaForm>
    <UbigeoForm :form="form" :regUbigeo2="regUbigeo2"></UbigeoForm>
</template>