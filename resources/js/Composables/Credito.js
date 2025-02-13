import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'

export default function useCredito() {
    const creditos = ref([])
    const errors = ref('')
    const credito = ref({})
    const respuesta = ref([])
    const tiposCreditos = ref([])
    const obtenerCredito = async(id) => {
        let respuesta = await axios.get('credito/mostrar?id='+id, getConfigHeader())
        credito.value = respuesta.data
    }
    const listaCreditos = async()=>{
        let respuesta = await axios.get('credito/todos', getConfigHeader())
        creditos.value = respuesta.data        
    }
    const listaTiposCreditos = async(cliente_id)=>{
        let respuesta = await axios.get('credito/tipo-credito-cliente?cliente_id='+cliente_id, getConfigHeader())
        tiposCreditos.value = respuesta.data         
    }
    const obtenerCreditos = async(data) => {
        let respuesta = await axios.get('credito/listar' + getdataParamsPagination(data), getConfigHeader())
        creditos.value = respuesta.data
    }
    const agregarCredito = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('credito/guardar', data, getConfigHeader())
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
    const actualizarCredito = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('credito/actualizar', data, getConfigHeader())
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
    const eliminarCredito = async(id) => {
        const respond = await axios.post('credito/eliminar', { id: id }, getConfigHeader())
        if (respond.data.ok == 1) {
            respuesta.value = respond.data
        }
    }

    return {
        errors, creditos, listaCreditos, credito, obtenerCredito, obtenerCreditos, 
        agregarCredito, actualizarCredito, eliminarCredito, respuesta, tiposCreditos, 
        listaTiposCreditos
    }
}
