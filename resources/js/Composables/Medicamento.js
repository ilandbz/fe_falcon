import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useMedicamento() {
    const medicamentos = ref([])
    const errors = ref('')
    const medicamento = ref({})
    const respuesta = ref([])
    
    const obtenerMedicamento = async(id) => {
        let respuesta = await axios.get('medicamento/mostrar?id='+id,getConfigHeader())
        medicamento.value = respuesta.data
    }
    const listaMedicamentos = async()=>{
        let respuesta = await axios.get('medicamento/todos',getConfigHeader())
        medicamentos.value = respuesta.data        
    }
    const obtenerMedicamentos = async(data) => {
        let respuesta = await axios.get('medicamento/listar' + getdataParamsPagination(data),getConfigHeader())
        medicamentos.value =respuesta.data
    }
    const obtenerMedicamentosMinsa = async(data, periodo) => {
        errors.value = ''
        try {
            let respond = await axios.post('reporte/medicamentos-minsa' + getdataParamsPagination(data),periodo,getConfigHeader())
            errors.value =''
            medicamentos.value=respond.data

        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }    
    const agregarMedicamento = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('medicamento/guardar',data,getConfigHeader())
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
    const actualizarMedicamento = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('medicamento/actualizar',data,getConfigHeader())
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
    const eliminarMedicamento = async(id) => {
        const respond = await axios.post('medicamento/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, medicamentos, listaMedicamentos, medicamento, obtenerMedicamento, obtenerMedicamentos, 
        agregarMedicamento, actualizarMedicamento, eliminarMedicamento, respuesta, obtenerMedicamentosMinsa
    }
}