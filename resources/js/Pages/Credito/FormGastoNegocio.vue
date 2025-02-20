<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useHelper from '@/Helpers';  

const { hideModal, Toast, openModal, Swal } = useHelper();

const props = defineProps({
    form: Object,
});

const { form } = toRefs(props);


const guardar = () => {
    
};

onMounted(() => {

});
</script>

<template>
    <form @submit.prevent="guardar">
        <div class="modal fade" id="GastosNegocio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="GastosNegocioLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-1" id="GastosNegocioLabel">Registrar Crédito</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" class="form-horizontal">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="" class="control-label">Alquiler</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/.</span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="0.00" v-model="form.alquiler">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="control-label col-md-6">Servicios</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/.</span>
                                        </div>	
                                        <input type="text" class="form-control" onclick="selecciona_value(this)" placeholder="0.00" v-model="form.servicios">
                                    </div>
                                </div>				
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="" class="control-label">Personal</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/.</span>
                                        </div>		
                                        <input type="text" class="form-control" name="personalpg" onclick="selecciona_value(this)" placeholder="0.00" v-model="form.personal">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="control-label">Sunat</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/.</span>
                                        </div>			
                                        <input type="text" class="form-control" name="sunatpg" onclick="selecciona_value(this)" placeholder="0.00" v-model="form.sunat">
                                    </div>
                                </div>				
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="" class="control-label">Transporte</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/.</span>
                                        </div>			
                                        <input type="text" class="form-control" name="transportepg" onclick="selecciona_value(this)" placeholder="0.00" v-model="form.transporte">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="control-label">Gastos Financieros</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/.</span>
                                        </div>			
                                        <input type="text" class="form-control" name="gastosfinan" onclick="selecciona_value(this)" placeholder="0.00" v-model="form.gastosfinancieros">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="" class="control-label">Otros</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/.</span>
                                        </div>		
                                        <input type="text" class="form-control" name="otrospg" onclick="selecciona_value(this)" placeholder="0.00" v-model="form.otros">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="control-label">Total</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">S/.</span>
                                        </div>		
                                        <input type="text" class="form-control" name="otrospg" onclick="selecciona_value(this)" placeholder="0.00" v-model="form.total" readonly>
                                    </div>
                                </div>
                            </div>
                        </form>
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
