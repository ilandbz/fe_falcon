import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'

export default function usePropuesta() {
    const errors = ref('')
    const respuesta = ref([])
    const propuesta = ref({})
    const obtenerPropuesta = async(id) => {
        let respuesta = await axios.get('propuesta/mostrar?credito_id='+id, getConfigHeader())
        propuesta.value = respuesta.data
    }    
    const agregarPropuesta = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('propuesta/guardar', data, getConfigHeader())
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
    
    const actualizarPropuesta = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('propuesta/actualizar', data, getConfigHeader())
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
        const respond = await axios.post('propuesta/eliminar', { id: id }, getConfigHeader())
        if (respond.data.ok == 1) {
            respuesta.value = respond.data
        }
    }

    return {
        errors, respuesta, obtenerPropuesta, agregarPropuesta, actualizarPropuesta, eliminarRegistro, propuesta
    }
}
