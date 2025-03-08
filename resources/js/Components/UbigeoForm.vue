<script setup>
import { ref, onMounted, toRefs } from 'vue';
import useHelper from '@/Helpers'; 
import useUbigeo from '@/Composables/Ubigeo.js';
const { hideModal } = useHelper();


const emit = defineEmits(['seleccionar']);
    const {
        obtenerDistritos, distritos, errors, respuesta
    } = useUbigeo();
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 10
    });
    const listarDistritos = async(page=1) => {
        dato.value.page= page
        await obtenerDistritos(dato.value)
    }

    const isActived = () => {
        return distritos.value.current_page
    }
    const offset = 2;

    const buscar = () => {
        listarDistritos()
    }
    const cambiarPaginacion = () => {
        listarDistritos()
    }
    const cambiarPagina =(pagina) => {
        listarDistritos(pagina)
    }
    const seleccionar=(fila)=>{
        emit('seleccionar', fila.ubigeo);
        hideModal('#modalUbigeo')
    }
    const pagesNumber = () => {
        if(!distritos.value.to){
            return []
        }
        let from = distritos.value.current_page - offset
        if(from < 1) from = 1
        let to = from + (offset*2)
        if( to >= distritos.value.last_page) to = distritos.value.last_page
        let pagesArray = []
        while(from <= to) {
            pagesArray.push(from)
            from ++
        }
        return pagesArray
    }
    onMounted(() => {
        listarDistritos()
    })
</script>
<style>

#modalUbigeo {
  z-index: 1060 !important; /* Asegura que esté por encima */
}
</style>
<template>
    <div class="modal fade" id="modalUbigeo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalUbigeoLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h1 class="modal-title fs-1" id="modalUbigeoLabel">Seleccione Distrito</h1>
                    <div class="row">
                        <div class="col-md-3 mb-1">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">Pag</span>
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
                                    <li v-if="distritos.current_page >= 2" class="page-item">
                                        <a href="#" aria-label="Previous" class="page-link"
                                            title="Primera Página"
                                            @click.prevent="cambiarPagina(1)">
                                            <span><i class="fas fa-backward"></i></span>
                                        </a>
                                    </li>
                                    <li v-if="distritos.current_page > 1" class="page-item">
                                        <a href="#" aria-label="Previous" class="page-link"
                                            title="Página Anterior"
                                            @click.prevent="cambiarPagina(distritos.current_page - 1)">
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
                                    <li v-if="distritos.current_page < distritos.last_page" class="page-item">
                                        <a href="#" aria-label="Next" class="page-link"
                                            title="Página Siguiente"
                                            @click.prevent="cambiarPagina(distritos.current_page + 1)">
                                            <span ><i class="fas fa-angle-right"></i></span>
                                        </a>
                                    </li>
                                        <li v-if="distritos.current_page <= distritos.last_page-1" class="page-item">
                                        <a href="#" aria-label="Next" class="page-link"
                                            @click.prevent="cambiarPagina(distritos.last_page)"
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
                                            <th colspan="8" class="text-center">Distritos</th>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>UBIGEO</th>
                                            <th>Distrito</th>
                                            <th>Provincia</th>
                                            <th>Departamento</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="distritos.total == 0">
                                            <td class="text-danger text-center" colspan="7">
                                                -- Datos No Registrados - Tabla Vacía --
                                            </td>
                                        </tr>
                                        <tr v-else v-for="(distrito,index) in distritos.data" :key="distrito.id">
                                            <td>{{ index + distritos.from }}</td>
                                            <td>{{ distrito.ubigeo }}</td>
                                            <td>{{ distrito.distrito }}</td>
                                            <td>{{ distrito.provincia }}</td>
                                            <td>{{ distrito.departamento }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" title="Seleccionar" @click.prevent="seleccionar(distrito)">
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
                            Mostrando <b>{{distritos.from}}</b> a <b>{{ distritos.to }}</b> de <b>{{ distritos.total}}</b> Registros
                        </div>
                        <div class="col-md-7 mb-1 text-right">
                            <nav>
                                <ul class="pagination">
                                    <li v-if="distritos.current_page >= 2" class="page-item">
                                        <a href="#" aria-label="Previous" class="page-link"
                                            title="Primera Página"
                                            @click.prevent="cambiarPagina(1)">
                                            <span><i class="fas fa-backward"></i></span>
                                        </a>
                                    </li>
                                    <li v-if="distritos.current_page > 1" class="page-item">
                                        <a href="#" aria-label="Previous" class="page-link"
                                            title="Página Anterior"
                                            @click.prevent="cambiarPagina(distritos.current_page - 1)">

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
                                    <li v-if="distritos.current_page < distritos.last_page" class="page-item">
                                        <a href="#" aria-label="Next" class="page-link"
                                            title="Página Siguiente"
                                            @click.prevent="cambiarPagina(distritos.current_page + 1)">
                                            <span ><i class="fas fa-angle-right"></i></span>
                                        </a>
                                    </li>
                                        <li v-if="distritos.current_page <= distritos.last_page-1" class="page-item">
                                        <a href="#" aria-label="Next" class="page-link"
                                            @click.prevent="cambiarPagina(distritos.last_page)"
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