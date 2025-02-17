import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'

export default function useBalance() {
    const errors = ref('')
    const respuesta = ref([])
    const balance = ref({})
    const obtenerBalance = async(id) => {
        let respuesta = await axios.get('balance/mostrar?credito_id='+id, getConfigHeader())
        balance.value = respuesta.data
    }    
    const agregarRegistro = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('balance/guardar', data, getConfigHeader())
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
            let respond = await axios.post('balance/actualizar', data, getConfigHeader())
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
        const respond = await axios.post('balance/eliminar', { id: id }, getConfigHeader())
        if (respond.data.ok == 1) {
            respuesta.value = respond.data
        }
    }

    return {
        errors, respuesta, obtenerBalance, agregarRegistro, actualizarRegistro, eliminarRegistro, balance
    }
}
