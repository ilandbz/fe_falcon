import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'

export default function useGastoFamiliar() {
    const gastosfamiliares = ref([])
    const errors = ref('')
    const respuesta = ref([])
    
    const obtenerGastosFamiliares = async(id) => {
        let respuesta = await axios.get('gasto-familiar/mostrar?credito_id='+id, getConfigHeader())
        gastosfamiliares.value = respuesta.data
    }

    const agregarGastosFamiliares = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('gasto-familiar/guardar', data, getConfigHeader())
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
    const actualizarGastosFamiliares = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('gasto-familiar/actualizar', data, getConfigHeader())
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
    const eliminarGastosFamiliares = async(id) => {
        const respond = await axios.post('gasto-familiar/eliminar', { id: id }, getConfigHeader())
        if (respond.data.ok == 1) {
            respuesta.value = respond.data
        }
    }
    return {
        errors, gastosfamiliares, obtenerGastosFamiliares,  
        agregarGastosFamiliares, actualizarGastosFamiliares, eliminarGastosFamiliares, respuesta
    }
}
