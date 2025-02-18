<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useHelper from '@/Helpers';  
import { onlyNumbers } from '@/Helpers'
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
        <div class="modal fade" id="modaldetVentas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="modaldetVentasLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-1" id="modaldetVentasLabel">Registrar Crédito</h1>
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
                                <span class="input-group-text">S/.</span>
                                <div class="form-floating is-invalid">
                                    <input type="text" class="form-control form-control-sm" v-model="form.monto"
                                    @change="buscarCliente(form.dni_cliente)"
                                    @keyup.enter="buscarCliente(form.dni_cliente)" placeholder="Monto">
                                    <label for="monto">Monto</label>
                                </div>
                                <div class="invalid-feedback" v-for="error in form.errors.monto" :key="error">
                                    {{ error }}
                                </div>
                            </div>
                            <div class="input-group has-validation input-group-sm pb-1">
                                <div class="form-floating is-invalid">
                                    <select class="form-select" v-model="form.tipo" @change="cambiarFuente" :disabled="tiposCreditos.length==0">
                                        <option :value="registro" v-for="registro in tiposCreditos">{{ registro }}</option>
                                    </select>
                                    <label for="tipo">Tipo</label>
                                </div>
                                <div class="invalid-feedback" v-for="error in form.errors.tipo" :key="error">
                                    {{ error }}
                                </div>
                            </div>
                            <div class="input-group has-validation input-group-sm pb-1">
                                <div class="form-floating is-invalid">
                                    <select class="form-select" v-model="form.fuenterecursos" @change="cambiarFuente">
                                        <option value="PROPIO">FUENTE 1</option>
                                        <option value="RECAUDADO">FUENTE 2</option>
                                    </select>
                                    <label for="plazo">Fuente Recursos</label>
                                </div>
                                <div class="invalid-feedback" v-for="error in form.errors.fuenterecursos" :key="error">
                                    {{ error }}
                                </div>                                
                            </div>
                        </div>
                        <div class="mb-3 d-flex gap-3">
                            <div class="input-group has-validation input-group-sm pb-1">
                                <div class="form-floating is-invalid">
                                    <select class="form-select" v-model="form.producto" @change="cambiarProducto">
                                        <option v-if="form.fuenterecursos == 'PROPIO'" value="CAPITAL">Capital</option>
                                        <option v-if="form.fuenterecursos == 'PROPIO'" value="PRENDARIO">Prendario</option>
                                        <option v-if="form.fuenterecursos == 'PROPIO'" value="ACTIVO FIJO">Activo Fijo</option>
                                        <option v-if="form.fuenterecursos == 'PROPIO'" value="TRANSPORTE">Transporte</option>
                                        <option v-if="form.fuenterecursos == 'PROPIO'" value="CONSUMO">Consumo</option>
                                        <option v-if="form.fuenterecursos == 'PROPIO'" value="CREDI-6">Credi-6</option>
                                        <option v-if="form.fuenterecursos == 'PROPIO'" value="CREDI-INVERSION">CREDI-INVERSION</option>
                                        <option v-if="form.fuenterecursos == 'PROPIO'" value="CONFIO EN TI">CONFIO EN TI</option>
                                        <option v-if="form.fuenterecursos != 'PROPIO'" value="CREDI-INVERSION">Credi-inversion</option>
                                        <option v-if="form.fuenterecursos != 'PROPIO'" value="CREDI-6/CREDI-INVERSION">Credi-6/CREDI-INVERSION</option>
                                    </select>
                                    <label for="plazo">Producto</label>
                                </div>
                                <div class="invalid-feedback" v-for="error in form.errors.producto" :key="error">
                                    {{ error }}
                                </div>
                            </div>
                            <div class="input-group has-validation input-group-sm pb-1">
                                <div class="form-floating is-invalid">
                                    <select class="form-control input-sm" v-model="form.frecuencia" :disabled="activoFrecuencia==false">
                                        <option value="DIARIO">Diario</option>
                                        <option value="SEMANAL">Semanal</option>
                                        <option value="QUINCENAL">Quincenal</option>
                                        <option value="MENSUAL">Mensual</option>
                                    </select>
                                    <label for="frecuencia">Frecuencia</label>                             
                                </div>
                                <div class="invalid-feedback" v-for="error in form.errors.frecuencia" :key="error">
                                    {{ error }}
                                </div>
                            </div>
                            <div class="input-group has-validation input-group-sm pb-1">
                                <div class="form-floating is-invalid">
                                    <input type="number" class="form-control form-control-sm" v-model="form.plazo"
                                    placeholder="Monto"
                                    :disabled="activoPlazo==false">
                                    <label for="plazo">Plazo</label>
                                </div>
                                <span class="input-group-text">dias</span>
                                <div class="invalid-feedback" v-for="error in form.errors.dni_cliente" :key="error">
                                    {{ error }}
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 d-flex gap-3">
                            <div class="input-group has-validation input-group-sm pb-1">
                                <div class="form-floating is-invalid">
                                    <select class="form-select" id="usuario" aria-label="Floating" v-model="form.asesor_id">
                                        <option selected disabled value="">Seleccione</option>
                                        <option v-for="usuario in usuarios" :value="usuario.id" :key="usuario.id">{{ usuario.name }}</option>
                                    </select>
                                    <label for="usuario">Asesor</label>
                                </div>
                                <div class="invalid-feedback" v-for="error in form.errors.asesor_id" :key="error">
                                    {{ error }}
                                </div>
                            </div>
                            <div class="input-group has-validation input-group-sm pb-1">
                                <div class="form-floating is-invalid">
                                    <select v-model="form.medioorigen" class="form-control input-sm">
                                        <option value="Asesores de Negocio">Asesores de Negocio</option>
                                        <option value="Referidos">Referidos</option>
                                        <option value="Promocion de campo">Promocion de Campo</option>
                                    </select>
                                    <label for="medioorigen">Medio Origen</label>                             
                                </div>
                                <div class="invalid-feedback" v-for="error in form.errors.medioorigen" :key="error">
                                    {{ error }}
                                </div>
                            </div>
                            <div class="input-group has-validation input-group-sm pb-1">
                                <div class="form-floating is-invalid">
                                    <select v-model="form.dondepagara" class="form-control input-sm" required="">
                                        <option value="Campo">Campo</option>
                                        <option value="Oficina">Oficina</option>
                                    </select>
                                    <label for="dondepagara">Lugar de Cobranza</label>                             
                                </div>
                                <div class="invalid-feedback" v-for="error in form.errors.dondepagara" :key="error">
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
