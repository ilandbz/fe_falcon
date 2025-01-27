<script setup>
  import { ref, onMounted } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import useUsuario from '@/Composables/Usuario.js';
  import UsuarioForm from './Form.vue'
  const { openModal, Toast, Swal } = useHelper();
  const {
        usuarios, errors, usuario, respuesta,
        obtenerUsuarios, obtenerUsuario, eliminarUsuario,
        resetClaveUsuario, cambiarEstado
    } = useUsuario();
    const show_tipo = ref("Habilitados")
    const titleHeader = ref({
      titulo: "Usuario",
      subTitulo: "Inicio",
      icon: "",
      vista: ""
    });
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 10,
        show_tipo : 'habilitados',
    });
    const form = ref({
        id:'',
        username : '',
        role_id : '',
        errors:[]

    });
    const limpiar = () => {
        form.value.id = '';
        form.value.username = '';
        form.value.role_id = '';
        form.value.errors = [];
        errors.value = [];
    };
    const obtenerDatos = async(id) => {
        await obtenerUsuario(id);
        if(usuario.value)
        {
            form.value.id=usuario.value.id;
            form.value.username=usuario.value.name;
            form.value.role_id=usuario.value.role_id;
        }
    }
    const editar = (id) => {
        limpiar();
        obtenerDatos(id)
        form.value.estadoCrud = 'editar'
        document.getElementById("modalusuarioLabel").innerHTML = 'Editar Usuario';
        openModal('#modalusuario')
    }
    const nuevo = () => {
        limpiar()
        form.value.estadoCrud = 'nuevo'
        openModal('#modalusuario')
        document.getElementById("modalusuarioLabel").innerHTML = 'Nuevo Usuario';
        //titulo.textContent = 'Editar Datos Personales';
    }
    const listarUsuarios = async(page=1) => {
        dato.value.page= page
        await obtenerUsuarios(dato.value)
    }
    const eliminar = (id) => {
        Swal.fire({
            title: '¿Estás seguro de Eliminar?',
            text: "Usuario",
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
    const resetear = async(id) => {
        Swal.fire({
            title: '¿Estás seguro de Resetear la clave?',
            text: "Usuarios",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si'
        }).then((result) => {
            if (result.isConfirmed) {
                resetearclaveUsuario(id)
            }
        })
    }
    const resetearclaveUsuario = async(id) => {
        await resetClaveUsuario(id)
        if(respuesta.value.ok==1)
        {
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            listarUsuarios()
        }
    }
    const elimina = async(id) => {
        await eliminarUsuario(id)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            listarUsuarios(usuarios.value.current_page)
        }
    }
    const cambEstado= async(id)=>{
        await cambiarEstado(id)
        if(respuesta.value.ok==1){
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            listarUsuarios()
        }
    }
    const mostrarTodos = async () => {
        show_tipo.value = 'Todos'
        dato.value.show_tipo = 'todos'
        listarUsuarios()
    }
    const mostrarHabilitados = async () => {
        show_tipo.value = 'Habilitados'
        dato.value.show_tipo = 'habilitados'
        listarUsuarios()
    }
    const mostrarInactivos = async () => {
        show_tipo.value = 'Inactivos'
        dato.value.show_tipo = 'inactivos'
        listarUsuarios()
    }
    // PAGINACION
    const isActived = () => {
        return usuarios.value.current_page
    }
    const offset = 2;

    const buscar = () => {
        listarUsuarios()
    }
    const cambiarPaginacion = () => {
        listarUsuarios()
    }
    const cambiarPagina =(pagina) => {
        listarUsuarios(pagina)
    }
    const pagesNumber = () => {
        if(!usuarios.value.to){
            return []
        }
        let from = usuarios.value.current_page - offset
        if(from < 1) from = 1
        let to = from + (offset*2)
        if( to >= usuarios.value.last_page) to = usuarios.value.last_page
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
        listarUsuarios()
    })
</script>
<template>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Listado de usuarios
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
                    <div class="col-md-3">
                        <button data-bs-toggle="dropdown" class="btn btn-indigo btn-block">
                            Mostrar <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i>{{usuario.buscar}}
                        </button>
                        <div class="dropdown-menu">
                            <a href="" class="dropdown-item" @click.prevent="mostrarTodos">Todos</a>
                            <a href="" class="dropdown-item" @click.prevent="mostrarHabilitados">Habilitados</a>
                            <a href="" class="dropdown-item" @click.prevent="mostrarInactivos">Inactivos</a>
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
                                <li v-if="usuarios.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="usuarios.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(usuarios.current_page - 1)">
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
                                <li v-if="usuarios.current_page < usuarios.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(usuarios.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="usuarios.current_page <= usuarios.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(usuarios.last_page)"
                                        title="Última Página">
                                        <span aria-hidden="true"><i class="fas fa-step-forward"></i></span>
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
                                        <th colspan="5" class="text-center">Usuarios {{ show_tipo }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Name</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="usuarios.total == 0">
                                        <td class="text-danger text-center" colspan="5">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(usuario,index) in usuarios.data" :key="usuario.id">
                                        <td class="text-center">{{ index + usuarios.from }}</td>
                                        <td>{{ usuario.name }}</td>
                                        <td>{{ usuario.role.nombre }}</td>
                                        <td>
                                            <span
                                                :class="{'badge bg-success': usuario.es_activo === 1, 'badge bg-secondary': usuario.es_activo !== 1}"
                                                @click="cambEstado(usuario.id)"
                                                style="cursor: pointer;"
                                            title="Cambiar Estado" >
                                                {{ usuario.es_activo === 1 ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" title="Editar Usuario" @click.prevent="editar(usuario.id)">
                                                <i class="fas fa-edit"></i>
                                            </button>&nbsp;
                                            <button class="btn btn-danger btn-sm" title="Eliminar Usuario" @click.prevent="eliminar(usuario.id)">
                                                <i class="fas fa-trash"></i>
                                            </button>&nbsp;
                                            <button class="btn btn-success btn-sm" title="Reset Clave" @click.prevent="resetear(usuario.id)">
                                                <i class="fas fa-key"></i>
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
                        Mostrando <b>{{usuarios.from}}</b> a <b>{{ usuarios.to }}</b> de <b>{{ usuarios.total}}</b> Registros
                    </div>
                    <div class="col-md-7 mb-1 text-right">
                        <nav>
                            <ul class="pagination">
                                <li v-if="usuarios.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="usuarios.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(usuarios.current_page - 1)">

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
                                <li v-if="usuarios.current_page < usuarios.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(usuarios.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="usuarios.current_page <= usuarios.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(usuarios.last_page)"
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
    <UsuarioForm :form="form" @onListar="listarUsuarios" :currentPage="usuarios.current_page"></UsuarioForm>
</template>