import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'

export default function useTipoEntidad() {
    const tiposEntidad = ref([])
    const errors = ref('')
    const tipoEntidad = ref({})
    const respuesta = ref([])
    
    const obtenerTipoEntidad = async(id) => {
        let respuesta = await axios.get('tipo-entidad/mostrar?id='+id, getConfigHeader())
        tipoEntidad.value = respuesta.data
    }
    const listaTiposEntidad = async()=>{
        let respuesta = await axios.get('tipo-entidad/todos', getConfigHeader())
        tiposEntidad.value = respuesta.data        
    }
    const obtenerTiposEntidad = async(data) => {
        let respuesta = await axios.get('tipo-entidad/listar' + getdataParamsPagination(data), getConfigHeader())
        tiposEntidad.value = respuesta.data
    }
    const agregarTipoEntidad = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('tipo-entidad/guardar', data, getConfigHeader())
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
    const actualizarTipoEntidad = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('tipo-entidad/actualizar', data, getConfigHeader())
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
    const eliminarTipoEntidad = async(id) => {
        const respond = await axios.post('tipo-entidad/eliminar', { id: id }, getConfigHeader())
        if (respond.data.ok == 1) {
            respuesta.value = respond.data
        }
    }
    return {
        errors, tiposEntidad, listaTiposEntidad, tipoEntidad, obtenerTipoEntidad, obtenerTiposEntidad, 
        agregarTipoEntidad, actualizarTipoEntidad, eliminarTipoEntidad, respuesta
    }
}
