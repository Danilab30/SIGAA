<?php $this->extend("General"); ?>
<?php $this->section("contenido"); ?>
<link rel="stylesheet" href="<?= base_url('dist/css/custom/cv/general.css') ?>">
<!-- ---------------------------------------- -->
<!-- Tarjeta para la tabla de productos academicos -->
<!-- ---------------------------------------- -->
<div class="section-container">
  <div class="header-container">
    <h2 class="header-title"><i class="fas fa-book"></i> Producto Académico</h2>
    <div>
      <button type="button" class="btn btn-primary mr-2" id="btn-ordenar">
        <i class="fas fa-sort"></i> Ordenar
      </button>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#productoModal">
        <i class="fas fa-plus-circle"></i> Agregar Producto Académico
      </button>
    </div>
  </div>
  <p class="section-description">  <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección, puedes agregar nuevos productos académicos, así como editar o eliminar productos académicos existentes. Usa el botón Ordenar para organizar tus productos.</p>   
  <div class="table-responsive">
    <table id="table_producto" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th><i class="fas fa-hashtag"></i> N°</th>
          <th><i class="fas fa-info-circle"></i> Descripción</th>
          <th><i class="fas fa-cogs"></i> Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($productos)): ?>
          <?php foreach ($productos as $index => $producto): ?>
            <tr data-id="<?= $producto['id'] ?>">
              <td class="text-center"><?= $index + 1 ?></td>
              <td><?= esc($producto['descripcion']) ?></td>
              <td>
                <button type="button" class="btn btn-sm btn-primary btn-editar-producto" data-toggle="modal"
                  data-target="#productoModal" data-id="<?= $producto['id'] ?>" 
                  data-descripcion="<?= esc($producto['descripcion']) ?>">
                  <i class="fas fa-edit"></i> 
                </button>
                <button type="button" class="btn btn-sm btn-danger btn-eliminar-producto" data-id="<?= $producto['id'] ?>">
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
<!-- Modal para agregar o editar producto academico -->
<!-- ---------------------------------------- -->
<div class="modal fade" id="productoModal" tabindex="-1" role="dialog" aria-labelledby="productoModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productoModalLabel"><i class="fas fa-trophy"></i> Agregar producto académico</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="productos-form" action="<?= base_url('CV/productoAcademico/save') ?>" method="post" id="modalFormProducto">
          <input type="hidden" id="id_producto_academico" name="id_producto_academico">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="descripcion"><i class="fas fa-info-circle"></i> Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="4" placeholder="Describe tu producto académico"></textarea>
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
<script src="<?= base_url('dist/js/custom/cv/productoAcademico.js') ?>"></script>
<?php $this->endSection(); ?>