import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'

export default function usedesembolso() {
    const desembolsos = ref([])
    const errors = ref('')
    const desembolso = ref({})
    const respuesta = ref([])
    const descuentos=ref({})
    const obtenerDesembolso = async(id) => {
        let respuesta = await axios.get('desembolso/mostrar?id='+id, getConfigHeader())
        desembolso.value = respuesta.data
    }

    const obtenerDesembolsos = async(data) => {
        let respuesta = await axios.get('desembolso/listar' + getdataParamsPagination(data), getConfigHeader())
        desembolsos.value = respuesta.data
    }
    const agregarDesembolso = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('desembolso/guardar', data, getConfigHeader())
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
    return {
        errors, desembolsos, desembolso, obtenerDesembolso, obtenerDesembolsos, 
        agregarDesembolso, actualizarDesembolso, eliminarDesembolso, respuesta,
        obtenerDescuentos, descuentos
    }
}
