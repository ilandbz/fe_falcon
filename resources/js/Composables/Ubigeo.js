import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useUbigeo() {
    const departamentos = ref([])
    const provincias = ref([])
    const distritos = ref([])
    const errors = ref('')
    const respuesta = ref([])
    const obtenerDepartamentos = async()=>{
        let respuesta = await axios.get('ubigeo/departamentos',getConfigHeader())
        departamentos.value = respuesta.data        
    }
    const obtenerProvincias = async(departamento_id) => {
        const respond = await axios.get('ubigeo/provincias?departamento_id='+departamento_id,getConfigHeader())
        provincias.value = respond.data  
    }
    const obtenerDistritos = async(provincia_id) => {
        const respond = await axios.get('ubigeo/distritos?provincia_id='+provincia_id,getConfigHeader())
        distritos.value = respond.data  
    }    
    return {
        errors, provincias, departamentos, distritos, obtenerDepartamentos, obtenerProvincias, obtenerDistritos,
        respuesta
    }
}