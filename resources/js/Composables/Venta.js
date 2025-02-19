import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useVenta() {
    const errors = ref('')
    const venta = ref({})
    const respuesta = ref([])
    const detalleVenta = ref([])
    const obtenerVenta = async(id) => {
        let respuesta = await axios.get('rol/mostrar?id='+id,getConfigHeader())
        role.value = respuesta.data
    }


    const agregarVenta = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('rol/guardar',data,getConfigHeader())
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
    const actualizarRole = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('rol/actualizar',data,getConfigHeader())
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
    const eliminarRole = async(id) => {
        const respond = await axios.post('rol/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, roles, listaRoles, role, obtenerVenta, 
        agregarVenta, actualizarRole, eliminarRole, respuesta
    }
}