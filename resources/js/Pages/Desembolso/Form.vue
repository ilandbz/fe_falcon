<script setup>
import { toRefs, onMounted } from 'vue';
import useAgencia from '@/Composables/Agencia.js';
import useUsuario from '@/Composables/Usuario.js';
import useHelper from '@/Helpers';  
const { hideModal, Toast, Swal } = useHelper();
const props = defineProps({
    form: Object,
    currentPage : Number
});
const { form, currentPage } = toRefs(props)
const {
    errors, respuesta, agregarAgencia, actualizarAgencia, listaAgencias, agencias
} = useAgencia();
const {
    obtenerUsuario, usuario
} = useUsuario();

const  emit  =defineEmits(['onListar', 'observar'])
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
                                    CREDITO
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="input-group has-validation input-group-sm pb-1">
                                                <div class="form-floating is-invalid">
                                                    <input type="text" class="form-control form-control-sm" :value="form.credito_id"
                                                    placeholder="ID SOLICITUD" readonly>
                                                    <label for="floatingInputGroup1">ID SOLICITUD</label>
                                                </div>
                                            </div>
                                        </div>
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
                                    </div>
                                    <div class="row mb-3">
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
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating is-invalid">
                                                <input type="text" class="form-control form-control-sm" :value="form.frecuencia"
                                                placeholder="FRECUENCIA" readonly>
                                                <label for="floatingInputGroup1">FRECUENCIA</label>
                                            </div> 
                                        </div>                                        
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
                                    </div>
                                    <div class="row mb-3">
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
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div v-if="form.vigentes.length>0" class="input-group has-validation input-group-sm pb-1">
                                                <div class="form-floating is-invalid">
                                                    <input type="text" class="form-control form-control-sm" :value="form.vigentes.length"
                                                    placeholder="Creditos Vigentes" readonly>
                                                    <label for="floatingInputGroup1">Creditos Vigentes</label>
                                                </div>
                                                <!-- <button title="Ver Creditos Vigentes" @click="verSolicitudes" class="btn btn-secondary"><i class="fa-solid fa-eye"></i></button> -->
                                            </div>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" v-if="form.vigentes.length>0">
                                <div class="card-header">Creditos Vigentes</div>
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
                                                    <th>Accion</th>
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
                                                    <td><button type="button" class="btn btn-sm btn-success" title="Cancelar Credito"><i class="fa-solid fa-money-bill"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
</template>