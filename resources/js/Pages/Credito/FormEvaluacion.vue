<script setup>
import { toRefs, onMounted, ref } from 'vue';
import useHelper from '@/Helpers';  
import { onlyNumbers } from '@/Helpers'
const { hideModal, Toast, openModal } = useHelper();

const props = defineProps({
    form: Object,
    credito: Object,
});

const { form, credito } = toRefs(props);

onMounted(() => {
    
});
</script>

<template>
    <form @submit.prevent="guardar">
        <div class="modal fade" id="modalevaluacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="modalevaluacionLabel">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-1" id="modalevaluacionLabel">Evaluacion Crédito</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card mb-3">
                            <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png);"></div> <!--/.bg-holder-->
                            <div class="card-body position-relative">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h3>{{ credito.cliente?.persona.apenom }}</h3>
                                    </div>
                                    <div class="col">
                                        <h4 class="mt-2"><small>Monto :</small> S/.{{ credito.monto }}</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <h4 class="mt-2"><small>TIPO : </small>{{ credito.tipo }}</h4>
                                        <h4 class="mt-2"><small>PRODUCTO : </small>{{ credito.producto }}</h4>
                                    </div>
                                    <div class="col">
                                        <h4 class="mt-2"><small>FRECUENCIA : </small>{{ credito.frecuencia }}</h4>
                                        <h4 class="mt-2"><small>PLAZO : </small>{{ credito.plazo }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card theme-wizard mb-5">
                            <div class="card-header bg-light pt-3 pb-2">
                                <ul class="nav justify-content-between nav-wizard">
                                <li class="nav-item"><a class="nav-link active fw-semi-bold" href="#bootstrap-wizard-tab1" data-bs-toggle="tab" data-wizard-step="data-wizard-step"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-chart-line"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Analisis Cualitativo</span></a></li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab2" data-bs-toggle="tab" data-wizard-step="data-wizard-step"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-balance-scale"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Balance General</span></a></li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab3" data-bs-toggle="tab" data-wizard-step="data-wizard-step"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-file-invoice-dollar"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Perdidas y Ganancias</span></a></li>
                                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab4" data-bs-toggle="tab" data-wizard-step="data-wizard-step"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-hand-holding-usd"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Propuesta de Credito</span></a></li>
                                </ul>
                            </div>
                            <div class="card-body py-4" id="wizard-controller">
                                <div class="tab-content">
                                    <div class="tab-pane active px-sm-3 px-md-1" role="tabpanel" aria-labelledby="bootstrap-wizard-tab1" id="bootstrap-wizard-tab1">
                                        <h3 class="text-center">Analisis Cualitativo</h3>
                                        <!-- UNIDAD FAMILIAR -->
                                         <div class="row mb-3">
                                            <div class="col">
                                                <div class="card border-info">
                                                    <div class="card-header bg-info text-white">I. UNIDAD FAMILIAR</div>
                                                    <div class="card-body">
                                                        <p class="text-primary fw-bold">1. TIPO DE GARANTÍA</p>
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label class="form-check-label" for="garantia1">
                                                                        REAL CONSTITUIDA A FAVOR DE LA INSTITUCIÓN (HIPOTECA Y/O PRENDA)
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input class="form-check-input" id="garantia1" type="radio" name="tipogarantia" value="4" />
                                                                    4
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label class="form-check-label" for="garantia2">
                                                                        SIMPLE
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input class="form-check-input" id="garantia2" type="radio" name="tipogarantia" value="2" />
                                                                    2
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="text-primary fw-bold">2. CARGA FAMILIAR</p>
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label class="form-check-label" for="carga1">
                                                                        NO TIENE DEPENDIENTES
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input class="form-check-input" id="carga1" type="radio" name="cargafamiliar" value="4" />
                                                                    4
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label class="form-check-label" for="carga2">
                                                                        TIENE DEPENDIENTES NO VULNERABLES
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input class="form-check-input" id="carga2" type="radio" name="cargafamiliar" value="2" />
                                                                    2
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label class="form-check-label" for="carga3">
                                                                        TIENE DEPENDIENTES MENORES A 5 AÑOS
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input class="form-check-input" id="carga3" type="radio" name="cargafamiliar" value="1" />
                                                                    1
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label class="form-check-label" for="carga4">
                                                                        TIENE ALGÚN DEPENDIENTE CON ENFERMEDADES FRECUENTES Y/O GRAVES
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input class="form-check-input" id="carga4" type="radio" name="cargafamiliar" value="0" />
                                                                    0
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="text-primary fw-bold">3. RIESGO POR EDAD MÁXIMA</p>
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label class="form-check-label" for="edad1">
                                                                        MENOR DE 64 AÑOS
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input class="form-check-input" id="edad1" type="radio" name="riesgoedadmax" value="3" />
                                                                    3
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label class="form-check-label" for="edad2">
                                                                        MAYOR O IGUAL A 64 AÑOS
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input class="form-check-input" id="edad2" type="radio" name="riesgoedadmax" value="1" />
                                                                    1
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <label for="totalunidadfam" class="form-label">TOTAL PUNTAJE UNIDAD FAMILIAR</label>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control" id="totalunidadfam" name="totalunidadfam" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- UNIDAD EMPRESARIAL -->
                                            <div class="col">
                                                <div class="card border-info">
                                                    <div class="card-header bg-info text-white">II. UNIDAD EMPRESARIAL</div>
                                                    <div class="card-body">
                                                    <p class="text-primary fw-bold">1. TIENE ANTECEDENTES CREDITICIOS</p>
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label class="form-check-label" for="antecedentes1">
                                                                        CRÉDITOS EN NUESTRA ENTIDAD
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input class="form-check-input" id="antecedentes1" type="radio" name="antecedentescredit" value="5" />
                                                                    5
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label class="form-check-label" for="antecedentes2">
                                                                        CRÉDITOS EN OTRAS ENTIDADES DEL SISTEMA FINANCIERO
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input class="form-check-input" id="antecedentes2" type="radio" name="antecedentescredit" value="4" />
                                                                    4
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label class="form-check-label" for="antecedentes3">
                                                                        CRÉDITO CON PROVEEDORES
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input class="form-check-input" id="antecedentes3" type="radio" name="antecedentescredit" value="3" />
                                                                    3
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label class="form-check-label" for="antecedentes4">
                                                                        NO HA TENIDO CRÉDITOS
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input class="form-check-input" id="antecedentes4" type="radio" name="antecedentescredit" value="1" />
                                                                    1
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <p class="text-primary fw-bold">2. RÉCORD DE PAGO DEL ÚLTIMO PRÉSTAMO</p>
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <label class="form-check-label" for="recordpago1">
                                                                        FUE CON PAGOS OPORTUNOS EN SU FECHA DE PAGO
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input class="form-check-input" id="recordpago1" type="radio" name="recordultimopago" value="7" />
                                                                    7
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card-footer">
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <label for="totalunidademp" class="form-label">
                                                                    TOTAL PUNTAJE UNIDAD EMPRESARIAL
                                                                </label>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control" id="totalunidademp" name="totalunidademp" readonly />
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>                                            
                                         </div>
                                         <div class="row">
                                            <div class="col-md-9"></div>
                                            <div class="col">
                                                <div class="mb-3 has-validation">
                                                    <div class="form-floating is-invalid">
                                                        <input type="puntajetotal" class="form-control form-control-sm" v-model="form.puntajetotal" 
                                                        placeholder="puntajetotal"
                                                        :class="{ 'is-invalid': form.errors.puntajetotal }">
                                                        <label for="puntajetotal">PUNTAJE TOTAL</label>
                                                    </div>
                                                    <div class="invalid-feedback" v-for="error in form.errors.puntajetotal" :key="error">
                                                        {{ error }}
                                                    </div>
                                                </div>
                                            </div>
                                         </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-1" role="tabpanel" aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2">
                                        <h3 class="text-center mb-6">Balance General</h3>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h5>ACTIVO CORRIENTE</h5>
                                                <div class="row">
                                                    <label for="activocaja" class="control-label col-md-7">CAJA</label>
                                                    <div class="col-md-5">
                                                        <input type="text" onchange="sumarbalance()" onclick="selecciona_value(this)" name="activocaja" id="activocaja" class="form-control form-control-sm numerosypunto" placeholder="S/. 0.00" value="<?php echo $detbalance['activocaja'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="activobancos" class="control-label col-md-7">BANCOS</label>
                                                    <div class="col-md-5">
                                                        <input type="text" onchange="sumarbalance()" onclick="selecciona_value(this)" name="activobancos" id="activobancos" class="form-control form-control-sm numerosypunto" placeholder="S/. 0.00" value="<?php echo $detbalance['activobancos'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="activoctascobrar" class="control-label col-md-7">CUENTAS POR COBRAR</label>
                                                    <div class="col-md-5">
                                                        <input type="text" onchange="sumarbalance()" onclick="selecciona_value(this)" name="activoctascobrar" id="activoctascobrar" class="form-control form-control-sm numerosypunto" placeholder="S/. 0.00" value="<?php echo $detbalance['activoctascobrar'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="activoinventarios" class="control-label col-md-7">INVENTARIOS</label>
                                                    <div class="col-md-5">
                                                        <div class="input-group input-group-sm">
                                                        <input type="text" name="activoinventarios" id="activoinventarios" class="form-control" placeholder="S/. 0.00" value="<?php echo $detbalance['activoinventarios'] ?>" readonly>
                                                        <div class="input-group-append">
                                                            <a href="#detalleinventarios" data-toggle="modal" class="btn btn-outline-secondary" type="button">+</a>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="totalactivocorr" class="control-label col-md-7">TOTAL ACTIVO CORR.</label>
                                                    <div class="col-md-5">
                                                        <input type="text" name="totalactivocorr" id="totalactivocorr" class="form-control form-control-sm numerosypunto" placeholder="S/. 0.00" value="<?php echo $detbalance['totalacorriente'] ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <h5>PASIVO CORRIENTE</h5>
                                                <div class="row">
                                                    <label for="pasivodeudaprove" class="control-label col-md-7">DEUDAS CON PROVEEDORES</label>
                                                    <div class="col-md-5">
                                                        <input type="text" onchange="sumarbalance()" onclick="selecciona_value(this)" name="pasivodeudaprove" id="pasivodeudaprove" class="form-control form-control-sm numerosypunto" placeholder="S/. 0.00" value="<?php echo $detbalance['pasivodeudaprove'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="pasivodeudaent" class="control-label col-md-7">DEUDAS CON ENTIDADES FINANCIERAS</label>
                                                    <div class="col-md-5">
                                                        <div class="input-group input-group-sm">
                                                        <input type="text" onchange="sumarbalance()" name="pasivodeudaent" id="pasivodeudaent" class="form-control" placeholder="0.00" value="<?php echo $detbalance['pasivodeudaent'] ?>" readonly>
                                                        <div class="input-group-append">
                                                            <a href="#deudasentidadfin" data-toggle="modal" class="btn btn-outline-secondary">+</a>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="pasivodeudaemprender" class="control-label col-md-7">DEUDAS CON EMPRENDER</label>
                                                    <div class="col-md-5">
                                                        <input type="text" onchange="sumarbalance()" onclick="selecciona_value(this)" name="pasivodeudaemprender" id="pasivodeudaemprender" class="form-control form-control-sm numerosypunto" placeholder="S/. 0.00" value="<?php echo $detbalance['pasivodeudaempre'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="totalpasivocorr" class="control-label col-md-7">TOTAL PASIVO CORR</label>
                                                    <div class="col-md-5">
                                                        <input type="text" name="totalpasivocorr" id="totalpasivocorr" class="form-control form-control-sm numerosypunto" placeholder="S/. 0.00" value="<?php echo $detbalance['totalpcorriente'] ?>" readonly>
                                                    </div>
                                                </div>							
                                            </div>
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <label for="totalactivo" class="control-label col-md-6">TOTAL ACTIVO</label>
                                                    <div class="col-md-6">
                                                        <input type="text" name="totalactivo" id="totalactivo" class="form-control numerosypunto form-control-sm" value="<?php echo $balance['total_activo'] ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="totalpasivo" class="control-label col-md-6">TOTAL PASIVO</label>
                                                    <div class="col-md-6">
                                                        <input type="text" name="totalpasivo" id="totalpasivo" class="form-control numerosypunto form-control-sm" value="<?php echo $balance['total_pasivo'] ?>" readonly>
                                                    </div>
                                                </div>							
                                            </div>				
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h5>ACTIVO NO CORRIENTE</h5>
                                                <div class="row">
                                                    <label for="activomueble" class="control-label col-md-7">MUEBLES, MAQUINARIA Y EQUIPO</label>
                                                    <div class="col-md-5">
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" onchange="sumarbalance()" name="activomueble" id="activomueble" class="form-control" placeholder="S/. 0.00" value="<?php echo $detbalance['activomueble'] ?>" readonly>
                                                            <div class="input-group-append">
                                                                <a href="#mueblemaq" data-toggle="modal" class="btn btn-outline-secondary">+</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="activootrosact" class="control-label col-md-7">OTROS ACTIVOS</label>
                                                    <div class="col-md-5">
                                                        <input type="text" onchange="sumarbalance()" onclick="selecciona_value(this)" class="form-control numerosypunto form-control-sm" name="activootrosact" id="activootrosact" placeholder="S/. 0.00" value="<?php echo $detbalance['activootrosact'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="activodepre" class="control-label col-md-7">DEPRECIACION, AMORTIZACION Y AGOTAMIENTO ACUMULADO</label>
                                                    <div class="col-md-5">
                                                        <input type="text" onchange="sumarbalance()" onclick="selecciona_value(this)" class="form-control numerosypunto form-control-sm" name="activodepre" id="activodepre" placeholder="S/. 0.00" value="<?php echo $detbalance['activodepre'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="totalactivonocorr" class="control-label col-md-7">TOTAL ACTIVO NO CORRIENTE</label>
                                                    <div class="col-md-5">
                                                        <input type="text" name="totalactivonocorr" id="totalactivonocorr" class="form-control form-control-sm numerosypunto" placeholder="S/. 0.00" value="<?php echo $detbalance['totalancorriente'] ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h5>PASIVO NO CORRIENTE</h5>
                                                <div class="row">
                                                    <label for="pasivolargop" class="control-label col-md-7">PASIVO LARGO PLAZO</label>
                                                    <div class="col-md-5">
                                                        <input type="text" onchange="sumarbalance()" onclick="selecciona_value(this)" name="pasivolargop" id="pasivolargop" class="form-control form-control-sm numerosypunto" placeholder="S/. 0.00" value="<?php echo $detbalance['pasivolargop'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="otrascuentaspagar" class="control-label col-md-7">OTRAS CUENTAS POR PAGAR</label>
                                                    <div class="col-md-5">
                                                        <input type="text" onchange="sumarbalance()" name="otrascuentaspagar" onclick="selecciona_value(this)" id="otrascuentaspagar" class="form-control form-control-sm numerosypunto" placeholder="S/. 0.00" value="<?php echo $detbalance['otrascuentaspagar'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="totalpasivonocorr" class="control-label col-md-7">TOTAL PASIVO NO CORRIENTE</label>
                                                    <div class="col-md-5">
                                                        <input type="text" name="totalpasivonocorr" id="totalpasivonocorr" class="form-control form-control-sm numerosypunto" placeholder="S/. 0.00" value="<?php echo $detbalance['totalpncorriente'] ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h5>PATRIMONIO</h5>
                                                <div class="row">
                                                    <label for="patrimonioemp" class="control-label col-md-7">PATRIMONIO EMPRESARIAL</label>
                                                    <div class="col-md-5">
                                                        <input type="text" name="patrimonioemp" id="patrimonioemp" class="form-control form-control-sm numerosypunto" value="<?php echo $balance['patrimonio'] ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="totpatrimonio" class="control-label col-md-7">TOTAL PATRIMONIO</label>
                                                    <div class="col-md-5">
                                                        <input type="text" name="totpatrimonio" id="totpatrimonio" class="form-control form-control-sm numerosypunto" value="<?php echo $balance['patrimonio'] ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="paspatrimonio" class="control-label col-md-7">PASIVO Y PATRIMONIO</label>
                                                    <div class="col-md-5">
                                                        <input type="text" name="paspatrimonio" id="paspatrimonio" class="form-control form-control-sm numerosypunto" value="<?php echo number_format($balance['patrimonio']+$balance['total_pasivo'],2) ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="captrabajo" class="control-label col-md-7">CAPITAL TRABAJO</label>
                                                    <div class="col-md-5">
                                                        <input type="text" name="captrabajo" id="captrabajo" class="form-control form-control-sm numerosypunto" value="<?php echo number_format($detbalance['totalacorriente']-$detbalance['totalpcorriente'],2); ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane  px-sm-3 px-md-1" role="tabpanel" aria-labelledby="bootstrap-wizard-tab3" id="bootstrap-wizard-tab3">
                                        <h3 class="text-center">Perdidas y Ganancias</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="" class="control-label">Ventas</label>						
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroup-sizing-sm">S/.</span>
                                                    </div>
                                                    <input type="text" name="ventaspg" id="ventaspg" class="form-control" placeholder="0.00" value="<?= is_null($perdidasgananciasgral) ? 0 : $perdidasgananciasgral['ventas'] ?>" readonly>
                                                    <div class="input-group-append">
                                                    <a href="#epgventascosto" data-toggle="modal" class="btn btn-outline-secondary" type="button">+</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="" class="control-label">Costo</label>						
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">S/.</span>								
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm numerosypunto" name="costopg" id="costopg" placeholder="0.00" value="<?= is_null($perdidasgananciasgral) ? 0 : $perdidasgananciasgral['costo'] ?>" readonly>
                                                    <div class="input-group-append">
                                                        <a href="#epgventascosto" data-toggle="modal" class="btn btn-outline-secondary" type="button">+</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="" class="control-label">UTILIDAD</label>							
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">S/.</span>								
                                                    </div>
                                                    <input type="text" class="form-control numerosypunto" name="utilidadbpg" id="utilidadbpg" placeholder="0.00" value="<?= is_null($perdidasgananciasgral) ? 0 : $perdidasgananciasgral['utilidad'] ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                
                                            </div>
                                            <div class="col-md-6">
                                                <label for="" class="control-label">Gasto Negocio</label>
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">S/.</span>									
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm numerosypunto" name="gastoneg" id="gastoneg" value="<?= is_null($perdidasgananciasgral) ? 0 : $perdidasgananciasgral['costonegocio'] ?>" placeholder="0.00" readonly>
                                                    <div class="input-group-append">
                                                        <a href="#gastonegocio" data-toggle="modal" class="btn btn-outline-secondary" type="button">+</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="" class="control-label">Utilidad Operativa</label>					
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">S/.</span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm numerosypunto" name="utilidopera" id="utilidopera" placeholder="0.00" value="<?= is_null($perdidasgananciasgral) ? 0 : $perdidasgananciasgral['utiloperativa'] ?>" readonly>
                                                </div>
                                            </div>						
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="" class="control-label">Otros Ingresos</label>
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">S/.</span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm numerosypunto" name="otrosing" id="otrosing" onclick="selecciona_value(this)" value="<?php echo !isset($perdidasgananciasgral['otrosing']) ? '0.00' : $perdidasgananciasgral['otrosing'] ?>" placeholder="0.00">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="" class="control-label">Otros Egresos</label>
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">S/.</span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm numerosypunto" name="otrosegre" id="otrosegre" onclick="selecciona_value(this)" value="<?php echo !isset($perdidasgananciasgral['otrosegr']) ? '0.00' : $perdidasgananciasgral['otrosegr'] ?>" placeholder="0.00">
                                                </div>
                                            </div>
                                        </div>										
                                        <div class="row">
                                            <div class="col-md-6"></div>
                                            <div class="col-md-6">
                                                <label for="" class="control-label col-md-offset-6">Gastos Familiares</label>
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">S/.</span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm numerosypunto" name="gastfamiliares" id="gastfamiliares" value="<?php echo !isset($perdidasgananciasgral['gast_fam']) ? '0.00' : $perdidasgananciasgral['gast_fam'] ?>" placeholder="0.00" onclick="selecciona_value(this)" readonly>
                                                    <div class="input-group-append">
                                                        <a href="#gastosfamiliares" data-toggle="modal" class="btn btn-outline-secondary">+</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="" class="control-label">Utilidad Neta</label>
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">S/.</span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm numerosypunto" name="utilneta" id="utilneta" placeholder="0.00" value="<?php echo !isset($perdidasgananciasgral['utilidadneta']) ? '0.00' : $perdidasgananciasgral['utilidadneta'] ?>" readonly>
                                                </div>
                                            </div>							
                                            <div class="col-md-6">
                                                <label for="" class="control-label" id="lblutilnet">Utilidad Neta</label>	
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">S/.</span>
                                                    </div>
                                                    <input type="hidden" name="tipoplazosol" value="<?= $solicitud['frecuencia'] ?>">
                                                    <input type="text" class="form-control form-control-sm numerosypunto" name="utilnetadiaria" id="utilnetadiaria" placeholder="0.00" value="<?php echo !isset($perdidasgananciasgral['utilnetdiaria']) ? '0.00' : $perdidasgananciasgral['utilnetdiaria'] ?>" readonly>
                                                </div>
                                            </div>						
                                        </div>
                                    </div>
                                    <div class="tab-pane px-sm-3 px-md-1" role="tabpanel" aria-labelledby="bootstrap-wizard-tab4" id="bootstrap-wizard-tab4">
                                        <h3 class=" text-center">Propuesta de Credito</h3>
                                        <div class="form-group">
                                            <label class="control-label">UNIDAD FAMILIAR(CONYUGUE, HIJOS)</label>
                                            <textarea name="unidfam" id="unidfam" class="form-control input-sm" placeholder="Unidad Familiar" rows="4"><?php echo is_null($propuestacred) ? '' : $propuestacred['unidad_familiar']; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="">EXPERIENCIA CREDITICIA Y NEGOCIO</label>
                                            <textarea name="expcred" id="expcred" class="form-control input-sm" placeholder="Experiencia Crediticia" rows="4"><?php echo is_null($propuestacred) ? '' : $propuestacred['experiencia_cred'] ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="">DESTINO DEL PRESTAMO</label>
                                            <textarea name="destprest" id="destprest" class="form-control input-sm" placeholder="Destino del Prestamo" rows="4"><?php echo is_null($propuestacred) ? '' : $propuestacred['destino_prest'] ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="">REFERENCIAS PERSONALES Y COMERCIALES</label>
                                            <textarea name="refper" id="refper" class="form-control input-sm" placeholder="Destino del Prestamo" rows="4"><?php echo is_null($propuestacred) ? '' : $propuestacred['referencias'] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light">
                                <div class="px-sm-3 px-md-5">

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
