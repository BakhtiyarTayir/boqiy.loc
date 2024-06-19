<?php
/*
Plugin Name: Boqiy Social Share Buttons
Description: Добавляет кнопки "Поделиться" для Facebook, Instagram и Telegram под постами BuddyPress.
Version: 1.0
Author: Boqiy.uz
*/


// Подключение Font Awesome и Tippy.js
function enqueue_scripts_and_styles() {
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css' );
    wp_enqueue_style( 'tippy-css', 'https://unpkg.com/tippy.js@6/dist/tippy.css' );
    wp_enqueue_script( 'popper-js', 'https://unpkg.com/@popperjs/core@2', array(), null, true );
    wp_enqueue_script( 'tippy-js', 'https://unpkg.com/tippy.js@6', array(), null, true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_scripts_and_styles' );

// Хук для инициализации плагина
add_action('bp_activity_entry_meta', 'add_social_share_buttons');

function add_social_share_buttons() {
    if (is_user_logged_in()) {
        $post_url = bp_get_activity_thread_permalink();  // Получаем URL поста
        $post_title = bp_get_activity_feed_item_title(); // Получаем заголовок поста
        $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($post_url);
        $telegram_url = 'https://t.me/share/url?url=' . urlencode($post_url) . '&text=' . urlencode($post_title);
        $instagram_url = '#'; // Instagram не поддерживает прямой шэринг ссылок

        $buttons_html = '<ul class="social-share-buttons">';
        $buttons_html .= '<li><a href="' . $facebook_url . '" target="_blank" class="social-share-button facebook-share-button" data-tippy-content="Поделиться в Facebook"><i class="fab fa-facebook-f"></i></a></li>';
        $buttons_html .= '<li><a href="' . $instagram_url . '" target="_blank" class="social-share-button instagram-share-button" data-tippy-content="Поделиться в Instagram"><i class="fab fa-instagram"></i></a></li>';
        $buttons_html .= '<li><a href="' . $telegram_url . '" target="_blank" class="social-share-button telegram-share-button" data-tippy-content="Поделиться в Telegram"><i class="fab fa-telegram-plane"></i></a></li>';
        $buttons_html .= '</ul>';

        echo $buttons_html;
    }
}

// Добавление стилей для кнопок
function social_share_styles() {
    echo '<style>
        .social-share-buttons {
            list-style: none;
            padding: 0;
            margin: 0 0 0 20px;
            display: flex;
            margin-left: auto;
        }
        .social-share-buttons li {
            margin-right: 10px;
        }
        .social-share-button {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            color: white;
            text-decoration: none;
            border-radius: 50%;
            text-align: center;
            font-size: 20px;
            transition: all 0.3s ease;
        }
        .social-share-button i {
            vertical-align: middle;
        }
        .facebook-share-button {
            color: #3b5998!important;
        }
        .instagram-share-button {
            color: #E1306C!important;
        }
        .telegram-share-button {
            color: #0088cc!important;
        }

        .facebook-share-button:hover {
            color: #2d4373!important;
        }
        .instagram-share-button:hover {
            color: #C13584!important;
        }
        .telegram-share-button:hover {
            color: #006699!important;
        }
        #youzify .activity-meta .social-share-buttons  a:before, 
        #youzify  .activity-meta .social-share-buttons  i {
            color: unset;
            margin-right: 0;
        }
    </style>';
}
add_action('wp_head', 'social_share_styles');

// Инициализация tooltips
function initialize_tooltips() {
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            tippy(".social-share-button", {
                placement: "top",
                theme: "light",
            });
        });
    </script>';
}
add_action('wp_footer', 'initialize_tooltips');




// Инициализация tooltips Bootstrap
function initialize_tooltips2() {
    echo '<script>

        $(function () {
            $(\'[data-toggle="tooltip"]\').tooltip()
          })
    </script>';
}
add_action('wp_footer', 'initialize_tooltips2');