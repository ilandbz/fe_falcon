<script setup>
  import { jwtDecode } from 'jwt-decode'
  import { ref, onMounted, inject } from 'vue';
  import useHelper from '@/Helpers';  
  import { defineTitle } from '@/Helpers';
  import useAtencion from '@/Composables/Atencion.js';
  import downloadexcel from "vue-json-excel3";

  const { formatoFecha, meses, Toast, Swal } = useHelper();

    const { atenciones, obtenerProduccion, obtenerProduccioncompleto, registros, 
        obtenerBrutoNeto } = useAtencion();
    const titleHeader = ref({
      titulo: "Produccion por Atenciones",
      subTitulo: "Reportes",
      icon: "",
      vista: ""
    });
    const anhoactual=formatoFecha(null,"YYYY");

    const datos = ref({
        anho:anhoactual,
        producto:'',
        paginacion:20,
        page:'',
        estado: '',
        errors:[]
    })
    const exportarData=async()=>{
        datos.value.tipo = "full";
        await obtenerProduccioncompleto(dato.value, datos.value)
        return registros.value;
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
                console.log("I was closed by the timer");
            }
        });
    }
    const finishDownload=()=>{
        clearInterval(timerInterval);
        Toast.fire({icon:'success', title:'Terminado'})
    }
    const json_fields = ref({
        "Codigo" : "codigo",
        "Lote": "lote",
        "Numero": "numero",
        "Fecha Atencion": "fecha_atencion",
        "Fecha Alta": "fecha_alta",
        "Medicamento (S/.)":"medicamentos",
        "Insumos (S/.)" : "insumos",
        "Procedimientos (S/.)" : "procedimientos",
        "Cantidad Diagnosticos" : "diagnosticos",
        "Digitador" : "user",
    })    

    const offset = 2;
    const listarRegistros = async(page=1) => {
        LoadState.value=true
        datos.value.page= page;
        datos.value.estado='Cambiando Pagina'
        await obtenerBrutoNeto(datos.value)
        LoadState.value=false
    }
    const cambiarPaginacion = () => {
        listarRegistros()
        
    }
    const cambiarPagina =(pagina) => {
        listarRegistros(pagina)
    }
    const isActived = () => {
        return atenciones.value.registros?.current_page
    }
    const pagesNumber = () => {
        if(!atenciones.value.registros?.to){
            return []
        }
        let from = atenciones.value.registros?.current_page - offset
        if(from < 1) from = 1
        let to = from + (offset*2)
        if( to >= atenciones.value.registros?.last_page) to = atenciones.value.registros?.last_page
        let pagesArray = []
        while(from <= to) {
            pagesArray.push(from)
            from ++
        }
        return pagesArray
    }

    const data=ref([]);
    const LoadState=ref(false);
    const graficar = async() => {
        
        datos.value.page = 1;
        LoadState.value = true;
        await obtenerBrutoNeto(datos.value);
        data.value = atenciones.value.data;
        docReady(topProductsInitBrutoNeto(data.value))
        LoadState.value = false;

    };

    onMounted(() => {
        defineTitle(titleHeader.value.titulo)

    })
</script>
<template>
    <div class="app-content">
      <div class="container-fluid">

        <div class="row mb-2">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h6 class="card-title">
                            Produccion Bruta Y Neta de Atenciones
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-2">
                                <label for="" class="form-label">Año</label>
                                <select v-model="datos.anho" class="form-select" :class="{ 'is-invalid': datos.errors.anho }">
                                    <option v-for="(i, n) in 5" :key="i" :value="anhoactual - n">
                                        {{ anhoactual - n }}
                                    </option>
                                </select>
                                <small class="text-danger" v-for="error in datos.errors.anho" :key="error">{{ error }}<br></small>
                            </div>    
                            <div class="col-md-3">
                                <label for="" class="form-label">Producto</label>
                                <select v-model="datos.producto" class="form-select" :class="{ 'is-invalid': datos.errors.producto }">
                                    <option value="" disabled>Seleccione</option>
                                    <option value="Insumo">Insumo</option>
                                    <option value="Medicamento">Medicamento</option>
                                    <option value="Procedimiento">Procedimiento</option>
                                </select>
                                <small class="text-danger" v-for="error in datos.errors.producto" :key="error">{{ error
                                        }}<br></small>
                                <br>
                            </div>
                            <div class="col-md-2">
                                <label for="" class="form-label">Paginacion</label>
                                <select class="form-select"  v-model="datos.paginacion" @change="cambiarPaginacion">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>                    
                            </div>
                            <div class="col-md-3 mb-4">
                                <br>
                                <template v-if="LoadState">
                                    <button class="btn btn-primary" @click.prevent="graficar()"><i class="fas fa-chart-bar"></i> Generar 
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </button>&nbsp;
                                </template>
                                <template v-else>
                                    <button class="btn btn-primary" @click.prevent="graficar()"><i class="fas fa-chart-bar"></i> Generar 
                                    </button>&nbsp;
                                </template>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="echart-bar-top-products h-100" data-echart-responsive="true">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h6 class="card-title">
                            Detallado
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="table-responsive">         
                                    <table class="table table-bordered table-hover table-sm table-striped table-sm">
                                        <thead class="table-dark">
                                            <tr>
                                                <th colspan="14" class="text-center">Registros</th>
                                            </tr>
                                            <tr>
                                                <th class="small">#</th>
                                                <th class="small">FUA</th>
                                                <th class="small">CODIGO</th>
                                                <th class="small">DNI</th>
                                                <th class="small">APENOM</th>
                                                <th class="small">REGISTROS</th>
                                                <th class="small">BRUTO</th>
                                                <th class="small">NETO</th>
                                                <th class="small">DIFERENCIA</th>
                                                <th class="small">PERIODO</th>
                                                <th class="small">Dig.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-if="atenciones.registros?.total == 0">
                                                <td class="text-danger text-center" colspan="14">
                                                    -- Datos No Registrados - Tabla Vacía --
                                                </td>
                                            </tr>
                                            <tr v-else-if="LoadState">
                                                <td colspan="14" class="text-center">
                                                    <br>
                                                    <div class="tab-pane preview-tab-pane active" role="tabpanel">
                                                        <div class="spinner-border text-warning" role="status"><span class="visually-hidden">Loading...</span></div>
                                                    </div>
                                                </td>
                                            </tr>                                
                                            <tr v-else v-for="(registro,index) in atenciones.registros?.data" :key="registro.id">
                                                <td class="small">{{ index + atenciones.registros?.from }}</td>
                                                <td class="small">{{ registro.fua }}</td>
                                                <td class="small">{{ registro.codigo }}</td>
                                                <td class="small">{{ registro.dni }}</td>
                                                <td class="small">{{ registro.apenom }}</td>
                                                <td class="small">{{ registro.registros }}</td>
                                                <td class="small">{{ registro.bruto }}</td>
                                                <td class="small">{{ registro.neto }}</td>
                                                <td class="small">{{ registro.diferencia }}</td>
                                                <td class="small">{{ registro.periodo }}</td>
                                                <td class="small">{{ registro.user_login }}</td>                  
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 mb-1">
                                Mostrando <b>{{atenciones.registros?.from}}</b> a <b>{{ atenciones.registros?.to }}</b> de <b>{{ atenciones.registros?.total}}</b> Registros
                            </div>
                            <div class="col-md-7 mb-1 text-right">
                                <nav>
                                    <ul class="pagination">
                                        <li v-if="atenciones.registros?.current_page >= 2" class="page-item">
                                            <a href="#" aria-label="Previous" class="page-link"
                                                title="Primera Página"
                                                @click.prevent="cambiarPagina(1)">
                                                <span><i class="fas fa-backward"></i></span>
                                            </a>
                                        </li>
                                        <li v-if="atenciones.registros?.current_page > 1" class="page-item">
                                            <a href="#" aria-label="Previous" class="page-link"
                                                title="Página Anterior"
                                                @click.prevent="cambiarPagina(atenciones.registros?.current_page - 1)">
        
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
                                        <li v-if="atenciones.registros?.current_page < atenciones.registros?.last_page" class="page-item">
                                            <a href="#" aria-label="Next" class="page-link"
                                                title="Página Siguiente"
                                                @click.prevent="cambiarPagina(atenciones.registros?.current_page + 1)">
                                                <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                            </a>
                                        </li>
                                            <li v-if="atenciones.registros?.current_page <= atenciones.registros?.last_page-1" class="page-item">
                                            <a href="#" aria-label="Next" class="page-link"
                                                @click.prevent="cambiarPagina(atenciones.registros?.last_page)"
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
        <div class="row">
            <div class="col-md-12">
                <!-- <VChart></VChart> -->
               <!-- <VueEChart :option="options" autoresize></VueEChart> -->
            </div>
        </div>
      </div>
    </div>

</template>