import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useMenu() {
    const menus = ref([])
    const errors = ref('')
    const menu = ref({})
    const respuesta = ref([])
    
    const obtenerMenu = async(id) => {
        let respuesta = await axios.get('menu/mostrar?id='+id,getConfigHeader())
        menu.value = respuesta.data
    }
    const listaMenus = async()=>{
        let respuesta = await axios.get('menu/todos',getConfigHeader())
        menus.value = respuesta.data        
    }
    const obtenerMenus = async(data) => {
        let respuesta = await axios.get('menu/listar' + getdataParamsPagination(data),getConfigHeader())
        menus.value =respuesta.data
    }
    const agregarMenu = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('menu/guardar',data,getConfigHeader())
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
    const actualizarMenu = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('menu/actualizar',data,getConfigHeader())
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
    const eliminarMenu = async(id) => {
        const respond = await axios.post('menu/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, menus, listaMenus, menu, obtenerMenu, obtenerMenus, 
        agregarMenu, actualizarMenu, eliminarMenu, respuesta
    }
}