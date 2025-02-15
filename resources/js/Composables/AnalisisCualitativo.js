import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'

export default function useAnalisisCualitativo() {
    const errors = ref('')
    const respuesta = ref([])
    const analisis = ref({})
    const obtenerAnalisisCredito = async(id) => {
        let respuesta = await axios.get('analisis-cualitativo/mostrar-analisis-cualitativo?credito_id='+id, getConfigHeader())
        analisis.value = respuesta.data
    }    
    const agregarRegistro = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('analisis-cualitativo/guardar', data, getConfigHeader())
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
    
    const actualizarRegistro = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('analisis-cualitativo/actualizar', data, getConfigHeader())
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
    const eliminarRegistro = async(id) => {
        const respond = await axios.post('analisis-cualitativo/eliminar', { id: id }, getConfigHeader())
        if (respond.data.ok == 1) {
            respuesta.value = respond.data
        }
    }

    return {
        errors, respuesta, obtenerAnalisisCredito, agregarRegistro, actualizarRegistro, analisis
    }
}
