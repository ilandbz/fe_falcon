<script setup>
  import { ref, onMounted, toRefs } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import useCliente from '@/Composables/Cliente.js';
  import useNegocio from '@/Composables/Negocio.js';
  import ClienteForm from './Form.vue'
  const props = defineProps({
    agencia: Object,
    role: Object,
    usuario: Object
});
const { agencia, role, usuario } = toRefs(props);
const { openModal, Toast, Swal } = useHelper();
const {
    clientes, errors, cliente, respuesta,
    obtenerClientes, obtenerCliente, eliminarCliente
} = useCliente();
const {
    negocios, listaNegociosPorCliente
} = useNegocio();

    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 10
    });
    const form = ref({
        id: '',
        dni:'',
        ape_pat:'',
        ape_mat:'',
        primernombre:'',
        otrosnombres:'',
        fecha_nac:'',
        ubigeo:'',
        email:'',
        celular:'',
        genero:'',
        estado_civil:'',
        ruc:'',
        agencia_id: agencia.value?.id,
        foto : '/storage/fotos/default.png',
        conyugue_id: '',
        dniconyugue: '',
        aval_id: '',
        grado_instr: '',
        profesion:'',
        usuario_id: '',
        usuario_name:'',
        dniaval:'',
        tipo_trabajador: '',
        ocupacion: 'NINGUNO',
        institucion_lab: '',
        ubicacion_domicilio_id:'',
        tipodomicilio: '',
        ubigeodomicilio: '',
        tipovia:'',
        nombrevia:'',
        nro:'',
        interior:'',
        mz:'',
        lote:'',
        tipozona:'',
        nombrezona: '',
        referencia:'',
        latitud_longitud:'',
        estado: 'REGISTRADO',
        fecha_reg: '',
        hora_reg: '',
        estadoCrud: '',
        errors: []
    });

    const limpiar = () => {
        form.value.id = '';
        form.value.dni = '';
        form.value.ape_pat = '';
        form.value.ape_mat = '';
        form.value.primernombre = '';
        form.value.otrosnombres = '';
        form.value.fecha_nac = '';
        form.value.ubigeo = '';
        form.value.agencia_id = agencia.value?.id;
        form.value.usuario_id = '';
        form.value.usuario_name = '';
        form.value.conyugue_id = '';
        form.value.dniconyugue = '';        
        form.value.aval_id = '';
        form.value.dniaval = '';
        form.value.tipo_trabajador = '';
        form.value.ocupacion = 'NINGUNO';
        form.value.estado = 'REGISTRADO';
        form.value.fecha_reg = '';
        form.value.hora_reg = '';
        form.value.estadoCrud = '';
        form.value.ubicacion_domicilio_id = '';
        form.value.tipodomicilio='';
        form.value.ubigeodomicilio='';
        form.value.tipovia='';
        form.value.nombrevia='';
        form.value.nro='';
        form.value.interior='';
        form.value.mz='';
        form.value.lote='';
        form.value.tipozona='';
        form.value.nombrezona='';
        form.value.referencia='';
        form.value.errors = [];
        errors.value = [];
    };
    const obtenerDatos = async (id) => {
    await obtenerCliente(id);
    if (cliente.value) {
        form.value.id = cliente.value.id;
        form.value.dni = cliente.value.persona.dni;
        form.value.ape_pat=cliente.value.persona.ape_pat;
        form.value.ape_mat=cliente.value.persona.ape_mat;
        form.value.primernombre=cliente.value.persona.primernombre;
        form.value.otrosnombres=cliente.value.persona.otrosnombres;
        form.value.fecha_nac=cliente.value.persona.fecha_nac;
        form.value.ubigeo=cliente.value.persona.ubigeo_nac;
        form.value.email=cliente.value.persona.email;
        form.value.celular=cliente.value.persona.celular;
        form.value.genero=cliente.value.persona.genero;
        form.value.estado_civil=cliente.value.persona.estado_civil;
        form.value.conyugue_id=cliente.value.persona.conyugue;
        form.value.dniconyugue=cliente.value.persona.conyuge_persona?.dni;
        form.value.ruc=cliente.value.persona.ruc;
        form.value.grado_instr=cliente.value.persona.grado_instr;
        form.value.tipo_trabajador=cliente.value.persona.tipo_trabajador;
        form.value.ocupacion=cliente.value.persona.ocupacion;
        form.value.institucion_lab=cliente.value.persona.institucion_lab;
        form.value.agencia_id = cliente.value.agencia_id;
        form.value.usuario_id = cliente.value.usuario_id;
        form.value.usuario_name = cliente.value.usuario.name;
        form.value.persona_id = cliente.value.persona_id;
        form.value.dniaval = cliente.value.dniaval;
        form.value.estado = cliente.value.estado;
        form.value.fecha_reg = cliente.value.fecha_reg;
        form.value.hora_reg = cliente.value.hora_reg;
        //domicilio
        form.value.ubicacion_domicilio_id = cliente.value.persona.ubicacion_domicilio_id;
        form.value.tipodomicilio = cliente.value.persona.ubicacion.tipo;
        form.value.ubigeodomicilio = cliente.value.persona.ubicacion.ubigeo;
        form.value.ubigeodomicilio = cliente.value.persona.ubicacion.ubigeo;
        form.value.tipovia = cliente.value.persona.ubicacion.tipovia;
        form.value.tipovia= cliente.value.persona.ubicacion.tipovia;
        form.value.nombrevia= cliente.value.persona.ubicacion.nombrevia;
        form.value.nro= cliente.value.persona.ubicacion.nro;
        form.value.interior= cliente.value.persona.ubicacion.interior;
        form.value.mz= cliente.value.persona.ubicacion.mz;
        form.value.lote= cliente.value.persona.ubicacion.lote;
        form.value.tipozona= cliente.value.persona.ubicacion.tipozona;
        form.value.nombrezona= cliente.value.persona.ubicacion.nombrezona;
        form.value.referencia= cliente.value.persona.ubicacion.referencia;
    }
};

    const editar = (id) => {
        limpiar();
        obtenerDatos(id)
        form.value.estadoCrud = 'editar'
        document.getElementById("modalClienteFormLabel").innerHTML = 'Editar Cliente';
        openModal('#modalClienteForm')
    }
    const nuevo = () => {
        limpiar()
        form.value.estadoCrud = 'nuevo'
        openModal('#modalClienteForm')
        document.getElementById("modalClienteFormLabel").innerHTML = 'Nuevo Cliente';
        //titulo.textContent = 'Editar Datos Personales';
    }
    const listarClientes = async(page=1) => {
        dato.value.page= page
        await obtenerClientes(dato.value)
    }

    const eliminar = (id) => {
        Swal.fire({
            title: '¿Estás seguro de Eliminar?',
            text: "Menu",
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
        await eliminarCliente(id)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            listarClientes(clientes.value.current_page)
        }
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
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h6 class="card-title">
                Listado de clientes
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 mb-1">
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
                <div class="col-md-4">
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="basic-addon1">Buscar</span>
                        <input class="form-control" placeholder="Ingrese nombre, código ciiu" type="text" v-model="dato.buscar"
                            @change="buscar" />
                    </div>
                </div>
                <div class="col-md-3 mb-1">
                    <nav>
                        <ul class="pagination">
                            <li v-if="clientes.current_page >= 2" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Primera Página"
                                    @click.prevent="cambiarPagina(1)">
                                    <span><i class="fas fa-backward"></i></span>
                                </a>
                            </li>
                            <li v-if="clientes.current_page > 1" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
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
                                <a href="#" aria-label="Next" class="page-link"
                                    title="Página Siguiente"
                                    @click.prevent="cambiarPagina(clientes.current_page + 1)">
                                    <span ><i class="fas fa-angle-right"></i></span>
                                </a>
                            </li>
                                <li v-if="clientes.current_page <= clientes.last_page-1" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
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
                                    <td class="text-danger text-center" colspan="8">
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
                                        <button class="btn btn-warning btn-sm" title="Editar" @click.prevent="editar(cliente.id)">
                                            <i class="fas fa-edit"></i>
                                        </button>&nbsp;
                                        <button class="btn btn-danger btn-sm" title="Enviar a Papelera" @click.prevent="eliminar(cliente.id, 'Temporal')">
                                            <i class="fas fa-trash"></i>
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
                    Mostrando <b>{{clientes.from}}</b> a <b>{{ clientes.to }}</b> de <b>{{ clientes.total}}</b> Registros
                </div>
                <div class="col-md-7 mb-1 text-right">
                    <nav>
                        <ul class="pagination">
                            <li v-if="clientes.current_page >= 2" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
                                    title="Primera Página"
                                    @click.prevent="cambiarPagina(1)">
                                    <span><i class="fas fa-backward"></i></span>
                                </a>
                            </li>
                            <li v-if="clientes.current_page > 1" class="page-item">
                                <a href="#" aria-label="Previous" class="page-link"
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
                                <a href="#" aria-label="Next" class="page-link"
                                    title="Página Siguiente"
                                    @click.prevent="cambiarPagina(clientes.current_page + 1)">
                                    <span ><i class="fas fa-angle-right"></i></span>
                                </a>
                            </li>
                                <li v-if="clientes.current_page <= clientes.last_page-1" class="page-item">
                                <a href="#" aria-label="Next" class="page-link"
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
    </div>

    <ClienteForm :form="form" @onListar="listarClientes" :currentPage="clientes.current_page"></ClienteForm>
</template>