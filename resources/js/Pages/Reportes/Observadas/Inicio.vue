<script setup>
    import { jwtDecode } from 'jwt-decode'
    import { ref, onMounted, inject } from 'vue';
    import useHelper from '@/Helpers';  
    import { defineTitle } from '@/Helpers';
    import JsonExcel from 'vue-json-excel3';
    import useMedicamento from '@/Composables/Medicamento.js';  
    import useProcedimiento from '@/Composables/Procedimiento.js'; 
    import useInsumo from '@/Composables/Insumo.js'; 
    import useServicio from '@/Composables/Servicio.js';     
    const { formatoFecha, meses } = useHelper();

    const { medicamentos, obtenerMedicamentosMinsa } = useMedicamento();
    const { procedimientos, obtenerProcedimientosMinsa } = useProcedimiento();
    const { insumos, obtenerInsumosMinsa } = useInsumo();    
    const { servicios, obtenerServiciosMinsa } = useServicio();    
    const anhoactual=formatoFecha(null,"YYYY");
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 20,
    });
    const LoadState=ref(false);
    const registros = ref([]);
    const periodo = ref({
        codigo:anhoactual+formatoFecha(null,"MM"),
        anho:anhoactual,
        tipo:'Medicamentos',
        mes:formatoFecha(null,"MM"),
        errors:[]
    })
    const jsonFields = ref({
        "DNI" : "DNI",
        "Apellidos y Nombres": "apenom",
        "Cargo": "cargo",
        "Nivel": "nivel",
        "Cargo": "cargo",
        "Nivel":"nivel",
    })
    const isActived = () => {
        return registros.value.current_page
    }
    const offset = 2;

    const cambiarPaginacion = () => {
        listarRegistros()
    }
    const cambiarPagina =(pagina) => {
        listarRegistros(pagina)
    }
    const pagesNumber = () => {
        if(!registros.value.to){
            return []
        }
        let from = registros.value.current_page - offset
        if(from < 1) from = 1
        let to = from + (offset*2)
        if( to >= registros.value.last_page) to = registros.value.last_page
        let pagesArray = []
        while(from <= to) {
            pagesArray.push(from)
            from ++
        }
        return pagesArray
    }
    onMounted(()=>{
        //buscar()
    });
    const establecerPeriodo=()=>{
        periodo.value.codigo = periodo.value.anho+periodo.value.mes
    }
    const buscar=()=>{
        listarRegistros()
    }
    const listarRegistros=(page)=>{
        if(periodo.value.tipo=='Medicamentos'){
            listarmedicamentos(page)
        }else if(periodo.value.tipo=='Procedimientos'){
            listarprocedimientos(page)
        }else if(periodo.value.tipo=='Servicios'){
            listarServicios(page)
        }else{
            listarinsumos(page)
        }
    }
    const listarmedicamentos = async(page=1) => {
        LoadState.value=true
        dato.value.page= page
        await obtenerMedicamentosMinsa(dato.value, periodo.value)
        registros.value=medicamentos.value
        LoadState.value=false
    }
    const listarServicios = async(page=1) => {
        LoadState.value=true
        dato.value.page= page
        await obtenerServiciosMinsa(dato.value, periodo.value)
        registros.value=servicios.value
        LoadState.value=false
    }    
    const listarprocedimientos = async(page=1) => {
        LoadState.value=true
        dato.value.page= page
        await obtenerProcedimientosMinsa(dato.value, periodo.value)
        registros.value=procedimientos.value
        LoadState.value=false
    }
    const listarinsumos = async(page=1) => {
        LoadState.value=true
        dato.value.page= page
        await obtenerInsumosMinsa(dato.value, periodo.value)
        registros.value=insumos.value
        LoadState.value=false
    }

</script>
<template>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Precios de Reportados del MINSA por periodo
                </h6>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-2">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">AÑO</span>
                            <select v-model="periodo.anho" class="form-control" :class="{ 'is-invalid': periodo.errors.anho }" @change="establecerPeriodo()">
                                <option v-for="(i, n) in 5" :key="i" :value="anhoactual - n">
                                    {{ anhoactual - n }}
                                </option>
                            </select>
                        </div>
                        <small class="text-danger" v-for="error in periodo.errors.anho" :key="error">{{ error
                                }}<br></small>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">MES</span>
                            <select v-model="periodo.mes" class="form-control" :class="{ 'is-invalid': periodo.errors.mes }" @change="establecerPeriodo()">
                                <option v-for="mes in meses" :key="mes.numero" :value="mes.numero">
                                    {{ mes.nombre }}
                                </option>
                            </select>
                        </div>
                        <small class="text-danger" v-for="error in periodo.errors.mes" :key="error">{{ error }}<br></small>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">PAGINACION</span>
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
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">TIPO</span>
                            <select v-model="periodo.tipo" class="form-control" :class="{ 'is-invalid': periodo.errors.mes }" @change="establecerPeriodo()">
                                <option value="Medicamentos">Medicamentos</option>
                                <option value="Procedimientos">Procedimientos</option>
                                <option value="Insumos">Insumos</option>
                                <option value="Servicios">Servicios</option>
                            </select>
                        </div>
                        <small class="text-danger" v-for="error in periodo.errors.mes" :key="error">{{ error }}<br></small>                          
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <button class="btn btn-primary" @click="buscar()"><i class="fas fa-search"></i> Buscar</button>&nbsp;
                        <JsonExcel class="btn btn-success" :fields="jsonFields" :data="medicamentos.data">
                            <i class="fa-solid fa-file-excel"></i> Descargar
                        </JsonExcel>
                    </div>                     
                </div>
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <div class="table-responsive">
                            <template v-if="periodo.tipo=='Servicios'">
                                <table class="table table-bordered table-hover table-sm table-striped table-sm">
                                    <thead class="table-dark">
                                        <tr>
                                            <th colspan="13" class="text-center" id="tituloReporte">Servicios</th>
                                        </tr>
                                        <tr>
                                            <th class="small p-1">#</th>
                                            <th class="small p-1">FUA</th>
                                            <th class="small p-1">Lote</th>
                                            <th class="small p-1">Numero</th>
                                            <th class="small p-1">DNI</th>
                                            <th class="small p-1">ApeNom</th>
                                            <th class="small p-1">Codigo</th>
                                            <th class="small p-1">Descripcion</th>
                                            <th class="small p-1">Valor Neto</th>
                                            <th class="small p-1">Valor Bruto</th>
                                            <th class="small p-1">Atencion</th>
                                            <th class="small p-1">Digitalizacion</th>
                                            <th class="small p-1">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="registros.total == 0">
                                            <td class="text-danger text-center" colspan="11">
                                                -- Datos No Registrados - Tabla Vacía --
                                            </td>
                                        </tr>
                                        <tr v-else-if="LoadState==true">
                                            <td colspan="12" class="text-center">
                                                <br>
                                                <div class="tab-pane preview-tab-pane active" role="tabpanel">
                                                    <div class="spinner-border text-warning" role="status"><span class="visually-hidden">Loading...</span></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-else v-for="(registro,index) in registros.data" :key="registro.id">
                                            <td class="small p-0">{{ index + registros.from }}</td>
                                            <td class="small p-0">{{ registro.fua }}</td>
                                            <td class="small p-0">{{ registro.lote }}</td>
                                            <td class="small p-0">{{ registro.numero }}</td>
                                            <td class="small p-0">{{ registro.dni }}</td>
                                            <td class="small p-0">{{ registro.apenom }}</td>
                                            <td class="small p-0">{{ registro.codigo }}</td>
                                            <td class="small p-0">{{ registro.descripcion }}</td>
                                            <td class="small p-0">{{ registro.valorNetoServ }}</td>
                                            <td class="small p-0">{{ registro.valorBrutoServ }}</td>
                                            <td class="small p-0">{{ registro.ate_fecate }}</td>
                                            <td class="small p-0">{{ registro.fecha_digitado }}</td>                                            
                                            <td class="small p-0">{{ registro.estado==0 ? 'No Obs.' : 'Obs.' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </template>
                            <template v-else>
                                <table class="table table-bordered table-hover table-sm table-striped table-sm">
                                    <thead class="table-dark">
                                        <tr>
                                            <th colspan="12" class="text-center" id="tituloReporte">{{periodo.tipo}}</th>
                                        </tr>
                                        <tr>
                                            <th class="small p-1">#</th>
                                            <th class="small p-1">FUA</th>
                                            <th class="small p-1">Lote</th>
                                            <th class="small p-1">Numero</th>
                                            <th class="small p-1">DNI</th>
                                            <th class="small p-1">ApeNom</th>
                                            <th class="small p-1">Codigo</th>
                                            <th class="small p-1">Descripcion</th>
                                            <th class="small p-1">Cantidad</th>
                                            <th class="small p-1">Precio</th>
                                            <th class="small p-1">Total</th>
                                            <th class="small p-1">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="registros.total == 0">
                                            <td class="text-danger text-center" colspan="11">
                                                -- Datos No Registrados - Tabla Vacía --
                                            </td>
                                        </tr>
                                        <tr v-else-if="LoadState==true">
                                            <td colspan="12" class="text-center">
                                                <br>
                                                <div class="tab-pane preview-tab-pane active" role="tabpanel">
                                                    <div class="spinner-border text-warning" role="status"><span class="visually-hidden">Loading...</span></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-else v-for="(registro,index) in registros.data" :key="registro.id">
                                            <td class="small p-0">{{ index + registros.from }}</td>
                                            <td class="small p-0">{{ registro.fua }}</td>
                                            <td class="small p-0">{{ registro.lote }}</td>
                                            <td class="small p-0">{{ registro.numero }}</td>
                                            <td class="small p-0">{{ registro.dni }}</td>
                                            <td class="small p-0">{{ registro.apenom }}</td>
                                            <td class="small p-0">{{ registro.codigo }}</td>
                                            <td class="small p-0">{{ registro.descripcion }}</td>
                                            <td class="small p-0">{{ registro.cantidad }}</td>
                                            <td class="small p-0">{{ registro.precio }}</td>
                                            <td class="small p-0">{{ registro.total }}</td>
                                            <td class="small p-0">{{ registro.estado==0 ? 'No Obs.' : 'Obs.' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </template> 

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-1">
                        Mostrando <b>{{registros.from}}</b> a <b>{{ registros.to }}</b> de <b>{{ registros.total}}</b> registros
                    </div>
                    <div class="col-md-7 mb-1 text-right">
                        <nav>
                            <ul class="pagination">
                                <li v-if="registros.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="registros.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(registros.current_page - 1)">

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
                                <li v-if="registros.current_page < registros.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(registros.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="registros.current_page <= registros.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(registros.last_page)"
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


    <canvas id="canvas" width="200" height="500">
    </canvas>
</template>