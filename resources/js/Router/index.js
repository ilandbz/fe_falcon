import { createRouter, createWebHistory } from "vue-router";
// import jwt_decode from 'jwt-decode';
import { jwtDecode } from 'jwt-decode'
//PLANTILLAS
import LayoutLogin from '@/Layouts/AppLayoutLogin.vue'
import LayoutDefault from '@/Layouts/AppLayoutDefault.vue'

//vistas
import Principal from '@/Pages/Principal.vue'
import Login from '@/Pages/Auth/Login.vue'
import Menu from '@/Pages/Menu/Inicio.vue'
import Usuario from '@/Pages/Usuario/Inicio.vue'
import Agencia from '@/Pages/Agencia/Inicio.vue'
import Cliente from '@/Pages/Cliente/Inicio.vue';
import Creditos from '@/Pages/Credito/Inicio.vue';
import Asesor from '@/Pages/Asesor/Inicio.vue';
import Pagos from '@/Pages/Pagos/Inicio.vue';
import CobranzaCampo from '@/Pages/CobranzaCampo/Inicio.vue';
import Desembolso from '@/Pages/Desembolso/Inicio.vue';
import HabilitarAsesor from '@/Pages/HabilitarAsesor/Inicio.vue';
import Tickets from '@/Pages/Tickets/Inicio.vue';
import Registros from '@/Pages/Registros/Inicio.vue';
import Devolucion from '@/Pages/Devolucion/Inicio.vue';
import Evaluacion from '@/Pages/Evaluacion/Inicio.vue';
import Evaluacion2 from '@/Pages/Evaluacion2/Inicio.vue';
import Extornar from '@/Pages/Extornar/Inicio.vue';
import CreditosAsesor from '@/Pages/GrupoAsesor/Credito/Inicio.vue';
const routes = [
    {
        path: '/', name:'Principal', component: Principal ,
        meta:{layout: LayoutDefault}
    },
    {
        path: '/login',name: 'Login', component: Login,
        meta: {layout: LayoutLogin}
    },
    {
        path: '/gestion-menus',name: 'Menus', component: Menu,
        meta: {layout: LayoutDefault}
    },
    {
        path: '/gestion-usuarios',name: 'Usuarios', component: Usuario,
        meta: {layout: LayoutDefault}
    },

    {
        path: '/gestion-agencias',name: 'GestionAgencias', component: Agencia,
        meta: {layout: LayoutDefault}
    },

    {
        path: '/gestion-cliente',
        name: 'Cliente',
        component: Cliente,
        meta: { layout: LayoutDefault }
    },
    {
        path: '/gestion-creditos',
        name: 'Creditos',
        component: Creditos,
        meta: { layout: LayoutDefault }
    },
    {
        path: '/gestion-asesor',
        name: 'Asesor',
        component: Asesor,
        meta: { layout: LayoutDefault }
    },
    {
        path: '/gestion-pagos',
        name: 'Pagos',
        component: Pagos,
        meta: { layout: LayoutDefault }
    },
    {
        path: '/gestion-cobranza-campo',
        name: 'CobranzaCampo',
        component: CobranzaCampo,
        meta: { layout: LayoutDefault }
    },
    {
        path: '/gestion-desembolso',
        name: 'Desembolso',
        component: Desembolso,
        meta: { layout: LayoutDefault }
    },
    {
        path: '/habilitar-asesor',
        name: 'HabilitarAsesor',
        component: HabilitarAsesor,
        meta: { layout: LayoutDefault }
    },
    {
        path: '/gestion-tickets',
        name: 'Tickets',
        component: Tickets,
        meta: { layout: LayoutDefault }
    },
    {
        path: '/gestion-registros',
        name: 'Registros',
        component: Registros,
        meta: { layout: LayoutDefault }
    },
    {
        path: '/gestion-devolucion',
        name: 'Devolucion',
        component: Devolucion,
        meta: { layout: LayoutDefault }
    },
    {
        path: '/evaluar-credito',
        name: 'Evaluacion',
        component: Evaluacion,
        meta: { layout: LayoutDefault }
    },
    {
        path: '/evaluar-credito-segundo-nivel',
        name: 'Evaluacion2',
        component: Evaluacion2,
        meta: { layout: LayoutDefault }
    },
    {
        path: '/extornar-desembolso',
        name: 'Extornar',
        component: Extornar,
        meta: { layout: LayoutDefault }
    },
    {
        path: '/extornar-desembolso',
        name: 'Extornar',
        component: Extornar,
        meta: { layout: LayoutDefault }
    },
    {
        path: '/gestion-creditos-asesor',
        name: 'creditosAsesor',
        component: CreditosAsesor,
        meta: { layout: LayoutDefault }
    },    
]

export default createRouter({
    history: createWebHistory(),
    routes
})