import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useDiagnostico() {
    const diagnosticos = ref([])
    const errors = ref('')
    const diagnostico = ref({})
    const respuesta = ref([])
    
    const obtenerDiagnostico = async(id) => {
        let respuesta = await axios.get('diagnostico/mostrar?id='+id,getConfigHeader())
        diagnostico.value = respuesta.data
    }
    const listaDiagnosticos = async()=>{
        let respuesta = await axios.get('diagnostico/todos',getConfigHeader())
        diagnosticos.value = respuesta.data        
    }
    const listaDiagnosticosByAtencion = async(id)=>{
        let respuesta = await axios.get('diagnostico/listar-por-atencion?atencion_id='+id)
        diagnosticos.value = respuesta.data        
    }    
    const obtenerDiagnosticos = async(data) => {
        let respuesta = await axios.get('diagnostico/listar' + getdataParamsPagination(data),getConfigHeader())
        diagnosticos.value =respuesta.data
    }
    const agregarDiagnostico = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('diagnostico/guardar',data,getConfigHeader())
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
    const actualizarDiagnostico = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('diagnostico/actualizar',data,getConfigHeader())
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
    const eliminarDiagnostico = async(id) => {
        const respond = await axios.post('diagnostico/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, diagnosticos, listaDiagnosticos, diagnostico, obtenerDiagnostico, obtenerDiagnosticos, 
        agregarDiagnostico, actualizarDiagnostico, eliminarDiagnostico, respuesta, listaDiagnosticosByAtencion
    }
}