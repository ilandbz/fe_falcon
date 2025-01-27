import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useEstablecimiento() {
    const establecimientos = ref([])
    const errors = ref('')
    const establecimiento = ref({})
    const respuesta = ref([])
    
    const obtenerEstablecimiento = async(id) => {
        let respuesta = await axios.get('establecimiento/mostrar?id='+id,getConfigHeader())
        establecimiento.value = respuesta.data
    }
    const listaEstablecimientos = async()=>{
        let respuesta = await axios.get('establecimiento/todos',getConfigHeader())
        establecimientos.value = respuesta.data        
    }
    const obtenerEstablecimientos = async(data) => {
        let respuesta = await axios.get('establecimiento/listar' + getdataParamsPagination(data),getConfigHeader())
        establecimientos.value =respuesta.data
    }
    const agregarEstablecimiento = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('establecimiento/guardar',data,getConfigHeader())
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
    const actualizarEstablecimiento = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('establecimiento/actualizar',data,getConfigHeader())
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
    const eliminarestablecimiento = async(id) => {
        const respond = await axios.post('establecimiento/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, establecimientos, listaEstablecimientos, establecimiento, obtenerEstablecimiento, obtenerEstablecimientos, 
        agregarEstablecimiento, actualizarEstablecimiento, eliminarestablecimiento, respuesta
    }
}