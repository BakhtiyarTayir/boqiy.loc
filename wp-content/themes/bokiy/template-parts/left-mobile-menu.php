<div id="mobile-menu" class="menu-panel">

	<div id="mobile-menu-inner" data-titlebar="<?php echo (boss_get_option( 'boss_titlebar_position' )) ? boss_get_option( 'boss_titlebar_position' ) : 'top'; ?>">
		
	<?php
$args = array(
    'taxonomy' => 'product_cat',
    'hide_empty' => false,
    'show_count'   => 1,
    'number'        => 7,
    'parent'   => 0,
);
$product_cat = get_terms( $args );
    echo '<div class="header-hor-tabs home-mobile-menu">';
        foreach ($product_cat as $parent_product_cat) 
        {
                $thumbnail_id = get_term_meta( $parent_product_cat->term_id, 'thumbnail_id', true );
                $image_url = wp_get_attachment_url( $thumbnail_id );
                echo '
                        <a href="'. get_term_link($parent_product_cat->term_id) .'" data-menu-id="'. $parent_product_cat->term_id . '">
                            <div class="category-item" >
                                <div>
                                    <span class="txt" data-spm-anchor-id="">'.$parent_product_cat->name. '</span>
                                </div>
                            </div>
                        </a>
                    ';

        }
        ?>
        
    </div>

	</div>

</div> <!-- #mobile-menu -->