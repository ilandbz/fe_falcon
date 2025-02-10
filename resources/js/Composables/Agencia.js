import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useAgencia() {
    const agencias = ref([])
    const errors = ref('')
    const agencia = ref({})
    const respuesta = ref([])
    
    const obtenerAgencia = async(id) => {
        let respuesta = await axios.get('agencia/mostrar?id='+id,getConfigHeader())
        agencia.value = respuesta.data
    }
    const listaAgencias = async()=>{
        let respuesta = await axios.get('agencia/todos',getConfigHeader())
        agencias.value = respuesta.data        
    }
    const obtenerAgencias = async(data) => {
        let respuesta = await axios.get('agencia/listar' + getdataParamsPagination(data),getConfigHeader())
        agencias.value =respuesta.data
    }
    const agregarAgencia = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('agencia/guardar',data,getConfigHeader())
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
    const actualizarAgencia = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('agencia/actualizar',data,getConfigHeader())
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
    const eliminarAgencia = async(id) => {
        const respond = await axios.post('agencia/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, agencias, listaAgencias, agencia, obtenerAgencia, obtenerAgencias, 
        agregarAgencia, actualizarAgencia, eliminarAgencia, respuesta
    }
}