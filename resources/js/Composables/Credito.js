import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination, getConfigHeaderpdf } from '@/Helpers'

export default function useCredito() {
    const creditos = ref([])
    const errors = ref('')
    const pdfUrl = ref('')
    const credito = ref({})
    const respuesta = ref([])
    const tiposCreditos = ref([])
    const obtenerCredito = async(id) => {
        let respuesta = await axios.get('credito/mostrar?id='+id, getConfigHeader())
        credito.value = respuesta.data
    }
  
    const listaCreditos = async()=>{
        let respuesta = await axios.get('credito/todos', getConfigHeader())
        creditos.value = respuesta.data        
    }

    const listaTiposCreditos = async(cliente_id)=>{
        let respuesta = await axios.get('credito/tipo-credito-cliente?cliente_id='+cliente_id, getConfigHeader())
        tiposCreditos.value = respuesta.data         
    }
    const obtenerCreditos = async(data) => {
        let respuesta = await axios.get('credito/listar' + getdataParamsPagination(data), getConfigHeader())
        creditos.value = respuesta.data
    }
    const obtenerCreditosEstadoAgencia = async(data, data2) => {
        let respuesta = await axios.post('credito/listar-estado-agencia' + getdataParamsPagination(data), data2, getConfigHeader())
        creditos.value = respuesta.data
    }    
    const validarEvaluacionAsesor = async(id) => {
        let respond = await axios.get('credito/validar-evaluacion-asesor?id='+id, getConfigHeader())
        respuesta.value = respond.data
    }
    const replicarEvaluacion = async(data) => {
        let respond = await axios.post('credito/replicar-evaluacion-anterior', data, getConfigHeader())
        respuesta.value = respond.data
    }    
    const agregarCredito = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('credito/guardar', data, getConfigHeader())
            errors.value = ''
            if (respond.data.ok == 1) {
                respuesta.value = respond.data
            }
        } catch (error) {
            errors.value = ""
            if (error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }

    const actualizarCredito = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('credito/actualizar', data, getConfigHeader())
            errors.value = ''
            if (respond.data.ok == 1) {
                respuesta.value = respond.data
            }
        } catch (error) {
            errors.value = ""
            if (error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }

    const cambiarEstado = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('credito/cambiar-estado', data, getConfigHeader())
            errors.value = ''
            if (respond.data.ok == 1) {
                respuesta.value = respond.data
            }
        } catch (error) {
            errors.value = ""
            if (error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const generarPdf = async (data) => {
        errors.value = "";
    
        try {
            let response = await axios.post("credito/generar-pdf",data,getConfigHeaderpdf());
    
            const file = new Blob([response.data], { type: "application/pdf" });
            pdfUrl.value = URL.createObjectURL(file);
    
        } catch (error) {
            console.error("Error al generar el PDF:", error);
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
        }
    };    
    const eliminarCredito = async(id) => {
        const respond = await axios.post('credito/eliminar', { id: id }, getConfigHeader())
        if (respond.data.ok == 1) {
            respuesta.value = respond.data
        }
    }

    return {
        errors, creditos, listaCreditos, credito, obtenerCredito, obtenerCreditos, 
        agregarCredito, actualizarCredito, eliminarCredito, respuesta, tiposCreditos, 
        listaTiposCreditos, replicarEvaluacion, validarEvaluacionAsesor, respuesta,
        cambiarEstado, generarPdf, pdfUrl, obtenerCreditosEstadoAgencia
    }
}
