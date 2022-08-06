/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: VI (Vietnamese; Tiếng Việt)
 */
$.extend( $.validator.messages, {
	required: "Trường bắt buộc phải nhập.",
	remote: "Giá trị này tồn tại trong cơ sở dữ liệu.",
	email: "Trường phải là địa chỉ email.",
	url: "Hãy nhập chính xác URL.",
	date: "Ngày chưa đúng định dạng.",
	dateISO: "Hãy nhập ngày (ISO).",
	number: "Trường yêu cầu nhập số.",
	digits: "Trường yêu cầu phải nhập số nguyên.",
	creditcard: "Hãy nhập số thẻ tín dụng.",
	equalTo: "Trường xác nhận chưa chính xác.",
	extension: "Phần mở rộng không đúng.",
	maxlength: $.validator.format( "Hãy nhập từ {0} kí tự trở xuống." ),
	minlength: $.validator.format( "Hãy nhập từ {0} kí tự trở lên." ),
	rangelength: $.validator.format( "Hãy nhập từ {0} đến {1} kí tự." ),
	range: $.validator.format( "Hãy nhập từ {0} đến {1}." ),
	max: $.validator.format( "Hãy nhập từ {0} trở xuống." ),
	min: $.validator.format( "Hãy nhập từ {0} trở lên." )
} );
