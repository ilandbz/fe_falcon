import axios from 'axios'
import { ref } from 'vue'

export default function usEntidad() {

    const entidad = ref({})
    const buscarEntidad = async(data)=>{
        let respuesta = await axios.post('api/consulta', data)
        entidad.value = respuesta.data   
    }

    return {
        buscarEntidad, entidad
    }
}
