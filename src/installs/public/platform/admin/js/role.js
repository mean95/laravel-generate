$(function () {
    let boolChecked = () => {
        let countCheckboxesChecked = $('.uri-block-summary input[type=checkbox]:checked').length;
        let countCheckboxes = $('.uri-block-summary input[type=checkbox]').length;
        return (countCheckboxes > countCheckboxesChecked);
    };

    if (boolChecked()) {
        $('#all-checked-permission').prop('checked', false);
    } else {
        $('#all-checked-permission').prop('checked', true);
    }

    $(document).on('click', '#all-checked-permission', function () {
        let _self = $(this);
        if (boolChecked()) {
            $('input[type=checkbox]').prop('checked', true);
            _self.prop('checked', true);
        } else {
            $('input[type=checkbox]').prop('checked', false);
            _self.prop('checked', false);
        }
    });
});
