<script setup>
  import { ref, onMounted } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import useMedicamento from '@/Composables/Medicamento.js';
  import usePrecioMedicamento from '@/Composables/PrecioMedicamento.js';  
  import detForm from './Det.vue'
  const { openModal } = useHelper();
  const {
        medicamentos, errors, medicamento, respuesta,
        obtenerMedicamentos, obtenerMedicamento, eliminarMedicamento
    } = useMedicamento();
  const {
    registros, obtenerPrecios
    } = usePrecioMedicamento();    
    const titleHeader = ref({
      titulo: "Medicamentos",
      subTitulo: "Inicio",
      icon: "",
      vista: ""
    });
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 10
    });
    const registroMed = ref({
        id:'',
        nombre : '',
        med_FormaFarmaceutica: '',
        Concen:'',
        registros:[]
    });
    const limpiar = ()=> {
        registroMed.value.id='',
        registroMed.value.nombre='',
        registroMed.value.med_FormaFarmaceutica = '',  
        registroMed.value.Concen = '',          
        registroMed.value.registros = []
    }
    const obtenerDatos = async(id) => {
        await obtenerMedicamento(id);
        await obtenerPrecios(id);
        if(medicamento.value)
        {
            registroMed.value.id=medicamento.value.id;
            registroMed.value.nombre=medicamento.value.med_Nombre;
            registroMed.value.med_FormaFarmaceutica=medicamento.value.med_FormaFarmaceutica;
            registroMed.value.Concen=medicamento.value.med_Concen;
            registroMed.value.registros=registros.value;
        }
    }
    const ver = (id)=>{
        limpiar();
        obtenerDatos(id)
        document.getElementById("modalmedicamentoLabel").innerHTML = 'Ver Detalles';
        openModal('#modalmedicamento')     
    }
    const listarMedicamentos = async(page=1) => {
        dato.value.page= page
        await obtenerMedicamentos(dato.value)
    }
    // PAGINACION
    const isActived = () => {
        return medicamentos.value.current_page
    }
    const offset = 2;

    const buscar = () => {
        listarMedicamentos()
    }
    const cambiarPaginacion = () => {
        listarMedicamentos()
    }
    const cambiarPagina =(pagina) => {
        listarMedicamentos(pagina)
    }
    const pagesNumber = () => {
        if(!medicamentos.value.to){
            return []
        }
        let from = medicamentos.value.current_page - offset
        if(from < 1) from = 1
        let to = from + (offset*2)
        if( to >= medicamentos.value.last_page) to = medicamentos.value.last_page
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
        listarMedicamentos()
    })
</script>
<template>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Listado de medicamentos
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-1 mb-1">
                        <!-- <button  type="button" class="btn btn-danger" @click.prevent="nuevo">
                            <i class="fas fa-plus"></i> Nuevo
                        </button>                         -->
                    </div>
                    <div class="col-md-2 mb-1">
                        <div class="input-group mb-1">
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
                                <li v-if="medicamentos.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="medicamentos.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(medicamentos.current_page - 1)">
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
                                <li v-if="medicamentos.current_page < medicamentos.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(medicamentos.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="medicamentos.current_page <= medicamentos.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(medicamentos.last_page)"
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
                                        <th colspan="10" class="text-center">Medicamentos</th>
                                    </tr>
                                    <tr>
                                        <th class="small p-1">#</th>
                                        <th class="small p-1">CODIGO</th>
                                        <th class="small p-1">Nombre</th>
                                        <th class="small p-1">FormaFarmaceutica</th>
                                        <th class="small p-1">Presen</th>
                                        <th class="small p-1">Concen</th>
                                        <th class="small p-1">Nombre SIS</th>
                                        <th class="small p-1">Present SIS</th>
                                        <th class="small p-1">FormaFarmaceutica SIS</th>
                                        <th class="small p-1">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="medicamentos.total == 0">
                                        <td class="text-danger text-center" colspan="10">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(medicamento,index) in medicamentos.data" :key="medicamento.id">
                                        <td class="small p-0">{{ index + medicamentos.from }}</td>
                                        <td class="small p-0">{{ medicamento.med_CodMed }}</td>
                                        <td class="small p-0">{{ medicamento.med_Nombre }}</td>
                                        <td class="small p-0">{{ medicamento.med_FormaFarmaceutica }}</td>
                                        <td class="small p-0">{{ medicamento.med_Presen }}</td>
                                        <td class="small p-0">{{ medicamento.med_Concen }}</td>
                                        <td class="small p-0">{{ medicamento.MED_V_NOMBRE_SIS }}</td>
                                        <td class="small p-0">{{ medicamento.MED_V_PRESENT_SIS }}</td>
                                        <td class="small p-0">{{ medicamento.MED_V_FORMAFARM_SIS }}</td>
                                        <td class="small p-0">
                                            <button class="btn btn-info btn-sm" title="Precios" @click.prevent="ver(medicamento.id)">
                                                <i class="fas fa-eye"></i>
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
                        Mostrando <b>{{medicamentos.from}}</b> a <b>{{ medicamentos.to }}</b> de <b>{{ medicamentos.total}}</b> Registros
                    </div>
                    <div class="col-md-7 mb-1 text-right">
                        <nav>
                            <ul class="pagination">
                                <li v-if="medicamentos.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="medicamentos.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(medicamentos.current_page - 1)">

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
                                <li v-if="medicamentos.current_page < medicamentos.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(medicamentos.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="medicamentos.current_page <= medicamentos.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(medicamentos.last_page)"
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
    <detForm :medicamento="registroMed"></detForm>
</template>