import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useGrupoMenu() {
    const grupos = ref([])
    const errors = ref('')
    const grupo = ref({})
    const respuesta = ref([])
    
    const obtenerGrupo = async(id) => {
        let respuesta = await axios.get('grupo-menu/mostrar?id='+id,getConfigHeader())
        grupo.value = respuesta.data
    }
    const listaGrupos = async()=>{
        let respuesta = await axios.get('grupo-menu/todos',getConfigHeader())
        grupos.value = respuesta.data        
    }
    const obtenerGrupos = async(data) => {
        let respuesta = await axios.get('grupo-menu/listar' + getdataParamsPagination(data),getConfigHeader())
        grupos.value =respuesta.data
    }
    const agregarGrupo = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('grupo-menu/guardar',data,getConfigHeader())
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
    const actualizarGrupo = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('grupo-menu/actualizar',data,getConfigHeader())
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
    const eliminarGrupo = async(id) => {
        const respond = await axios.post('grupo-menu/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, grupos, listaGrupos, grupo, obtenerGrupo, obtenerGrupos, 
        agregarGrupo, actualizarGrupo, eliminarGrupo, respuesta
    }
}