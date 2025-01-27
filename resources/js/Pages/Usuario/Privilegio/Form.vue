<script setup>
import { toRefs } from 'vue'
import useMenuRole from '@/Composables/menu-role.js'
import useHelper from '@/Helpers'
    const props = defineProps({
        role_menu: Object,
        menus : Object
    });
    const { role_menu, menus } = toRefs(props)


    const {agregarMenuRole, mrRespuesta} = useMenuRole()
    const { hideModal, Toast} = useHelper()
    const agregar = async() => {
        await agregarMenuRole(role_menu.value)
        if(mrRespuesta.value.ok==1){
            Toast.fire({icon:'success', title:mrRespuesta.value.mensaje})
        }
    }
    const guardar = () =>{
        agregar()
    }

</script>
<template>
    <div class="card border border-info">
        <div class="card-header bg-info text-white">
            <h3 class="card-title">Menus para:... {{ role_menu.role_nombre }}</h3>
        </div>
        <div class="card-body">
            <div class="tab-content pt-0" id="tab-contenido">
                <div v-for="menu in menus" :key="menu.id" >
                    <label>
                        <input type="checkbox"  :value="menu.id" v-model="role_menu.menu_id">
                        {{ menu.nombre }} <small v-if="menu.slug">(Enlace: {{ menu.slug }})</small>
                    </label>

                    <ul v-if="menu.menus.length>0">
                        <li v-for="submenu in menu.menus" :key="submenu.id">
                            <label>
                                <input type="checkbox"  :value="submenu.id" v-model="role_menu.menu_id">
                                {{ submenu.nombre }} <small v-if="submenu.slug">(Enlace: {{ submenu.slug }})</small>
                            </label>
                        </li>
                    </ul>
                </div>
                <div class="row container-fluid text-center" v-if="role_menu.role_nombre">
                    <button type="button" class="btn btn-success" @click="guardar">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>