$(document).ready(function () {
    $('.icon').iconpicker();

    $('#menu-nestable').nestable({
        group: 1
    });

    $('#menu-nestable').on('change', function() {
        var jsonData = $('#menu-nestable').nestable('serialize');
        $.ajax({
            url: route('admin.admin_menus.update_hierarchy'),
            method: 'GET',
            data: {
                jsonData: jsonData,
            },
            success: function(data) {
                window.location.reload();
            }
        });
    });

    $(".js-add-module-menu").on("click", function() {
        var moduleId = $(this).attr("data-module");
        $.ajax({
            url: route('admin.admin_menus.store'),
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            data: {
                "module_id": moduleId,
            },
            success: function(data) {
                window.location.reload();
            },
            error: function (error) {
                toastr.error(error.responseJSON.message);
            }
        });
    });
});
