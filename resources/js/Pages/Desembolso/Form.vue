<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useUsuario from '@/Composables/Usuario.js';
import useDesembolso from '@/Composables/Desembolso.js';
import DescuentosForm from './FormDescuentos.vue' 
import CalendarioForm from './FormCalendarioPagos.vue' 
import useHelper from '@/Helpers';  
const { hideModal, openModal, Toast, Swal } = useHelper();
const props = defineProps({
    form: Object,
    currentPage : Number,
    descuentos: Object,
});
const { form, currentPage, descuentos } = toRefs(props)
const  emit  =defineEmits(['onListar', 'observar', 'obtenerDatos'])
const {
    obtenerUsuario, usuario
} = useUsuario();

const {
    cancelarCredito, errors, respuesta, agregarDesembolso
} = useDesembolso();


const cancelar=async(registro)=>{
    let formData = new FormData();
    formData.append('credito_id_principal', form.value.credito_id);
    formData.append('credito_id', registro.id);
    formData.append('fecha', form.value.fecha);
    formData.append('hora', form.value.hora);
    formData.append('user_id', form.value?.usuario_id || ''); // Verifica si existe
    formData.append('montopagado', String(registro.Saldo)); // Asegura conversión a string
    formData.append('mediopago', 'Efectivo');
    formData.append('tipo_cancelar', 'RCS');
    formData.append('agencia_id', form.value.agencia_id);
    formData.append('apenom', form.value.apenom);
    formData.append('montoseguro', descuentos.value.montoseguro);
    await cancelarCredito(formData)
    if (errors.value) {
        console.log(errors.value);
    }
    if (respuesta.value.ok == 1) {
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: respuesta.value.mensaje,
            showConfirmButton: false,
            timer: 1500
        });
        actualizarTipoSolicitud()
    } 
}
const actualizarTipoSolicitud = () => {
    emit('obtenerDatos', form.value.credito_id)
}
const registrarDesembolso = async() => {
    let formData = new FormData();
    formData.append('credito_id', form.value.credito_id);
    formData.append('fecha', form.value.fecha);
    formData.append('hora', form.value.hora);
    formData.append('user_id', form.value?.usuario_id); // Verifica si existe
    formData.append('descontado', form.value.descontado);
    formData.append('totalentregado', form.value.totalentregar);
    formData.append('rcsdebe', form.value.rcsdebe);
    formData.append('agencia_id', form.value.agencia_id);
    formData.append('apenom', form.value.apenom);
    formData.append('montoseguro', descuentos.value.montoseguro);
    formData.append('total', form.value.total);
    formData.append('plazo', form.value.plazo);
    formData.append('frecuencia', form.value.frecuencia);
    await agregarDesembolso(formData)

    form.value.errors = []
    if(errors.value)
    {
        form.value.errors = errors.value
    }
    if (respuesta.value.ok == 1) {
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: respuesta.value.mensaje,
            showConfirmButton: false,
            timer: 1500
        });
        hideModal('#modaldesembolso');
        emit('onListar', currentPage.value)
        verCalendarioPagos(form.value.credito_id);
    } 
}
const verCalendarioPagos = (id) => {
    openModal('#modalcalendariopagos')
    document.getElementById("modalcalendariopagosLabel").innerHTML = 'Calendario de Pagos';
}
const guardar = () =>{
    Swal.fire({
        title: 'Desembolsar',
        text: `¿Está seguro de desembolsar el crédito ${form.value.credito_id}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, desembolsar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            registrarDesembolso()
        }
    })
}
const imagenNoEncontrada = (event)=>{
    event.target.src = "/storage/fotos/default.png";
}
const verAsesor = async(id) => {
    await obtenerUsuario(id)
    Swal.fire({
        title: "Asesor",
        text: `${usuario.value.persona.apenom}`,
        imageUrl: form.value.foto,
        imageWidth: 220,
        imageHeight: 320,
        imageAlt: `${usuario.value.name}`,
        didOpen: () => {
            const img = Swal.getImage();
            img.onerror = () => {
                img.src = "/storage/fotos/default.png"; // Imagen por defecto si no se encuentra la original
            };
        }
    });
}
const Observar = () => {
    hideModal('#modaldesembolso');
    emit('observar', form.value.credito_id)
}

const verDescuentos = async()=>{
    openModal('#modaldescuentos')
    document.getElementById("modaldescuentosLabel").innerHTML = 'Descuentos';
}

onMounted(() => {
    
})
</script>
<template>
    <form @submit.prevent="guardar">
    <div class="modal fade" id="modaldesembolso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-1" id="modaldesembolsoLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <small>CLIENTE : </small>{{ form.apenom }}
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="card">
                                            <img id="inputImagen" :src="form.foto" class="img-fluid img-thumbnail" @error="imagenNoEncontrada">
                                        </div>
                                        <small class="text-danger" v-for="error in form.errors.foto" :key="error">{{ error }}<br></small>
                                    </div>
                                    <div class="mb-3">
                                        <h4><small>DNI: </small>{{ form.dni }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card mb-2">
                                <div class="card-header">
                                    CREDITO ID : {{ form.credito_id }}
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating is-invalid">
                                                <input type="text" class="form-control form-control-sm" :value="form.producto"
                                                placeholder="Producto" readonly>
                                                <label for="floatingInputGroup1">Producto</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating is-invalid">
                                                <input type="text" class="form-control form-control-sm" :value="'S/.'+form.monto" 
                                                placeholder="Monto" readonly>
                                                <label for="floatingInputGroup1">Monto</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group has-validation input-group-sm pb-1">
                                                <div class="form-floating is-invalid">
                                                    <input type="number" class="form-control form-control-sm" step="0.5" min="1" :value="form.tasainteres" 
                                                    placeholder="Tasa Interés" readonly>
                                                    <label for="floatingInputGroup1">Tasa Interés</label>
                                                </div>
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating is-invalid">
                                                <input type="text" class="form-control form-control-sm" :value="'S/.'+form.total"
                                                placeholder="TOTAL" readonly>
                                                <label for="floatingInputGroup1">TOTAL</label>
                                            </div>                                    
                                        </div>                                        
                                        <div class="col">
                                            <div class="form-floating is-invalid">
                                                <input type="text" class="form-control form-control-sm" :value="form.plazo"
                                                placeholder="PLAZO" readonly>
                                                <label for="floatingInputGroup1">PLAZO</label>
                                            </div> 
                                        </div>
                                        <div class="col">
                                            <div class="form-floating is-invalid">
                                                <input type="text" class="form-control form-control-sm" :value="form.frecuencia"
                                                placeholder="FRECUENCIA" readonly>
                                                <label for="floatingInputGroup1">FRECUENCIA</label>
                                            </div> 
                                        </div>                                        
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating is-invalid">
                                                <input type="text" class="form-control form-control-sm" :value="form.tiposolicitud"
                                                placeholder="TIPO SOLICITUD" readonly>
                                                <label for="floatingInputGroup1">TIPO SOLICITUD</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating is-invalid">
                                                <input type="text" class="form-control form-control-sm" :value="form.medioorigen"
                                                placeholder="MEDIO ORIGEN" readonly>
                                                <label for="floatingInputGroup1">MEDIO ORIGEN</label>
                                            </div>                                    
                                        </div>                                
                                        <div class="col">
                                            <div class="input-group has-validation input-group-sm pb-1">
                                                <div class="form-floating is-invalid">
                                                    <input type="text" class="form-control form-control-sm" :value="form.asesor"
                                                    placeholder="ASESOR" readonly>
                                                    <label for="floatingInputGroup1">ASESOR</label>
                                                </div>
                                                <button title="Ver Asesor" @click="verAsesor(form.asesor_id)" class="btn btn-secondary"><i class="fa-solid fa-eye"></i></button>
                                            </div>
                                        </div>                    
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating is-invalid">
                                                <input type="text" class="form-control form-control-sm" :value="form.dondepagara"
                                                placeholder="DONDE PAGARA" readonly>
                                                <label for="floatingInputGroup1">DONDE PAGARA</label>
                                            </div>                              
                                        </div>
                                        <div class="col">
                                            <div class="form-floating is-invalid">
                                                <input type="text" class="form-control form-control-sm" :value="'S/.' + form.costomora"
                                                placeholder="COSTO MORA" readonly>
                                                <label for="floatingInputGroup1">COSTO MORA</label>
                                            </div>                                             
                                        </div>
                                        <div class="col">
                                            <div v-if="form.vigentes.length>0" class="input-group has-validation input-group-sm pb-1">
                                                <div class="form-floating is-invalid">
                                                    <input type="text" class="form-control form-control-sm" :value="form.vigentes.length"
                                                    placeholder="Creditos Vigentes" readonly>
                                                    <label for="floatingInputGroup1">Creditos Vigentes</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header"></div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <div class="input-group has-validation">
                                                        <span class="input-group-text">S/.</span>
                                                        <div class="form-floating is-invalid">
                                                            <input type="text" class="form-control form-control-sm"
                                                            :class="descuentos.estado=='debe' ? 'is-invalid' : ''"
                                                            :value="form.descontado.toFixed(2)"
                                                            placeholder="DESCUENTO" readonly>
                                                            <label for="floatingInputGroup1">DESCUENTO</label>
                                                        </div>
                                                        <button type="button" title="Ver Descuentos" @click="verDescuentos()" class="btn btn-secondary"><i class="fa-solid fa-eye"></i></button>                                                             
                                                        <div class="invalid-feedback" v-for="error in form.errors.rcsdebe" :key="error">
                                                            {{ error }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group">
                                                        <span class="input-group-text">S/.</span>
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control form-control-sm"
                                                            :class="(form.totalentregar)<=1 ? 'is-invalid' : ''"
                                                            :value="(form.totalentregar).toFixed(2)"
                                                            placeholder="TOTAL ENTREGAR" readonly>
                                                            <label for="floatingInputGroup1">TOTAL ENTREGAR</label>
                                                        </div>   
                                                    </div>
                                                </div>                    


                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" v-if="form.vigentes.length>0">
                        <div class="card-header">Creditos Vigentes del Cliente</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm small table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>FECHA</th>
                                            <th>MONTO</th>
                                            <th>PLAZO</th>
                                            <th>TIPO</th>
                                            <th>ESTADO</th>
                                            <th>SALDO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="vigente in form.vigentes" :key="vigente.id">
                                            <td>{{ vigente.id }}</td>
                                            <td>{{ vigente.fecha_reg }}</td>
                                            <td>{{ vigente.monto }}</td>
                                            <td>{{ vigente.plazo }}</td>
                                            <td>{{ vigente.tipo }}</td>
                                            <td>{{ vigente.estado }}</td>
                                            <td>{{ vigente.Saldo }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Desembolsar</button>
                    <button type="button" class="btn btn-warning" @click="Observar">Observar</button>
                </div>
            </div>
        </div>
    </div>
    </form>
    <DescuentosForm :form="descuentos" @cancelar="cancelar"></DescuentosForm>
    <CalendarioForm></CalendarioForm>
</template>