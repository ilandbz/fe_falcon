import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function usePrecioServicio() {
    const registros = ref([])
    const errors = ref('')
    const respuesta = ref([])

    const obtenerServicios = async(data, codigo) => {
        let respuesta = await axios.post('precio-servicio/listar' + getdataParamsPagination(data),{codigo:codigo},getConfigHeader())
        registros.value =respuesta.data
    }
    
    return {
        errors, registros, obtenerServicios, respuesta, errors
    }
}