import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'

export default function useFeriado() {
    const feriados = ref([])
    const errors = ref('')
    const feriado = ref({})
    const respuesta = ref([])
    
    const obtenerFeriado = async(id) => {
        let respuesta = await axios.get('feriado/mostrar?id='+id, getConfigHeader())
        feriado.value = respuesta.data
    }
    const listaFeriados = async()=>{
        let respuesta = await axios.get('feriado/todos', getConfigHeader())
        feriados.value = respuesta.data        
    }
    const obtenerFeriados = async(data) => {
        let respuesta = await axios.get('feriado/listar' + getdataParamsPagination(data), getConfigHeader())
        feriados.value = respuesta.data
    }
    const agregarFeriado = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('feriado/guardar', data, getConfigHeader())
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
    const actualizarFeriado = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('feriado/actualizar', data, getConfigHeader())
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
    const eliminarFeriado = async(id) => {
        const respond = await axios.post('feriado/eliminar', { id: id }, getConfigHeader())
        if (respond.data.ok == 1) {
            respuesta.value = respond.data
        }
    }
    return {
        errors, feriados, listaFeriados, feriado, obtenerFeriado, obtenerFeriados, 
        agregarFeriado, actualizarFeriado, eliminarFeriado, respuesta
    }
}