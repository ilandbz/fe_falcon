import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'

export default function useTesoreria() {
    const registrostesoreria = ref([])
    const errors = ref('')
    const registrotesoreria = ref({})
    const respuesta = ref([])
    
    const obtenerRegistroTesoreria = async(id) => {
        let respuesta = await axios.get('tesoreria/mostrar?id='+id, getConfigHeader())
        registrotesoreria.value = respuesta.data
    }
    const obtenerRegistrosTesoreria = async(data) => {
        let respuesta = await axios.get('tesoreria/listar' + getdataParamsPagination(data), getConfigHeader())
        registrostesoreria.value = respuesta.data
    }
    const agregarRegistroTesoreria = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('tesoreria/guardar', data, getConfigHeader())
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
    const actualizarRegistroTesoreria = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('tesoreria/actualizar', data, getConfigHeader())
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
    const eliminarRegistroTesoreria = async(id) => {
        const respond = await axios.post('tesoreria/eliminar', { id: id }, getConfigHeader())
        if (respond.data.ok == 1) {
            respuesta.value = respond.data
        }
    }
    return {
        errors, registrostesoreria, registrotesoreria, obtenerRegistroTesoreria, obtenerRegistrosTesoreria, 
        agregarRegistroTesoreria, actualizarRegistroTesoreria, eliminarRegistroTesoreria, respuesta
    }
}
