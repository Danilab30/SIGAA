$(document).ready(function () {
  // Inicializa DataTable
  CommonFunctions.initializeDataTable("#table_aportacion");

  // Inicializa manejadores comunes
  CommonFunctions.initializeCommonHandlers();

  // Inicializa modal para agregar/editar aportacion
  CommonFunctions.initializeModal(
    "#aportacionModal",
    "#modalFormAportacion",
    baseUrl + "/Cv/aportacionPE/save"
  );

  // Lógica del modal de logro
  $("#aportacionModal").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget);
    var id = button.data("id");
    var modal = $(this);

    if (id) {
      modal.find(".modal-title").text("Editar Aportación");
      modal.find("#id_aportacion").val(id);
      modal.find("#descripcion").val(button.data("descripcion"));
    } else {
      modal.find(".modal-title").text("Agregar Aportación");
      modal.find("form")[0].reset();
      modal.find("#id_aportacion").val("");
    }
  });

  // Lógica para eliminar aportacion
  $(".btn-eliminar-aportacion").click(function () {
    var id = $(this).data("id");
    CommonFunctions.confirmarEliminacion(
      baseUrl + "/Cv/aportacionPE/delete/" + id,
      "¿Estás seguro?",
      "¡No podrás revertir esto!",
      "Aportación eliminado"
    );
  });


  // Contador de caracteres para la descripción
  const descripcionInput = document.getElementById("descripcion");
  const charCount = document.getElementById("charCount");
  const maxLength = 1000;

  if (descripcionInput && charCount) {
    descripcionInput.addEventListener("input", function () {
      const currentLength = descripcionInput.value.length;
      charCount.textContent = `${currentLength} / ${maxLength} caracteres`;


      if (currentLength > maxLength) {
        charCount.style.color = "red";
      } else {
        charCount.style.color = "";
      }
    });
  }
});