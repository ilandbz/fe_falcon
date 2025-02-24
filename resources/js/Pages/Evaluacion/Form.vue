<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useCredito from '@/Composables/Credito.js';
import useHelper from '@/Helpers';  
const {
    pdfUrl, generarPdf
    } = useCredito();
const { hideModal, Toast, openModal, Swal } = useHelper();
const emit = defineEmits(['calcularTotal','activarDiv']);
const props = defineProps({
    form: Object,
    esActivodiv: Boolean
});

const { form } = toRefs(props);
const calcular = ()=>{
    const monto = parseFloat(form.value.monto) || 0;
    const tasaDecimal = parseFloat(form.value.tasainteres) / 100;
    form.value.monto=monto
    form.value.total = (monto * (1 + tasaDecimal)).toFixed(2);
}

const resetear = ()=>{
    emit('calcularTotal');
}
const data=ref({
    credito_id : '',
    tipo : '',
})
const verSolicitud=async()=>{
    emit('activarDiv');
    data.value.credito_id = form.value.credito_id;
    data.value.tipo = 'solicitud';
    await generarPdf(data.value);
}

const rechazar = async() => {
    Swal.fire({
        title: "Ingrese el motivo de rechazo\nID: " + form.value.credito_id,
        input: "text",
        inputAttributes: {
            autocapitalize: "off"
        },
        showCancelButton: true,
        confirmButtonText: "Enviar",
        cancelButtonText: "Cancelar",
        showLoaderOnConfirm: true,
        preConfirm: (motivo) => {
            if (!motivo) {
                Swal.showValidationMessage("Debe ingresar un motivo para rechazar el crédito.");
            } else {
                return motivo; // Retorna el motivo si es válido
            }
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí puedes enviar el motivo a tu backend o procesarlo
            console.log("Motivo de rechazo:", result.value);
            Swal.fire({
                icon: "success",
                title: "Rechazo registrado",
                text: `Motivo: ${result.value}`
            });
        }
    });
    hideModal('#modalevaluacion')
};


</script>

<template>
        <div class="modal fade" id="modalevaluacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="modalevaluacionLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-1" id="modalevaluacionLabel">Registrar Crédito</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="input-group has-validation input-group-sm pb-1">
                                <div class="form-floating is-invalid">
                                    <input type="text" class="form-control form-control-sm" :value="form.dni"
                                    placeholder="DNI Cliente" readonly>
                                    <label for="floatingInputGroup1">DNI Cliente</label>
                                </div>
                                <span class="input-group-text">{{ form.apenom }}</span>
                                <div class="invalid-feedback" v-for="error in form.errors.dni" :key="error">
                                    {{ error }}
                                </div>                                                                 
                            </div>  
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-floating is-invalid">
                                    <input type="text" class="form-control form-control-sm" :value="form.producto"
                                    placeholder="Producto" readonly>
                                    <label for="floatingInputGroup1">Producto</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group has-validation input-group-sm pb-1">
                                    <div class="form-floating is-invalid">
                                        <input type="number" class="form-control form-control-sm border-primary" step="0.5" min="1" v-model="form.tasainteres" 
                                        placeholder="Tasa Interés" @change="calcular()">
                                        <label for="floatingInputGroup1">Tasa Interés</label>
                                    </div>
                                    <span class="input-group-text border-primary">%</span>
                                    <button class="btn btn-outline-primary" title="Resetear" type="button" @click="resetear()">
                                        <i class="fa-solid fa-arrows-rotate"></i>
                                    </button>
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
                        <div class="mb-3">
                            <div class="row">
                                <div class="col">
                                    <div class="input-group has-validation input-group-sm pb-1">
                                        <div class="form-floating is-invalid">
                                            <input type="text" class="form-control form-control-sm" :value="form.credito_id"
                                            placeholder="ID SOLICITUD" readonly>
                                            <label for="floatingInputGroup1">ID SOLICITUD</label>
                                        </div>
                                        <button class="btn btn-outline-secondary" title="Ver Solicitud" type="button" @click="verSolicitud()">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
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
                                        <input type="text" class="form-control form-control-sm" :value="form.medioorigen"
                                        placeholder="MEDIO ORIGEN" readonly>
                                        <label for="floatingInputGroup1">MEDIO ORIGEN</label>
                                    </div>                                    
                                </div>                                
                            </div>
                        </div>
                        <div class="card border-info" v-if="esActivodiv">
                            <div class="card-header bg-info text-white">PRE VISUALIZACION</div>
                            <div class="card-body">
                                <iframe v-if="pdfUrl" :src="pdfUrl" width="100%" height="500px"></iframe>
                                <p v-else>Seleccione un documento para visualizar.</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-warning" title="Observar" @click.prevent="observar(credito.id)"><i class="fas fa-exclamation-circle"></i> Observar</button>
                        <button type="button" class="btn btn-danger" @click="rechazar()"><i class="fas fa-thumbs-down"></i> Rechazar</button>
                        <button type="button" class="btn btn-success"><i class="fas fa-thumbs-up"></i> Aprobar</button>
                    </div>
                </div>
            </div>
        </div>


</template>
