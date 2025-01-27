import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function usePrecioProcedimiento() {
    const registros = ref([])
    const errors = ref('')
    const respuesta = ref([])

    const obtenerProcedimientos = async(data, codigo) => {
        let respuesta = await axios.post('precio-procedimiento/listar' + getdataParamsPagination(data),{codigo:codigo},getConfigHeader())
        registros.value =respuesta.data
    }
    const obtenerPrecios = async(id)=>{
        let respuesta = await axios.get('precio-procedimiento/precios?procedimiento_id='+id,getConfigHeader())
        registros.value = respuesta.data        
    }
    return {
        errors, registros, obtenerProcedimientos, respuesta, errors, obtenerPrecios
    }
}