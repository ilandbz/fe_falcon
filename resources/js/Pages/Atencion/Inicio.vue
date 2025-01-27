<script setup>
  import { ref, onMounted } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import useAtencion from '@/Composables/Atencion.js';
  import useDiagnostico from '@/Composables/Diagnostico.js';
  import DetAtencionForm from './DetAtencion.vue'
  import downloadexcel from "vue-json-excel3";
  const { openModal, Toast, Swal, formatoFecha, meses } = useHelper();
  const {
        atenciones, errors, atencion, respuesta,
        obtenerAtenciones, obtenerAtencion, eliminarAtencion,
        listaMedicamentos, medicamentos, listaInsumos, insumos, listaProcedimientos, procedimientos, 
        digitadores, listaDigitadores, listaProfesionales, profesionales
    } = useAtencion();
  const {
        listaDiagnosticosByAtencion, diagnosticos
    } = useDiagnostico();    
    const titleHeader = ref({
      titulo: "Atenciones",
      subTitulo: "Inicio",
      icon: "",
      vista: ""
    });
    const anhoactual=formatoFecha(null,"YYYY");
    const LoadState=ref(false);
    const dato = ref({
        page:'',
        anho:anhoactual,
        mes:formatoFecha(null,"MM"),
        digitador:'',
        responsable: '',
        buscar:'',
        paginacion: 20,
        errors:[]
    });
    const json_fields = ref({
        "FUA": "fua",
        "Fecha Atención": "fecha_atencion",
        "Servicio": "servicio",
        "Tipo Atención": "tipo_atencion",
        "Documento Paciente": "nro_documento",
        "Nombre Completo": "nombre_completo",
        "DNI Profesional": "dni_profesional",
        "Apellidos y Nombres Profesional": "apenom_profesional",
        "Colegiatura Profesional": "col_profesional",
        "Digitador": "user",
        "Fecha Transacción": "fechatrans",
        "Hora Digitalización": "hora_digitalizacion",
        "Costo Total (S/.)": "costo_total"
    }) 
    const exportarData=async()=>{
        const { paginacion } = dato.value;
        dato.value.paginacion = 0; 
        await obtenerAtenciones(dato.value);
        dato.value.paginacion = paginacion;
        return atenciones.value;
    }
    let timerInterval;
    const startDownload=()=>{
        Swal.fire({
            title: "Cargando!",
            html: "Se cerrara automaticamente",
            timer: 25000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
                timerInterval = setInterval(() => {
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            }
            }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log("Sera cerrado");
            }
        });
    }
    const finishDownload=()=>{
        clearInterval(timerInterval);
        Toast.fire({icon:'success', title:'Terminado'})
    }
    const form = ref({
        id: '',
        codigo: '',
        lote: '',
        numero: '',
        establecimiento_id: '',
        componente_id: '',
        tipo_formato_id: '',
        disaformato: '',
        lote_formato: '',
        nro_formato: '',
        paciente: '',
        tipo_atencion_id: '',
        condicion_materna_id: '',
        modalidad_atencion_id: '',
        fecha_atencion: '',
        hora_atencion: '',
        codigo_historia_clinica: '',
        estadoCrud: '',
        errors: []
    });
    const limpiar = () => {
        form.value.id = '';
        form.value.codigo = '';
        form.value.lote = '';
        form.value.numero = '';
        form.value.establecimiento_id = '';
        form.value.componente_id = '';
        form.value.tipo_formato_id = '';
        form.value.disaformato = '';
        form.value.lote_formato = '';
        form.value.nro_formato = '';
        form.value.paciente = '';
        form.value.tipo_atencion_id = '';
        form.value.condicion_materna_id = '';
        form.value.modalidad_atencion_id = '';
        form.value.fecha_atencion = '';
        form.value.hora_atencion = '';
        form.value.codigo_historia_clinica = '';
        form.value.estadoCrud = '';
        form.value.errors = [];
        errors.value = [];
    };
    const obtenerDatos = async(id) => {
        await obtenerAtencion(id);
        if(atencion.value)
        {
            form.value.id = atencion.value.id;
            form.value.codigo = atencion.value.codigo;
            form.value.lote = atencion.value.lote;
            form.value.numero = atencion.value.numero;
            form.value.establecimiento_id = atencion.value.establecimiento_id;
            form.value.componente_id = atencion.value.componente_id;
            form.value.tipo_formato_id = atencion.value.tipo_formato_id;
            form.value.disaformato = atencion.value.disaformato;
            form.value.lote_formato = atencion.value.lote_formato;
            form.value.nro_formato = atencion.value.nro_formato;
            form.value.paciente = atencion.value.paciente;
            form.value.tipo_atencion_id = atencion.value.tipo_atencion_id;
            form.value.condicion_materna_id = atencion.value.condicion_materna_id;
            form.value.modalidad_atencion_id = atencion.value.modalidad_atencion_id;
            form.value.fecha_atencion = atencion.value.fecha_atencion;
            form.value.hora_atencion = atencion.value.hora_atencion;
            form.value.codigo_historia_clinica = atencion.value.codigo_historia_clinica;
        }
    }
    const cargarDiagnosticos = async(id)=>{
        await listaDiagnosticosByAtencion(id)
        await listaMedicamentos(id)
        await listaInsumos(id)
        await listaProcedimientos(id)
    }
    const ver = (id)=>{
        limpiar();
        obtenerDatos(id)
        cargarDiagnosticos(id)
        form.value.estadoCrud = 'show'
        document.getElementById("modalatencionLabel").innerHTML = 'Ver Detalles';
        openModal('#modalatencion')     
    }
    const editar = (id) => {
        limpiar();
        obtenerDatos(id)
        form.value.estadoCrud = 'editar'
        document.getElementById("modalatencionLabel").innerHTML = 'Editar Rol';
        openModal('#modalatencion')
    }
    const nuevo = () => {
        limpiar()
        form.value.estadoCrud = 'nuevo'
        openModal('#modalatencion')
        document.getElementById("modalatencionLabel").innerHTML = 'Nuevo Rol';
    }
    const total = ref(0)
    const listarAtenciones = async(page=1) => {
        dato.value.page= page
        LoadState.value=true
        await obtenerAtenciones(dato.value)
        LoadState.value=false
        total.value = atenciones.value.data.reduce((sum, atencion) => sum + parseFloat(atencion.costo_total || 0), 0);
    }
    const listarDigitadores = async()=>{
        await listaDigitadores()
    }
    const listarProfesionales = async()=>{
        await listaProfesionales()
    }
    const elimina = async(id) => {
        await eliminarAtencion(id)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            listarAtenciones(atenciones.value.current_page)
        }
    }
    // PAGINACION
    const isActived = () => {
        return atenciones.value.current_page
    }
    const offset = 2;
    const buscar = () => {
        listarAtenciones()
    }
    const cambiarPaginacion = () => {
        listarAtenciones()
    }
    const cambiarPagina =(pagina) => {
        listarAtenciones(pagina)
    }
    const pagesNumber = () => {
        if(!atenciones.value.to){
            return []
        }
        let from = atenciones.value.current_page - offset
        if(from < 1) from = 1
        let to = from + (offset*2)
        if( to >= atenciones.value.last_page) to = atenciones.value.last_page
        let pagesArray = []
        while(from <= to) {
            pagesArray.push(from)
            from ++
        }
        return pagesArray
    }
    // CARGA
    onMounted(() => {
        defineTitle(titleHeader.value.titulo)
        listarAtenciones()
        listarDigitadores()
        listarProfesionales()
    })
</script>
<style>
  /* Aplica bordes solo al segundo <tr> */
  .table thead tr:nth-child(2) {
      border: 2px solid white; /* Cambia el grosor y color del borde según necesites */
  }
  
  /* Aplicar bordes también a los <th> dentro del segundo <tr> */
  .table thead tr:nth-child(2) th {
      border: 2px solid white; /* Cambia el grosor y color del borde según prefieras */
  }
</style>
<template>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Listado de atenciones
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 mb-1">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">Paginacion</span>
                            <select class="form-select"  v-model="dato.paginacion" @change="cambiarPaginacion">
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
                            <input class="form-control" placeholder="Nombres o Fua" type="text" v-model="dato.buscar"
                                @change="buscar" />
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <nav>
                            <ul class="pagination">
                                <li v-if="atenciones.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="atenciones.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(atenciones.current_page - 1)">
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
                                <li v-if="atenciones.current_page < atenciones.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(atenciones.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="atenciones.current_page <= atenciones.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(atenciones.last_page)"
                                        title="Última Página">
                                        <span aria-hidden="true"><i class="fas fa-step-forward"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label for="" class="form-label">Año</label>
                        <select v-model="dato.anho" class="form-select" :class="{ 'is-invalid': dato.errors.anho }" @change="buscar">
                            <option v-for="(i, n) in 5" :key="i" :value="anhoactual - n">
                                {{ anhoactual - n }}
                            </option>
                        </select>
                        <small class="text-danger" v-for="error in dato.errors.anho" :key="error">{{ error
                                }}<br></small>
                    </div>
                    <div class="col-md-2">
                        <label for="" class="form-label">Mes</label>
                        <select v-model="dato.mes" class="form-select" :class="{ 'is-invalid': dato.errors.mes }" @change="buscar">
                            <option v-for="mes in meses" :key="mes.numero" :value="mes.numero">
                                {{ mes.nombre }}
                            </option>
                        </select>
                        <small class="text-danger" v-for="error in dato.errors.mes" :key="error">{{ error
                                }}<br></small>
                    </div>
                    <div class="col-md-2">
                        <label for="" class="form-label">Digitador</label>
                        <select v-model="dato.digitador" class="form-select" :class="{ 'is-invalid': dato.errors.digitador }" @change="buscar">
                            <option value="">Todos</option>
                            <option v-for="digitador in digitadores" :key="digitador.id" :value="digitador.id">
                                {{ digitador.primer_nombre+' '+digitador.ape_paterno }}
                            </option>
                        </select>
                        <small class="text-danger" v-for="error in dato.errors.digitador" :key="error">{{ error
                                }}<br></small>
                    </div>
                    <div class="col-md-2">
                        <label for="" class="form-label">Responable Medico</label>
                        <select v-model="dato.responsable" class="form-select" :class="{ 'is-invalid': dato.errors.responsable }" @change="buscar">
                            <option value="">Todos</option>
                            <option v-for="profesional in profesionales" :key="profesional.id" :value="profesional.id">
                                {{ profesional.descripcion }}
                            </option>
                        </select>
                        <small class="text-danger" v-for="error in dato.errors.digitador" :key="error">{{ error
                                }}<br></small>
                    </div>
                    <div class="col-md-3 mb-4">
                        <br>
                        <button class="btn btn-primary" @click="buscar()"><i class="fas fa-search"></i> Buscar</button>&nbsp;
                        <downloadexcel
                            class            = "btn btn-success"
                            :fetch           = "exportarData"
                            :fields          = "json_fields"
                            :before-generate = "startDownload"
                            :before-finish   = "finishDownload">
                            Descargar <i class="fas fa-file-excel"></i>
                        </downloadexcel>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped small">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="15" class="text-center">Atenciones</th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class="text-center"></th>
                                        <th colspan="2" class="text-center">Paciente</th>
                                        <th colspan="3" class="text-center">Medico</th>
                                        <th colspan="4" class="text-center">Digitacion</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Fua</th>
                                        <th>Fecha de Atencion</th>
                                        <th>Servicio</th>
                                        <th>Tipo Atencion</th>
                                        <th>DNI</th>
                                        <th>ApeNom</th>
                                        <th>DNI</th>
                                        <th>Apenom</th>
                                        <th>RESP. Coleg.</th>
                                        <th>Digitador</th>
                                        <th>Fecha Digitacion</th>
                                        <th>Hora Digitacion</th>
                                        <th>Costo Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="atenciones.total == 0">
                                        <td class="text-danger text-center" colspan="12">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else-if="LoadState==true">
                                        <td colspan="13" class="text-center">
                                            <br>
                                            <div class="tab-pane preview-tab-pane active" role="tabpanel">
                                                <div class="spinner-border text-warning" role="status"><span class="visually-hidden">Loading...</span></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(atencion,index) in atenciones.data" :key="atencion.id">
                                        <td class="small p-1">{{ index + atenciones.from }}</td>
                                        <td class="small p-1">{{ atencion.fua }}</td>
                                        <td class="small p-1">{{ atencion.fecha_atencion }}</td>
                                        <td class="small p-1">{{ atencion.servicio }}</td>
                                        <td class="small p-1">{{ atencion.tipo_atencion }}</td>
                                        <td class="small p-1">{{ atencion.nro_documento }}</td>
                                        <td class="small p-1">{{ atencion.nombre_completo }}</td>
                                        <td class="small p-1">{{ atencion.dni_profesional }}</td>
                                        <td class="small p-1">{{ atencion.apenom_profesional }}</td>
                                        <td class="small p-1">{{ atencion.col_profesional }}</td>
                                        <td class="small p-1">{{ atencion.user }}</td>
                                        <td class="small p-1">{{ atencion.fechatrans }}</td>
                                        <td class="small p-1">{{ atencion.hora_digitalizacion }}</td>
                                        <td class="small p-1">{{ atencion.costo_total }}</td>
                                        <td class="small p-1">
                                            <button class="btn btn-dark btn-sm" title="Ver Detalles" @click.prevent="ver(atencion.id)">
                                                <i class="fas fa-eye"></i>
                                            </button>&nbsp;
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="13" class="text-end fw-bold">Total Costo:</td>
                                        <td class="small p-1 fw-bold">S/.{{ total.toFixed(2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-1">
                        Mostrando <b>{{atenciones.from}}</b> a <b>{{ atenciones.to }}</b> de <b>{{ atenciones.total}}</b> Registros
                    </div>
                    <div class="col-md-7 mb-1 text-right">
                        <nav>
                            <ul class="pagination">
                                <li v-if="atenciones.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="atenciones.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(atenciones.current_page - 1)">

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
                                <li v-if="atenciones.current_page < atenciones.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(atenciones.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="atenciones.current_page <= atenciones.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(atenciones.last_page)"
                                        title="Última Página">
                                        <span aria-hidden="true"><i class="fas fa-step-forward"></i></span>
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
    <DetAtencionForm :atencion="form" :diagnosticos="diagnosticos" :medicamentos="medicamentos" :insumos="insumos" :procedimientos="procedimientos"></DetAtencionForm>
</template>