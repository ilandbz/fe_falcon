<script setup>
  import { ref, onMounted } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import useGrupoMenu from '@/Composables/GrupoMenu.js';
  import GrupoForm from './Form.vue'
  const { openModal, Toast, Swal } = useHelper();
  const {
        grupos, errors, grupo, respuesta,
        obtenerGrupos, obtenerGrupo, eliminarGrupo
        
    } = useGrupoMenu();
    const titleHeader = ref({
      titulo: "Grupo Menu",
      subTitulo: "Inicio",
      icon: "",
      vista: ""
    });
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 10
    });
    const form = ref({
        id:'',
        titulo : '',
        estadoCrud:'',
        errors:[]

    });
    const limpiar = ()=> {
        form.value.id='',
        form.value.titulo='',
        form.value.estadoCrud = '',          
        form.value.errors = []
        errors.value = []
    }
    const obtenerDatos = async(id) => {
        await obtenerGrupo(id);
        if(grupo.value)
        {
            form.value.id=grupo.value.id;
            form.value.titulo=grupo.value.titulo;
        }
    }
    const editar = (id) => {
        limpiar();
        obtenerDatos(id)
        form.value.estadoCrud = 'editar'
        document.getElementById("modalGrupoLabel").innerHTML = 'Editar Grupo Menu';
        openModal('#modalGrupo')
    }
    const nuevo = () => {
        limpiar()
        form.value.estadoCrud = 'nuevo'
        openModal('#modalGrupo')
        document.getElementById("modalGrupoLabel").innerHTML = 'Nuevo Grupo Menu';
        //titulo.textContent = 'Editar Datos Personales';
    }
    const listarGrupos = async(page=1) => {
        dato.value.page= page
        await obtenerGrupos(dato.value)
    }
    const eliminar = (id) => {
        Swal.fire({
            title: '¿Estás seguro de Eliminar?',
            text: "Grupo Menu",
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
        await eliminarGrupo(id)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            listarGrupos(grupos.value.current_page)
        }
    }
    // PAGINACION
    const isActived = () => {
        return grupos.value.current_page
    }
    const offset = 2;

    const buscar = () => {
        listarGrupos()
    }
    const cambiarPaginacion = () => {
        listarGrupos()
    }
    const cambiarPagina =(pagina) => {
        listarGrupos(pagina)
    }
    const pagesNumber = () => {
        if(!grupos.value.to){
            return []
        }
        let from = grupos.value.current_page - offset
        if(from < 1) from = 1
        let to = from + (offset*2)
        if( to >= grupos.value.last_page) to = grupos.value.last_page
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
        listarGrupos()
    })
</script>
<template>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Listado de Grupos
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
                                <li v-if="grupos.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="grupos.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(grupos.current_page - 1)">
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
                                <li v-if="grupos.current_page < grupos.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(grupos.current_page + 1)">
                                        <span ><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="grupos.current_page <= grupos.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(grupos.last_page)"
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
                                        <th colspan="7" class="text-center">grupos</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Titulo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="grupos.total == 0">
                                        <td class="text-danger text-center" colspan="7">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(grupo,index) in grupos.data" :key="grupo.id">
                                        <td>{{ index + grupos.from }}</td>
                                        <td>{{ grupo.titulo }}</td>
                                        <td>
                                            <template v-if="grupo.deleted_at == null">
                                                <button class="btn btn-warning btn-sm" title="Editar" @click.prevent="editar(grupo.id)">
                                                    <i class="fas fa-edit"></i>
                                                </button>&nbsp;
                                                <button class="btn btn-danger btn-sm" title="Enviar a Papelera" @click.prevent="eliminar(grupo.id, 'Temporal')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </template>
                                            <template v-else>
                                                <button class="btn btn-info btn-sm" title="Restaurar" @click.prevent="restaurar(grupo.id)">
                                                    <i class="fas fa-trash-restore-alt"></i>
                                                </button>&nbsp;
                                                <button class="btn btn-danger btn-sm" title="Eliminar Permanente" @click.prevent="eliminar(grupo.id, 'Permanente')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </template>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-1">
                        Mostrando <b>{{grupos.from}}</b> a <b>{{ grupos.to }}</b> de <b>{{ grupos.total}}</b> Registros
                    </div>
                    <div class="col-md-7 mb-1 text-right">
                        <nav>
                            <ul class="pagination">
                                <li v-if="grupos.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="grupos.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(grupos.current_page - 1)">

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
                                <li v-if="grupos.current_page < grupos.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(grupos.current_page + 1)">
                                        <span ><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="grupos.current_page <= grupos.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(grupos.last_page)"
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
    <GrupoForm :form="form" @onListar="listarGrupos" :currentPage="grupos.current_page"></GrupoForm>
</template>