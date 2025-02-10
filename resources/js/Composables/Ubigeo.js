import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useUbigeo() {
    const departamentos = ref([])
    const provincias = ref([])
    const distritos = ref([])
    const errors = ref('')
    const respuesta = ref([])
    const registro = ref([])
    const obtenerDistritos = async(data) => {
        const respond = await axios.get('ubigeo/lista-distritos'+getdataParamsPagination(data),getConfigHeader())
        distritos.value = respond.data  
    }
    const obtenerUbigeo = async(ubigeo) => {
        try {
            let respond = await axios.get('ubigeo/obtener?ubigeo='+ubigeo,getConfigHeader())
            registro.value = respond.data
        } catch (error) {
            errors.value = error.response.data
        }
    }    
    return {
        errors, distritos, obtenerDistritos,
        respuesta, obtenerUbigeo, registro
    }
}