var currency = '$';
var cart;
var totalCart = 0;

function loadPage() {
    if (!cart) {
        cart = localStorage.getItem('PPMiniCart');
        cart = JSON.parse(unescape(cart));
    }

    let products = cart.value.items;
    let lengthCart = 0;
    let productChild = $('.rem1').clone();

    productChild.prop('hidden', false);
    products.forEach(product => {
        productChild.find('.invert-index').html(lengthCart + 1);
        productChild.find('.invert-name').html(product.item_name);
        productChild.find('.invert-price').html(currency + product.amount.toLocaleString());
        productChild.find('.invert .value').attr('value', product.quantity);
        productChild.find('.invert-image a').attr('href', product.href);
        productChild.find('.invert-image .image-product-cart').attr('src', product.image_src);
        $('.checkout-right .timetable_sub ').append(productChild.wrap('<tr class="rem1"><tr/>').parent().html());

        $('<li>' + product.item_name + ' <i>-</i> <span>' + currency + (product.amount * product.quantity).toLocaleString() + ' </span></li>').insertBefore('.checkout-left .checkout-left-basket li:last-child');

        totalCart += product.amount * product.quantity;
        lengthCart++;
    });

    $('.checkout-left .checkout-left-basket li:last-child span').html(currency + totalCart.toLocaleString());
    $('.checkout h2 span').html(lengthCart + ' ' + $('.checkout h2 span').html());
}

loadPage()

$(document).ready(function() {

    $('.close1').on('click', function(){
        $(this).closest('.rem1').fadeOut('slow', function(){
            let index = $(this).closest('.rem1').index();
            totalCart = totalCart - (cart.value.items[index - 1].quantity * cart.value.items[index - 1].amount);
            cart.value.items.splice(index - 1, 1);

            localStorage.setItem('PPMiniCart', escape(JSON.stringify(cart)));
            $('.checkout-left .checkout-left-basket li:nth-child(' + index + ')').remove();
            $('.checkout-left .checkout-left-basket li:last-child span').html(currency + totalCart.toLocaleString());
            $(this).remove();
        });
    });

    $('.value-plus').on('click', function(){
        let divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.val(), 10) + 1;
        if (newVal <= divUpd.attr('max') || !divUpd.attr('max')) {
            divUpd.val(newVal);
            divUpd.change();
        }
    });

    $('.value-minus').on('click', function(){
        let divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.val(), 10) - 1;
        if (newVal >= divUpd.attr('min')) {
            divUpd.val(newVal);
            divUpd.change();
        }
    });

    $('.value').on('change', function(){
        let newVal = parseInt($(this).val());
        let oldVal = parseInt($(this).attr('value'));
        let index = $(this).closest('.rem1').index();
        let newPrice = newVal * cart.value.items[index - 1].amount;
        let oldPrice = oldVal * cart.value.items[index - 1].amount;
        if (newVal > oldVal) {
            $(this).attr('value', newVal);
            totalCart = totalCart - oldPrice + newPrice;

            cart.value.items[index - 1].quantity = newVal;
            localStorage.setItem('PPMiniCart', escape(JSON.stringify(cart)));
            $('.checkout-left .checkout-left-basket li:nth-child(' + index + ') span').html(currency + newPrice.toLocaleString());
            $('.checkout-left .checkout-left-basket li:last-child span').html(currency + totalCart.toLocaleString());
        } else if (newVal > 0) {
            $(this).attr('value', newVal);
            totalCart = totalCart - oldPrice + newPrice;

            cart.value.items[index - 1].quantity = newVal;
            localStorage.setItem('PPMiniCart', escape(JSON.stringify(cart)));
            $('.checkout-left .checkout-left-basket li:nth-child(' + index + ') span').html(currency + newPrice.toLocaleString());
            $('.checkout-left .checkout-left-basket li:last-child span').html(currency + totalCart.toLocaleString());
        }
    });
});
