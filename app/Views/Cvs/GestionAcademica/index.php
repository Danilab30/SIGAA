<?php $this->extend("General"); ?>
<?php $this->section("contenido"); ?>
<link rel="stylesheet" href="<?= base_url('dist/css/custom/cv/general.css') ?>">




<!-- ---------------------------------------- -->
<!-- Tarjeta para la tabla de experiencia laboral-->
<!-- ---------------------------------------- -->
<div class="section-container">
    <div class="header-container">
        <h2 class="header-title"><i class="fas fa-briefcase"></i> Gestion Academica</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#gestionAcademicaModal"
            id="addGestionAcademicaBtn">
            <i class="fas fa-plus-circle"></i> Agregar Gestión Academica
        </button>
    </div>

    <p class="section-description">
    <i class="fas fa-info-circle" style="color: #0066cc; margin-right: 8px;"></i>
  En esta sección puedes visualizar y modificar tu gestión Academica. Agrega, edita o elimina registros según sea necesario para mantener tu información actualizada.
</p>

    <div class="table-responsive">
        <table id="table_gestion_academica" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><i class="fas fa- fa-user-tie"></i> Actividad/Puesto</th>
                    <th><i class="fas fa-building"></i> Institución</th>
                    <th><i class="fas fa-calendar-alt"></i> Fecha de Inicio</th>
                    <th><i class="fas fa-calendar-check"></i> Fecha de Fin</th>
                    <th><i class="fas fa-cogs"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($gestiones)): ?>
                    <?php foreach ($gestiones as $gestion): ?>
                        <tr>
                            <td><?= esc($gestion['puesto']) ?></td>
                            <td><?= esc($gestion['institucion']) ?></td>
                            <td><?= esc($gestion['mes_inicio']) . ' - ' . esc($gestion['anio_inicio']) ?></td>
                            <td>
                                <?php if ($gestion['actualmente'] == 1): ?>
                                    Actualmente
                                <?php elseif (!empty($gestion['mes_fin']) && !empty($gestion['anio_fin'])): ?>
                                    <?= esc($gestion['mes_fin']) . ' - ' . esc($gestion['anio_fin']) ?>
                                <?php else: ?>
                                    No especificado
                                <?php endif; ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-editar-gestion-academica" data-toggle="modal"
                                    data-target="#gestionAcademicaModal" data-id="<?= $gestion['id'] ?>"
                                    data-puesto="<?= esc($gestion['puesto']) ?>"
                                    data-institucion="<?= esc($gestion['institucion']) ?>"
                                    data-mes_inicio="<?= esc($gestion['mes_inicio']) ?>"
                                    data-anio_inicio="<?= esc($gestion['anio_inicio']) ?>"
                                    data-mes_fin="<?= esc($gestion['mes_fin']) ?>"
                                    data-anio_fin="<?= esc($gestion['anio_fin']) ?>"
                                    data-actualmente="<?= $gestion['actualmente'] ?>" title="Editar Gestion Academica">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-eliminar-gestion-academica"
                                    data-id="<?= $gestion['id'] ?>"
                                    title="Eliminar Gestion Academica">
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
<!-- Modal para agregar/editar una experiencia laboral -->
<!-- ---------------------------------------- -->
<div class="modal fade" id="gestionAcademicaModal" tabindex="-1" role="dialog" aria-labelledby="gestionAcademicaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gestionAcademicaModalLabel"><strong><i class="fas fa-briefcase"></i> Agregar Gestión Academica</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('Cv/gestionacademica/save') ?>" method="post" id="modalFormGestionAcademica">
                    <input type="hidden" id="id_gestion_academica" name="id_gestion_academica">
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="puesto"><i class="fas fa-user-tie"></i> Actividad/Puesto</label>
                            <input type="text" class="form-control" id="puesto" name="puesto" placeholder="Ej. Puestos directos, de coordinación, de supervisión, etc.">
                            <div class="page-warning"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="institucion"><i class="fas fa-building"></i> Institución</label>
                            <input type="text" class="form-control" id="institucion" name="institucion" placeholder="Ingrese el nombre de la institución">
                            <div class="page-warning"></div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="mes_inicio"><i class="fas fa-calendar-alt"></i> Mes de Inicio</label>
                            <select class="form-control" id="mes_inicio" name="mes_inicio">
                                <option value="">Seleccione un mes...</option>
                                <option value="Enero">Enero</option>
                                <option value="Febrero">Febrero</option>
                                <option value="Marzo">Marzo</option>
                                <option value="Abril">Abril</option>
                                <option value="Mayo">Mayo</option>
                                <option value="Junio">Junio</option>
                                <option value="Julio">Julio</option>
                                <option value="Agosto">Agosto</option>
                                <option value="Septiembre">Septiembre</option>
                                <option value="Octubre">Octubre</option>
                                <option value="Noviembre">Noviembre</option>
                                <option value="Diciembre">Diciembre</option>
                            </select>
                            <div class="page-warning"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="anio_inicio"><i class="fas fa-clock"></i> Año de Inicio</label>
                            <select class="form-control" id="anio_inicio" name="anio_inicio">
                                <option value="">Seleccione un año...</option>
                                <?php for ($i = date("Y"); $i >= 1970; $i--): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <div class="page-warning"></div>
                        </div>
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="actualmente" name="actualmente" value="1">
                        <label class="form-check-label" for="actualmente"><i class="fas fa-check-circle"></i> Actualmente en este puesto</label>
                    </div>
                    
                    <div class="form-row" id="fechaFinContainer">
                        <div class="form-group col-md-6">
                            <label for="mes_fin"><i class="fas fa-calendar-alt"></i> Mes de Fin</label>
                            <select class="form-control" id="mes_fin" name="mes_fin">
                                <option value="">Seleccione un mes...</option>
                                <option value="Enero">Enero</option>
                                <option value="Febrero">Febrero</option>
                                <option value="Marzo">Marzo</option>
                                <option value="Abril">Abril</option>
                                <option value="Mayo">Mayo</option>
                                <option value="Junio">Junio</option>
                                <option value="Julio">Julio</option>
                                <option value="Agosto">Agosto</option>
                                <option value="Septiembre">Septiembre</option>
                                <option value="Octubre">Octubre</option>
                                <option value="Noviembre">Noviembre</option>
                                <option value="Diciembre">Diciembre</option>
                            </select>
                            <div class="page-warning"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="anio_fin"><i class="fas fa-calendar-check"></i> Año de Fin</label>
                            <select class="form-control" id="anio_fin" name="anio_fin">
                                <option value="">Seleccione un año...</option>
                                <?php for ($i = date("Y"); $i >= 1970; $i--): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <div class="page-warning"></div>
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
</div>



<!-- ---------------------------------------- -->
<!-- JS -->
<!-- ---------------------------------------- -->

<script>
    var baseUrl = '<?= base_url() ?>'; 
</script>
<script src="<?= base_url('dist/js/custom/cv/utils/commonFunctions.js') ?>"></script>
<script src="<?= base_url('dist/js/custom/cv/gestionAcademica.js') ?>"></script>
<?php $this->endSection(); ?>