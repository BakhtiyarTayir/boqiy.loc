<?php
$args = array(
     'taxonomy' => 'product_cat',
          'hide_empty' => false,
          'parent'   => 0
);
$product_cat = get_terms( $args );
echo '<div class="home-category">';
    echo '<div class="left-market" data-spm="allinfo" style="" data-spm-max-idx="8">';
        echo '<div class="category-left">';
        foreach ($product_cat as $parent_product_cat) 
        {
                $thumbnail_id = get_term_meta( $parent_product_cat->term_id, 'thumbnail_id', true );
           
                echo '
                        <a href="'. get_term_link($parent_product_cat->term_id) .'" data-menu-id="'. $parent_product_cat->term_id . '">
                            <div class="category-item" >
                                <div>
                                   
                                    <span class="txt" data-spm-anchor-id="">'.$parent_product_cat->name. '</span>
                                </div>
                                <i class="sc-hd-prefix2-icon sc-hd-prefix2-icon-arrow-right"></i>
                            </div>
                        </a>
                    ';

        }
        echo '</div>';// category-left
        foreach ($product_cat as $parent_product_cat) 
        {
                $thumbnail_id = get_term_meta( $parent_product_cat->term_id, 'thumbnail_id', true );
                $image_url = wp_get_attachment_url( $thumbnail_id );

            $child_args = array(
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
                'number'        => 6,
                'parent'   => $parent_product_cat->term_id
            );
            $child_product_cats = get_terms( $child_args );
            echo '<div class="category-list"  id="dropDown'.$parent_product_cat->term_id .'">
                    <div class="category-layout">';
            foreach ($child_product_cats as $child_product_cat)
            {
                if ($child_product_cat) {
                    echo '<div class="category-item">
                        <h3><a href="'. get_term_link($child_product_cat->term_id) .'"> ' . $child_product_cat->name . ' </a></h3>';
                    
                        $children_args = array(
                        'taxonomy' => 'product_cat',
                        'hide_empty' => false,
                        'number'        => 6,
                        'parent'   => $child_product_cat->term_id
                        );
                        $children_product_cats = get_terms( $children_args);
                    echo '<ul>';
                        foreach ($children_product_cats as $children_product_cat)
                        {
                            ?>
                                <li>
                                    <a href="<?php echo get_term_link($children_product_cat->term_id);?>"><?php echo $children_product_cat->name;?></a>
                                </li>
                            <?php

                        }
                        ?>

                        </ul>
                    </div> <!--/ .category-item -->
                        
                    <?php
                }
                
            }
            echo '</div>'; // <!--/ .category-layout -->
            echo '</div>'; // <!--/ .category-list -->
            
        }
        ?>
        
        <?php
    echo '</div>';    // left-market
echo '</div>'; // home-category
