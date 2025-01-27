import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useAtencion() {
    const atenciones = ref([])
    const digitadores = ref([])
    const profesionales = ref([])
    const medicamentos = ref({registros: [],total: 0})
    const insumos =  ref({registros: [],total: 0})
    const procedimientos = ref({registros: [],total: 0})
    const errors = ref('')
    const atencion = ref({})
    const respuesta = ref([])
    const registros = ref([])
    const obtenerAtencion = async(id) => {
        let respuesta = await axios.get('atencion/mostrar?id='+id,getConfigHeader())
        atencion.value = respuesta.data
    }
    const listaAtenciones = async()=>{
        let respuesta = await axios.get('atencion/todos',getConfigHeader())
        atenciones.value = respuesta.data        
    }
    const listaDigitadores = async()=>{
        let respuesta = await axios.get('atencion/lista-digitadores',getConfigHeader())
        digitadores.value = respuesta.data        
    }
    const listaProfesionales = async()=>{
        let respuesta = await axios.get('atencion/lista-profesionales',getConfigHeader())
        profesionales.value = respuesta.data        
    }    
    const listaMedicamentos = async(id)=>{
        let respuesta = await axios.get('atencion/medicamentos?atencion_id='+id,getConfigHeader())
        medicamentos.value = respuesta.data        
    }
    const listaInsumos = async(id)=>{
        let respuesta = await axios.get('atencion/insumos?atencion_id='+id,getConfigHeader())
        insumos.value = respuesta.data        
    }

    const listaProcedimientos = async(id)=>{
        let respuesta = await axios.get('atencion/procedimientos?atencion_id='+id,getConfigHeader())
        procedimientos.value = respuesta.data        
    }
    
    const obtenerAtenciones = async(data) => {
        let respuesta = await axios.post('atencion/listar', data,getConfigHeader())
        atenciones.value =respuesta.data
    }
    const agregaAtencion = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('atencion/guardar',data,getConfigHeader())
            errors.value =''
            if(respond.data.ok==1){
                respuesta.value=respond.data
            }
        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const actualizarAtencion = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('atencion/actualizar',data,getConfigHeader())
            errors.value =''
            if(respond.data.ok==1){
                respuesta.value=respond.data
            }

        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const eliminarAtencion = async(id) => {
        const respond = await axios.post('atencion/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    const obtenerProduccion = async(data, periodo)=>{//paginado
        errors.value = ''
        try {
            let respond = await axios.post('reporte/produccion-atencion' + getdataParamsPagination(data),periodo,getConfigHeader())
            errors.value =''
            atenciones.value=respond.data

        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }

    const obtenerProduccioncompleto = async(data, periodo)=>{
        errors.value = ''
        try {
            let respond = await axios.post('reporte/produccion-atencion' + getdataParamsPagination(data),periodo,getConfigHeader())
            errors.value =''
            registros.value=respond.data

        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const obtenerProduccionAnual = async(periodo)=>{//paginado
        errors.value = ''
        try {
            let respond = await axios.post('reporte/produccion-atencion-anual',periodo,getConfigHeader())
            errors.value =''
            atenciones.value=respond.data

        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const obtenerBrutoNeto = async(datos)=>{
        errors.value = ''
        try {
            let respond = await axios.post('reporte/produccion-bruto-neto',datos,getConfigHeader())
            errors.value =''
            atenciones.value=respond.data

        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    return {
        errors, atenciones, listaAtenciones, atencion, obtenerAtencion, obtenerAtenciones, listaMedicamentos,
        agregaAtencion, actualizarAtencion, eliminarAtencion, respuesta, obtenerProduccion, registros,
        medicamentos, insumos, procedimientos, listaInsumos, listaProcedimientos, obtenerProduccioncompleto, obtenerProduccionAnual,
        obtenerBrutoNeto, digitadores, listaDigitadores, listaProfesionales, profesionales
    }
}