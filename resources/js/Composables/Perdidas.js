import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'

export default function usePerdidas() {
    const errors = ref('')
    const respuesta = ref([])
    const perdidas = ref({})
    const obtenerPerdidas = async(id) => {
        let respuesta = await axios.get('perdidas-ganancias/mostrar?credito_id='+id, getConfigHeader())
        perdidas.value = respuesta.data
    }    
    const agregarPerdidas = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('perdidas-ganancias/guardar', data, getConfigHeader())
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
    
    const actualizarPerdidas = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('perdidas-ganancias/actualizar', data, getConfigHeader())
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
        const respond = await axios.post('perdidas-ganancias/eliminar', { id: id }, getConfigHeader())
        if (respond.data.ok == 1) {
            respuesta.value = respond.data
        }
    }

    return {
        errors, respuesta, obtenerPerdidas, agregarPerdidas, actualizarPerdidas, eliminarRegistro, perdidas
    }
}
