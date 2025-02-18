<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useBalance from '@/Composables/Balance.js'; 
import useHelper from '@/Helpers'; 
const props = defineProps({
    formBalance: Object,

});
const { formBalance } = toRefs(props);
const {
    agregarRegistro, actualizarRegistro, respuesta, errors
    } = useBalance();
const { Toast } = useHelper();

const calcularBalance = () => {
    formBalance.value.totalacorriente = Number(formBalance.value.activocaja) + Number(formBalance.value.activobancos) + Number(formBalance.value.activoctascobrar) + Number(formBalance.value.activoinventarios)
    formBalance.value.totalpcorriente = Number(formBalance.value.pasivodeudaprove) + Number(formBalance.value.pasivodeudaent) + Number(formBalance.value.pasivodeudacapital)
    formBalance.value.totalancorriente = Number(formBalance.value.activomueble) + Number(formBalance.value.activootrosact) + Number(formBalance.value.activodepre)
    formBalance.value.totalpncorriente = Number(formBalance.value.pasivolargop) + Number(formBalance.value.otrascuentaspagar)
    formBalance.value.total_activo = Number(formBalance.value.totalacorriente) + Number(formBalance.value.totalancorriente)
    formBalance.value.total_pasivo = Number(formBalance.value.totalpcorriente) + Number(formBalance.value.totalpncorriente)
    formBalance.value.patrimonio = Number(formBalance.value.total_activo) - Number(formBalance.value.total_pasivo)  
};
const crud = {
    'nuevo': async() => {
        await agregarRegistro(formAnalisis.value)
        formAnalisis.value.errors = []
        if(errors.value)
        {
            formAnalisis.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            formAnalisis.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            formAnalisis.value.estadoCrud='editar'
        }
    },
    'editar': async() => {
        await actualizarRegistro(formAnalisis.value)
        formAnalisis.value.errors = []
        if(errors.value)
        {
            formAnalisis.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            formAnalisis.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
        }
    }
}
const guardarBalance = () => {
    crud[formAnalisis.value.estadoCrud]();
};
</script>
<template>
    <h3 class="text-center mb-3">Balance General</h3>
    <form @submit.prevent="guardarBalance">
        <div class="row">
            <div class="col">
                <div class="card border-info mb-3">
                    <div class="card-header bg-info text-white">ACTIVO</div>
                    <div class="card-body">
                        <h5 class="mb-4">CORRIENTE</h5>
                        <div class="row mb-2">
                            <div class="col">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.activocaja"
                                        placeholder="ACTIVO CAJA"
                                        @change="calcularBalance()">
                                        <label>ACTIVO CAJA</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.activocaja" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>
                            </div>
                            <div class="col">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.activobancos"
                                        placeholder="ACTIVO BANCOS"
                                        @change="calcularBalance()">
                                        <label>ACTIVO BANCOS</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.activobancos" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>                                                            
                            </div>                                                        
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.activoctascobrar"
                                        placeholder="CUENTAS POR COBRAR"
                                        @change="calcularBalance()">
                                        <label>CUENTAS POR COBRAR</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.activoctascobrar" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>                                                            
                            </div> 
                            <div class="col">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.activoinventarios"
                                        placeholder="INVENTARIOS"
                                        @change="calcularBalance()">
                                        <label>INVENTARIOS</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.activoinventarios" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>                                                            
                            </div> 
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.totalacorriente"
                                        placeholder="TOTAL ACTIVO CORRIENTE"
                                        @change="calcularBalance()">
                                        <label>TOTAL ACTIVO CORRIENTE</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.totalacorriente" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>                                                            
                            </div> 
                        </div>
                        <h5>NO CORRIENTE</h5>
                        <div class="row mb-2">
                            <div class="col">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input title="MUEBLES, MAQUINARIA Y EQUIPO" type="text" class="form-control form-control-sm" v-model="formBalance.activomueble"
                                        placeholder="MUEBLES, MAQUINARIA Y EQUIPO"
                                        @change="calcularBalance()">
                                        <label>MUEBLES, MAQUINARIA Y EQUIPO</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.activomueble" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>                                                            
                            </div> 
                            <div class="col">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input title="OTROS ACTIVOS" type="text" class="form-control form-control-sm" v-model="formBalance.activootrosact"
                                        placeholder="OTROS ACTIVOS"
                                        @change="calcularBalance()">
                                        <label>OTROS ACTIVOS</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.activootrosact" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>                                                            
                            </div> 

                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input title="DEPRECIACION, AMORTIZACION Y AGOTAMIENTO ACUMULADO" type="text" class="form-control form-control-sm" v-model="formBalance.activodepre"
                                        placeholder="DEPRECIACION, AMORTIZACION Y AGOTAMIENTO ACUMULADO"
                                        @change="calcularBalance()">
                                        <label>DEPRECIACION, AMORTIZACION Y AGOTAMIENTO ACUMULADO</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.activodepre" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>                                                            
                            </div> 
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input title="TOTAL ACTIVO NO CORRIENTE" type="text" class="form-control form-control-sm" v-model="formBalance.totalancorriente"
                                        placeholder="TOTAL ACTIVO NO CORRIENTE"
                                        @change="calcularBalance()">
                                        <label>TOTAL ACTIVO NO CORRIENTE</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.totalancorriente" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>                                                            
                            </div>                                                            
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input title="TOTAL ACTIVO" type="text" class="form-control form-control-sm" v-model="formBalance.total_activo"
                                        placeholder="TOTAL ACTIVO">
                                        <label>TOTAL ACTIVO</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.total_activo" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>                                                            
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-danger text-white">PASIVO</div>
                    <div class="card-body">
                        <h5 class="mb-4">CORRIENTE</h5>
                        <div class="row mb-2">
                            <div class="col">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.pasivodeudaprove"
                                        placeholder="PROVEEDORES"
                                        @change="calcularBalance()">
                                        <label>PROVEEDORES</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.pasivodeudaprove" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>
                            </div>
                            <div class="col">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.pasivodeudaent"
                                        placeholder="DEUDAS CON ENTIDADES FINANCIERAS"
                                        @change="calcularBalance()">
                                        <label>DEUDAS CON ENTIDADES FINANCIERAS</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.pasivodeudaent" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>
                            </div>                                                         
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.pasivodeudaempre"
                                        placeholder="DEUDAS CON EMPRENDER"
                                        @change="calcularBalance()">
                                        <label>DEUDAS CON EMPRENDER</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.pasivodeudaempre" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>                                                            
                            </div>
                            <div class="col">
                            
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.totalpcorriente"
                                        placeholder="TOTAL PASIVO CORRIENTE">
                                        <label>TOTAL PASIVO CORRIENTE</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.totalpcorriente" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>                                                            
                            </div>
                        </div>
                        <h5>NO CORRIENTE</h5>
                        <div class="row mb-2">
                            <div class="col">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input title="PASIVO LARGO PLAZO" type="text" class="form-control form-control-sm" v-model="formBalance.pasivolargop"
                                        placeholder="PASIVO LARGO PLAZO"
                                        @change="calcularBalance()">
                                        <label>PASIVO LARGO PLAZO</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.pasivolargop" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>                                                            
                            </div>
                            <div class="col">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input title="OTRAS CUENTAS POR PAGAR<" type="text" class="form-control form-control-sm" v-model="formBalance.otrascuentaspagar"
                                        placeholder="OTRAS CUENTAS POR PAGAR"
                                        @change="calcularBalance()">
                                        <label>OTRAS CUENTAS POR PAGAR<</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.otrascuentaspagar" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>                                                            
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.totalpncorriente"
                                        placeholder="TOTAL PASIVO NO CORRIENTE" readonly>
                                        <label>TOTAL PASIVO NO CORRIENTE</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.totalpncorriente" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>                                                            
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input type="text" class="form-control form-control-sm" v-model="formBalance.total_pasivo"
                                        placeholder="TOTAL PASIVO" readonly>
                                        <label>TOTAL PASIVO</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.total_pasivo" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>                                                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">PATRIMONIO</div>
                    <div class="card-body">
                        <div class="row mb-2 align-items-center">
                            <label for="patrimonio" class="col-md-6 col-form-label text-end">PATRIMONIO EMPRESARIAL</label>
                            <div class="col-md-4">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input type="text" class="form-control form-control-sm w-75" v-model="formBalance.patrimonio"
                                        placeholder="PATRIMONIO EMPRESARIAL">
                                        <label>PATRIMONIO EMP.</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.patrimonio" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>
                            </div> 
                        </div>

                        <div class="row mb-2 align-items-center">
                            <label for="totpatrimonio" class="col-md-6 col-form-label text-end">TOTAL PATRIMONIO</label>
                            <div class="col-md-4">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input type="text" class="form-control form-control-sm w-75" v-model="formBalance.patrimonio"
                                        placeholder="TOTAL PATRIMONIO">
                                        <label>TOTAL PATR.</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.patrimonio" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>
                            </div> 
                        </div>

                        <div class="row mb-2 align-items-center">
                            <label for="paspatrimonio" class="col-md-6 col-form-label text-end">PASIVO Y PATRIMONIO</label>
                            <div class="col-md-4">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input type="text" class="form-control form-control-sm w-75" :value="Number(formBalance.patrimonio) + Number(formBalance.total_pasivo)"
                                        placeholder="PASIVO Y PATRIMONIO">
                                        <label>PASIVO Y PATR.</label>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="row mb-2 align-items-center">
                            <label for="captrabajo" class="col-md-6 col-form-label text-end">CAPITAL DE TRABAJO</label>
                            <div class="col-md-4">
                                <div class="has-validation">
                                    <div class="form-floating is-invalid">
                                        <input type="text" class="form-control form-control-sm w-75" :value="Number(formBalance.totalacorriente)-Number(formBalance.totalpcorriente)"
                                        placeholder="CAPITAL DE TRABAJO">
                                        <label>CAP. TRAB.</label>
                                    </div>
                                    <div class="invalid-feedback" v-for="error in formBalance.errors.captrabajo" :key="error">
                                        {{ error }}
                                    </div> 
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ (formBalance.estadoCrud=='nuevo') ? 'Guardar Balance' : 'Actualizar Balance' }}</button>
    </form>
</template>