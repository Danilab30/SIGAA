<?php $this->extend("General"); ?>
<?php $this->section("contenido"); ?>

<link rel="stylesheet" href="<?= base_url('dist/css/custom/cv/general.css') ?>">
<!-- ---------------------------------------- -->
<!-- Tarjeta para la tabla de aportacion -->
<!-- ---------------------------------------- -->
<div class="section-container">
  <div class="header-container">
    <h2 class="header-title"><i class="fas fa-handshake"></i> Aportaciones</h2>
    <?php if (empty($aportaciones)): ?>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#aportacionModal">
        <i class="fas fa-plus-circle"></i> Agregar Aportacion
      </button>
    <?php endif; ?>
  </div>
  <p class="section-description">  <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección, puedes agregar la aportacion, así como editar o eliminar aportacion existente.</p>

  <div class="table-responsive">
    <table id="table_aportacion" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th><i class="fas fa-info-circle"></i> Descripción</th>
          <th><i class="fas fa-cogs"></i> Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($aportaciones)): ?>
          <?php foreach ($aportaciones as $aportacion): ?>
            <tr>
              <td><?= esc($aportacion['descripcion']) ?></td>
              <td>
                <button type="button" class="btn btn-sm btn-primary btn-editar-aportacion" data-toggle="modal"
                  data-target="#aportacionModal" data-id="<?= $aportacion['id'] ?>"
                  data-descripcion="<?= esc($aportacion['descripcion']) ?>">
                  <i class="fas fa-edit"></i> 
                </button>
                <button type="button" class="btn btn-sm btn-danger btn-eliminar-aportacion" data-id="<?= $aportacion['id'] ?>">
                  <i class="fas fa-trash-alt"></i> 
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- ---------------------------------------- -->
<!-- Modal para agregar o editar aportacion -->
<!-- ---------------------------------------- -->
<div class="modal fade" id="aportacionModal" tabindex="-1" role="dialog" aria-labelledby="aportacionModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logroModalLabel"><i class="fas fa-handshake"></i> Agregar Aportación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="aportaciones-form"  action="<?= base_url('Cv/aportacionPE/save') ?>" method="post" id="modalFormAportacion">
          <input type="hidden" id="id_aportacion" name="id_aportacion">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="descripcion"><i class="fas fa-info-circle"></i> Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="4"></textarea>
                <div id="charCount" style="text-align: right; color: #666;">0 / 1000 caracteres</div>
                <div class="page-warning"></div>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- ---------------------------------------- -->
<!-- JS -->
<!-- ---------------------------------------- -->

<script>
  var baseUrl = '<?= base_url() ?>'; 

</script>

<script src="<?= base_url('dist/js/custom/cv/utils/commonFunctions.js') ?>"></script>
<script src="<?= base_url('dist/js/custom/cv/aportacionPE.js') ?>"></script>

<?php $this->endSection(); ?>
