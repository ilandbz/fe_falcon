<script setup>
  import { ref, onMounted } from 'vue';
  import useRol from '@/Composables/Rol.js';
  import useMenuRole from '@/Composables/menu-role'
  import useHelper from '@/Helpers';  
  import MenuRoleForm from './Form.vue'
  const { openModal, Toast, Swal } = useHelper();
  const {roles, listaRoles} = useRol()
  const {listarRoleMenus, roleMenus,
            role, listarMenus, menus} = useMenuRole()
    const titleHeader = ref({
      titulo: "Menu Role",
      subTitulo: "Inicio",
      icon: "",
      vista: ""
    });
  const obtenerRoles = async() =>{
        await listaRoles()
    }
    const role_menu=ref({
        role_id      : '',
        role_nombre  : '',
        menu_id      : []
    })

    const errors=''
    onMounted(() => {
        obtenerRoles()
    })
    const mostrarRoleMenus = async() =>{
        await listarRoleMenus(role_menu.value)
        await listarMenus()
        role_menu.value.menu_id = []
        role_menu.value.role_nombre=role.value.nombre
        roleMenus.value.forEach(m=>{
            role_menu.value.menu_id.push(m.id)
        })
        
    }
</script>
<template>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline mt-2">
            <div class="card-header">
                <h6 class="card-title">
                    Listado de Registros Menu - Rol
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header text-white bg-primary">
                                Roles
                            </div>
                            <div class="card-body ">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-form-label-sm col-md-3">Rol</label>
                                    <div class="col-md-9">
                                        <select class="form-control form-control-sm"
                                            v-model="role_menu.role_id"
                                            :class="{ 'is-invalid' : errors.role_id}">
                                            <option value="" :class="role_menu.role_id == '' ? 'd-block' : 'd-none'" disabled>-Seleccionar-</option>
                                            <option  v-for="rol in roles" :key="rol.id"
                                                :value="rol.id" :title="rol.nombre">
                                                {{ rol.nombre}}
                                            </option>
                                        </select>
                                        <small class="text-danger" v-for="error in errors.role_id"
                                        :key="error">{{error }}</small>
                                    </div>
                                </div>
                                <br />
                                <button class="btn btn-primary btn-block" @click="mostrarRoleMenus" :disabled="role_menu.role_id==''">Generar <i class="fas fa-arrow-alt-circle-right"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <menu-role-form :role_menu="role_menu" :menus="menus" v-if="role_menu.role_nombre"></menu-role-form>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</template>