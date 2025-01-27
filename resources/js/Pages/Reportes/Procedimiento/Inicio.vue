<script setup>
  import { jwtDecode } from 'jwt-decode'
  import { ref, onMounted, inject } from 'vue';
  import useHelper from '@/Helpers';  
  import { defineTitle } from '@/Helpers';
  import usePrecioProcedimiento from '@/Composables/PrecioProcedimiento.js';
  import JsonExcel from 'vue-json-excel3';
  import html2canvas from 'html2canvas'
  import jspdf from 'jspdf'
  const { formatoFecha, meses } = useHelper();

    const { registros, obtenerProcedimientos,errors } = usePrecioProcedimiento();
    const LoadState=ref(false);
    const titleHeader = ref({
      titulo: "Procedimientos - Precio",
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
    
    const periodo = ref({
        codigo:anhoactual+formatoFecha(null,"MM"),
        anho:anhoactual,
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
        listarProcedimientos()
    }
    const cambiarPagina =(pagina) => {
        listarProcedimientos(pagina)
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
        buscar()
    });
    const establecerPeriodo=()=>{
        periodo.value.codigo = periodo.value.anho+periodo.value.mes
    }
    const buscar=()=>{
        listarProcedimientos()
    }
    const listarProcedimientos = async(page=1) => {
        LoadState.value=true
        dato.value.page= page
        await obtenerProcedimientos(dato.value, periodo.value.codigo)
        LoadState.value=false
    }

    const downloadPDF=(registro)=>{
    let canvas = document.getElementById('canvas')
    html2canvas(canvas).then((canvas) => {
        let img = '/img/logo.jpg';
        let doc = new jspdf();

        const textToCenter = "GOBIERNO REGIONAL HUANUCO";
        let posy = 20
        let textWidth = doc.getTextDimensions(textToCenter).w;
        let centerX = (doc.internal.pageSize.getWidth() - textWidth) / 2;

        doc.addImage(img, 'png', 8, 2);

        doc.setFontSize(14);
        doc.setFont("Arial", "italic", "bold");
        doc.text(textToCenter, centerX+15, posy);
        let texto = "DIRECCIÓN REGIONAL DE SALUD";
        posy+=10
        doc.text(texto, centerX, posy);
        posy+=10
        texto = "UNIDAD EJECUTORA 404 - RED DE SALUD HUÁNUCO";
        textWidth = doc.getTextDimensions(texto).w;
        centerX = (doc.internal.pageSize.getWidth() - textWidth) / 2;
        doc.text(texto, centerX, posy);
        posy+=10
        texto = "Año de la Unidad, la Paz y el Desarrollo";
        doc.text(texto, centerX, posy);
        posy+=20
        doc.setFontSize(12);
        doc.text("FORMATO DE registros.data INJUSTIFICADAS", 10,posy);
        // Texto justificado
        doc.setFontSize(12);
        doc.setFont("Arial", "italic", "normal");
        let posY = 80; // Posición inicial
        const parrafo = "Comunico a Usted que el servidor (a) público "+
        registro.apenom+" el día "+
        formatoFecha(registro.fecha, 'D [de] MMMM [del] YYYY')+
        ", no se hizo presente a Laborar, por lo que de acuerdo a la R.M. Nª 0734-2017-SA/P Art. 31 Incs_B; se ha procedido a Considerar INASISTENCIA INJUSTIFICADA.";

        // Divide el párrafo en líneas
        const lines = doc.splitTextToSize(parrafo, doc.internal.pageSize.getWidth() - 20);

        // Agrega cada línea al PDF
        for (let i = 0; i < lines.length; i++) {
            doc.text(10, posY, lines[i]);
            posY += 10; // Espacio entre líneas
        }
        doc.text("OBSERVACIONES : _________________________________________________________", 10,posY);
        posY += 20
        doc.text("_____________________", 10,posY);
        doc.text("_____________________", 60,posY);
        doc.text("_____________________", 110,posY);
        doc.text("_______________", 170,posY);
        posY += 10
        doc.text("JEFE DE SERVICIO", 10,posY);
        doc.text("UNIDAD RR.HH.", 60,posY);
        doc.text("CONTROL DE ASISTENCIA", 110,posY);
        doc.text("DIRECTOR", 170,posY);        
        posY += 20
        doc.text("RESOLUCION MINISTERIAL Nª 734-2017-MINSA", 10,posY);
        
        doc.save("output.pdf");
    })
    }
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
                    Precios de Procedimientos por Periodo
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
                        <small class="text-danger" v-for="error in periodo.errors.mes" :key="error">{{ error
                                }}<br></small>
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
                    <div class="col-md-3 mb-4">

                    </div> 
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">DESCRIPCION</span>
                            <input class="form-control" placeholder="Ingrese nombre, código ciiu" type="text" v-model="dato.buscar"
                                @change="buscar()" />
                        </div>
                    </div>                     
                    <div class="col-md-3 mb-4">
                        <button class="btn btn-primary" @click="buscar()"><i class="fas fa-search"></i> Buscar</button>&nbsp;
                        <JsonExcel class="btn btn-success" :fields="jsonFields" :data="registros.data">
                            <i class="fa-solid fa-file-excel"></i> Descargar
                        </JsonExcel>
                    </div>                     
                </div>
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped table-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="10" class="text-center">registros</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>PERIODO</th>
                                        <th>CODIGO</th>
                                        <th>PRCD_V_CODPRO_MINSA</th>
                                        <th>Descripcion</th>
                                        <th>NIVEL 2 (S/.)</th>
                                        <th>NIVEL 3 (S/.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="registros.total == 0">
                                        <td class="text-danger text-center" colspan="10">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else-if="LoadState==true">
                                        <td colspan="10" class="text-center">
                                            <br>
                                            <div class="tab-pane preview-tab-pane active" role="tabpanel">
                                                <div class="spinner-border text-warning" role="status"><span class="visually-hidden">Loading...</span></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(registro,index) in registros.data" :key="registro.id">
                                        <td>{{ index + registros.from }}</td>
                                        <td>{{ registro.periodo }}</td>
                                        <td>{{ registro.PRCD_ID_PROCEDIMIENTO }}</td>
                                        <td>{{ registro.PRCD_V_CODPRO_MINSA }}</td>
                                        <td>{{ registro.PRCD_V_DESPROCEDIMIENTO }}</td>
                                        <td>{{ registro.nivel2 }}</td>
                                        <td>{{ registro.nivel3 }}</td>                                    
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-1">
                        Mostrando <b>{{registros.from}}</b> a <b>{{ registros.to }}</b> de <b>{{ registros.total}}</b> Registros
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