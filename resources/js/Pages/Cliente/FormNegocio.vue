<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useCliente from '@/Composables/Cliente.js';
import useHelper from '@/Helpers';  
import ClientesSearch from '@/Components/ClientesSearch.vue'
import useUsuario from '@/Composables/Usuario.js';
import useNegocio from '@/Composables/Negocio.js';
import useEntidad from '@/Composables/Entidad.js';
import useTipoActividad from '@/Composables/TipoActividad.js';
import { onlyNumbers } from '@/Helpers'
const { hideModal, Toast, openModal, Swal } = useHelper();

const props = defineProps({
    form: Object,
    currentPage: Number,
});
const negociosPosee = ref([]);
const { form, currentPage } = toRefs(props);
const {
    usuarios, obtenerUsuariosTipoAgencia
} = useUsuario();

const {
    buscarEntidad, entidad
} = useEntidad();

const {
    negocios, listaNegociosPorCliente
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
    await agregarCredito(form.value);
    form.value.errors = [];
    if (errors.value) {
        form.value.errors = errors.value;
    }
    if (respuesta.value.ok == 1) {
        form.value.errors = [];
        hideModal('#modalcredito');
        Toast.fire({ icon: 'success', title: respuesta.value.mensaje });
        Swal.fire({
            title: "<strong>CREDITO</strong>",
            icon: "info",
            html: `¿DESEA REALIZAR LA EVALUACION?`,
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: `<i class="fa fa-thumbs-up"></i> SI!`,
            confirmButtonAriaLabel: "SI!",
            cancelButtonText: `<i class="fa fa-thumbs-down"></i> NO!`,
            cancelButtonAriaLabel: "NO!"
        }).then((result) => {
            if (result.isConfirmed) {
                
                emit('evaluar', respuesta.value.credito_id);
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                console.log("Usuario canceló la evaluación.");
            }
        });
        emit('onListar', currentPage.value);
    }
};
const buscarCliente = async(dni) =>{
    vigentes.value=[]
    form.value.dni_cliente=dni
    await obtenerClientePorDni(dni)
    //await listaNegociosPorCliente()
    form.value.apenom = cliente.value.persona.apenom

    form.value.cliente_id=cliente.value.id
    vigentes.value = cliente.value.creditos
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
        <div class="modal fade" id="modalNegocio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-1" id="modalNegocioLabel">Registrar Crédito</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
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
                        <div class="mb-3 d-flex gap-3">
                            <div class="input-group has-validation input-group-sm pb-1">
                                <div class="form-floating is-invalid">
                                    <input type="text" class="form-control form-control-sm" v-model="form.ruc" @keypress="onlyNumbers" placeholder="RUC" @change="busarRuc(form.ruc)">
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
                                    <input type="text" class="form-control form-control-sm" v-model="form.tel_cel" @keypress="onlyNumbers" placeholder="Telefono">
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
                                             
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <ClientesSearch @cargarPersona="buscarCliente"></ClientesSearch>

</template>
