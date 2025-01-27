import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function usePrecioInsumo() {
    const registros = ref([])
    const errors = ref('')
    const respuesta = ref([])

    const obtenerInsumos = async(data, codigo) => {
        let respuesta = await axios.post('precio-insumo/listar' + getdataParamsPagination(data),{codigo:codigo},getConfigHeader())
        registros.value =respuesta.data
    }
    const obtenerPrecios = async(id)=>{
        let respuesta = await axios.get('precio-insumo/precios?insumo_id='+id,getConfigHeader())
        registros.value = respuesta.data        
    }
    return {
        errors, registros, obtenerInsumos, respuesta, errors, obtenerPrecios
    }
}