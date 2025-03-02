<script setup>
  import { ref, onMounted, toRefs } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers'; 
  import useCredito from '@/Composables/Credito.js';
  import DesembolsoForm from './Form.vue'
  import useEvaluacion from '@/Composables/Evaluacion.js';
  import useDesembolso from '@/Composables/Desembolso.js';
    const props = defineProps({
        agencia: Object,
        role: Object,
        usuario: Object,
    });
    const {
        obtenerDescuentos, descuentos
    } = useDesembolso();
    const { agencia, usuario } = toRefs(props);
    const { openModal, Toast, Swal, formatoFecha } = useHelper();
    const {
        credito, creditos, obtenerCreditosEstadoAgencia, obtenerCredito,
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
        credito_id : '',
        fecha : formatoFecha(null,"YYYY-MM-DD"),
        hora : formatoFecha(null,"HH:mm:ss"),
        fechahora : formatoFecha(null,"YYYY-MM-DD HH:mm:ss"),
        usuario_id : usuario.value.id,
        agencia_id : agencia.value ? agencia.value.id : 1,
        descontado : 0,
        totalentregado : 0,
        dni: '',
        apenom: '',
        plazo:'',
        apenom:'',
        frecuencia: '',
        producto : '',
        monto: '',
        medioorigen : '',
        tiposolicitud : '',
        tasainteres : '',
        resultado:'',
        comentario:'',
        rcsdebe:'',//si debe recurrente con saldo
        costomora: 0,
        dondepagara : '',
        totalentregar: 0,
        total: 0,
        asesor:'',
        asesor_id: '',
        vigentes:[],
        errors: []
    });
    const limpiar=()=>{
        form.value.credito_id = '',
        form.value.fecha = formatoFecha(null,"YYYY-MM-DD");
        form.value.hora = formatoFecha(null,"HH:mm:ss");
        form.value.usuario_id = usuario.value.id,
        form.value.descontado = 0,
        form.value.totalentregado = 0,
        form.value.apenom=''
        form.value.dni = '';
        form.value.apenom = '';
        form.value.plazo = '';
        form.value.frecuencia = '';
        form.value.producto = '';
        form.value.medioorigen = '';
        form.value.tiposolicitud = '';
        form.value.agencia_id = agencia.value ? agencia.value.id : 1;
        form.value.dondepagara = '';
        form.value.total = 0;
        form.value.costomora = 0;
        form.value.tasainteres = '';
        form.value.resultado = '';
        form.value.comentario = '';
        form.value.rcsdebe = '';
        form.value.totalentregar = 0;
        form.value.asesor=''
        form.value.foto='/storage/fotos/default.png',
        form.value.errors = []
        form.value.vigentes = []
    }
    const desembolsar=(id)=>{
        obtenerDatos(id)
        openModal('#modalextorno')
        document.getElementById("modalextornoLabel").innerHTML = 'Extornar';
    }
    const solicitarMotivo = async (tipo) => {
        const result = await Swal.fire({
            title: `${tipo} : \nSolicitud ID: ${form.value.credito_id}\nIngrese el motivo`,
            input: "text",
            inputAttributes: {
                autocapitalize: "off",
                autofocus: "true",
                class: "form-control"
            },
            showCancelButton: true,
            confirmButtonText: "Enviar",
            cancelButtonText: "Cancelar",
            showLoaderOnConfirm: true,
            preConfirm: (motivo) => {
                const input = Swal.getInput();
                if (!motivo) {
                    Swal.showValidationMessage(
                        `<div class="text-danger fw-bold">Debe ingresar un motivo.</div>`
                    );
                    if (input) {
                        input.classList.add("is-invalid");
                    }
                    return false;
                }
                if (input) {
                    input.classList.remove("is-invalid");
                }
                return motivo;
            },
            allowOutsideClick: () => !Swal.isLoading(),
            didOpen: () => {
                const input = Swal.getInput();
                if (input) {
                    input.addEventListener("input", () => {
                        input.classList.remove("is-invalid");
                    });
                }
            }
        });
        if (result.isConfirmed) {
            return result.value;
        }
        return null;
    };
    const data=ref({
        credito_id:'',
        monto:'',
        tipo : '',
        producto : '',
    })
    const obtenerDatos = async(id)=>{
        limpiar()
        await obtenerCredito(id);
        if (credito.value) {
            form.value.credito_id = credito.value.id
            form.value.dni=credito.value.cliente.persona.dni
            form.value.apenom=credito.value.cliente.persona.apenom
            form.value.apenom=credito.value.cliente.persona.apenom
            form.value.producto = credito.value.producto
            form.value.monto = credito.value.monto
            form.value.plazo = credito.value.plazo
            form.value.frecuencia = credito.value.frecuencia
            form.value.medioorigen = credito.value.medioorigen
            form.value.tiposolicitud = credito.value.tipo
            form.value.tasainteres = credito.value.tasainteres
            form.value.dondepagara = credito.value.dondepagara
            form.value.vigentes = credito.value.cliente.creditos
            form.value.costomora = credito.value.moradiaria
            form.value.total = credito.value.total
            form.value.asesor = credito.value.asesor.name
            form.value.asesor_id = credito.value.asesor.id
            form.value.foto='/storage/fotos/usuarios/'+usuario.value.name+'.webp';
            data.value.credito_id = form.value.credito_id
            data.value.monto = form.value.monto
            data.value.tipo = form.value.tiposolicitud
            data.value.producto = form.value.producto
            await obtenerDescuentos(data.value)
            form.value.rcsdebe = descuentos.value.estado
            form.value.descontado=descuentos.value.deudatotal
            form.value.totalentregar=Number(form.value.monto)-Number(form.value.descontado)
        }
    }

    const listarCreditos = async(page=1) => {
        dato.value.page= page
        dato2.value.estado='DESEMBOLSADO'
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
                    Desembolsos a Extornar
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
                                    <a href="#" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="creditos.current_page > 1" class="page-item">
                                    <a href="#" class="page-link"
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
                                    <a href="#" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(creditos.current_page + 1)">
                                        <span><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="creditos.current_page <= creditos.last_page-1" class="page-item">
                                    <a href="#" class="page-link"
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
                                        <th colspan="15" class="text-center">Creditos</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Cod</th>
                                        <th>DNI</th>
                                        <th>Apellidos y Nombres</th>
                                        <th>Monto</th>
                                        <th>Tasa</th>
                                        <th>Plazo</th>
                                        <th>Tipo</th>
                                        <th>Fecha</th>
                                        <th>Frecuencia</th>
                                        <th>Total</th>
                                        <th>Asesor</th>
                                        <th>Agencia</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="creditos.total == 0">
                                        <td class="text-danger text-center" colspan="15">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(credito,index) in creditos.data" :key="credito.id">
                                        <td>{{ index + creditos.from }}</td>
                                        <td>{{ credito.id }}</td>
                                        <td>{{ credito.cliente.persona.dni }}</td>
                                        <td>{{ credito.cliente.persona.apenom }}</td>
                                        <td>{{ 'S/. ' + credito.monto }}</td>
                                        <td>{{ credito.tasainteres + '%' }}</td>
                                        <td>{{ credito.plazo }}</td>
                                        <td>{{ credito.tipo }}</td>
                                        <td>{{ credito.fecha_reg }}</td>
                                        <td>{{ credito.frecuencia }}</td>
                                        <td>{{ 'S/. ' + credito.total }}</td>
                                        <td>{{ credito.asesor.name }}</td>
                                        <td>{{ credito.agencia.nombre }}</td>
                                        <td>{{ credito.estado }}</td>
                                        <td>
                                            <button class="btn btn-success btn-sm" style="font-size: .65rem;" title="Realizar Extorno" @click.prevent="desembolsar(credito.id)">
                                                <i class="fas fa-undo-alt"></i>
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
                                    <a href="#" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="creditos.current_page > 1" class="page-item">
                                    <a href="#" class="page-link"
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
                                    <a href="#" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(creditos.current_page + 1)">
                                        <span><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="creditos.current_page <= creditos.last_page-1" class="page-item">
                                    <a href="#" class="page-link"
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
<DesembolsoForm
:form="form"
:descuentos="descuentos"
@observar="observar"
@obtenerDatos="obtenerDatos"
@onListar="listarCreditos"></DesembolsoForm>
</template>