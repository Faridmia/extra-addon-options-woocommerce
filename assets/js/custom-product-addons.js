jQuery(document).ready(function($) {
    $('#eaw-add-row').on('click', function() {
        let extra_item = $('.empty-row.screen-reader-text').clone(true);
        extra_item.removeClass('empty-row screen-reader-text');
        extra_item.insertBefore('#eaw-repeatable-fieldset-one tbody>tr:last');
        return false;
    });

    $('.eaw-remove-row').on('click', function() {
        $(this).parents('tr').remove();
        return false;
    });
});

jQuery(document).ready(function($) {
    $('#eaw-accessories-add-row').on('click', function() {
        let acc_item = $('.empty-row-acc.screen-reader-text').clone(true);
        acc_item.removeClass('empty-row-acc screen-reader-text');
        acc_item.insertBefore('#eaw-repeatable-fieldset-accessories tbody>tr:last');
        return false;
    });

    $('.eaw-accessories-remove-row').on('click', function() {
        $(this).parents('tr').remove();
        return false;
    });
});

