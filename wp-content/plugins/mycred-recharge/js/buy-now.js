jQuery(document).ready(function($) {
    $('.buy-now-button').on('click', function() {
        var product_id = $(this).data('product-id');
        var recharge_amount = $('#recharge_amount').val() || 1000;
        setTimeout(function() {
            console.log(window.location.href);
        }, 10000);

        // Определение текущего языка страницы
        var currentLang = window.location.pathname.split('/')[1];
        if (currentLang.length !== 2) { // Если не удается определить язык, используем язык по умолчанию
            currentLang = 'uz';
        }

        $.ajax({
            type: 'POST',
            url: buyNow.ajax_url,
            data: {
                action: 'buy_now',
                product_id: product_id,
                recharge_amount: recharge_amount
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = '/' + currentLang + '/buyurtmani-rasmiylashtirish/';
                } else {
                    alert('Ошибка при добавлении товара в корзину');
                }
            }
        });
    });
});
