import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useInsumo() {
    const insumos = ref([])
    const errors = ref('')
    const insumo = ref({})
    const respuesta = ref([])
    
    const obtenerInsumo = async(id) => {
        let respuesta = await axios.get('insumo/mostrar?id='+id,getConfigHeader())
        insumo.value = respuesta.data
    }
    const listaInsumos = async()=>{
        let respuesta = await axios.get('insumo/todos',getConfigHeader())
        insumos.value = respuesta.data        
    }
    const obtenerInsumos = async(data) => {
        let respuesta = await axios.get('insumo/listar' + getdataParamsPagination(data),getConfigHeader())
        insumos.value =respuesta.data
    }
    const obtenerInsumosMinsa = async(data, periodo) => {
        errors.value = ''
        try {
            let respond = await axios.post('reporte/insumos-minsa' + getdataParamsPagination(data),periodo,getConfigHeader())
            errors.value =''
            insumos.value=respond.data

        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }    
    const agregarInsumo = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('insumo/guardar',data,getConfigHeader())
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
    const actualizarInsumo = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('insumo/actualizar',data,getConfigHeader())
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
    const eliminarInsumo = async(id) => {
        const respond = await axios.post('insumo/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, insumos, listaInsumos, insumo, obtenerInsumo, obtenerInsumos, 
        agregarInsumo, actualizarInsumo, eliminarInsumo, respuesta, obtenerInsumosMinsa
    }
}