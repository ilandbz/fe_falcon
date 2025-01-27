import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function usePeriodo() {
    const periodos = ref([])
    const errors = ref('')
    const menu = ref({})
    const respuesta = ref([])
    
    const obtenerPeriodo = async(id) => {
        let respuesta = await axios.get('periodo/mostrar?id='+id,getConfigHeader())
        menu.value = respuesta.data
    }
    const listaPeriodos = async()=>{
        let respuesta = await axios.get('periodo/todos',getConfigHeader())
        periodos.value = respuesta.data        
    }
    const obtenerPeriodos = async(data) => {
        let respuesta = await axios.get('periodo/listar' + getdataParamsPagination(data),getConfigHeader())
        periodos.value =respuesta.data
    }
    const agregarPeriodo = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('periodo/guardar',data,getConfigHeader())
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
    const actualizarMenu = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('periodo/actualizar',data,getConfigHeader())
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
    const eliminarPeriodo = async(id) => {
        const respond = await axios.post('periodo/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, periodos, listaPeriodos, menu, obtenerPeriodo, obtenerPeriodos, 
        agregarPeriodo, actualizarMenu, eliminarPeriodo, respuesta
    }
}