import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'

export default function useNegocio() {
    const negocios = ref([])
    const errors = ref('')
    const negocio = ref({})
    const respuesta = ref([])
    
    const obtenerNegocio = async(id) => {
        let respuesta = await axios.get('negocio/mostrar?id='+id, getConfigHeader())
        negocio.value = respuesta.data
    }
    const listaNegocios = async()=>{
        let respuesta = await axios.get('negocio/todos', getConfigHeader())
        negocios.value = respuesta.data        
    }

    const listaNegociosPorCliente = async(cliente_id)=>{
        let respuesta = await axios.get('negocio/por-cliente?cliente_id='+cliente_id, getConfigHeader())
        negocios.value = respuesta.data        
    }
    
    const obtenerNegocios = async(data) => {
        let respuesta = await axios.get('negocio/listar' + getdataParamsPagination(data), getConfigHeader())
        negocios.value = respuesta.data
    }
    const agregarNegocio = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('negocio/guardar', data, getConfigHeader())
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
    const actualizarNegocio = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('negocio/actualizar', data, getConfigHeader())
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
    const eliminarNegocio = async(id) => {
        const respond = await axios.post('negocio/eliminar', { id: id }, getConfigHeader())
        if (respond.data.ok == 1) {
            respuesta.value = respond.data
        }
    }
    return {
        errors, negocios, listaNegocios, negocio, obtenerNegocio, obtenerNegocios, 
        agregarNegocio, actualizarNegocio, eliminarNegocio, respuesta, listaNegociosPorCliente
    }
}
