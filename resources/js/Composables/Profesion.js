import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'

export default function useProfesion() {
    const profesiones = ref([])
    const errors = ref('')
    const profesion = ref({})
    const respuesta = ref([])
    
    const obtenerProfesion = async(id) => {
        let respuesta = await axios.get('profesion/mostrar?id='+id, getConfigHeader())
        profesion.value = respuesta.data
    }
    const listaProfesiones = async()=>{
        let respuesta = await axios.get('profesion/todos', getConfigHeader())
        profesiones.value = respuesta.data        
    }
    const obtenerProfesiones = async(data) => {
        let respuesta = await axios.get('profesion/listar' + getdataParamsPagination(data), getConfigHeader())
        profesiones.value = respuesta.data
    }
    const agregarProfesion = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('profesion/guardar', data, getConfigHeader())
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
    const actualizarProfesion = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('profesion/actualizar', data, getConfigHeader())
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
    const eliminarProfesion = async(id) => {
        const respond = await axios.post('profesion/eliminar', { id: id }, getConfigHeader())
        if (respond.data.ok == 1) {
            respuesta.value = respond.data
        }
    }
    return {
        errors, profesiones, listaProfesiones, profesion, obtenerProfesion, obtenerProfesiones, 
        agregarProfesion, actualizarProfesion, eliminarProfesion, respuesta
    }
}
