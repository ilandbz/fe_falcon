import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'

export default function useCliente() {
    const clientes = ref([])
    const errors = ref('')
    const cliente = ref({})
    const respuesta = ref([])
    
    const obtenerCliente = async(id) => {
        let respuesta = await axios.get('cliente/mostrar?id='+id, getConfigHeader())
        cliente.value = respuesta.data
    }
    const listaClientes = async()=>{
        let respuesta = await axios.get('cliente/todos', getConfigHeader())
        clientes.value = respuesta.data        
    }
    const obtenerClientes = async(data) => {
        let respuesta = await axios.get('cliente/listar' + getdataParamsPagination(data), getConfigHeader())
        clientes.value = respuesta.data
    }
    const agregarCliente = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('cliente/guardar', data, getConfigHeader())
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
    const actualizarCliente = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('cliente/actualizar', data, getConfigHeader())
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
    const eliminarCliente = async(id) => {
        const respond = await axios.post('cliente/eliminar', { id: id }, getConfigHeader())
        if (respond.data.ok == 1) {
            respuesta.value = respond.data
        }
    }
    return {
        errors, clientes, listaClientes, cliente, obtenerCliente, obtenerClientes, 
        agregarCliente, actualizarCliente, eliminarCliente, respuesta
    }
}
