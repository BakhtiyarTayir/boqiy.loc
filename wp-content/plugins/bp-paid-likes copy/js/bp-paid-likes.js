jQuery(document).ready(function($) {
    console.log('document ready');

    $('.bp-like-button').on('click', function() {
        console.log('click'); 
        var button = $(this);
        var post_id = button.data('post-id');

        $.ajax({
            url: bpPaidLikes.ajaxurl,
            type: 'POST',
            data: {
                action: 'bp_paid_likes',
                post_id: post_id,
                security: bpPaidLikes.nonce
            },
            success: function(response) {
                console.log('response: ' + response.data.message);
                alert(response.data.message);
            },
            error: function(xhr, status, error) {
                console.log("Ошибка: " + error);
            }
        });

    });

    $('.like-item').click(function() {
        var imageUrl = $(this).find('img').attr('src'); // Получаем URL изображения
        var postId = $(this).data('post-id')
        var postBlock = $(this).parent('.like-options').parent('.like-container').parent('.activity-meta').parent('.activity-content'); 
        var productId = $(this).data('product-id');
        
        var activityContent = $(this).closest('.activity-content'); // Получаем блок activity-content
        var imageCover = $('<div class="covered-image"></div>').css('background-image', 'url(' + imageUrl + ')').css('background-size', 'cover');
        console.log(imageCover); 
        

        $.ajax({
            url: bpPaidLikes.ajaxurl,
            type: 'POST',
            data: {
                action: 'bp_paid_likes',
                post_id: postId,
                product_id: productId, // Отправляем product_id
                security: bpPaidLikes.nonce
            },
            success: function(response) {
                if (response.success) {
                    alert(response.data.message);
                    activityContent.append(imageCover);
                } else {
                    alert(response.data.message);
                }
            },
            error: function(xhr, status, error) {
                alert("Произошла ошибка: " + error);
            }
        });
    });


});


