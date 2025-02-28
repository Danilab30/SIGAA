<?php $this->extend("General"); ?>
<?php $this->section("contenido"); ?>
<link rel="stylesheet" href="<?= base_url('dist/css/custom/cv/general.css') ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<!-- ---------------------------------------- -->
<!-- Tarjeta para la tabla de diseños ingenieriles -->
<!-- ---------------------------------------- -->
<div class="section-container">
  <div class="header-container">
    <h2 class="header-title"><i class="fas fa-drafting-compass"></i> Diseño Ingenieril</h2>
    <div>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#disenoIngenierilModal">
        <i class="fas fa-plus-circle"></i> Agregar Diseño Ingenieril
      </button>
    </div>
  </div>
  <p class="section-description">  <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
    En esta sección, puedes agregar tu experiencia en diseño ingenieril, así como editar o eliminar entradas existentes.</p>   
  <div class="table-responsive">
    <table id="table_diseno_ingenieril" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th><i class="fas fa-building"></i> Organismo</th>
          <th><i class="fas fa-calendar"></i> Período</th>
          <th><i class="fas fa-user-tag"></i> Nivel de Experiencia</th>
          <th><i class="fas fa-cogs"></i> Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($disenoIngenieril)): ?>
          <?php foreach ($disenoIngenieril as $index => $diseno): ?>
            <tr data-id="<?= $diseno['id'] ?>">
              <td><?= esc($diseno['organismo']) ?></td>
              <td><?= esc($diseno['anio_inicio']) ?> - <?= esc($diseno['anio_fin']) ?></td>
              <td>
                <?php if ($diseno['nivel_experiencia'] === 'otro'): ?>
                  <?= esc($diseno['otro_nivel']) ?>
                <?php else: ?>
                  <?= ucfirst(esc($diseno['nivel_experiencia'])) ?>
                <?php endif; ?>
              </td>
              <td>
                <button type="button" class="btn btn-sm btn-primary btn-editar-diseno" data-toggle="modal"
                  data-target="#disenoIngenierilModal" data-id="<?= $diseno['id'] ?>" 
                  data-organismo="<?= esc($diseno['organismo']) ?>"
                  data-anio-inicio="<?= esc($diseno['anio_inicio']) ?>"
                  data-anio-fin="<?= esc($diseno['anio_fin']) ?>"
                  data-nivel-experiencia="<?= esc($diseno['nivel_experiencia']) ?>"
                  data-otro-nivel="<?= esc($diseno['otro_nivel']) ?>">
                  <i class="fas fa-edit"></i> 
                </button>
                <button type="button" class="btn btn-sm btn-danger btn-eliminar-diseno" data-id="<?= $diseno['id'] ?>">
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
<!-- Modal para agregar o editar diseño ingenieril -->
<!-- ---------------------------------------- -->
<div class="modal fade" id="disenoIngenierilModal" tabindex="-1" role="dialog" aria-labelledby="disenoIngenierilModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="disenoIngenierilModalLabel"><i class="fas fa-drafting-compass"></i> Agregar diseño ingenieril</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="diseno-form" action="<?= base_url('CV/disenoIngenieril/save') ?>" method="post" id="modalFormDisenoIngenieril">
          <input type="hidden" id="id_diseno_ingenieril" name="id_diseno_ingenieril">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="organismo"><i class="fas fa-building"></i> Organismo</label>
                <input type="text" class="form-control" id="organismo" name="organismo" placeholder="Nombre del organismo">
                <div class="page-warning "></div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="anio_inicio"><i class="fas fa-calendar-alt"></i> Año de inicio</label>
                <input type="text" class="form-control year-picker" id="anio_inicio" name="anio_inicio" placeholder="Ingrese el año" readonly>
                <div class="page-warning "></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="anio_fin"><i class="fas fa-calendar-check"></i> Año de fin</label>
                <input type="text" class="form-control year-picker" id="anio_fin" name="anio_fin"  placeholder="Ingrese el año"  readonly>
                <div class="page-warning"></div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="nivel_experiencia"><i class="fas fa-user-tag"></i> Nivel de experiencia</label>
                <select class="form-control" id="nivel_experiencia" name="nivel_experiencia">
                  <option value="">Seleccione un nivel</option>
                  <option value="responsable">Responsable</option>
                  <option value="asistente">Asistente</option>
                  <option value="analista">Analista</option>
                  <option value="auxiliar">Auxiliar</option>
                  <option value="otro">Otro</option>
                </select>
                <div class="page-warning"></div>
              </div>
            </div>
          </div>
          <div class="row" id="otro_nivel_container" style="display: none;">
            <div class="col-md-12">
              <div class="form-group">
                <label for="otro_nivel"><i class="fas fa-pen"></i> Especifique otro nivel</label>
                <input type="text" class="form-control" id="otro_nivel" name="otro_nivel" placeholder="Especifique el nivel de experiencia">
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
<script src="<?= base_url('dist/js/custom/cv/disenoIngenieril.js') ?>"></script>
<?php $this->endSection(); ?>