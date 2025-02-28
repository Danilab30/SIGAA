$(document).ready(function () {
  CommonFunctions.initializeDataTable("#table_diseno_ingenieril");
  CommonFunctions.initializeCommonHandlers();
  CommonFunctions.initializeModal(
    "#disenoIngenierilModal",
    "#modalFormDisenoIngenieril",
    baseUrl + "/Cv/disenoingenieril/save"
  );

  $("#disenoIngenierilModal").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget);
    var id = button.data("id");
    var modal = $(this);
    console.log(button.data());
    if (id) {
      modal.find(".modal-title").text("Editar Diseño Ingenieril");
      modal.find("#id_diseno_ingenieril").val(id);
      modal.find("#organismo").val(button.data("organismo"));
      modal.find("#anio_inicio").val(button.data("anio-inicio"));
      modal.find("#anio_fin").val(button.data("anio-fin"));
      modal.find("#nivel_experiencia").val(button.data("nivel-experiencia"));
      modal.find("#otro_nivel").val(button.data("otro-nivel"));
    } else {
      modal.find(".modal-title").text("Agregar Diseño Ingenieril");
      modal.find("form")[0].reset();
      modal.find("#id_diseno_ingenieril").val("");
    }
  });

  $(".btn-eliminar-diseno").click(function () {
    var id = $(this).data("id");
    CommonFunctions.confirmarEliminacion(
      baseUrl + "/Cv/disenoingenieril/delete/" + id,
      "¿Estás seguro?",
      "¡No podrás revertir esto!",
      "Diseño Ingenieril eliminado!"
    );
  });

  // Cambiar los selectores year-picker a inputs numéricos
  $(".year-picker").each(function() {
    $(this)
      .attr("type", "number")
      .attr("min", "1900")
      .attr("max", new Date().getFullYear() + 10)
      .removeAttr("readonly")
      .removeClass("year-picker");
  });
  
  // Agregar validación para los inputs de año
  $("#anio_fin").on("change", function() {
    var anioInicio = parseInt($("#anio_inicio").val());
    var anioFin = parseInt($("#anio_fin").val());
    
    if (!isNaN(anioInicio) && !isNaN(anioFin) && anioFin < anioInicio) {
      alert("El año fin no puede ser menor que el año inicio.");
      $(this).val("");
    }
  });

  $("#nivel_experiencia").change(function () {
    if ($(this).val() === "otro") {
      $("#otro_nivel_container").show();
    } else {
      $("#otro_nivel_container").hide();
      $("#otro_nivel").val("");
    }
  });

  $("#disenoIngenierilModal").on("shown.bs.modal", function () {
    if ($("#nivel_experiencia").val() === "otro") {
      $("#otro_nivel_container").show();
    } else {
      $("#otro_nivel_container").hide();
    }
  });
});