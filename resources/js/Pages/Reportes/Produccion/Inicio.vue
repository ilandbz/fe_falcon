<script setup>
  import { jwtDecode } from 'jwt-decode'
  import { ref, onMounted, inject } from 'vue';
  import useHelper from '@/Helpers';  
  import { defineTitle } from '@/Helpers';
  import useAtencion from '@/Composables/Atencion.js';
  import downloadexcel from "vue-json-excel3";

  const { formatoFecha, meses, Toast, Swal } = useHelper();

    const { atenciones, obtenerProduccion, obtenerProduccioncompleto, registros, 
        obtenerProduccionAnual } = useAtencion();
    const titleHeader = ref({
      titulo: "Produccion por Atenciones",
      subTitulo: "Reportes",
      icon: "",
      vista: ""
    });
    const anhoactual=formatoFecha(null,"YYYY");
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 20,
    });
    const LoadState=ref(false);
    const periodo = ref({
        codigo:anhoactual+formatoFecha(null,"MM"),
        anho:anhoactual,
        mes:formatoFecha(null,"MM"),
        tipo:'',
        errors:[]
    })
    const exportarData=async()=>{
        periodo.value.tipo = "full";
        await obtenerProduccioncompleto(dato.value, periodo.value)
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
    const isActived = () => {
        return atenciones.value.current_page
    }
    const offset = 2;

    const cambiarPaginacion = () => {
        listarRegistros()
    }
    const cambiarPagina =(pagina) => {
        listarRegistros(pagina)
    }
    const pagesNumber = () => {
        if(!atenciones.value.to){
            return []
        }
        let from = atenciones.value.current_page - offset
        if(from < 1) from = 1
        let to = from + (offset*2)
        if( to >= atenciones.value.last_page) to = atenciones.value.last_page
        let pagesArray = []
        while(from <= to) {
            pagesArray.push(from)
            from ++
        }
        return pagesArray
    }
    const establecerPeriodo=()=>{
        periodo.value.codigo = periodo.value.anho+periodo.value.mes
    }

    const buscar=()=>{
        listarRegistros()
    }
    const listarRegistros = async(page=1) => {
        LoadState.value=true
        dato.value.page= page;
        periodo.value.tipo ="";
        await obtenerProduccion(dato.value, periodo.value)
        LoadState.value=false
    }


    const graficar = async () => {
        // Establece el temporizador inicial en 25 segundos (25000 ms)
        const swalTimer = 25000;
        
        // Muestra el Swal con el temporizador inicial
        const swalInstance = Swal.fire({
            title: "Cargando!",
            html: "Se cerrará automáticamente",
            timer: swalTimer,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            },
            willClose: () => {
                clearInterval(timerInterval);
            }
        });

        // Captura el tiempo antes de la llamada async
        const startTime = Date.now();

        // Espera la respuesta de la función asíncrona
        await obtenerProduccionAnual(periodo.value);

        // Calcula el tiempo que tardó la respuesta
        const endTime = Date.now();
        const responseTime = endTime - startTime; // Tiempo de respuesta en milisegundos

        // Calcula el tiempo restante y ajusta el temporizador de Swal
        const timeRemaining = swalTimer - responseTime;

        // Si el tiempo restante es mayor que 0, actualiza el temporizador
        if (timeRemaining > 0) {
            swalInstance.update({
                timer: timeRemaining
            });
        } else {
            // Si el tiempo restante es menor o igual a 0, ciérralo inmediatamente
            swalInstance.close();
        }

        // Obtén los datos de la variable atenciones
        const data = atenciones.value;

        // Llama a la función que procesará los datos
        docReady(topProductsInitprueba(data));
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
                            Produccion Neta de Atenciones
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-2">
                                <label for="" class="form-label">Año</label>
                                <select v-model="periodo.anho" class="form-select" :class="{ 'is-invalid': periodo.errors.anho }" @change="establecerPeriodo()">
                                    <option v-for="(i, n) in 5" :key="i" :value="anhoactual - n">
                                        {{ anhoactual - n }}
                                    </option>
                                </select>
                                <small class="text-danger" v-for="error in periodo.errors.anho" :key="error">{{ error
                                        }}<br></small>
                                <br>
                                <small>Cantidad entregada por PREOPE</small>
                            </div>    
                            <div class="col-md-3">
                                
                            </div>            
                            <div class="col-md-3 mb-4">
                                <br>
                                <button class="btn btn-primary" @click="graficar()"><i class="fas fa-chart-bar"></i> Graficar</button>&nbsp;
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
                            Produccion de Atenciones Por Periodo
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-2">
                                <label for="" class="form-label">Año</label>
                                <select v-model="periodo.anho" class="form-select" :class="{ 'is-invalid': periodo.errors.anho }" @change="establecerPeriodo()">
                                    <option v-for="(i, n) in 5" :key="i" :value="anhoactual - n">
                                        {{ anhoactual - n }}
                                    </option>
                                </select>
                                <small class="text-danger" v-for="error in periodo.errors.anho" :key="error">{{ error
                                        }}<br></small>
                            </div>
                            <div class="col-md-2">
                                <label for="" class="form-label">Mes</label>
                                <select v-model="periodo.mes" class="form-select" :class="{ 'is-invalid': periodo.errors.mes }" @change="establecerPeriodo()">
                                    <option v-for="mes in meses" :key="mes.numero" :value="mes.numero">
                                        {{ mes.nombre }}
                                    </option>
                                </select>
                                <small class="text-danger" v-for="error in periodo.errors.mes" :key="error">{{ error
                                        }}<br></small>
                            </div>
                            <div class="col-md-2">
                                <label for="" class="form-label">Paginacion</label>
                                <select class="form-select"  v-model="dato.paginacion" @change="cambiarPaginacion">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>                    
                            </div>
                            <div class="col-md-2">
                            </div>                    
                            <div class="col-md-3 mb-4">
                                <br>
                                <button class="btn btn-primary" @click="buscar()"><i class="fas fa-search"></i> Buscar</button>&nbsp;
                                <downloadexcel
                                    class            = "btn btn-success"
                                    :fetch           = "exportarData"
                                    :fields          = "json_fields"
                                    :before-generate = "startDownload"
                                    :before-finish   = "finishDownload">
                                    Descargar
                                </downloadexcel>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="table-responsive">         
                                    <table class="table table-bordered table-hover table-sm table-striped table-sm">
                                        <thead class="table-dark">
                                            <tr>
                                                <th colspan="15" class="text-center">registros</th>
                                            </tr>
                                            <tr>
                                                <th class="small">#</th>
                                                <th class="small">FUA</th>
                                                <th class="small">CODIGO</th>
                                                <th class="small">LOTE</th>
                                                <th class="small">Numero</th>
                                                <th class="small">ApeNombres</th>
                                                <th class="small">Fecha Atencion</th>
                                                <th class="small">Fecha Alta</th>
                                                <th class="small">Med (S/.)</th>
                                                <th class="small">Ins (S/.)</th>
                                                <th class="small">Proc (S/.)</th>
                                                <th class="small">Subtotal</th>
                                                <th class="small">Total</th>
                                                <th class="small">Diagnosticos</th>
                                                <th class="small">User</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-if="atenciones.total == 0">
                                                <td class="text-danger text-center" colspan="14">
                                                    -- Datos No Registrados - Tabla Vacía --
                                                </td>
                                            </tr>
                                            <tr v-else-if="LoadState==true">
                                                    <td colspan="14" class="text-center">
                                                        <br>
                                                        <div class="tab-pane preview-tab-pane active" role="tabpanel">
                                                            <div class="spinner-border text-warning" role="status"><span class="visually-hidden">Loading...</span></div>
                                                        </div>
                                                    </td>
                                                </tr>                                
                                            <tr v-else v-for="(registro,index) in atenciones.data" :key="registro.id">
                                                <td class="small">{{ index + atenciones.from }}</td>
                                                <td class="small">{{ registro.fua }}</td>
                                                <td class="small">{{ registro.codigo }}</td>
                                                <td class="small">{{ registro.lote }}</td>
                                                <td class="small">{{ registro.numero }}</td>
                                                <td class="small">{{ registro.paciente }}</td>
                                                <td class="small">{{ registro.fecha_atencion }}</td>
                                                <td class="small">{{ registro.fecha_alta }}</td>
                                                <td class="small">{{ registro.medicamentos }}</td>
                                                <td class="small">{{ registro.insumos }}</td>
                                                <td class="small">{{ registro.procedimientos }}</td>
                                                <td class="small">{{ registro.subtotal }}</td>
                                                <td class="small">{{ registro.costo_total }}</td>
                                                <td class="small">{{ registro.diagnosticos }}</td>
                                                <td class="small">{{ registro.user }}</td>                       
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 mb-1">
                                Mostrando <b>{{atenciones.from}}</b> a <b>{{ atenciones.to }}</b> de <b>{{ atenciones.total}}</b> Registros
                            </div>
                            <div class="col-md-7 mb-1 text-right">
                                <nav>
                                    <ul class="pagination">
                                        <li v-if="atenciones.current_page >= 2" class="page-item">
                                            <a href="#" aria-label="Previous" class="page-link"
                                                title="Primera Página"
                                                @click.prevent="cambiarPagina(1)">
                                                <span><i class="fas fa-backward"></i></span>
                                            </a>
                                        </li>
                                        <li v-if="atenciones.current_page > 1" class="page-item">
                                            <a href="#" aria-label="Previous" class="page-link"
                                                title="Página Anterior"
                                                @click.prevent="cambiarPagina(atenciones.current_page - 1)">
        
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
                                        <li v-if="atenciones.current_page < atenciones.last_page" class="page-item">
                                            <a href="#" aria-label="Next" class="page-link"
                                                title="Página Siguiente"
                                                @click.prevent="cambiarPagina(atenciones.current_page + 1)">
                                                <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                            </a>
                                        </li>
                                            <li v-if="atenciones.current_page <= atenciones.last_page-1" class="page-item">
                                            <a href="#" aria-label="Next" class="page-link"
                                                @click.prevent="cambiarPagina(atenciones.last_page)"
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