import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useUsuario() {
    const usuarios = ref([])
    const errors = ref('')
    const usuario = ref({})

    const usuario2 = ref({})
    const respuesta = ref([])

    const obtenerUsuario = async(id) => {
        let respuesta = await axios.get('usuario/mostrar?id='+id,getConfigHeader())
        usuario.value = respuesta.data
    }
    const obtenerUsuarios = async(data) => {
        let respuesta = await axios.get('usuario/listar-'+data.show_tipo + getdataParamsPagination(data),getConfigHeader())
        usuarios.value =respuesta.data
    }
    const agregarUsuario = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('usuario/guardar',data,getConfigHeader())
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
    const actualizarUsuario = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('usuario/actualizar',data,getConfigHeader())
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
    const eliminarUsuario = async(id) => {
        const respond = await axios.post('usuario/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1){
            respuesta.value = respond.data
        }
    }
    const cambiarEstado = async(id)=>{
        errors.value = ''
        try {
            let respond = await axios.get('usuario/cambiar-estado?id='+id,getConfigHeader())
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
    const resetClaveUsuario = async(id) => {
        errors.value = ''
        try {
            let respond = await axios.post('usuario/reset-password',{id:id},getConfigHeader())
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
    const cambiarClave=async(data)=>{
        errors.value = ''
        try {
            let respond = await axios.post('usuario/cambiar-clave',data,getConfigHeader())
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
    return {
        errors, usuarios, usuario, obtenerUsuario, obtenerUsuarios, 
        agregarUsuario, actualizarUsuario, eliminarUsuario, respuesta,
        resetClaveUsuario, cambiarEstado, cambiarClave
    }
}