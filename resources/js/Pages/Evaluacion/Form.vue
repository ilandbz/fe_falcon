<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useCredito from '@/Composables/Credito.js';
import useHelper from '@/Helpers';  

const { hideModal, Toast, openModal, Swal } = useHelper();

const props = defineProps({
    form: Object,
});

const { form } = toRefs(props);

const {
    errors, respuesta, agregarCredito, actualizarCredito,
    listaTiposCreditos, tiposCreditos
} = useCredito();

const examinarClientes = ()=>{
    document.getElementById("modalClienteLabel").innerHTML = 'Buscar Cliente';
    openModal('#modalCliente')
}

const guardar = async() => {
    // await agregarCredito(form.value);
    // form.value.errors = [];
    // if (errors.value) {
    //     form.value.errors = errors.value;
    // }
    // if (respuesta.value.ok == 1) {
    //     form.value.errors = [];
    //     hideModal('#modalcredito');
    //     Toast.fire({ icon: 'success', title: respuesta.value.mensaje });
    //     Swal.fire({
    //         title: "<strong>CREDITO</strong>",
    //         icon: "info",
    //         html: `¿DESEA REALIZAR LA EVALUACION?`,
    //         showCloseButton: true,
    //         showCancelButton: true,
    //         focusConfirm: false,
    //         confirmButtonText: `<i class="fa fa-thumbs-up"></i> SI!`,
    //         confirmButtonAriaLabel: "SI!",
    //         cancelButtonText: `<i class="fa fa-thumbs-down"></i> NO!`,
    //         cancelButtonAriaLabel: "NO!"
    //     }).then((result) => {
    //         if (result.isConfirmed) {
                
    //             emit('evaluar', respuesta.value.credito_id);
    //         } else if (result.dismiss === Swal.DismissReason.cancel) {
    //             console.log("Usuario canceló la evaluación.");
    //         }
    //     });
    //     emit('onListar', currentPage.value);
    // }
};


onMounted(() => {

});
</script>

<template>
    <form @submit.prevent="guardar">
        <div class="modal fade" id="modalevaluacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="modalevaluacionLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-1" id="modalevaluacionLabel">Registrar Crédito</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="input-group has-validation input-group-sm pb-1">
                                <button class="btn btn-outline-secondary" title="Seleccionar" type="button" @click="examinarClientes">
                                    <i class="fas fa-search"></i>
                                </button>
                                <div class="form-floating is-invalid">
                                    <input type="text" class="form-control form-control-sm" v-model="form.dni" @keypress="onlyNumbers"
                                    placeholder="DNI Cliente">
                                    <label for="floatingInputGroup1">DNI Cliente</label>
                                </div>
                                <span class="input-group-text">{{ form.apenom }}</span>
                                <div class="invalid-feedback" v-for="error in form.errors.dni" :key="error">
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

</template>
