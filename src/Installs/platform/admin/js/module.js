$(document).ready(function () {

	function getHtmlMinMax() {
		return $('#form_min_or_max').html();
	}

	function getHtmlUnique() {
		return $('#form_unique').html();
	}

	function getHtmlPopupVal() {
		return $('#form_popup_val').html();
	}

	function getHtmlTagInput() {
		return $('#form_tagsinput').html();
	}
	
	function getHtmlFromTable() {
		return $('#form_from_table').html();
	}

	function getHtmlFromList() {
		return $('#form_from_list').html();
	}

    function showValuesSection() {
		var fieldType = $(".m-ui-type select").val();
			fieldType = parseInt(fieldType);
		let unique = [5, 6, 9, 11, 13, 14, 18];
		let popupVal = [2, 8, 15, 17];
		let minMax = [1, 4, 7, 9, 11, 12, 13, 14, 16, 18, 19, 21];
		$('.m-unique').remove();
		if (unique.indexOf(fieldType) !== -1) {
			$('.m-ui-type').after(getHtmlUnique());
			$('.m-unique input').bootstrapToggle()
		}
		$('.m-popup-val').remove();
		if (popupVal.indexOf(fieldType) !== -1) {
			$('.m-required').after(getHtmlPopupVal());
			$('.m-popup-val .radio').after(getHtmlFromTable());
		}
		
		if (fieldType === 19) {
			$('.m-required').after(getHtmlTagInput());
			$('.m-popup-val label').after(getHtmlFromList());
			$("select[data-role=tagsinput]").tagsinput('items');
		}

		$('.m-min, .m-max').remove();
		if (minMax.indexOf(fieldType) !== -1) {
			$('.m-default-value').after(getHtmlMinMax());
		}
    }
    
    $(document).on('change', '.m-ui-type select', function () {
        showValuesSection();
	});
	if (changeField === true) {
		showValuesSection();
	}
	
	$(document).on('click', 'input[name=popup_value_type]', function () {
		let val = $(this).val();
		if (val === 'table') {
			let select = $('select[name=popup_val_table]').length;
			if (select === 0) {
				$('.m-popup-val .radio').after(getHtmlFromTable());
				$('.m-popup-val .bootstrap-tagsinput, select[data-role=tagsinput]').remove();
			}
		} else {
			let select = $('select[data-role=tagsinput]').length;
			if (select === 0) {
				$('#popup_val_table ~ span.select2').remove();
				$('#popup_val_table').remove();
				$('.m-popup-val .radio').after(getHtmlFromList());
				$("select[data-role=tagsinput]").tagsinput('items');
			}
		}
    });

	$("form#form_add_field").validate({
		rules: {
			label: {
				required: true,
				maxlength: 100
			},
			column_name: {
				required: true,
				maxlength: 30
			},
			field_type_id: {
				required: true,
				range: [0,16383],
			},
			default_value: {
				maxlength: 255
			},
			minlength: {
				digits: true,
				maxlength: 20,
			},
			maxlength: {
				digits: true,
				range: [0,16383],
			}
		},
	});

	$(document).on('click', '.show_delete_module', function() {
		let router = $(this).attr('data-route'),
			modelName = $(this).attr('data-model-name'),
			nameDB = $(this).attr('data-db-name');
		$('#modal_delete_module form').attr('action', router);
		$('#modal_delete_module form .module_name_delete').text(modelName);
		$('#modal_delete_module form .db_name_delete').text(nameDB);
		$('#modal_delete_module').modal('show');
	});

});