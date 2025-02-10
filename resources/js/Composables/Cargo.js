import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'

export default function useCargo() {
    const cargos = ref([])
    const errors = ref('')
    const cargo = ref({})
    const respuesta = ref([])
    
    const obtenerCargo = async(id) => {
        let respuesta = await axios.get('cargo/mostrar?id='+id, getConfigHeader())
        cargo.value = respuesta.data
    }
    const listaCargos = async()=>{
        let respuesta = await axios.get('cargo/todos', getConfigHeader())
        cargos.value = respuesta.data        
    }
    const obtenerCargos = async(data) => {
        let respuesta = await axios.get('cargo/listar' + getdataParamsPagination(data), getConfigHeader())
        cargos.value = respuesta.data
    }
    const agregarCargo = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('cargo/guardar', data, getConfigHeader())
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
    const actualizarCargo = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('cargo/actualizar', data, getConfigHeader())
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
    const eliminarCargo = async(id) => {
        const respond = await axios.post('cargo/eliminar', { id: id }, getConfigHeader())
        if (respond.data.ok == 1) {
            respuesta.value = respond.data
        }
    }
    return {
        errors, cargos, listaCargos, cargo, obtenerCargo, obtenerCargos, 
        agregarCargo, actualizarCargo, eliminarCargo, respuesta
    }
}
