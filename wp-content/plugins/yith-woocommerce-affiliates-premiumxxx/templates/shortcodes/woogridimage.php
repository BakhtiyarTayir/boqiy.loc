<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php 
global $post; global $product;
$request_affiliate = YITH_WCAF_Affiliate_Handler()->get_affiliate_by_user_id( get_current_user_id() );

if ( $request_affiliate ) {
    $request_token = $request_affiliate['token'];
}
$children = $product->get_children();
$product_rates = get_option( 'yith_wcaf_product_rates', 0 );
$stavka = $product_rates[ $post->ID ];
$rate = ($stavka * $product->get_regular_price()) / 100;
?>  
<?php if (empty( $product ) ) {return;}?>
<?php $classes = array('type-product','rh-hover-up', 'rh-cartbox','product', 'col_item','two_column_mobile', 'column_grid', 'flowvisible', 'pt0', 'pb0', 'pr0', 'pl0', 'rh-shadow4', 'woo_column_image');?>
<?php $woolinktype = (isset($woolinktype)) ? $woolinktype : '';?>
<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID ), 'single-post-thumbnail' );?>
<?php $affiliatetype = ($product->get_type() =='external') ? true : false;?>
<?php $custom_img_width = (isset($custom_img_width)) ? $custom_img_width : '';?>
<?php $custom_img_height = (isset($custom_img_height)) ? $custom_img_height : '';?>
<?php $custom_col = (isset($custom_col)) ? $custom_col : '';?>
<?php if($affiliatetype && ($woolinktype == 'aff' )) :?>
    <?php $woolink = $product->add_to_cart_url(); $wootarget = ' target="_blank" rel="nofollow sponsored"';?>
<?php else:?>
    <?php $woolink = get_post_permalink($post->ID); $wootarget = '';?>
<?php endif;?>
<?php $sales_html = ''; if ( $product->is_on_sale()) : ?>
    <?php 
    $percentage=0;
    if ($product->get_regular_price() && is_numeric($product->get_regular_price()) && $product->get_regular_price() !=0) {
        $percentage = round( ( ( $product->get_regular_price() - $product->get_price() ) / $product->get_regular_price() ) * 100 );
    }
    if ($percentage && $percentage>0 && !$product->is_type( 'variable' )) {
        $sales_html = '<div class="font80 text-right-align"><span><i class="rhicon rhi-arrow-down"></i> ' . $percentage . '%</span></div>';
        $classes[] = 'prodonsale';
    }
    ?>
<?php endif; ?>
<div class="product col_item column_grid type-product rh-cartbox hide_sale_price two_column_mobile woo_column_grid rh-shadow4 flowvisible prodonsale">   
     
    <div class="position-relative woofigure pt30 pb30 pl20 pr20">
           
    <figure class="text-center eq_figure mb0">      
        <a class="img-centered-flex rh-flex-center-align rh-flex-justify-center" href="<?php echo esc_url($woolink) ;?>"<?php echo ''.$wootarget ;?>>
            <?php if($image[0]):?>
            <img src="<?php  echo $image[0]; ?>">
            <?php else:?>
               <div class="empty_image"></div>
            <?php endif;?>
        </a>
           
    </figure>
    </div>
    <div class="pb10 pr15 pl15">               
        <h3 class="text-clamp text-clamp-3 mb15 mt0 font105 mobfont100 fontnormal lineheight20 minheight60">
            <a href="<?php echo esc_url($woolink) ;?>"><?php echo the_title();?></a>
        </h3> 
        <div class="clearbox"></div>  
        <div class="woo_gridloop_btn mb10 mt10 text-center">
            <div class="link-target hidden">    
                <input class="copy-target" readonly="readonly" type="text" name="generated_url" value="<?php echo  YITH_WCAF()->get_referral_url( $request_token, $woolink ); ;?>"> 
                <a href="#"  class="re_track_btn woo_loop_btn btn_offer_block ajax_copy"><?php echo __('Copy', 'yith-woocommerce-affiliates');?></a>
            </div>
            
            <div class="border-top pt10 pr10 pl10 pb10 rh-flex-center-align">
                
                <div class="rh-flex-right-align mobilesblockdisplay rehub-btn-font pr5 pricefont100 redbrightcolor fontbold mb0 lineheight20 text-right-align">
                    
                    <span class="price">
                    <div class="price_block pb10">
                            <b>Bonus:</b> <?php echo $rate.' '.get_woocommerce_currency_symbol();?><br>                      
                        </div>                 
                        <div class="price_block">                    
                            <b>Narxi:</b><?php echo $product->get_regular_price().' '.get_woocommerce_currency_symbol();?>
                        </div>               
                    </span>
                                
                </div>        
            </div>  
            <a href="#"  class="re_track_btn woo_loop_btn btn_offer_block  create_referral_url product_type_simple"><?php echo __("Create Referral URL", 'yith-woocommerce-affiliates');?></a>  
        </div>
    </div> 
                                  
</div>