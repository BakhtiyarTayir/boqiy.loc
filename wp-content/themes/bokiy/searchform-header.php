<?php
/**
 * The template for displaying search forms in Boss
 *
 * @package Boss
 */
$current_lang = pll_current_language();
if($current_lang == 'en'){
	$action_text = 'en';
}else if($current_lang == 'uz'){
	$action_text = 'uz';
}else{
	$action_text = '';
}
?>
<form role="search" method="get" class="searchform" action="<?php echo get_site_url().'/'.$action_text; ?>">
    <div class="search-wrapper">
        <label class="screen-reader-text" for="s"><?php _e( 'Search for:', 'boss' ); ?></label>
        <input type="text" value="" name="s" />
        <button type="submit" class="searchsubmit" title="<?php _e( 'Search', 'boss' ); ?>"><i class="fa fa-search"></i></button>
        <button id="search-close"><i class="fas fa-times"></i></button>
    </div>
</form>

