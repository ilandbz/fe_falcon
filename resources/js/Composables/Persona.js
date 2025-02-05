import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function usePersona() {
    const persona = ref({})
    const errors = ref('')
    const respuesta = ref([])
    const obtenerPorDni = async(dni) => {
        let respuesta = await axios.get('persona/mostrar-por-dni?dni='+dni,getConfigHeader())
        persona.value = respuesta.data
    }
    
    return {
        errors, persona, respuesta, obtenerPorDni
    }
}