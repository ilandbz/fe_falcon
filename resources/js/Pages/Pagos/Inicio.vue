<script setup>
  import { ref, onMounted } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import useCredito from '@/Composables/Credito.js';
  import CreditoForm from './Form.vue'
  import useDatosSession from '@/Composables/session';
  const { agencia } = useDatosSession();
    const { openModal, Toast, Swal } = useHelper();
    const {
        creditos, errors, credito, respuesta,
        obtenerCreditos, obtenerCredito, eliminarCredito
        
    } = useCredito();
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 10
    });
    const form = ref({
        id: '',
        dni:'',
        ape_pat:'',
        ape_mat:'',
        primernombre:'',
        otrosnombres:'',
        fecha_nac:'',
        ubigeo:'',
        email:'',
        celular:'',
        genero:'',
        estado_civil:'',
        ruc:'',
        agencia_id: agencia.value?.id,
        foto : '/storage/fotos/default.png',
        conyugue_id: '',
        aval_id: '',
        grado_instr: '',
        profesion:'',
        usuario_id: '',
        dniconyugue: '',
        dniaval:'',
        tipo_trabajador: '',
        ocupacion: '',
        institucion_lab: '',
        tipodomicilio: '',
        ubigeodomicilio: '',
        tipovia:'',
        nombrevia:'',
        nro:'',
        interior:'',
        mz:'',
        lote:'',
        tipozona:'',
        nombrezona: '',
        referencia:'',
        latitud_longitud:'',
        estado: 'REGISTRADO',
        fecha_reg: '',
        hora_reg: '',
        estadoCrud: '',
        errors: []
    });
    const limpiar = () => {
        form.value.id = '';
        form.value.dni = '';
        form.value.ape_pat = '';
        form.value.ape_mat = '';
        form.value.primernombre = '';
        form.value.otrosnombres = '';
        form.value.fecha_nac = '';
        form.value.ubigeo = '';
        form.value.agencia_id = agencia.value?.id;
        form.value.usuario_id = '';
        form.value.conyugue_id = '';
        form.value.aval_id = '';
        form.value.dniaval = '';
        form.value.dniconyugue = '';
        form.value.estado = 'REGISTRADO';
        form.value.fecha_reg = '';
        form.value.hora_reg = '';
        form.value.estadoCrud = '';
        form.value.errors = [];
        errors.value = [];
    };
    const obtenerDatos = async (id) => {
        await obtenerCredito(id);
        if (credito.value) {
            form.value.id = credito.value.id;
            form.value.ape_pat=credito.value.persona.ape_pat;
            form.value.ape_mat=credito.value.persona.ape_mat;
            form.value.primernombre=credito.value.persona.primernombre;
            form.value.otrosnombres=credito.value.persona.otrosnombres;
            form.value.fecha_nac=credito.value.persona.fecha_nac;
            form.value.agencia_id = credito.value.agencia_id;
            form.value.usuario_id = credito.value.usuario_id;
            form.value.persona_id = credito.value.persona_id;
            form.value.dniaval = credito.value.dniaval;
            form.value.estado = credito.value.estado;
            form.value.fecha_reg = credito.value.fecha_reg;
            form.value.hora_reg = credito.value.hora_reg;
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
    const listarCreditos = async(page=1) => {
        dato.value.page= page
        await obtenerCreditos(dato.value)
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
                    Listado de Creditos
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
                                        <span ><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="creditos.current_page <= creditos.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(creditos.last_page)"
                                        title="Última Página">
                                        <span ><i class="fas fa-step-forward"></i></span>
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
                                        <th colspan="11" class="text-center">Creditos</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Cod</th>
                                        <th>DNI</th>
                                        <th>Apellidos y Nombres</th>
                                        <th>Monto</th>
                                        <th>Plazo</th>
                                        <th>Frecuencia</th>
                                        <th>Asesor</th>
                                        <th>Agencia</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="creditos.total == 0">
                                        <td class="text-danger text-center" colspan="11">
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
                                        <td>{{ credito.frecuencia }}</td>
                                        <td>{{ credito.asesor.name }}</td>
                                        <td>{{ credito.agencia.nombre }}</td>
                                        <td>{{ credito.estado }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" title="Editar" @click.prevent="editar(credito.id)">
                                                <i class="fas fa-edit"></i>
                                            </button>&nbsp;
                                            <button class="btn btn-danger btn-sm" title="Enviar a Papelera" @click.prevent="eliminar(credito.id, 'Temporal')">
                                                <i class="fas fa-trash"></i>
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
                                        <span ><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="creditos.current_page <= creditos.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(creditos.last_page)"
                                        title="Última Página">
                                        <span ><i class="fas fa-step-forward"></i></span>
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
    <creditoForm :form="form" @onListar="listarCreditos" :currentPage="creditos.current_page"></creditoForm>
</template>