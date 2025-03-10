<script setup>
import { toRefs } from 'vue';
const props = defineProps({
    form: Object,
});
const { form } = toRefs(props)




</script>
<template>
<!-- Modal -->
<div class="modal fade" id="verModal" tabindex="-1" aria-labelledby="verModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="verModalLabel">Detalles de la Empresa</h5>
        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <strong>CLIENTE:</strong> {{ form.apenom }}
            </div>            
          </div>
          <div class="row mb-2">
            <div class="col-md-6">
              <strong>RUC:</strong> {{ form.ruc }}
            </div>
            <div class="col-md-6">
              <strong>Razón Social:</strong> {{ form.razonsocial }}
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-6">
              <strong>Teléfono:</strong> {{ form.tel_cel }}
            </div>
            <div class="col-md-6">
              <strong>Tipo de Actividad:</strong> {{ form.tipoActividadNombre }}
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-6">
              <strong>Descripción:</strong> {{ form.descripcion }}
            </div>
            <div class="col-md-6">
              <strong>Inicio de Actividad:</strong> {{ form.inicioactividad }}
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-6">
              <strong>Provincia:</strong> {{ form.provincia }}
            </div>
            <div class="col-md-6">
              <strong>Distrito:</strong> {{ form.distrito }}
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-12">
              <strong>Ubicación:</strong> {{ form.direccion }}
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times"></i> Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

</template>