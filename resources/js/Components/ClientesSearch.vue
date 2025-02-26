<script setup>
  import { ref, onMounted, toRefs } from 'vue';
  import useHelper from '@/Helpers';  
  import useCliente from '@/Composables/Cliente.js';
    const { hideModal } = useHelper();
    const emit = defineEmits(['cargarPersona']);
    const {
        clientes,
        obtenerClientes, 
        
    } = useCliente();
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 10
    });
    const seleccionar=(fila)=>{
        emit('cargarPersona', fila.persona.dni);

        hideModal('#modalCliente')
    }

    const listarClientes = async(page=1) => {
        dato.value.page= page
        await obtenerClientes(dato.value)
    }


    // PAGINACION
    const isActived = () => {
        return clientes.value.current_page
    }
    const offset = 2;

    const buscar = () => {
        listarClientes()
    }
    const cambiarPaginacion = () => {
        listarClientes()
    }
    const cambiarPagina =(pagina) => {
        listarClientes(pagina)
    }
    const pagesNumber = () => {
        if(!clientes.value.to){
            return []
        }
        let from = clientes.value.current_page - offset
        if(from < 1) from = 1
        let to = from + (offset*2)
        if( to >= clientes.value.last_page) to = clientes.value.last_page
        let pagesArray = []
        while(from <= to) {
            pagesArray.push(from)
            from ++
        }
        return pagesArray
    }
    // CARGA
    onMounted(() => {
        listarClientes()
    })
</script>
<template>
    <div class="modal fade" id="modalCliente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-1" id="modalClienteLabel">Seleccione Distrito</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-4 mb-1">
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
                                <li v-if="clientes.current_page >= 2" class="page-item">
                                    <a href="#" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="clientes.current_page > 1" class="page-item">
                                    <a href="#" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(clientes.current_page - 1)">
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
                                <li v-if="clientes.current_page < clientes.last_page" class="page-item">
                                    <a href="#" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(clientes.current_page + 1)">
                                        <span ><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="clientes.current_page <= clientes.last_page-1" class="page-item">
                                    <a href="#" class="page-link"
                                        @click.prevent="cambiarPagina(clientes.last_page)"
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
                                        <th colspan="8" class="text-center">clientes</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>DNI</th>
                                        <th>Apellidos y Nombres</th>
                                        <th>Asesor</th>
                                        <th>Estado</th>
                                        <th>Agencia</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="clientes.total == 0">
                                        <td class="text-danger text-center" colspan="7">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(cliente,index) in clientes.data" :key="cliente.id">
                                        <td>{{ index + clientes.from }}</td>
                                        <td>{{ cliente.persona.dni }}</td>
                                        <td>{{ cliente.apenom }}</td>
                                        <td>{{ cliente.usuario.name }}</td>
                                        <td>{{ cliente.estado }}</td>
                                        <td>{{ cliente.agencia.nombre }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" title="Seleccionar" @click.prevent="seleccionar(cliente)">
                                                <i class="fas fa-check"></i>
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
                        Mostrando <b>{{clientes.from}}</b> a <b>{{ clientes.to }}</b> de <b>{{ clientes.total}}</b> Registros
                    </div>
                    <div class="col-md-7 mb-1 text-right">
                        <nav>
                            <ul class="pagination">
                                <li v-if="clientes.current_page >= 2" class="page-item">
                                    <a href="#" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="clientes.current_page > 1" class="page-item">
                                    <a href="#" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(clientes.current_page - 1)">

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
                                <li v-if="clientes.current_page < clientes.last_page" class="page-item">
                                    <a href="#" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(clientes.current_page + 1)">
                                        <span ><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="clientes.current_page <= clientes.last_page-1" class="page-item">
                                    <a href="#" class="page-link"
                                        @click.prevent="cambiarPagina(clientes.last_page)"
                                        title="Última Página">
                                        <span ><i class="fas fa-step-forward"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
</template>