$(document).ready(function () {
    $(document).on('click', '.show-confirm-delete', function () {
        $('#modal_confirm_delete').modal('show');
        let route = $(this).attr('data-route');
        $('#modal_confirm_delete form').attr('action', route);
    });

    $('tbody').on('mouseover', 'tr', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'hover',
            html: true
        });
    });
    $('[data-toggle="tooltip"]').tooltip();
    
    $(document).on('keypress', '.bootstrap-tagsinput input', function(e){
		if (e.keyCode == 13){
			e.keyCode = 188;
			e.preventDefault();
		};
    });

    $('.date-picker').datetimepicker({
        "allowInputToggle": true,
        "showClose": true,
        "showClear": true,
        "showTodayButton": true,
        "format": "YYYY-MM-DD",
        'locale': app.locale
    });

    $('.datetime-picker').datetimepicker({
        "allowInputToggle": true,
        "showClose": true,
        "showClear": true,
        "showTodayButton": false,
        "format": "YYYY-MM-DD HH:mm:ss",
        "locale": app.locale
    });

    $('.select2').select2({
        theme: 'bootstrap4'
    })
   
    jQuery.validator.addMethod("data-unique", function(value, element) {
        value = value.trim();
        var isAllowed = false;
        var fieldId = element.getAttribute('data-field-id');
        var prefix = element.getAttribute('data-prefix');
		var rowId = element.getAttribute('data-row-id');
        if(value !== '') {
            $.ajax({
				url: route(prefix + '.ajax.module_fields.unique_field_value'),
				type:"GET",
				async: false,
				data:{
                    'field_value': value,
					'row_id': rowId,
					'field_id': fieldId,
                },
				success: function(data) {
                    if(data.exists == true) {
                        isAllowed = false;
                    } else {
                        isAllowed = true;
                    }
				}
			});
		}
		return isAllowed;
    }, app.uniqueValue);

    function file(elmClass, options) {
        $(document).on('click', elmClass, function () {
            let __this = $(this);
            let host = location.origin;
            let routePrefix = (options && options.prefix) ? options.prefix : '/admin/file-manager';
            let type = (options && options.type) ? options.type : 'file';
            window.open(routePrefix + '?type=' + type, 'FileManager', 'width=1500,height=1000');
            window.SetUrl = function (items) {
                let fileObject = items[0];
                let filePath = fileObject.url;
                __this.find('input').val(filePath.replace(host, ''));
                __this.find('.custom-file-label').text(filePath);
                let previewElement = __this.closest('.group-file').find('.file-preview'); 
                previewElement.html('<img />');
                previewElement.find('img').attr('src', fileObject.thumb_url);
            };
        });
    }
    file('.custom-file', {});

    $('.js-summernote').summernote({
        height: 450,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'italic', 'clear']],
            ['fontname', ['fontname', 'fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'lfm', 'video', 'hr']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],
        buttons: {
            lfm: LFMButton
        }
    });

    function LFMButton(context) {
        var ui = $.summernote.ui;
        var button = ui.button({
            contents: '<i class="note-icon-picture"></i> ',
            tooltip: 'Picture',
            click: function() {
                let options = {type: 'file', prefix: '/admin/file-manager'};
                var routePrefix = (options && options.prefix) ? options.prefix : '/admin/file-manager';
                window.open(routePrefix + '?type=' + options.type || 'file', 'FileManager', 'width=1500,height=1000');
                window.SetUrl = function (items, path) {
                    items.forEach(function (item) {
                        context.invoke('insertImage', item.url);
                    });
                };
            }
        });
        return button.render();
    };

    $('.nav-link.active').closest('.has-treeview').addClass('menu-open');
});
