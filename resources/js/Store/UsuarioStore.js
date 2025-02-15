import { defineStore } from "pinia";
import axios from "axios";
import { jwtDecode } from 'jwt-decode'
import router from '@/Router';
export const useUsuarioStore = defineStore("usuario", {

    state: () => ({
        usuario: {},
        menus:[],
        roles:[],
        role:{},
        agencia:{},
        agencias:[],
    }),
    actions: {
        async cargarDatosSession(){
            const ls = localStorage.getItem('userSession');
            const user_id = ls ? JSON.parse( JSON.stringify(jwtDecode(ls).user)) : null;
            const role_id = ls ? JSON.parse( JSON.stringify(jwtDecode(ls).roleid)) : null;
            const agencia_id = ls ? JSON.parse( JSON.stringify(jwtDecode(ls).agenciaid)) : null;
            try {
                const response = await axios.get('usuario-session-data/', { params: { id: user_id } });
                const response2 = await axios.get('mostrar-role', { params: { id: role_id } });
                const response3 = await axios.get('mostrar-agencia', { params: { id: agencia_id } });
                this.usuario = response.data.usuario;
                this.role = response2.data.role;
                this.roles = response.data.usuario.roles ?? []
                this.agencias = response.data.usuario.agencias ?? []               
                this.agencia = response3.data.agencia
                this.cargarMenus(role_id)
            } catch (error) {
                if (error.response) {
                    const status = error.response.status;
                    if (status === 401) {
                        localStorage.removeItem('userSession');
                        router.push('/login');
                    }
                }
            }
        },
        modificarFoto(foto) {
            this.usuario.foto = foto
        },
        async cargarMenus(role_id) {
            const response3 = await axios.get('obtener-menus-role/', { params: { role_id: role_id } });
            this.menus = response3.data.menus;
        },
        async cambiarRole(id, agenciaid){
            const respuesta = await axios.post('cambiar-role', { id: id, agenciaid:agenciaid })
            if(respuesta.data)
            {
                localStorage.setItem('userSession',respuesta.data);
                window.location.href = '/';
            }
        },
        async cambiarAgencia(id, roleid){
            const respuesta = await axios.post('cambiar-agencia', { id: id, roleid:roleid })
            if(respuesta.data)
            {
                localStorage.setItem('userSession',respuesta.data);
                window.location.href = '/';
            }
        },        
        actualizarDatosSession(usuario, menus) {
            
            this.usuario = usuario;
            this.menus = menus
        },
        limpiarEstados() {
            // this.usuario = {};
            // this.menus = [this.menus];
            // this.roles = [this.roles];
            // this.role=null;
            // this.agencia=null;
            // this.agencias = [];
        }
    }
})