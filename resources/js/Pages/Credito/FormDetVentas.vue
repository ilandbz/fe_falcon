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
        <div class="modal fade" id="modaldetVentas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="modaldetVentasLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-1" id="modaldetVentasLabel">Registrar Crédito</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-condensed small" id="perdidasganancias">
                                <tr>
                                    <th width="40%"></th>
                                    <td>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" value="SI" checked="true" disabled>&nbsp;&nbsp;&nbsp;Ingresa
                                        </label>
                                        <div class="text-primary">PRODUCTO 1</div>				
                                    </td>
                                    <td>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" value="SI" name="aproducto2">&nbsp;&nbsp;&nbsp;Ingresa
                                        </label>
                                        <div class="text-primary">PRODUCTO 2</div>
                                    </td>
                                    <td>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" value="SI" name="aproducto3">&nbsp;&nbsp;&nbsp;Ingresa
                                        </label>
                                        <div class="text-primary">PRODUCTO 3</div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>DESCRIPCIÓN DEL PRODUCTO</th>
                                    <td><input type="text" class="form-control form-control-sm producto1" name="descproducto1" placeholder="Descripción"></td>
                                    <td><input type="text" class="form-control form-control-sm producto2" name="descproducto2" placeholder="Descripción" disabled></td>
                                    <td><input type="text" class="form-control form-control-sm producto3" name="descproducto3" placeholder="Descripción" disabled></td>
                                </tr>
                                <tr>
                                    <th>UNIDAD DE MEDIDA</th>
                                    <td>
                                        <select name="unidmedida1" id="unidmedida1" class="form-control form-control-sm producto1">
                                            <option value="Diario">Diario</option>
                                            <option value="Semanal">Semanal</option>
                                            <option value="Mensual">Mensual</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="unidmedida2" id="unidmedida2" class="form-control form-control-sm producto2" disabled>
                                            <option value="Diario">Diario</option>
                                            <option value="Semanal">Semanal</option>
                                            <option value="Mensual">Mensual</option>
                                        </select>								
                                    </td>
                                    <td>
                                        <select name="unidmedida3" id="unidmedida3" class="form-control form-control-sm producto3" disabled>
                                            <option value="Diario">Diario</option>
                                            <option value="Semanal">Semanal</option>
                                            <option value="Mensual">Mensual</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>PRECIO VENTA UNIT.</th>
                                    <td><input type="text" class="input-sm numerosypunto producto1" size="6" maxlength="10" name="precioventaunit1" value="0.00"></td>
                                    <td><input type="text" class="input-sm numerosypunto producto2" size="6" maxlength="10" name="precioventaunit2" value="0.00" disabled></td>
                                    <td><input type="text" class="input-sm numerosypunto producto3" size="6" maxlength="10" name="precioventaunit3" value="0.00" disabled></td>
                                </tr>
                                <tr>
                                    <th>MATERIA PRIMA PRINCIPAL</th>
                                    <td><input type="text" class="input-sm numerosypunto producto1 matprima1" size="6" maxlength="10" name="materiaprimapri1" value="0.00"></td>
                                    <td><input type="text" class="input-sm numerosypunto producto2 matprima2" size="6" maxlength="10" name="materiaprimapri2" value="0.00" disabled></td>
                                    <td><input type="text" class="input-sm numerosypunto producto3 matprima3" size="6" maxlength="10" name="materiaprimapri3" value="0.00" disabled></td>
                                </tr>
                                <tr>
                                    <th>MANO DE OBRA</th>
                                    <td><input type="text" class="input-sm numerosypunto producto1" size="6" maxlength="10" name="manoobra1" value="0.00" readonly></td>
                                    <td><input type="text" class="input-sm numerosypunto producto2" size="6" maxlength="10" name="manoobra2" value="0.00" readonly disabled></td>
                                    <td><input type="text" class="input-sm numerosypunto producto3" size="6" maxlength="10" name="manoobra3" value="0.00" readonly disabled></td>
                                </tr>
                                <tr>
                                    <th>PRODUCCIÓN MENSUAL POR PRODUCTO</th>
                                    <td><input type="text" class="input-sm numerosypunto producto1" size="6" maxlength="10" name="produccionmensprod1" value="26" readonly></td>
                                    <td><input type="text" class="input-sm numerosypunto producto2" size="6" maxlength="10" name="produccionmensprod2" value="26" readonly disabled></td>
                                    <td><input type="text" class="input-sm numerosypunto producto3" size="6" maxlength="10" name="produccionmensprod3" value="26" readonly disabled></td>
                                </tr>
                                <tr>
                                    <th>VENTAS TOTALES POR PRODUCTO</th>
                                    <td><input type="text" class="input-sm numerosypunto producto1" size="6" maxlength="10" name="ventastotprod1" value="0.00" readonly></td>
                                    <td><input type="text" class="input-sm numerosypunto producto2" size="6" maxlength="10" name="ventastotprod2" value="0.00" readonly disabled></td>
                                    <td><input type="text" class="input-sm numerosypunto producto3" size="6" maxlength="10" name="ventastotprod3" value="0.00" readonly disabled></td>
                                </tr>
                                <tr>
                                    <th>MARGEN DE VENTAS POR PRODUCTO</th>
                                    <td><input type="text" class="input-sm numerosypunto producto1" size="6" maxlength="10" name="margenventasprod1" value="0.00" readonly></td>
                                    <td><input type="text" class="input-sm numerosypunto producto2" size="6" maxlength="10" name="margenventasprod2" value="0.00" readonly disabled></td>
                                    <td><input type="text" class="input-sm numerosypunto producto3" size="6" maxlength="10" name="margenventasprod3" value="0.00" readonly disabled></td>
                                </tr>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                            <label for="" class="control-label">TOTAL INGRESO MENSUAL</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">S/.</span>
                                    </div>
                                    <input type="text" name="totingmensual" class="form-control" value="" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                            <label for="margtontal" class="control-label">MARGEN TOTAL</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">S/.</span>
                                    </div>
                                    <input type="text" name="margtontal" id="margtontal" class="form-control form-control-sm" value="" readonly>
                                </div>					
                            </div>			
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="totcostoprimo" class="control-label">TOTAL COSTO PRIMO MENSUAL</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">S/.</span>
                                    </div>
                                    <input type="text" name="totcostoprimo" id="totcostoprimo" class="form-control form-control-sm" value="" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                            <label for="" class="control-label">VENTAS AL CREDITO</label>						
                                <div class="input-group input-group-sm">
                                    <input type="text" name="ventcredito" class="form-control form-control-sm" value="">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon1">%</span>
                                    </div>						
                                </div>
                            </div>			
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="" class="control-label">COSTO PRIMO/VENTAS</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">S/.</span>
                                    </div>
                                    <input type="text" name="costoprimovent" class="form-control form-control-sm" value="" readonly>
                                </div>	
                            </div>
                            <div class="col-md-6">
                                <label for="" class="control-label">IRRECUPERABILIDAD</label>	
                                <div class="input-group input-group-sm">
                                    <input type="text" name="irrecuperabilidad" class="form-control form-control-sm" value="">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon1">%</span>
                                    </div>						
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
