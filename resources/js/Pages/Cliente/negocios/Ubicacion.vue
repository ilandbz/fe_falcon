<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useCliente from '@/Composables/Cliente.js';
import useHelper from '@/Helpers';  
import useUbigeo from '@/Composables/Ubigeo.js';
import UbigeoFormNegocio from '@/Components/UbigeoForm.vue'
import { onlyNumbers } from '@/Helpers'
const { hideModal, Toast, openModal } = useHelper();
const props = defineProps({
    formNegocio: Object,
});
const { formNegocio } = toRefs(props)


const {
    errors, respuesta, agregarUbicacion, registro, obtenerUbigeo
} = useUbigeo();
const regUbigeo = ref({
    distrito : 'Dist.',
    provincia : 'Prov.',
    departamento : 'Depart.',
});
const form=ref({
    id:'',
    tipo:'',
    ubigeo: '',
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
    form.value.id = '';
    form.value.tipo = '';
    form.value.tipovia = '';
    form.value.nombrevia = '';
    form.value.ubigeo = '';
    form.value.nro = '';
    form.value.interior = '';
    form.value.mz = '';
    form.value.lote = '';
    form.value.tipozona = '';
    form.value.nombrezona = '';
    form.value.referencia = '';
    form.value.latitud_longitud = '';
    form.value.errors = [];
    errors.value = [];
};
const registrar = async() => {
    await agregarUbicacion(form.value)
    form.value.errors = []
    if(errors.value)
    {
        form.value.errors = errors.value
    }
    if(respuesta.value.ok==1){
        form.value.errors = []
        hideModal('#modalUbicacionForm')
        Toast.fire({icon:'success', title:respuesta.value.mensaje})
        formNegocio.value.ubicacion_id = respuesta.value.id
        formNegocio.value.direccion = respuesta.value.direccion
    }
}
const guardar = () => {
    registrar()
}

const buscarPorUbigeo = async (ubigeo, reg) => {
    await obtenerUbigeo(ubigeo);
    if (registro.value) {
        reg.distrito = registro.value.nombre || '';
        reg.provincia = registro.value.provincia?.nombre || '';
        reg.departamento = registro.value.provincia?.departamento?.nombre || '';
    } else {
        reg.distrito = '';
        reg.provincia = '';
        reg.departamento = '';
    }
};

const ubigeoSeleccionado = (ubigeo) =>{
    buscarPorUbigeo(ubigeo, regUbigeo.value)
    form.value.ubigeo = ubigeo
}
const buscarUbigeo = ()=>{
    document.getElementById("modalUbigeoLabel").innerHTML = 'Buscar Ubigeo';
    openModal('#modalUbigeo')
}

</script>
<template>
    <form @submit.prevent="guardar">
        <div class="modal fade" id="modalUbicacionForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="modalUbicacionFormLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-1" id="modalUbicacionFormLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Domicilio</h6>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-4 has-validation">
                                            <div class="form-floating is-invalid">
                                                <select class="form-select" aria-label="Floating" v-model="form.tipo">
                                                    <option selected disabled value="">Seleccione</option>
                                                    <option value="Familiar">Familiar</option>
                                                    <option value="Propia">Propia</option>
                                                    <option value="Alquilada">Alquilada</option>
                                                </select>
                                                <label for="tipo">Tipo</label>
                                            </div>
                                            <div class="invalid-feedback" v-for="error in form.errors.tipo" :key="error">
                                                {{ error }}
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group has-validation input-group-sm pb-1">
                                                <button class="btn btn-outline-secondary" title="Seleccionar" type="button" @click="buscarUbigeo">
                                                    <i class="fas fa-search"></i>
                                                </button>
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
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d1389.472705542119!2d-76.24521300428613!3d-9.932101491122813!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2spe!4v1738981027678!5m2!1ses-419!2spe" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
    <UbigeoFormNegocio @seleccionar="ubigeoSeleccionado"></UbigeoFormNegocio>
</template>