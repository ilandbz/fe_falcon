import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader } from '@/Helpers'

export default function useTipoActividad() {
    const tiposActividades = ref([])
    const errors = ref('')
    const tipoActividad = ref({})
    const respuesta = ref([])
    
    const obtenerTipoActividad = async(id) => {
        let respuesta = await axios.get('tipo-actividad/mostrar?id='+id, getConfigHeader())
        tipoActividad.value = respuesta.data
    }
    const listaTipoActividades = async()=>{
        let respuesta = await axios.get('tipo-actividad/todos', getConfigHeader())
        tiposActividades.value = respuesta.data        
    }
    const agregarTipoActividad = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('tipo-actividad/guardar', data, getConfigHeader())
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
    const eliminarTipoActividad = async(id) => {
        const respond = await axios.post('tipo-actividad/eliminar', { id: id }, getConfigHeader())
        if (respond.data.ok == 1) {
            respuesta.value = respond.data
        }
    }
    return {
        errors, tiposActividades, listaTipoActividades, tipoActividad, obtenerTipoActividad, 
        agregarTipoActividad, eliminarTipoActividad, respuesta
    }
}
