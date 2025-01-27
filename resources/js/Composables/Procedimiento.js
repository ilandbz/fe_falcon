import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function usePersonal() {
    const procedimientos = ref([])
    const errors = ref('')
    const procedimiento = ref({})
    const respuesta = ref([])
    const insumos = ref([])
    const obtenerProcedimiento = async(id) => {
        let respuesta = await axios.get('procedimiento/mostrar?id='+id,getConfigHeader())
        procedimiento.value = respuesta.data
    }
    const listaProcedimientos = async()=>{
        let respuesta = await axios.get('procedimiento/todos',getConfigHeader())
        procedimientos.value = respuesta.data        
    }
    const obtenerProcedimientos = async(data) => {
        let respuesta = await axios.get('procedimiento/listar' + getdataParamsPagination(data),getConfigHeader())
        procedimientos.value =respuesta.data
    }
    const obtenerInsumos = async(id) => {
        let respuesta = await axios.get('procedimiento/insumos?codigo='+id,getConfigHeader())
        insumos.value = respuesta.data
    }    
    const obtenerProcedimientosMinsa = async(data, periodo) => {
        errors.value = ''
        try {
            let respond = await axios.post('reporte/procedimientos-minsa' + getdataParamsPagination(data),periodo,getConfigHeader())
            errors.value =''
            procedimientos.value=respond.data

        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }    
    const agregarProcedimiento = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('procedimiento/guardar',data,getConfigHeader())
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
    const actualizarProcedimiento = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('procedimiento/actualizar',data,getConfigHeader())
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
    const eliminarProcedimiento = async(id) => {
        const respond = await axios.post('procedimiento/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    
    return {
        errors, procedimientos, listaProcedimientos, procedimiento, obtenerProcedimiento, obtenerProcedimientos, 
        agregarProcedimiento, actualizarProcedimiento, eliminarProcedimiento, respuesta, obtenerProcedimientosMinsa,
        obtenerInsumos, insumos
    }
}