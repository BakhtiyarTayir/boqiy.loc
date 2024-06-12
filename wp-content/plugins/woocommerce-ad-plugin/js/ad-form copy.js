jQuery(document).ready(function ($) {
    // Открытие и закрытие модальных окон
    $('#public_ad_btn, #anonymous_ad_btn, #paid_ad_btn').on('click', function () {
        var modalId = $(this).attr('id').replace('_btn', '_ad_modal');
        $('#' + modalId).show();
    });

    $('.close').on('click', function () {
        var modalId = $(this).data('modal');
        $('#' + modalId).hide();
    });

    // Закрытие модального окна при клике вне его области
    $(window).on('click', function (event) {
        if ($(event.target).hasClass('ad-modal')) {
            $(event.target).hide();
        }
    });

    // Увеличение/уменьшение количества товара
    $('.ad-form-wrapper').on('click', '.plus', function () {
        var $input = $(this).siblings('input[type="number"]');
        $input.val(parseInt($input.val()) + 1);
    });

    $('.ad-form-wrapper').on('click', '.minus', function () {
        var $input = $(this).siblings('input[type="number"]');
        if ($input.val() > 1) {
            $input.val(parseInt($input.val()) - 1);
        }
    });

    // Расчет стоимости в зависимости от выбора количества просмотров
    $('select[id^="ad_views_"]').on('change', function () {
        var additionalViews = parseInt($(this).val(), 10);
        var pricePerView = 18;
        var totalPrice = additionalViews * pricePerView;
        var priceInputId = $(this).attr('id').replace('views', 'total_price');
        $('#' + priceInputId).val(totalPrice);
    });




    $('.save_ad_btn').on('click', function(event) {
        event.preventDefault();
        
        var type = $(this).data('type');
 
        var product_id = $(this).data('product-id');
        var ad_data = {
            title: $('#ad_title_' + type).val(),
            phone: $('#ad_phone_' + type).val(),
            social_links: $('#ad_social_links_' + type).val(),
            views: $('#ad_views_' + type).val(),
            total_price: $('#ad_total_price_' + type).val()
        };
    
        var form_data = new FormData();
        form_data.append('action', 'save_ad_data');
        form_data.append('product_id', product_id);
        form_data.append('ad_data', JSON.stringify(ad_data));
    
        if (type !== 'anonymous') {
            var $file_input = $('#ad_image_' + type);
            if ($file_input.length > 0) {
                var file_data = $file_input.prop('files')[0];
                if (file_data) {
                    form_data.append('ad_image', file_data);
                }
            }
        }
    
        console.log('Form Data:', form_data.getAll('ad_data'));
    
        $.ajax({
            url: adFormAjax.ajaxurl, // URL для обработки на сервере
            type: 'POST',
            data: form_data,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                if (response.success) {
                    alert('Ad data saved successfully!' + JSON.stringify(response));
                } else {
                    alert('Failed to save ad data: ' + response.data);
                }
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
            }
        });


        var quantity = $(this).siblings('.quantity-wrapper').find('input[type="number"]').val();
        var checkoutUrl = wc_add_to_cart_params.checkout_url + '?add-to-cart=' + product_id + '&quantity=' + quantity;
        setTimeout(function () {
            window.location.href = checkoutUrl;
        }, 50000);
        

    });

    $('.close').on('click', function() {
        var modalId = $(this).data('modal');
        $('#' + modalId).hide();
    });


});
