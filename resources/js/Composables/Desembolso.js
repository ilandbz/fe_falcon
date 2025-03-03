import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination, getConfigHeaderpdf } from '@/Helpers'

export default function usedesembolso() {
    const desembolsos = ref([])
    const errors = ref('')
    const desembolso = ref({})
    const respuesta = ref([])
    const descuentos=ref({})
    const pdfUrl = ref('')
    const obtenerDesembolso = async(id) => {
        let respuesta = await axios.get('desembolso/mostrar?id='+id, getConfigHeader())
        desembolso.value = respuesta.data
    }

    const obtenerDesembolsos = async(data) => {
        let respuesta = await axios.get('desembolso/listar' + getdataParamsPagination(data), getConfigHeader())
        desembolsos.value = respuesta.data
    }
    const agregarDesembolso = async (data) => {
        errors.value = ''
        try {
            let response = await axios.post('desembolso/procesar', data, getConfigHeader()) // NUEVO ENDPOINT
            
            if (response.data.ok == 1) {
                respuesta.value = response.data
            } else {
                errors.value = response.data.error || "Ocurrió un error inesperado"
            }
        } catch (error) {
            errors.value = ""
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors
            } else {
                errors.value = "Error en la conexión con el servidor"
            }
        }
    }
    const actualizarDesembolso = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('desembolso/actualizar', data, getConfigHeader())
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
    const eliminarDesembolso = async(id) => {
        const respond = await axios.post('desembolso/destroy', { id:id }, getConfigHeader())
        if (respond.data.ok == 1) {
            respuesta.value = respond.data
        }
    }
    const obtenerDescuentos = async(data) => {
        const respond = await axios.post('desembolso/obtener-descuentos',  data , getConfigHeader())
        descuentos.value = respond.data
    }
    const cancelarCredito = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('desembolso/cancelar-credito', data, getConfigHeader())
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
            let response = await axios.post("desembolso/generar-pdf",data,getConfigHeaderpdf());
    
            const file = new Blob([response.data], { type: "application/pdf" });
            pdfUrl.value = URL.createObjectURL(file);
    
        } catch (error) {
            console.error("Error al generar el PDF:", error);
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
        }
    };    
    return {
        errors, desembolsos, desembolso, obtenerDesembolso, obtenerDesembolsos, 
        agregarDesembolso, actualizarDesembolso, eliminarDesembolso, respuesta,
        obtenerDescuentos, descuentos, cancelarCredito, generarPdf, pdfUrl
    }
}
