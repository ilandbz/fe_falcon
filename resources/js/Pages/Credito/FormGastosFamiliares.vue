<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useHelper from '@/Helpers';  

const { hideModal, Toast, openModal, Swal } = useHelper();

const props = defineProps({
    form: Object,
    currentPage: Number
});

const { form, currentPage } = toRefs(props);

const emit = defineEmits(['onListar', 'evaluar']);

const guardar = () => {
    
};

onMounted(() => {

});
</script>

<template>
    <form @submit.prevent="guardar">
        <div class="modal fade" id="GastosFamiliar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="GastosFamiliarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-1" id="GastosFamiliarLabel">Gastos Familiares</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <label for="" class="control-label col-md-6">Alimentacion</label>
                            <div class="col-md-6">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">S/.</span>
                                    </div>
                                    <input type="text" class="form-control" name="alimentac" onclick="selecciona_value(this)" placeholder="0.00" value="0.00">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label for="" class="control-label col-md-6">Alquileres</label>
                            <div class="col-md-6">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">S/.</span>
                                    </div>		
                                    <input type="text" class="form-control" name="alquil" onclick="selecciona_value(this)" placeholder="0.00" value="0.00">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label for="" class="control-label col-md-6">Educacion</label>
                            <div class="col-md-6">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">S/.</span>
                                    </div>			
                                    <input type="text" class="form-control" name="educac" onclick="selecciona_value(this)" placeholder="0.00" value="0.00">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label for="" class="control-label col-md-6">Servicios</label>
                            <div class="col-md-6">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">S/.</span>
                                    </div>			
                                    <input type="text" class="form-control" name="servic" onclick="selecciona_value(this)" placeholder="0.00" value="0.00">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label for="" class="control-label col-md-6">Transporte</label>
                            <div class="col-md-6">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">S/.</span>
                                    </div>			
                                    <input type="text" class="form-control" name="transport" onclick="selecciona_value(this)" placeholder="0.00" value="0.00">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label for="" class="control-label col-md-6">Salud</label>
                            <div class="col-md-6">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">S/.</span>
                                    </div>			
                                    <input type="text" class="form-control" name="salud" onclick="selecciona_value(this)" placeholder="0.00" value="0.00">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label for="" class="control-label col-md-6">Otros</label>
                            <div class="col-md-6">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">S/.</span>
                                    </div>		
                                    <input type="text" class="form-control" name="otros_gf" onclick="selecciona_value(this)" placeholder="0.00" value="0.00">
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
