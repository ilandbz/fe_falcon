<script setup>
  import { ref, onMounted } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import useAgencia from '@/Composables/Agencia.js';
  import AgenciaForm from './Form.vue'
  const { openModal, Toast, Swal } = useHelper();
  const {
        agencias, errors, agencia, respuesta,
        obtenerAgencias, obtenerAgencia, eliminarAgencia
        
    } = useAgencia();
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 10
    });
    const form = ref({
        id:'',
        nombre : '',
        slug : '',
        icono : '',
        padre_id : '',
        grupo_id : '',
        orden : '',  
        estadoCrud:'',
        errors:[]

    });
    const limpiar = ()=> {
        form.value.id='',
        form.value.nombre='',
        form.value.slug='',
        form.value.icono='',
        form.value.padre_id='',
        form.value.grupo_id='',
        form.value.orden= '',
        form.value.estadoCrud = '',          
        form.value.errors = []
        errors.value = []
    }
    const obtenerDatos = async(id) => {
        await obtenerAgencia(id);
        if(agencia.value)
        {
            form.value.id=agencia.value.id;
            form.value.nombre=agencia.value.nombre;
            form.value.slug=agencia.value.slug;
            form.value.icono=agencia.value.icono;
            form.value.grupo_id=agencia.value.grupo_id;
            form.value.padre_id=agencia.value.padre_id;
            form.value.orden= agencia.value.orden;  
        }
    }
    const editar = (id) => {
        limpiar();
        obtenerDatos(id)
        form.value.estadoCrud = 'editar'
        document.getElementById("modalagenciaLabel").innerHTML = 'Editar Agencia';
        openModal('#modalagencia')
    }
    const nuevo = () => {
        limpiar()
        form.value.estadoCrud = 'nuevo'
        openModal('#modalagencia')
        document.getElementById("modalagenciaLabel").innerHTML = 'Nuevo Agencia';
        //titulo.textContent = 'Editar Datos Personales';
    }
    const listarAgencias = async(page=1) => {
        dato.value.page= page
        await obtenerAgencias(dato.value)
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
        await eliminarAgencia(id)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            listarAgencias(agencias.value.current_page)
        }
    }
    // PAGINACION
    const isActived = () => {
        return agencias.value.current_page
    }
    const offset = 2;

    const buscar = () => {
        listarAgencias()
    }
    const cambiarPaginacion = () => {
        listarAgencias()
    }
    const cambiarPagina =(pagina) => {
        listarAgencias(pagina)
    }
    const pagesNumber = () => {
        if(!agencias.value.to){
            return []
        }
        let from = agencias.value.current_page - offset
        if(from < 1) from = 1
        let to = from + (offset*2)
        if( to >= agencias.value.last_page) to = agencias.value.last_page
        let pagesArray = []
        while(from <= to) {
            pagesArray.push(from)
            from ++
        }
        return pagesArray
    }
    // CARGA
    onMounted(() => {
        listarAgencias()
    })
</script>
<template>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Listado de agencias
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
                            <input class="form-control" placeholder="Ingrese nombre, código ciiu" type="text" v-model="dato.buscar"
                                @change="buscar" />
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <nav>
                            <ul class="pagination">
                                <li v-if="agencias.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="agencias.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(agencias.current_page - 1)">
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
                                <li v-if="agencias.current_page < agencias.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(agencias.current_page + 1)">
                                        <span ><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="agencias.current_page <= agencias.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(agencias.last_page)"
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
                            <table class="table table-bordered table-hover table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="8" class="text-center">agencias</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="agencias.total == 0">
                                        <td class="text-danger text-center" colspan="7">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(agencia,index) in agencias.data" :key="agencia.id">
                                        <td>{{ index + agencias.from }}</td>
                                        <td>{{ agencia.nombre }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" title="Editar" @click.prevent="editar(agencia.id)">
                                                <i class="fas fa-edit"></i>
                                            </button>&nbsp;
                                            <button class="btn btn-danger btn-sm" title="Enviar a Papelera" @click.prevent="eliminar(agencia.id, 'Temporal')">
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
                        Mostrando <b>{{agencias.from}}</b> a <b>{{ agencias.to }}</b> de <b>{{ agencias.total}}</b> Registros
                    </div>
                    <div class="col-md-7 mb-1 text-right">
                        <nav>
                            <ul class="pagination">
                                <li v-if="agencias.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="agencias.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(agencias.current_page - 1)">

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
                                <li v-if="agencias.current_page < agencias.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(agencias.current_page + 1)">
                                        <span ><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="agencias.current_page <= agencias.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(agencias.last_page)"
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
    <AgenciaForm :form="form" @onListar="listarAgencias" :currentPage="agencias.current_page"></AgenciaForm>
</template>