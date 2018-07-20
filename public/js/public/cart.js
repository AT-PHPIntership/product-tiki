$(document).ready(function() {
    $('.close1').on('click', function(){
        $(this).closest('.rem1').fadeOut('slow', function(){
            $(this).remove();
        });
    });

    $('.value-plus').on('click', function(){
        let divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.val(), 10) + 1;
        if (newVal <= divUpd.attr('max') || !divUpd.attr('max')) {
            divUpd.val(newVal);
        }
    });

    $('.value-minus').on('click', function(){
        let divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.val(), 10) - 1;
        if (newVal >= divUpd.attr('min')) {
            divUpd.val(newVal);
        }
    });
});
