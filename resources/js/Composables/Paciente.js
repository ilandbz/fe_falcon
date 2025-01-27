import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function usePaciente() {
    const pacientes = ref([])
    const errors = ref('')
    const paciente = ref({})
    const respuesta = ref([])
    
    const obtenerPaciente = async(id) => {
        let respuesta = await axios.get('paciente/mostrar?id='+id,getConfigHeader())
        paciente.value = respuesta.data
    }
    const listaPacientes = async()=>{
        let respuesta = await axios.get('paciente/todos',getConfigHeader())
        pacientes.value = respuesta.data        
    }
    const obtenerPacientes = async(data) => {
        let respuesta = await axios.get('paciente/listar' + getdataParamsPagination(data),getConfigHeader())
        pacientes.value =respuesta.data
    }
    const agregarPaciente = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('paciente/guardar',data,getConfigHeader())
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
    const actualizarPaciente = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('paciente/actualizar',data,getConfigHeader())
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
    const eliminarPaciente = async(id) => {
        const respond = await axios.post('paciente/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, pacientes, listaPacientes, paciente, obtenerPaciente, obtenerPacientes, 
        agregarPaciente, actualizarPaciente, eliminarPaciente, respuesta
    }
}