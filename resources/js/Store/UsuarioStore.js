import { defineStore } from "pinia";
import axios from "axios";
import { jwtDecode } from 'jwt-decode'
import router from '@/Router';
export const useUsuarioStore = defineStore("usuario", {

    state: () => ({
        usuario: {},
        menus:[],
        role:{},
    }),
    actions: {
        async cargarDatosSession(){
            const user_id = localStorage.getItem('userSession') ? 
                JSON.parse( JSON.stringify(jwtDecode(localStorage.getItem('userSession')).user)) 
                : null;
            // this.usuario = await axios.get('usuario-session-data/',{params:{id:user_id}}).then(
            //         (respuesta) => respuesta.data
            //     )
            try {
                const response = await axios.get('usuario-session-data/', { params: { id: user_id } });
                this.usuario = response.data.usuario;
                this.menus = response.data.menus ?? []
            } catch (error) {
                if (error.response) {
                    const status = error.response.status;
                    if (status === 401) {
                        localStorage.removeItem('userSession');
                        router.push('/login');
                    }
                }
            }
            if(this.usuario)
            {
                this.role = this.usuario.role
            }

        },
        modificarFoto(foto) {
            this.usuario.foto = foto
        },
        cargarMenus() {
            if(!this.menus)
            {
                this.menus = []
            }
        },
        limpiarEstados() {
            this.usuario = {};
            this.menus = [this.menus];
            this.roles = [this.roles];
            role:{};
        }
    }
})