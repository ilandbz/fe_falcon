import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'

export default function useEstadoCivil() {
    const estadosCiviles = ref([])
    const errors = ref('')
    const estadoCivil = ref({})
    const respuesta = ref([])
    
    const obtenerEstadoCivil = async(id) => {
        let respuesta = await axios.get('estado-civil/mostrar?id='+id, getConfigHeader())
        estadoCivil.value = respuesta.data
    }
    const listaEstadosCiviles = async()=>{
        let respuesta = await axios.get('estado-civil/todos', getConfigHeader())
        estadosCiviles.value = respuesta.data        
    }
    const obtenerEstadosCiviles = async(data) => {
        let respuesta = await axios.get('estado-civil/listar' + getdataParamsPagination(data), getConfigHeader())
        estadosCiviles.value = respuesta.data
    }
    const agregarEstadoCivil = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('estado-civil/guardar', data, getConfigHeader())
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
    const actualizarEstadoCivil = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('estado-civil/actualizar', data, getConfigHeader())
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
    const eliminarEstadoCivil = async(id) => {
        const respond = await axios.post('estado-civil/eliminar', { id: id }, getConfigHeader())
        if (respond.data.ok == 1) {
            respuesta.value = respond.data
        }
    }
    return {
        errors, estadosCiviles, listaEstadosCiviles, estadoCivil, obtenerEstadoCivil, obtenerEstadosCiviles, 
        agregarEstadoCivil, actualizarEstadoCivil, eliminarEstadoCivil, respuesta
    }
}
