import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useServicio() {
    
    const servicios = ref([])
    const errors = ref('')
    const servicio = ref({})
    const respuesta = ref([])
    
    const obtenerServicio = async(id) => {
        let respuesta = await axios.get('servicio/mostrar?id='+id,getConfigHeader())
        servicio.value = respuesta.data
    }
    const listaServicios = async()=>{
        let respuesta = await axios.get('servicio/todos',getConfigHeader())
        servicios.value = respuesta.data        
    }
    const obtenerServicios = async(data) => {
        let respuesta = await axios.get('servicio/listar' + getdataParamsPagination(data),getConfigHeader())
        servicios.value =respuesta.data
    }
    const agregarServicio = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('servicio/guardar',data,getConfigHeader())
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
    const actualizarServicio = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('servicio/actualizar',data,getConfigHeader())
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
    const eliminarServicio = async(id) => {
        const respond = await axios.post('servicio/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }

    const obtenerServiciosMinsa = async(data, periodo) => {
        errors.value = ''
        try {
            let respond = await axios.post('reporte/servicios-minsa' + getdataParamsPagination(data),periodo,getConfigHeader())
            errors.value =''
            servicios.value=respond.data

        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }    

    return {
        errors, servicios, listaServicios, servicio, obtenerServicio, obtenerServicios, 
        agregarServicio, actualizarServicio, eliminarServicio, respuesta, obtenerServiciosMinsa
    }
}