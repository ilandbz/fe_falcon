import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useAlmacenProducto() {
    const errors = ref('')
    const registrosAp = ref([])
    const registro = ref({})
    const respuesta = ref([])

    const obtenerRegistrosAp = async(id) => {
        let respuesta = await axios.get('almacen-producto/listar?producto_id='+id,getConfigHeader())
        registrosAp.value =respuesta.data
    }

    const obtenerRegistro = async(id) => {
        let respuesta = await axios.get('almacen-producto/mostrar?id='+id,getConfigHeader())
        registro.value = respuesta.data
    }

    const agregarRegistro = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('almacen-producto/guardar',data,getConfigHeader())
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
    const actualizarRegistro = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('almacen-producto/actualizar',data,getConfigHeader())
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
    const eliminarRegistro = async(producto_id, conversion_id) => {
        const respond = await axios.post('almacen-producto/eliminar', {producto_id:producto_id, conversion_id:conversion_id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }

    return {
        errors, registro, registrosAp, respuesta,
        obtenerRegistrosAp, agregarRegistro, obtenerRegistro,
        eliminarRegistro, actualizarRegistro
    }
}