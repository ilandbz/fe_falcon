import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function usePrecioMedicamento() {
    const registros = ref([])
    const errors = ref('')
    const respuesta = ref([])
    

    const obtenerMedicamentos = async(data, codigo) => {
        let respuesta = await axios.post('precio-medicamento/listar' + getdataParamsPagination(data),{codigo:codigo},getConfigHeader())
        registros.value =respuesta.data
    }

    const obtenerPrecios = async(id)=>{
        let respuesta = await axios.get('precio-medicamento/precios?medicamento_id='+id,getConfigHeader())
        registros.value = respuesta.data        
    }
    return {
        errors, registros, obtenerMedicamentos, respuesta, errors, obtenerPrecios
    }
}