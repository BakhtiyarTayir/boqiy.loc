jQuery(document).ready(function($) {


    // Обработка клика по кнопке лайка
    $('.like-item').click(function() {
        var imageUrl = $(this).find('img').attr('src'); // Получаем URL изображения
        var postId = $(this).data('post-id');
        var likeId = $(this).data('like-id');
        
        var activityContent = $(this).closest('.activity-content');
        var imageCover = $('<div class="covered-image"></div>').css('background-image', 'url(' + imageUrl + ')').css('background-size', 'cover');

    

        $.ajax({
            url: bpPaidLikes.ajaxurl,
            type: 'POST',
            data: {
                action: 'bp_paid_likes',
                post_id: postId,
                like_id: likeId, // Отправляем product_id
                security: bpPaidLikes.nonce
            },
            success: function(response) {
                var modal = $('#likeModal');
                var modalMessage = $('#modalMessage');
                var rechargeLink = $('#rechargeLink');

                if (response.success) {
                    modalMessage.text(response.data.message);
                    activityContent.append(imageCover);
                    // Обновляем количество лайков
                    var likesCount = response.data.likes_count;
                    activityContent.find('.likes-count').text('Лайков: ' + likesCount);
                } else {
                    $('#modalMessage').text(response.data.message);
                    $('#likeModal').modal('show');
                }

                modal.show();
            },
            error: function(xhr, status, error) {
                var modal = $('#likeModal');
                var modalMessage = $('#modalMessage');
                var rechargeLink = $('#rechargeLink');

                modalMessage.text("Произошла ошибка: " + error);
                rechargeLink.show();
                modal.show();
            }
        });
    });

    // Добавление сохраненных лайков при загрузке страницы
    $('.like-container').each(function() {
        var activityContent = $(this).closest('.activity-content');
 
        $(this).find('.covered-image').each(function() {
            activityContent.append($(this).clone());
        });
    });
     // Закрытие модального окна при клике на "x"
     $('.close').click(function() {
        $('#likeModal').hide();
    });

    // Закрытие модального окна при клике вне его
    $(window).click(function(event) {
        if ($(event.target).is('#likeModal')) {
            $('#likeModal').hide();
        }
    });




});


jQuery(document).ready(function($) {
    // Создаем MutationObserver
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            // Проверяем, была ли кнопка "Show all comments" удалена
            if ($(mutation.removedNodes).filter('.show-all').length > 0) {
                console.log('Show all comments button removed');

                // Добавляем кнопку "Свернуть"
                $('ul').append('<li class="hide-comments"><a href="#">Свернуть</a></li>');
            }
        });
    });

    // Наблюдаем за изменениями в ul
    observer.observe(document.querySelector('ul'), {
        childList: true
    });

    // Обработчик для кнопки "Свернуть"
    $(document).on('click', '.hide-comments', function(event) {
        event.preventDefault();
        console.log('Hide comments clicked');
        var $this = $(this);

        // Скрываем все комментарии, кроме элемента с классом "show-all"
        $this.siblings('li').not('.show-all').hide();

        // Удаляем кнопку "Свернуть"
        $this.remove();

        // Восстанавливаем кнопку "Show all comments"
        $('ul').append('<li class="show-all"><a href="#activity-30947/show-all/">Show all comments (6)</a></li>');
    });
});



