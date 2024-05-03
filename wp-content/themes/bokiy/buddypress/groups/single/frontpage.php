<?php
/**
 * BP Nouveau Default group's front template.
 *
 * @since 3.0.0
 * @version 3.2.0
 */

$group_id = bp_get_group_id();
$st_description = groups_get_groupmeta( $group_id, 'group_ext_st_description' );
$university = groups_get_groupmeta( $group_id, 'group_ext_university' );
$course = groups_get_groupmeta( $group_id, 'group_ext_course' );
$tutor = groups_get_groupmeta( $group_id, 'group_ext_tutor' );
$test = groups_get_groupmeta( $group_id, 'group_ext_test' );
$file = groups_get_groupmeta( $group_id, 'group_ext_file' );

    ?>
    <div class="container">
        <div class="grid">
            <div class="quick-filters">
                <div class="quick-filters-tabs nav nav-tabs" id="nav-tab" role="tablist">
                <a class="active quick-filters-tab" id="nav-desc-tab" data-bs-toggle="tab" href="#nav-desc" ><?php echo __('Description', 'boss')?></a>
                    <a class="quick-filters-tab" id="nav-university-tab" data-bs-toggle="tab" href="#nav-university" ><?php echo pll__('Universities', 'boss')?></a>
                    <a class="quick-filters-tab" id="nav-couse-tab" data-bs-toggle="tab" href="#nav-course" ><?php echo __('Education centers', 'boss')?></a>
                    <a class="quick-filters-tab" id="nav-tutor-tab" data-bs-toggle="tab" href="#nav-tutor" ><?php echo __('Repetitors', 'boss')?></a>
                    <a class="quick-filters-tab" id="nav-test-tab" data-bs-toggle="tab" href="#nav-test" ><?php echo __('Tests', 'boss')?></a>
                    <a class="quick-filters-tab" id="nav-book-tab" data-bs-toggle="tab" href="#nav-book" ><?php echo __('Books', 'boss')?></a>
                </div>
            </div>

            <div class="tab-content" id="nav-tabContent">
                <!-- description -->
                <div class="tab-pane fade show active" id="nav-desc" role="tabpanel" aria-labelledby="nav-desc">
                    <div class="filterable-list">
                        <div>
                            <div class="centered">
                                <div class="container clearfix">
                                    <div class="row">
                                        <div class="col-md-12 group-description">
                                            <?php echo htmlspecialchars_decode($st_description); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <!-- ./description -->

                <!-- university -->
                <div class="tab-pane fade" id="nav-university" role="tabpanel" aria-labelledby="nav-university">
                    <div class="filterable-list">
                        <div>
                            <div class="grid grid-6-6 centered">
                            <?php
                                    $args = array(
                                        'tax_query' => array(
                                                array(
                                                    'taxonomy' => 'university_tax',
                                                    'field' => 'term_id',
                                                    'terms' => $university
                                                    )
                                            )
                                        );
    
                                        $query = new WP_Query($args);
                                        if ( $query -> have_posts() ) : while ( $query -> have_posts() ) : $query -> the_post(); ?>
                                            <div class="post-preview small animate-slide-down ">
                                                <a href="<?php the_permalink(); ?>">
                                                    <div class="post-preview-image"
                                                        style="background: url(<?php the_post_thumbnail_url(); ?>) center center / cover no-repeat;">
                                                    </div>
                                                </a>
                                                <div class="post-preview-info">
                                                    <div class="post-preview-info-top">
                                                        <p class="post-preview-timestamp">
                                                        <p class="post-preview-title">
                                                            <a href="<?php the_permalink(); ?>">
                                                            <?php the_title(); ?>
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endwhile; ?>
                                            <!-- post navigation -->
                                        <?php else: ?>
                                            <!-- no posts found -->
                                        <?php endif; 
                                    ?>
                            </div>
                        </div>
                    </div>
                </div> 
                <!-- ./university -->

                <!-- course -->
                <div class="tab-pane fade" id="nav-course" role="tabpanel" aria-labelledby="nav-couse">
                    <div class="filterable-list">
                        <div>
                            <div class="grid grid-6-6 centered">
                            <?php
                                    $args = array(
                                    'tax_query' => array(
                                            array(
                                                'taxonomy' => 'course_tax',
                                                'field' => 'term_id',
                                                'terms' => $course
                                                )
                                        )
                                    );

                                    $query = new WP_Query($args);
                                    if ( $query -> have_posts() ) : while ( $query -> have_posts() ) : $query -> the_post(); ?>
                                                <div class="post-preview small animate-slide-down ">
                                                <a href="<?php the_permalink(); ?>">
                                                    <div class="post-preview-image"
                                                        style="background: url(<?php the_post_thumbnail_url(); ?>) center center / cover no-repeat;">
                                                    </div>
                                                </a>
                                                <div class="post-preview-info">
                                                    <div class="post-preview-info-top">
                                                        <p class="post-preview-timestamp">
                                                        <p class="post-preview-title">
                                                            <a href="<?php the_permalink(); ?>">
                                                            <?php the_title(); ?>
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                            <!-- post navigation -->
                                        <?php else: ?>
                                            <!-- no posts found -->
                                        <?php endif; 

                                       
                                    ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./course -->
                
                <!-- tutor -->
                <div class="tab-pane fade" id="nav-tutor" role="tabpanel" aria-labelledby="nav-tutor">
                    <div class="filterable-list">
                        <div>
                            <div class="grid grid-6-6 centered">
                            <?php
                                    $args = array(
                                    'tax_query' => array(
                                            array(
                                                'taxonomy' => 'tutor_tax',
                                                'field' => 'term_id',
                                                'terms' => $tutor
                                                )
                                        )
                                    );

                                    $query = new WP_Query($args);
                                    if ( $query -> have_posts() ) : while ( $query -> have_posts() ) : $query -> the_post(); ?>
                                                <div class="post-preview small animate-slide-down ">
                                                <a href="<?php the_permalink(); ?>">
                                                    <div class="post-preview-image"
                                                        style="background: url(<?php the_post_thumbnail_url(); ?>) center center / cover no-repeat;">
                                                    </div>
                                                </a>
                                                <div class="post-preview-info">
                                                    <div class="post-preview-info-top">
                                                        <p class="post-preview-timestamp">
                                                        <p class="post-preview-title">
                                                            <a href="<?php the_permalink(); ?>">
                                                            <?php the_title(); ?>
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                            <!-- post navigation -->
                                        <?php else: ?>
                                            <!-- no posts found -->
                                        <?php endif; 

                                       
                                    ?>            
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./tutor -->

                <!-- test -->
                <div class="tab-pane fade" id="nav-test" role="tabpanel" aria-labelledby="nav-test">
                    <div class="filterable-list">
                        <div>
                            <div class="grid grid-6-6 centered">
                                [watuprolist cat_id=<?php echo $test; ?>]
                                    <div class="post-preview small animate-slide-down ">
                                        <a href="{{{quiz-url}}}">
                                            <div class="post-preview-image"
                                                style="background: url({{{quiz-thumbnail-url}}}) center center / cover no-repeat;">
                                            </div>
                                        </a>
                                        <div class="post-preview-info">
                                            <div class="post-preview-info-top">
                                                <p class="post-preview-title">
                                                    <a href="{{{quiz-url}}}">
                                                    {{{quiz-name}}}
                                                    </a>
                                                </p>
                                                <!-- <p>{{{quiz-description}}}</p> -->
                                                <a class="button secondary small" href="{{{quiz-url}}}">
                                                    <?php echo __('Pass the test', 'boss');?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                [/watuprolist] 

                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./test -->

                <!-- book -->
                <div class="tab-pane fade" id="nav-book" role="tabpanel" aria-labelledby="nav-book">
                    <div class="filterable-list">
                        <div>
                            <div class="grid grid-6-6 centered">
                            <?php
                                    if($file):
                                        // параметры по умолчанию
                                        $posts = get_posts( array(
                                        'numberposts' => 5,
                                        'category'    => $file,
                                        'orderby'     => 'date',
                                        'order'       => 'DESC',
                                        'include'     => array(),
                                        'exclude'     => array(),
                                        'meta_key'    => '',
                                        'meta_value'  =>'',
                                        'post_type'   => 'wpdmpro',
                                        'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
                                        ) );
                                        
                                        foreach( $posts as $post ){
                                        setup_postdata($post);

                                         echo do_shortcode("[wpdm_package id=".get_the_ID()." template='link-template-calltoaction3.php']");  
                                        
                                        }
                                        wp_reset_postdata(); // сброс
                                    endif;
                                ?> 
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./book -->
              
            </div>
        </div>
    </div>
    <style>

.profile-header.v2 .profile-header-info .profile-header-info-actions .profile-header-info-action.button:before{
    content: attr(data-title);
}
.profile-header.v2 .profile-header-info .profile-header-info-actions .profile-header-info-action.button svg{
    display: none;
}
</style>


