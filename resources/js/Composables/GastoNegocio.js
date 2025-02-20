import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'

export default function useGastoNegocio() {
    const gastos = ref([])
    const errors = ref('')
    const respuesta = ref([])
    
    const obtenerGastos = async(id) => {
        let respuesta = await axios.get('gasto-negocio/mostrar?id='+id, getConfigHeader())
        gastos.value = respuesta.data
    }

    const agregarGastos = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('gasto-negocio/guardar', data, getConfigHeader())
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
    const actualizarGastos = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('gasto-negocio/actualizar', data, getConfigHeader())
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
    const eliminarGastos = async(id) => {
        const respond = await axios.post('gasto-negocio/eliminar', { id: id }, getConfigHeader())
        if (respond.data.ok == 1) {
            respuesta.value = respond.data
        }
    }
    return {
        errors, gastos, obtenerGastos, obtenerGastos, 
        agregarGastos, actualizarGastos, eliminarGastos, respuesta
    }
}
