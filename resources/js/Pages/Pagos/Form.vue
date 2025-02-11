<script setup>
import { toRefs, onMounted } from 'vue';
import useCredito from '@/Composables/Credito.js';
import useHelper from '@/Helpers';  
const { hideModal, Toast } = useHelper();

const props = defineProps({
    form: Object,
    currentPage: Number
});
const { form, currentPage } = toRefs(props);

const {
    errors, respuesta, agregarCredito, actualizarCredito, listaCreditos
} = useCredito();

const emit = defineEmits(['onListar']);

const crud = {
    'nuevo': async () => {
        await agregarCredito(form.value);
        form.value.errors = [];
        if (errors.value) {
            form.value.errors = errors.value;
        }
        if (respuesta.value.ok == 1) {
            form.value.errors = [];
            hideModal('#modalcredito');
            Toast.fire({ icon: 'success', title: respuesta.value.mensaje });
            emit('onListar', currentPage.value);
        }
    },
    'editar': async () => {
        await actualizarCredito(form.value);
        form.value.errors = [];
        if (errors.value) {
            form.value.errors = errors.value;
        }
        if (respuesta.value.ok == 1) {
            form.value.errors = [];
            hideModal('#modalcredito');
            Toast.fire({ icon: 'success', title: respuesta.value.mensaje });
            emit('onListar', currentPage.value);
        }
    }
};

const guardar = () => {
    crud[form.value.estadoCrud]();
};

onMounted(() => {
    listaCreditos();
});
</script>

<template>
    <form @submit.prevent="guardar">
        <div class="modal fade" id="modalcredito" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="modalcreditoLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalcreditoLabel">Registrar Crédito</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="cliente" class="form-label">Cliente</label>
                            <input type="text" class="form-control" v-model="form.cliente_id"
                                :class="{ 'is-invalid': form.errors.cliente_id }" placeholder="ID Cliente">
                            <small class="text-danger" v-for="error in form.errors.cliente_id" :key="error">{{ error }}</small>
                        </div>
                        <div class="mb-3">
                            <label for="monto" class="form-label">Monto</label>
                            <input type="number" class="form-control" v-model="form.monto"
                                :class="{ 'is-invalid': form.errors.monto }" placeholder="Monto del Crédito">
                            <small class="text-danger" v-for="error in form.errors.monto" :key="error">{{ error }}</small>
                        </div>
                        <div class="mb-3">
                            <label for="plazo" class="form-label">Plazo</label>
                            <input type="number" class="form-control" v-model="form.plazo"
                                :class="{ 'is-invalid': form.errors.plazo }" placeholder="Plazo en meses">
                            <small class="text-danger" v-for="error in form.errors.plazo" :key="error">{{ error }}</small>
                        </div>
                        <div class="mb-3">
                            <label for="tasainteres" class="form-label">Tasa de Interés (%)</label>
                            <input type="number" step="0.01" class="form-control" v-model="form.tasainteres"
                                :class="{ 'is-invalid': form.errors.tasainteres }" placeholder="Tasa de Interés">
                            <small class="text-danger" v-for="error in form.errors.tasainteres" :key="error">{{ error }}</small>
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
