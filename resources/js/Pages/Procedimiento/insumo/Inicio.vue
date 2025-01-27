<script setup>
  import { ref, onMounted } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import useProcedimiento from '@/Composables/Procedimiento.js';
  import usePrecioProcedimiento from '@/Composables/PrecioProcedimiento.js';  
  const { openModal, Toast, Swal } = useHelper();
  const {
        procedimientos, errors, procedimiento, respuesta,
        obtenerProcedimientos, obtenerProcedimiento, obtenerInsumos, insumos
    } = useProcedimiento();
    const {
    registros, obtenerPrecios
    } = usePrecioProcedimiento();  
    const titleHeader = ref({
      titulo: "Procedimiento",
      subTitulo: "Inicio",
      icon: "",
      vista: ""
    });
    const registroProc = ref({
        id:'',
        PRCD_ID_PROCEDIMIENTO : '',
        PRCD_V_CODPRO_MINSA: '',
        PRCD_V_DESPROCEDIMIENTO:'',
        registros:[]
    });
    const RegistrosInsumos = ref(
        []
    )
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 10
    });
    const ver = (id)=>{
        limpiar();
        obtenerDatos(id)
        document.getElementById("modalprocedimientoLabel").innerHTML = 'Ver Detalles';
        openModal('#modalprocedimiento')     
    }
    const limpiar = ()=> {
        registroProc.value.id='',
        registroProc.value.PRCD_ID_PROCEDIMIENTO='',
        registroProc.value.PRCD_V_CODPRO_MINSA = '',    
        registroProc.value.PRCD_V_DESPROCEDIMIENTO = '',          
        registroProc.value.registros = []
    }
    const obtenerDatos = async(id) => {
        await obtenerProcedimiento(id);
        await obtenerPrecios(id)
        if(procedimiento.value)
        {
            registroProc.value.id=procedimiento.value.id;
            registroProc.value.PRCD_ID_PROCEDIMIENTO=procedimiento.value.PRCD_ID_PROCEDIMIENTO;
            registroProc.value.PRCD_V_CODPRO_MINSA=procedimiento.value.PRCD_V_CODPRO_MINSA;
            registroProc.value.PRCD_V_DESPROCEDIMIENTO=procedimiento.value.PRCD_V_DESPROCEDIMIENTO;
            registroProc.value.registros=registros.value;
        }
    }
    const agregarInsumos = async(page=1) => {
        dato.value.page= page
        await obtenerInsumos(dato.value.buscar)
        RegistrosInsumos.value.push(...insumos.value.insumos);
    }
    // PAGINACION
    const isActived = () => {
        return procedimientos.value.current_page
    }
    const offset = 2;

    const buscar = () => {
    
        agregarInsumos()
    }

    const pagesNumber = () => {
        if(!procedimientos.value.to){
            return []
        }
        let from = procedimientos.value.current_page - offset
        if(from < 1) from = 1
        let to = from + (offset*2)
        if( to >= procedimientos.value.last_page) to = procedimientos.value.last_page
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
    })
</script>
<template>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    AGREGAR INSUMOS POR PROCEDIMIENTO
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">ID</span>
                            <input class="form-control" placeholder="Ingrese CODIGO DE PROCEDIMIENTO" type="text" v-model="dato.buscar"
                                @keyup.enter="buscar" />
                        </div>
                    </div>
                    <div class="col-md-5">
                        PROCEDIMIENTOS : {{ insumos.PRCD_V_DESPROCEDIMIENTO }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="5" class="text-center">INSUMOS</th>
                                    </tr>
                                    <tr>
                                        <th class="small p-1">#</th>
                                        <th class="small p-1">Codigo</th>
                                        <th class="small p-1">Descripcion</th>
                                        <th class="small p-1">Presentacion</th>
                                        <th class="small p-1">Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(insumo, index) in RegistrosInsumos">
                                        <td class="small p-0">{{ index+1 }}</td>
                                        <td class="small p-0">{{ insumo.ins_CodIns }}</td>
                                        <td class="small p-0">{{ insumo.ins_Nombre }}</td>
                                        <td class="small p-0">{{ insumo.pivot.presentacion }}</td>
                                        <td class="small p-0">{{ insumo.pivot.cantidad }}</td>                                        
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-1">
                        Mostrando <b>{{RegistrosInsumos.length}}</b> Registros
                    </div>
                    <div class="col-md-7 mb-1 text-right">
                        <nav>
                            <ul class="pagination">
                                <li v-if="procedimientos.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="procedimientos.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(procedimientos.current_page - 1)">

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
                                <li v-if="procedimientos.current_page < procedimientos.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(procedimientos.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="procedimientos.current_page <= procedimientos.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(procedimientos.last_page)"
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
</template>