<script setup>
import { toRefs, onMounted, ref } from 'vue';
const props = defineProps({
    usuario: Object,
});

const foto = ref('');
const imagenNoEncontrada = (event)=>{
    event.target.src = "/storage/fotos/default.png";
}

const { usuario } = toRefs(props)

onMounted(()=>{
  foto.value= '/storage/fotos/usuarios/';
});

</script>
<template>
  <div class="modal fade" id="perfilModal" tabindex="-1" role="dialog" aria-labelledby="perfilModal-label" >
      <div class="modal-dialog mt-6" role="document">
        <div class="modal-content border-0">
          <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
            <div class="position-relative z-1" data-bs-theme="light">
              <h4 class="mb-0 text-white" id="perfilModal-label">Perfil</h4>
            </div><button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body py-4 px-5">
            <div class="row">
              <div class="col-lg-12">
                <img id="inputImagen" :src="foto+usuario.name+'.webp'" class="img-fluid img-thumbnail" @error="imagenNoEncontrada">
                <div class="card shadow-sm border-0" style="max-width: 400px;">
                  <div class="card-body">
                      <p class="text-muted mb-1"><i class="bi bi-person-circle me-2"></i><strong>Rol:</strong> {{ usuario.role?.nombre }}</p>
                      <p class="text-muted mb-1"><i class="bi bi-person-circle me-2"></i><strong>Agencia:</strong> {{ usuario.agencia?.nombre }}</p>
                      <p class="text-muted mb-1"><i class="bi bi-person-circle me-2"></i><strong>Name:</strong> {{ usuario.name }}</p>
                      <p class="text-muted mb-1"><i class="bi bi-person-circle me-2"></i><strong>Nombre:</strong> {{ usuario.persona?.apenom }}</p>
                      <p class="text-muted mb-1"><i class="bi bi-credit-card me-2"></i><strong>DNI:</strong> {{ usuario.persona?.dni }}</p>
                      <p class="text-muted mb-1"><i class="bi bi-telephone me-2"></i><strong>Celular:</strong> {{ usuario.persona?.celular }}</p>
                      <p class="text-muted mb-0"><i class="bi bi-envelope me-2"></i><strong>Email:</strong> {{ usuario.persona?.email || 'No registrado' }}</p>
                  </div>
              </div>
                
                <div class="border-bottom border-dashed my-4 d-lg-none"></div>
              </div>              
            </div>
          </div>
        </div>
      </div>
  </div> 
</template>
