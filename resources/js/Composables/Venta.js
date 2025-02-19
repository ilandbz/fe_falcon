import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useVenta() {
    const errors = ref('')
    const regventa = ref({})
    const respuesta = ref([])
    const detalleVenta = ref([])
    const obtenerVenta = async(id) => {
        let respuesta = await axios.get('ventapyg/mostrar?credito_id='+id,getConfigHeader())
        regventa.value = respuesta.data

    }


    const agregarVenta = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('ventapyg/guardar',data,getConfigHeader())
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
    const actualizarVenta = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('ventapyg/actualizar',data,getConfigHeader())
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
    const eliminarVenta = async(id) => {
        const respond = await axios.post('ventapyg/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, regventa, obtenerVenta, 
        agregarVenta, actualizarVenta, eliminarVenta, respuesta
    }
}