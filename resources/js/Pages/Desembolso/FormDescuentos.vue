<script setup>
import { toRefs, onMounted, ref } from 'vue';
const props = defineProps({
    form: Object,
});
const { form } = toRefs(props)
</script>
<template>
    <div class="modal fade" id="modaldescuentos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-1" id="modaldescuentosLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating is-invalid">
                                <input type="text" class="form-control form-control-sm" title="Gasto Administrativo" :value="form.montoseguro"
                                placeholder="Gasto Administrativo" readonly>
                                <label for="floatingInputGroup1">Gasto Administrativo</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating is-invalid">
                                <input type="text" class="form-control form-control-sm" title="Saldo Credito" :value="'S/.'+form.saldototal" 
                                placeholder="Saldo Credito" readonly>
                                <label for="floatingInputGroup1">Saldo Credito</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col" v-if="form.montoconfioenti>0">
                            <div class="form-floating is-invalid">
                                <input type="text" class="form-control form-control-sm" title="Saldo Credito" :value="'S/.'+form.montoconfioenti" 
                                placeholder="Monto Confio en Ti" readonly>
                                <label for="floatingInputGroup1">Monto Confio en Ti</label>
                            </div>
                        </div>                        
                    </div>
                    <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped small">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="8" class="text-center">Creditos</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Cod</th>
                                        <th>Monto Solic</th>
                                        <th>Total</th>
                                        <th>Saldo</th>
                                        <th>Mora</th>
                                        <th>Estado</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="!form.detalles?.length">
                                        <td class="text-danger text-center" colspan="8">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(credito,index) in form.detalles" :key="credito.credito_id">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ credito.credito_id }}</td>
                                        <td>S/. {{ Number(credito.Monto).toFixed(2) }}</td>
                                        <td>S/. {{ Number(credito.Total).toFixed(2) }}</td>
                                        <td>S/. {{ Number(credito.Saldo).toFixed(2) }}</td>
                                        <td></td>
                                        <td>{{ credito.Estado }}</td>
                                        <td>
                                            <button class="btn btn-success btn-sm" style="font-size: .65rem;" title="Realizar Pago" @click.prevent="pagar(credito.id)">
                                                <i class="fa-solid fa-money-bill"></i>
                                            </button>&nbsp;
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
</template>