<script setup>
  import { ref, onMounted, toRefs } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers'; 
  import useCredito from '@/Composables/Credito.js';
  import useAnalisisCualitativo from '@/Composables/AnalisisCualitativo.js';  
  import usePerdidas from '@/Composables/Perdidas.js'; 
  import useBalance from '@/Composables/Balance.js'; 
  import usePropuesta from '@/Composables/Propuesta.js'; 
  import CreditoForm from './Form.vue'
  import EvaluacionForm from './FormEvaluacion.vue'
  import FormImpresiones from './FormImpresiones.vue';
  const props = defineProps({
    agencia: Object,
    role: Object,
    usuario: Object,
});

const { agencia, role } = toRefs(props);
const { openModal, Toast, Swal, formatoFecha } = useHelper();
const {
    creditos, errors, credito, respuesta,
    obtenerCreditosEstadoAgencia, obtenerCredito, eliminarCredito,
    validarEvaluacionAsesor, cambiarEstado,
} = useCredito();
const {
    obtenerAnalisisCredito, analisis
} = useAnalisisCualitativo();
const {
    obtenerBalance, balance
} = useBalance();
const {
    obtenerPerdidas, perdidas
} = usePerdidas();
const {
    obtenerPropuesta, propuesta
} = usePropuesta();
const dato = ref({
    page:'',
    buscar:'',
    paginacion: 10
});

const form = ref({
    id: '',
    cliente_id : '',
    dni_cliente : '',
    apenom : 'APELLIDOS Y NOMBRES',
    agencia_id : agencia.id ?? 1,
    asesor_id : '',
    estado : 'PENDIENTE',
    fecha_reg : formatoFecha(null,"YYYY-MM-DD"),
    tipo : '',
    monto : '',
    producto : 'CAPITAL',
    frecuencia : 'DIARIO',
    plazo : '30',
    medioorigen : 'Asesores de Negocio',
    dondepagara : 'Campo',
    fuenterecursos : 'PROPIO',
    tasainteres : 9,
    total : 0.00,
    costomora : 0.00,
    creditos_seleccionados : [],
    estadoCrud: '',
    errors: []
});

    const formAnalisis = ref({
        credito_id: '',
        tipogarantia: '',
        cargafamiliar: '',
        riesgoedadmax: '',
        antecedentescred: '',
        recorpagoult: '',
        niveldesarr: '',
        tiempo_neg: '',
        control_ingegre: '',
        vent_totdec: '',
        compsubsector: '',
        totunidfamiliar: '',
        totunidempresa: '',
        total: '',
        estadoCrud: '',
        errors: []
    })
    const formBalance = ref({
        credito_id : '',
        total_activo : '',
        total_pasivo : '',
        patrimonio : '',
        paspatrimonio: '',
        captrabajo: '',
        fecha: '',
        activocaja: '',
        activobancos: '',
        activoctascobrar: '',
        activoinventarios: '',
        totalacorriente: '', 
        activomueble: '',
        activootrosact: '',
        activodepre: '',
        totalancorriente: '',
        pasivodeudaprove: '',
        pasivodeudaent: '',
        pasivodeudaempre: '',
        totalpcorriente: '',
        pasivolargop: '',
        otrascuentaspagar: '',          
        totalpncorriente: '',
        fecha : '',
        estadoCrud: '',
        errors: []
    })
    const formPerdidas = ref({
        credito_id: '',
        ventas : '',
        costo : '',
        utilidad : '',
        costonegocio : '',
        utiloperativa : '',
        otrosing : '',
        otrosegr : '',
        gast_fam : '',
        utilidadneta : '',
        utilnetdiaria : '',
        estadoCrud: '',
        errors: []
    })
    const formPropuesta = ref({
        credito_id: '',
        unidad_familiar : '',
        experiencia_cred : '',
        destino_prest : '',
        referencias : '',
        estadoCrud: '',
        errors: []
    })
    const limpiar = () => {
        form.value.id = '';
        form.value.cliente_id = '';
        form.value.dni_cliente = '',
        form.value.apenom = 'APELLIDOS Y NOMBRES';
        form.value.agencia_id = agencia.id ?? 1;
        form.value.asesor_id = '';
        form.value.estado = 'PENDIENTE';
        form.value.fecha_reg = formatoFecha(null,"YYYY-MM-DD"),
        form.value.tipo = '';
        form.value.monto = '';
        form.value.producto = 'CAPITAL';
        form.value.frecuencia = 'DIARIO';
        form.value.plazo = '30';
        form.value.medioorigen = 'Asesores de Negocio';
        form.value.dondepagara = 'Campo';
        form.value.fuenterecursos = 'PROPIO';
        form.value.tasainteres = 0.00;
        form.value.total = 0.00;
        form.value.costomora = 0.00;
        form.value.estadoCrud = '';
        form.value.errors = [];
        form.value.creditos_seleccionados = [];
        errors.value = [];
        
    };
    const obtenerDatos = async (id) => {
        await obtenerCredito(id);
        if (credito.value) {
            let cliente = credito.value.cliente;
            form.value.id = credito.value.id;
            form.value.cliente_id = credito.value.cliente_id;
            form.value.dni_cliente = cliente.persona.dni
            form.value.apenom = cliente.persona.apenom
            form.value.agencia_id = credito.value.agencia_id;
            form.value.asesor_id = credito.value.asesor_id;
            form.value.estado = credito.value.estado;
            form.value.fecha_reg = credito.value.fecha_reg;
            form.value.tipo = credito.value.tipo;
            form.value.monto = credito.value.monto;
            form.value.producto = credito.value.producto;
            form.value.frecuencia = credito.value.frecuencia;
            form.value.plazo = credito.value.plazo;
            form.value.medioorigen = credito.value.medioorigen;
            form.value.dondepagara = credito.value.dondepagara;
            form.value.fuenterecursos = credito.value.fuenterecursos;
            form.value.tasainteres = credito.value.tasainteres;
            form.value.total = credito.value.total;
            form.value.costomora = credito.value.costomora;
            form.value.creditos_seleccionados = [];
        }
    };
    const editar = (id) => {
        limpiar();
        obtenerDatos(id)
        form.value.estadoCrud = 'editar'
        document.getElementById("modalcreditoLabel").innerHTML = 'Editar credito';
        openModal('#modalcredito')
    }
    const nuevo = () => {
        limpiar()
        form.value.estadoCrud = 'nuevo'
        openModal('#modalcredito')
        document.getElementById("modalcreditoLabel").innerHTML = 'Nuevo credito';
        //titulo.textContent = 'Editar Datos Personales';
    }
    const dato2=ref({
        'estado' : '',
        'agencia_id' : '',
    })
    const listarCreditos = async(page=1) => {
        dato.value.page= page
        dato2.value.estado='DESEMBOLSADO'
        await obtenerCreditosEstadoAgencia(dato.value, dato2.value)
    }
    const eliminar = (id) => {
        Swal.fire({
            title: '¿Estás seguro de Eliminar?',
            text: "Menu",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminalo!'
        }).then((result) => {
            if (result.isConfirmed) {
                elimina(id)
            }
        })
    }
    const elimina = async(id) => {
        await eliminarCredito(id)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            listarCreditos(creditos.value.current_page)
        }
    }
    // PAGINACION
    const isActived = () => {
        return creditos.value.current_page
    }
    const offset = 2;

    const buscar = () => {
        listarCreditos()
    }
    const cambiarPaginacion = () => {
        listarCreditos()
    }
    const asignarValores = (form, datos, valoresPorDefecto) => {
        Object.keys(valoresPorDefecto).forEach(key => {
            form.value[key] = datos && datos[key] !== undefined ? datos[key] : valoresPorDefecto[key];
        });
    };
    const data=ref({
        id:'',
        estado:'',
    })
    const datoImpresiones=ref({
        credito_id: '',
        tipo: '',
        url:'',
    });
    const limpiarDatosImpresiones = () => {
        datoImpresiones.value.credito_id = '';
        datoImpresiones.value.tipo = '';
        datoImpresiones.value.url = '';
    }
    const enviar=(id)=>{
        validarEnvio(id)
    };
    const cambiarEstadoCredito=async(id)=>{
        data.value.id=id
        data.value.estado='EVALUACION'
        await cambiarEstado(data.value)
    }
    const validarEnvio=async(id)=>{
        await validarEvaluacionAsesor(id)
        if(respuesta.value.ok==1){
            Swal.fire({
                title: '¿Estás seguro de Enviar a Gerencia?',
                text: "Credito",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Enviar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    cambiarEstadoCredito(id)
                    listarCreditos(creditos.value.current_page)
                }
            })
        }else{
            Swal.fire("Falta evaluar");
        }        
    }
    const cargarDatosEvaluacion = (id) => {
        asignarValores(formAnalisis, analisis.value, {
            credito_id: id,
            tipogarantia: '',
            cargafamiliar: '',
            riesgoedadmax: '',
            antecedentescred: '',
            recorpagoult: '',
            niveldesarr: '',
            tiempo_neg: '',
            control_ingegre: '',
            vent_totdec: '',
            compsubsector: '',
            totunidfamiliar: '',
            totunidempresa: '',
            total: '',
            estadoCrud: analisis.value ? 'editar' : 'nuevo'
        });
        asignarValores(formBalance, balance.value, {
            credito_id: id,
            total_activo: '',
            total_pasivo: '',
            patrimonio: '',
            paspatrimonio: '',
            captrabajo: '',
            fecha: '',
            activocaja: '',
            activobancos: '',
            activoctascobrar: '',
            activoinventarios: '',
            totalacorriente: '', 
            activomueble: '',
            activootrosact: '',
            activodepre: '',
            totalancorriente: '',
            pasivodeudaprove: '',
            pasivodeudaent: '',
            pasivodeudaempre: '',
            totalpcorriente: '',
            pasivolargop: '',
            otrascuentaspagar: '',          
            totalpncorriente: '',
            estadoCrud: balance.value ? 'editar' : 'nuevo'
        });
        asignarValores(formPerdidas, perdidas.value, {
            credito_id: id,
            ventas: '',
            costo: '',
            utilidad: '',
            costonegocio: '',
            utiloperativa: '',
            otrosing: '',
            otrosegr: '',
            gast_fam: '',
            utilidadneta: '',
            utilnetdiaria: '',
            estadoCrud: perdidas.value ? 'editar' : 'nuevo'
        });
        asignarValores(formPropuesta, propuesta.value, {
            credito_id: id,
            unidad_familiar: '',
            experiencia_cred: '',
            destino_prest: '',
            referencias: '',
            estadoCrud: propuesta.value ? 'editar' : 'nuevo'
        });
    };

    const buscarCredito = async(id)=>{
        await obtenerCredito(id)
        await obtenerAnalisisCredito(id)
        await obtenerPerdidas(id)
        await obtenerBalance(id)
        await obtenerPropuesta(id)
        cargarDatosEvaluacion(id)
    }
    const evaluacion = (id)=>{
        buscarCredito(id)
        openModal('#modalevaluacion')
        document.getElementById("modalevaluacionLabel").innerHTML = 'Evaluacion Credito';
    }
    const archivos=async(id)=>{
       await validarEvaluacionAsesor(id)
        if(respuesta.value.ok==1){
            limpiarDatosImpresiones();
            datoImpresiones.value.credito_id = id;
            openModal('#modalimpresiones')
            document.getElementById("modalimpresionesLabel").innerHTML = 'Evaluacion Credito';        
       }else{
            Swal.fire("Falta evaluar");
        }  
    }
    const cambiarPagina =(pagina) => {
        listarCreditos(pagina)
    }
    const pagesNumber = () => {
        if(!creditos.value.to){
            return []
        }
        let from = creditos.value.current_page - offset
        if(from < 1) from = 1
        let to = from + (offset*2)
        if( to >= creditos.value.last_page) to = creditos.value.last_page
        let pagesArray = []
        while(from <= to) {
            pagesArray.push(from)
            from ++
        }
        return pagesArray
    }
    // CARGA
    onMounted(() => {
        listarCreditos()
    })
</script>
<template>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Listado de Creditos Asesor
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-1 mb-1">
                        <button  type="button" class="btn btn-danger" @click.prevent="nuevo">
                            <i class="fas fa-plus"></i> Nuevo
                        </button>                        
                    </div>
                    <div class="col-md-2 mb-1">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">Mostrar</span>
                            <select class="form-select"  v-model="dato.paginacion" @change="cambiarPaginacion">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="1000">1000</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">Buscar</span>
                            <input class="form-control" placeholder="Ingrese nombre, código" type="text" v-model="dato.buscar"
                                @change="buscar" />
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <nav>
                            <ul class="pagination">
                                <li v-if="creditos.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="creditos.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(creditos.current_page - 1)">
                                        <span><i class="fas fa-angle-left"></i></span>
                                    </a>
                                </li>
                                <li v-for="page in pagesNumber()" class="page-item"
                                    :key="page"
                                    :class="[ page == isActived() ? 'active' : '']"
                                    :title="'Página '+ page">
                                    <a href="#" class="page-link"
                                        @click.prevent="cambiarPagina(page)">{{ page }}</a>
                                </li>
                                <li v-if="creditos.current_page < creditos.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(creditos.current_page + 1)">
                                        <span><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="creditos.current_page <= creditos.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(creditos.last_page)"
                                        title="Última Página">
                                        <span><i class="fas fa-step-forward"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped small">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="13" class="text-center">Creditos</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Cod</th>
                                        <th>DNI</th>
                                        <th>Apellidos y Nombres</th>
                                        <th>Monto</th>
                                        <th>Mencion</th>
                                        <th>Tipo</th>
                                        <th>Fecha</th>
                                        <th>Frecuencia</th>
                                        <th>Asesor</th>
                                        <th>Agencia</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="creditos.total == 0">
                                        <td class="text-danger text-center" colspan="13">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(credito,index) in creditos.data" :key="credito.id">
                                        <td>{{ index + creditos.from }}</td>
                                        <td>{{ credito.id }}</td>
                                        <td>{{ credito.cliente.persona.dni }}</td>
                                        <td>{{ credito.cliente.persona.apenom }}</td>
                                        <td>{{ 'S/. ' + credito.monto }}</td>
                                        <td>{{ credito.mencion }}</td>
                                        <td>{{ credito.tipo }}</td>
                                        <td>{{ credito.fecha_reg }}</td>
                                        <td>{{ credito.frecuencia }}</td>
                                        <td>{{ credito.asesor.name }}</td>
                                        <td>{{ credito.agencia.nombre }}</td>
                                        <td>{{ credito.estado }}</td>
                                        <td>
                                            <template v-if="credito.estado === 'PENDIENTE' || credito.estado === 'OBSERVADO'">
                                                <button class="btn btn-warning btn-sm btn-custom" title="Editar" @click.prevent="editar(credito.id)">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm btn-custom" title="Enviar a Papelera" @click.prevent="eliminar(credito.id, 'Temporal')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <button class="btn btn-info btn-sm btn-custom" title="Evaluar" @click.prevent="evaluacion(credito.id)">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn btn-primary btn-sm btn-custom" title="Enviar a Gerencia" @click.prevent="enviar(credito.id)">
                                                    <i class="fa-solid fa-paper-plane"></i>
                                                </button>
                                            </template>
                                            <button v-if="credito.estado === 'PENDIENTE' || credito.estado === 'EVALUACION'" class="btn btn-success btn-sm btn-custom" title="Archivos" @click.prevent="archivos(credito.id)">
                                                <i class="fa-solid fa-file-pdf"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-1">
                        Mostrando <b>{{creditos.from}}</b> a <b>{{ creditos.to }}</b> de <b>{{ creditos.total}}</b> Registros
                    </div>
                    <div class="col-md-7 mb-1 text-right">
                        <nav>
                            <ul class="pagination">
                                <li v-if="creditos.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="creditos.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(creditos.current_page - 1)">

                                        <span><i class="fas fa-angle-left"></i></span>
                                    </a>
                                </li>
                                <li v-for="page in pagesNumber()" class="page-item"
                                    :key="page"
                                    :class="[ page == isActived() ? 'active' : '']"
                                    :title="'Página '+ page">
                                    <a href="#" class="page-link"
                                        @click.prevent="cambiarPagina(page)">{{ page }}</a>
                                </li>
                                <li v-if="creditos.current_page < creditos.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(creditos.current_page + 1)">
                                        <span><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="creditos.current_page <= creditos.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(creditos.last_page)"
                                        title="Última Página">
                                        <span><i class="fas fa-step-forward"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    <CreditoForm
    :form="form"
    @onListar="listarCreditos"
    :currentPage="creditos.current_page"
    @evaluar="evaluacion"></CreditoForm>
    <EvaluacionForm :formAnalisis="formAnalisis"
    :credito="credito"
    :analisis="analisis"
    :formBalance="formBalance"
    :formPerdidas="formPerdidas"
    :formPropuesta="formPropuesta"
    @buscarCredito="buscarCredito"></EvaluacionForm>
    <FormImpresiones :form="datoImpresiones"></FormImpresiones>
</template>