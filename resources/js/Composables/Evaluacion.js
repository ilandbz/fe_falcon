import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useEvaluacion() {
    const evaluaciones = ref([])
    const errors = ref('')
    const evaluacion = ref({})
    const respuesta = ref([])
    
    const obtenerEvaluacion = async(id) => {
        let respuesta = await axios.get('evaluacion-gerente/mostrar?id='+id,getConfigHeader())
        evaluacion.value = respuesta.data
    }
    const obtenerEvaluaciones = async(data) => {
        let respuesta = await axios.get('evaluacion-gerente/listar' + getdataParamsPagination(data),getConfigHeader())
        evaluaciones.value =respuesta.data
    }
    const agregarEvaluacion = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('evaluacion-gerente/guardar',data,getConfigHeader())
            errors.value =''
            if(respond.data.ok==1){
                respuesta.value=respond.data
            }
        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const actualizarEvaluacion = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('evaluacion-gerente/actualizar',data,getConfigHeader())
            errors.value =''
            if(respond.data.ok==1){
                respuesta.value=respond.data
            }

        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const eliminarEvaluacion = async(id) => {
        const respond = await axios.post('evaluacion-gerente/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, evaluaciones, evaluacion, obtenerEvaluacion, obtenerEvaluaciones, 
        agregarEvaluacion, actualizarEvaluacion, eliminarEvaluacion, respuesta
    }
}