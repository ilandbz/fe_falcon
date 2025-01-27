import { onMounted, provide, ref } from 'vue';
import { storeToRefs } from 'pinia';
import { useUsuarioStore } from '@/Store';
import { jwtDecode } from 'jwt-decode'

export default function useDatosSession() {

    const user_id = localStorage.getItem('userSession') ? JSON.parse( JSON.stringify(jwtDecode(localStorage.getItem('userSession')).user)) : null
    ;

    const usuarioStore = useUsuarioStore();
    const  menuactivo = ref();
    const { usuario, menus, roles } = storeToRefs(usuarioStore)

    const { cargarDatosSession, modificarFoto, cargarMenus} = useUsuarioStore()

    const obtenerUsuarioSesion = async() => {
        if(user_id != null)
        {
            await cargarDatosSession();
            cargarMenus();
        }
    }

    onMounted(() => {
        obtenerUsuarioSesion()
    })

    const cambiarFoto = async(foto) => {
        modificarFoto(foto);
    }
    const obtenerMenupadreActivo = async(slug) => {
        let respuesta = await axios.get('obtener-menu-slug',{params:{slug:slug}})
        menuactivo.value = respuesta.data
    }
    return {
        usuario, menus, cambiarFoto, obtenerMenupadreActivo, menuactivo, roles
    }
}