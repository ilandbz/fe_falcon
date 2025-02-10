import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'

export default function useAsesor() {
    const asesores = ref([])
    const errors = ref('')
    const asesor = ref({})
    const respuesta = ref([])
    
    const obtenerAsesor = async(id) => {
        let respuesta = await axios.get('asesor/mostrar?id='+id, getConfigHeader())
        asesor.value = respuesta.data
    }
    const listaAsesores = async()=>{
        let respuesta = await axios.get('asesor/todos', getConfigHeader())
        asesores.value = respuesta.data        
    }
    const obtenerAsesores = async(data) => {
        let respuesta = await axios.get('asesor/listar' + getdataParamsPagination(data), getConfigHeader())
        asesores.value = respuesta.data
    }
    const agregarAsesor = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('asesor/guardar', data, getConfigHeader())
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
    const actualizarAsesor = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('asesor/actualizar', data, getConfigHeader())
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
    const eliminarAsesor = async(id) => {
        const respond = await axios.post('asesor/eliminar', { id: id }, getConfigHeader())
        if (respond.data.ok == 1) {
            respuesta.value = respond.data
        }
    }
    return {
        errors, asesores, listaAsesores, asesor, obtenerAsesor, obtenerAsesores, 
        agregarAsesor, actualizarAsesor, eliminarAsesor, respuesta
    }
}
