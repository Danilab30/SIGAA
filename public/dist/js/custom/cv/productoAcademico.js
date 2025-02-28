$(document).ready(function () {
    const table = $("#table_producto tbody");
    CommonFunctions.initializeDataTable("#table_producto");
    let ordenarActivo = false;
    CommonFunctions.initializeCommonHandlers();

    CommonFunctions.initializeModal(
        '#productoModal',
        '#modalFormProducto',
        baseUrl + '/CV/ProductoAcademico/save'
    );

    $("#productoModal").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var id = button.data("id");
        var modal = $(this);

        if (id) {
            modal.find(".modal-title").text("Editar Producto Académico");
            modal.find("#id_producto_academico").val(id);
            modal.find("#descripcion").val(button.data("descripcion"));
        } else {
            modal.find(".modal-title").text("Agregar Producto");
            modal.find("form")[0].reset();
            modal.find("#id_producto_academico").val("");
        }
    });

    $(document).on("click", ".btn-eliminar-producto", function () {
        var id = $(this).data("id");
        CommonFunctions.confirmarEliminacion(
            baseUrl + "/CV/ProductoAcademico/delete/" + id,
            "¿Estás seguro?",
            "¡No podrás revertir esto!",
            "Producto Académico eliminado"
        );
    });

    // Botón para activar/desactivar ordenamiento
    $('#btn-ordenar').click(function() {
        ordenarActivo = !ordenarActivo;
        if (ordenarActivo) {
            $(this).html('<i class="fas fa-save"></i> Guardar Orden').addClass('btn-success').removeClass('btn-primary');
            table.find('.btn').prop('disabled', true); 
            activarSortable();
        } else {
            $(this).html('<i class="fas fa-sort"></i> Ordenar').addClass('btn-primary').removeClass('btn-success');
            table.find('.btn').prop('disabled', false); 
            guardarOrden();
            desactivarSortable();
        }
    });

    function activarSortable() {
        table.sortable({
            items: 'tr',
            cursor: 'move',
            axis: 'y',
            placeholder: 'sortable-placeholder',
            forcePlaceholderSize: true,
            opacity: 0.8,
            update: function(event, ui) {
                actualizarNumeracion();
            }
        }).disableSelection();
    }


    function desactivarSortable() {
        if (table.hasClass('ui-sortable')) {
            table.sortable('destroy');
        }
    }


    function actualizarNumeracion() {
        table.find('tr').each(function(index) {
            $(this).find('td:first').text(index + 1);
        });
    }


    function guardarOrden() {
        let orden = [];
        table.find('tr').each(function() {
            const id = $(this).data('id');
            if (id) {
                orden.push({
                    id: id
                });
            }
        });

        if (orden.length === 0) return;

        $.ajax({
            url: baseUrl + '/CV/ProductoAcademico/updateOrder',
            method: 'POST',
            data: JSON.stringify(orden),
            contentType: 'application/json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Orden actualizado correctamente',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al actualizar el orden'
                });
            }
        });
    }
});