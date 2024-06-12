

jQuery(document).ready(function($) {
    $('#public_ad_btn').on('click', function() {
        $('#public_ad_modal').show();
    });

    $('#anonymous_ad_btn').on('click', function() {
        $('#anonymous_ad_modal').show();
    });

    $('#paid_ad_btn').on('click', function() {
        $('#paid_ad_modal').show();
    });

    $('.close').on('click', function() {
        var modalId = $(this).data('modal');
        $('#' + modalId).hide();
    });

    // Закрытие модального окна при клике вне его области
    $(window).on('click', function(event) {
        if ($(event.target).hasClass('ad-modal')) {
            $(event.target).hide();
        }
    });

    // Расчет стоимости в зависимости от выбора количества просмотров
    $('select[id^="ad_views_"]').on('change', function() {
        var additionalViews = parseInt($(this).val(), 10);
        var pricePerView = 18;
        var totalPrice = additionalViews * pricePerView;
        var priceInputId = $(this).attr('id').replace('views', 'total_price');
        $('#' + priceInputId).val(totalPrice);
    });
});
