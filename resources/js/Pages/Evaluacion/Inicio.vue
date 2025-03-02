<script setup>
  import { ref, onMounted, toRefs } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers'; 
  import useCredito from '@/Composables/Credito.js';
  import EvaluacionForm from './Form.vue'
  import useEvaluacion from '@/Composables/Evaluacion.js';
    const props = defineProps({
        agencia: Object,
        role: Object,
        usuario: Object,
    });

    const { agencia, usuario } = toRefs(props);
    const { openModal, Toast, Swal, formatoFecha } = useHelper();
    const {
        creditos, credito, obtenerCreditosEstadoAgencia, obtenerCredito,
    } = useCredito();
    const {
    respuesta, agregarEvaluacion, errors
    } = useEvaluacion();
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 50
    });
    const dato2=ref({
        'estado' : '',
        'agencia_id' : '',
    })
    const form = ref({
        id: '',
        dni: '',
        apenom: '',
        credito_id : '',
        usuario_id : '',
        resultado : '',
        fechahora : formatoFecha(null,"YYYY-MM-DD HH:mm:ss"),
        plazo:'',
        producto : '',
        monto: '',
        comentario : '',
        tasainteres : '',
        medioorigen : '',
        tiposolicitud : '',
        vigentes:[],
        cantvigentes:0,
        total: '',
        errors: []
    });
    const limpiar=()=>{
        form.value.id = '';
        form.value.dni = '';
        form.value.apenom = '';
        form.value.credito_id = '';
        form.value.usuario_id = usuario.value.id;
        form.value.resultado = '';
        form.value.fechahora = formatoFecha(null,"YYYY-MM-DD HH:mm:ss");
        form.value.plazo = '';
        form.value.producto = '';
        form.value.monto = '';
        form.value.comentario = '';
        form.value.tasainteres = '';
        form.value.medioorigen = '';
        form.value.tiposolicitud = '';
        form.value.vigentes= [];
        form.value.cantvigentes = 0,
        form.value.total = '';
        form.value.errors = [];
    }
const calcularTotal=()=>{
    const tasas = {
        'CREDI-6': 6,
        'CREDI-6/CREDI-INVERSION': 6,
        'CREDI-INVERSION': 7,
        'RECAUDADO': 7
    };
    let tasaInteres = tasas[form.value.producto] || 9;
    if (form.value.producto === 'CONFIO EN TI' || form.value.plazo === 20) {
        tasaInteres = 6;
    }
    form.value.tasainteres = tasaInteres;
    const monto = parseFloat(form.value.monto) || 0;
    const tasaDecimal = parseFloat(tasaInteres) / 100;
    form.value.monto=monto
    form.value.total = (monto * (1 + tasaDecimal)).toFixed(2);
}
const obtenerDatos = async(id)=>{
    limpiar()
    await obtenerCredito(id);
    if (credito.value) {
        form.value.credito_id = credito.value.id
        form.value.dni=credito.value.cliente.persona.dni
        form.value.apenom=credito.value.cliente.persona.apenom
        form.value.producto = credito.value.producto
        form.value.monto = credito.value.monto
        form.value.plazo = credito.value.plazo
        form.value.medioorigen = credito.value.medioorigen
        form.value.tiposolicitud = credito.value.tipo
        form.value.vigentes = credito.value.cliente.creditos
        form.value.cantvigentes = credito.value.cliente.creditos.length
    }
}
const enviarRegistro=async()=>{
    await agregarEvaluacion(form.value);
    if (errors.value) {
        form.value.errors = errors.value;
    }
    if (respuesta.value.ok == 1) {
        form.value.errors = [];
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: respuesta.value.mensaje,
            showConfirmButton: false,
            timer: 1500
        });
    }    
}
const aprobar = async(id) => {
    await obtenerDatos(id)      
    calcularTotal()
    await Swal.fire({
        title: '¿Estás seguro de aprobar este crédito?',
        text: `Recuerda que el monto es de S/. ${credito.value.monto}, la tasa de interés es de ${form.value.tasainteres}, y el total a pagar será de S/. ${form.value.total}.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, aprobar crédito',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.value.resultado = 'APROBADO';
            enviarRegistro();
        }
    });
    listarCreditos()
};

const aprobarTodos = () => {
    Swal.fire({
        title: '¿Estás seguro de aprobar todos los créditos?',
        text: `Recuerda que se aprobarán todos los créditos de la lista.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, aprobar créditos',
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            for (const credito of creditos.value.data) { // <-- Usamos `for...of`
                await aprobar(credito.id)
            }
        }
    });
};
const esActivodiv=ref(false);
const activarDiv=()=>{
    esActivodiv.value=!esActivodiv.value
}

    const listarCreditos = async(page=1) => {
        dato.value.page= page
        dato2.value.estado='EVALUACION'
        await obtenerCreditosEstadoAgencia(dato.value, dato2.value)
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
    const evaluar = async(id)=>{
        esActivodiv.value=false
        await obtenerDatos(id)
        calcularTotal()
        openModal('#modalevaluacion')
        document.getElementById("modalevaluacionLabel").innerHTML = 'Evaluacion Credito';
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
        dato2.value.agencia_id=agencia.value ? agencia.value.id : '0'
        listarCreditos()
    })
</script>
<template>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Creditos a Evaluar
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 mb-1">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">Mostrar</span>
                            <select class="form-select"  v-model="dato.paginacion" @change="cambiarPaginacion">
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="100">200</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
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
                    <div class="col-md-2 mb-1">
                        <button  type="button" class="btn btn-danger" @click.prevent="aprobarTodos">
                            <i class="fa-solid fa-check-double"></i> Aprobar a Todos
                        </button>                        
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
                                        <th>Plazo</th>
                                        <th>Fecha</th>
                                        <th>Frecuencia</th>
                                        <th>Tipo</th>
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
                                        <td>{{ credito.plazo }}</td>
                                        <td>{{ credito.fecha_reg }}</td>
                                        <td>{{ credito.frecuencia }}</td>
                                        <td>{{ credito.tipo }}</td>
                                        <td>{{ credito.asesor.name }}</td>
                                        <td>{{ credito.agencia.nombre }}</td>
                                        <td>{{ credito.estado }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm" style="font-size: .65rem;" title="Evaluar" @click.prevent="evaluar(credito.id)">
                                                <i class="fa-solid fa-file-circle-check"></i>
                                            </button>&nbsp;
                                            <button class="btn btn-success btn-sm" style="font-size: .65rem;" title="Aprobar" @click.prevent="aprobar(credito.id)">
                                                <i class="fa-solid fa-money-check-alt"></i>
                                            </button>&nbsp;

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
    <EvaluacionForm 
    @calcularTotal="calcularTotal"
    @activarDiv="activarDiv"
    @limpiar="limpiar"
    @onListar="listarCreditos"
    @enviarRegistro="enviarRegistro"
    :esActivodiv="esActivodiv"
    :form="form" 
    :currentPage="creditos.current_page"
    ></EvaluacionForm>

</template>