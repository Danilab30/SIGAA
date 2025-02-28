$(document).ready(function () {

    CommonFunctions.initializeDataTable("#table_gestion_academica");

    CommonFunctions.initializeCommonHandlers();

    CommonFunctions.initializeModal(
        '#gestionAcademicaModal',
        '#modalFormGestionAcademica',
        baseUrl + '/Cv/gestionacademica/save'
    );

    $("#gestionAcademicaModal").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var id = button.data("id");
        var modal = $(this);

        if (id) {
            modal.find(".modal-title").text("Editar Gestión Académica");
            modal.find("#id_gestion_academica").val(id);
            modal.find("#puesto").val(button.data("puesto"));
            modal.find("#institucion").val(button.data("institucion"));
            modal.find("#mes_inicio").val(button.data("mes_inicio"));
            modal.find("#anio_inicio").val(button.data("anio_inicio"));
            modal.find("#mes_fin").val(button.data("mes_fin"));
            modal.find("#anio_fin").val(button.data("anio_fin"));
            modal.find("#actualmente").prop("checked", button.data("actualmente") == "1");
            toggleFechaFin();
        } else {
            modal.find(".modal-title").text("Agregar Gestión Académica");
            modal.find("form")[0].reset();
            modal.find("#id_gestion_academica").val("");
        }
    });

    $(".btn-eliminar-gestion-academica").click(function () {
        var id = $(this).data("id");
        CommonFunctions.confirmarEliminacion(
            baseUrl + "/Cv/gestionAcademica/delete/" + id,
            "¿Estás seguro?",
            "¡No podrás revertir esto!",
            "Gestión académica eliminada"
        );
    });

    $("#actualmente").change(toggleFechaFin);

    function toggleFechaFin() {
        var currentlyChecked = $("#actualmente").is(":checked");
        $("#fechaFinContainer").toggle(!currentlyChecked);
    }

    toggleFechaFin();

});