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
import Medicina from '@/Pages/Medicina/Inicio.vue'
import Servicio from '@/Pages/Servicio/Inicio.vue'
import ReporteMedicamento from '@/Pages/Reportes/Medicamento/Inicio.vue'
import ReporteProcedimiento from '@/Pages/Reportes/Procedimiento/Inicio.vue'
import ReporteInsumo from '@/Pages/Reportes/Insumo/Inicio.vue'
import ReporteServicio from '@/Pages/Reportes/Servicio/Inicio.vue'
import Produccion from '@/Pages/Reportes/Produccion/Inicio.vue'
import Observadas from '@/Pages/Reportes/Observadas/Inicio.vue'
import Establecimiento from '@/Pages/Establecimiento/Inicio.vue'
import BrutaNeta from '@/Pages/Reportes/ProduccionMinsa/Inicio.vue'
import InsumoProcedimiento from '@/Pages/Procedimiento/insumo/Inicio.vue'
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
        path: '/gestion-medicina',name: 'Medicina', component: Medicina,
        meta: {layout: LayoutDefault}
    }, 
    {
        path: '/gestion-servicios',name: 'Servicio', component: Servicio,
        meta: {layout: LayoutDefault}
    }, 
  
    {
        path: '/reporte-medicamentos',name: 'ReporteMedicamento', component: ReporteMedicamento,
        meta: {layout: LayoutDefault}
    },
     
    {
        path: '/reporte-servicio',name: 'ReporteServicio', component: ReporteServicio,
        meta: {layout: LayoutDefault}
    },
    {
        path: '/reporte-insumo',name: 'ReporteInsumo', component: ReporteInsumo,
        meta: {layout: LayoutDefault}
    },
    {
        path: '/establecimiento',name: 'Establecimiento', component: Establecimiento,
        meta: {layout: LayoutDefault}
    },
    {
        path: '/reporte-produccion',name: 'ReporteProduccion', component: Produccion,
        meta: {layout: LayoutDefault}
    }, 
    {
        path: '/fuas-observadas',name: 'ReporteObservadas', component: Observadas,
        meta: {layout: LayoutDefault}
    },
    {
        path: '/produccion-bruta-neta',name: 'ReporteProduccionNB', component: BrutaNeta,
        meta: {layout: LayoutDefault}
    },
    {
        path: '/insumo-procedimiento',name: 'InsumoProcedimiento', component: InsumoProcedimiento,
        meta: {layout: LayoutDefault}
    },    
]

export default createRouter({
    history: createWebHistory(),
    routes
})