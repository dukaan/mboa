<?php
function beTubeGetSectionContent($sectionTitle, $sectionCategory, $sectionView, $sectionCount, $sectionOrder, $sectionAdsCode)
{
    global $post;
    $post_id = $post->ID;
    ?>
    <!-- main content -->
    <section class="content">
        <?php if (!empty($sectionAdsCode)) { ?>
            <div class="googleAdv text-center">
                <?php echo $sectionAdsCode; ?>
            </div><!-- End ad Section -->
        <?php } ?>
        <!-- newest video -->
        <div class="main-heading">
            <div class="row secBg padding-14">
                <div class="medium-8 small-8 columns">
                    <div class="head-title">
                        <i class="fa fa-film"></i>
                        <h4><?php if (empty($sectionTitle)) {
                                echo $sectionCategory;
                            } else {
                                echo $sectionTitle;
                            } ?></h4>
                    </div>
                </div>
                <div class="medium-4 small-4 columns">
                    <ul class="tabs text-right pull-right" data-tabs>
                        <li class="tabs-title is-active"><a data-tab="1"
                                                            href=""><?php esc_html_e('All', 'betube'); ?></a></li>
                        <li class="tabs-title"><a data-tab="2" href=""><?php esc_html_e('HD', 'betube'); ?></a></li>
                    </ul>
                </div>
            </div>
        </div><!--mainheading-->
        <div class="row secBg">
            <div class="large-12 columns">
                <div class="row column head-text clearfix">
                    <?php
                    $postsInCat = get_term_by('id', $sectionCategory, 'category');
                    $totalPost = $postsInCat->count;
                    ?>
                    <p class="pull-left"><?php esc_html_e('All Videos', 'betube'); ?>
                        &nbsp;:&nbsp;<span><?php echo $totalPost; ?>
                            &nbsp;<?php esc_html_e('Videos posted', 'betube'); ?></span></p>
                    <div class="grid-system pull-right show-for-large">
                        <a class="secondary-button <?php if ($sectionView == "gridsmall") {
                            echo "current";
                        } ?> grid-default" href="#"><i class="fa fa-th"></i></a>
                        <a class="secondary-button <?php if ($sectionView == "gridmedium") {
                            echo "current";
                        } ?> grid-medium" href="#"><i class="fa fa-th-large"></i></a>
                        <a class="secondary-button <?php if ($sectionView == "listmedium") {
                            echo "current";
                        } ?> list" href="#"><i class="fa fa-th-list"></i></a>
                    </div>
                </div><!--headtext-->
                <div class="tabs-content">
                    <div class="tabs-panel tab-content active" data-content="1">
                        <?php
                        global $paged, $wp_query, $wp;
                        $args = wp_parse_args($wp->matched_query);
                        if (!empty ($args['paged']) && 0 == $paged) {
                            $wp_query->set('paged', $args['paged']);
                            $paged = $args['paged'];
                        }
                        if ($sectionOrder == 'views') {
                            $arags = array(
                                'post_type' => 'post',
                                'posts_per_page' => $sectionCount,
                                'paged' => $paged,
                                'cat' => $sectionCategory,
                                'order' => 'DESC',
                                'meta_key' => 'wpb_post_views_count',
                                'orderby' => 'meta_value_num'
                            );
                        } else {
                            $arags = array(
                                'post_type' => 'post',
                                'posts_per_page' => $sectionCount,
                                'paged' => $paged,
                                'cat' => $sectionCategory,
                                'order' => 'DESC',
                                'orderby' => $sectionOrder
                            );
                        }
                        $wsp_query = new WP_Query($arags);
                        $current = 1;
                        //print_r($wsp_query);
                        ?>
                        <div class="row list-group">
                            <?php
                            $myClass = "";
                            if ($sectionView == "gridsmall") {
                                $myClass = "group-item-grid-default";
                            } elseif ($sectionView == "gridmedium") {
                                $myClass = "grid-medium";
                            } elseif ($sectionView == "listmedium") {
                                $myClass = "list";
                            }
                            ?>
                            <?php while ($wsp_query->have_posts()) : $wsp_query->the_post();
                                $current++; ?>
                                <div class="mboa-item item large-3 medium-6 columns end <?php echo $myClass; ?>">
                                    <div class="item-heading">
                                        <?php
                                        $user_ID = $post->post_author;
                                        ?>
                                        <?php echo get_avatar($user_ID); ?>
                                        <span>
                                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author_meta('display_name', $user_ID); ?></a>
                                </span>
                                    </div>
                                    <div class="post thumb-border">
                                        <div class="post-thumb">
                                            <?php
                                            global $post;
                                            $post_id = $post->ID;
                                            $thumbURL = the_post_thumbnail();
                                            if (empty($thumbURL)) {
                                                $thumbURL = betube_thumb_url($post_id);
                                            }
                                            //$thumbURL = betube_thumb_url($post_id);
                                            $altTag = betube_thumb_alt($post_id);
                                            ?>
                                            <img src="<?php echo esc_url($thumbURL); ?>" alt="<?php echo $altTag; ?>"/>

                                            <a href="<?php the_permalink(); ?>" class="hover-posts">
                                                <span><i class="fa fa-play"></i><?php esc_html_e('Watch Video', 'betube'); ?></span>
                                            </a>
                                            <div class="video-stats clearfix">
                                                <?php
                                                $beTubePostHD = get_post_meta($post->ID, 'post_quality', true);
                                                if (!empty($beTubePostHD)) {
                                                    ?>
                                                    <div class="thumb-stats pull-left">
                                                        <h6><?php echo $beTubePostHD; ?></h6>
                                                    </div>
                                                <?php } ?>
                                                <?php
                                                include_once(ABSPATH . 'wp-admin/includes/plugin.php');
                                                if (is_plugin_active("betube-helper/index.php")) {
                                                    ?>
                                                    <div class="thumb-stats pull-left">
                                                        <!--<i class="fa fa-heart"></i>-->
                                                        <span><?php echo get_simple_likes_button(get_the_ID()); ?></span>
                                                    </div>
                                                <?php } ?>
                                                <?php
                                                $beTubePostTime = get_post_meta($post->ID, 'post_time', true);
                                                if (!empty($beTubePostTime)) {
                                                    ?>
                                                    <div class="thumb-stats pull-right">
                                                        <span><?php echo $beTubePostTime; ?></span>
                                                    </div>
                                                <?php } ?>
                                            </div><!--video-stats-->
                                        </div><!--post-thumb-->
                                        <div class="post-des">
                                            <h6>
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php $theTitle = get_the_title();
                                                    echo $theTitle; ?>
                                                </a>
                                            </h6>
                                            <div class="post-stats clearfix">
                                                <p class="pull-left">
                                                    <i class="fa fa-user"></i>
                                                    <?php
                                                    $user_ID = $post->post_author;
                                                    ?>
                                                    <span><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author_meta('display_name', $user_ID); ?></a></span>
                                                </p>
                                                <p class="pull-left">
                                                    <i class="fa fa-clock-o"></i>
                                                    <?php $beTubedateFormat = get_option('date_format'); ?>
                                                    <span><?php echo get_the_date($beTubedateFormat, $post_id); ?></span>
                                                </p>
                                                <p class="pull-left">
                                                    <i class="fa fa-eye"></i>
                                                    <span><?php echo betube_get_post_views(get_the_ID()); ?></span>
                                                </p>
                                            </div><!--post-stats-->
                                            <div class="post-summary">
                                                <p>
                                                    <?php echo substr(get_the_excerpt(), 0, 260); ?>
                                                </p>
                                            </div><!--post-summary-->
                                            <div class="post-button">
                                                <a href="<?php the_permalink(); ?>" class="secondary-button"><i
                                                            class="fa fa-play-circle"></i><?php esc_html_e('Watch Video', 'betube'); ?>
                                                </a>
                                            </div><!--post-button-->
                                        </div><!--post-des-->
                                    </div><!--post thumb-border-->
                                </div><!--item-->
                                <?php if ($current > $sectionCount) {
                                    break;
                                }; ?>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                            <?php //echo $current."Shabir";
                            ?>
                        </div><!--row list-group-->
                    </div><!--tabspanel-->
                    <div class="tabs-panel tab-content" data-content="2">
                        <div class="row list-group">
                            <?php
                            global $paged, $wp_query, $wp;
                            $args = wp_parse_args($wp->matched_query);
                            $temp = $wp_query;
                            $wp_query = null;
                            if ($sectionOrder == 'views') {
                                $args = array(
                                    'post_type' => 'post',
                                    'posts_per_page' => $sectionCount,
                                    'paged' => $paged,
                                    'cat' => $sectionCategory,
                                    'order' => 'DESC',
                                    'meta_key' => 'wpb_post_views_count',
                                    'orderby' => 'meta_value_num',
                                    'meta_query' => array(
                                        array(
                                            'key' => 'hd_post',
                                            'value' => '1',
                                            'compare' => '=='
                                        )
                                    ),
                                );
                            } else {
                                $args = array(
                                    'post_type' => 'post',
                                    'posts_per_page' => $sectionCount,
                                    'paged' => $paged,
                                    'cat' => $sectionCategory,
                                    'order' => 'DESC',
                                    'orderby' => $sectionOrder,
                                    'meta_query' => array(
                                        array(
                                            'key' => 'hd_post',
                                            'value' => '1',
                                            'compare' => '=='
                                        )
                                    ),
                                );
                            }
                            $wp_query = new WP_Query($args);
                            $current = -1;
                            while ($wp_query->have_posts()) : $wp_query->the_post();
                                $betubeHDMeta = get_post_meta($post->ID, 'hd_post', true);
                                ?>
                                <div class="item large-3 medium-6 columns end <?php echo $myClass; ?>">
                                    <div class="post thumb-border">
                                        <div class="post-thumb">
                                            <?php
                                            $thumbURL = the_post_thumbnail();
                                            if (empty($thumbURL)) {
                                                $thumbURL = betube_thumb_url($post_id);
                                            }
                                            //$thumbURL = betube_thumb_url($post_id);
                                            $altTag = betube_thumb_alt($post_id);
                                            ?>
                                            <img src="<?php echo esc_url($thumbURL); ?>" alt="<?php echo $altTag; ?>"/>

                                            <a href="<?php the_permalink(); ?>" class="hover-posts">
                                                <span><i class="fa fa-play"></i><?php esc_html_e('Watch Video', 'betube'); ?></span>
                                            </a>
                                            <div class="video-stats clearfix">
                                                <?php
                                                $beTubePostHD = get_post_meta($post->ID, 'post_quality', true);
                                                if (!empty($beTubePostHD)) {
                                                    ?>
                                                    <div class="thumb-stats pull-left">
                                                        <h6><?php echo $beTubePostHD; ?></h6>
                                                    </div>
                                                <?php } ?>
                                                <?php
                                                include_once(ABSPATH . 'wp-admin/includes/plugin.php');
                                                if (is_plugin_active("betube-helper/index.php")) {
                                                    ?>
                                                    <div class="thumb-stats pull-left">
                                                        <!--<i class="fa fa-heart"></i>-->
                                                        <span><?php echo get_simple_likes_button(get_the_ID()); ?></span>
                                                    </div>
                                                <?php } ?>
                                                <?php
                                                $beTubePostTime = get_post_meta($post->ID, 'post_time', true);
                                                if (!empty($beTubePostTime)) {
                                                    ?>
                                                    <div class="thumb-stats pull-right">
                                                        <span><?php echo $beTubePostTime; ?></span>
                                                    </div>
                                                <?php } ?>
                                            </div><!--video-stats-->
                                        </div><!--post-thumb-->
                                        <div class="post-des">
                                            <h6>
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php $theTitle = get_the_title();
                                                    echo $theTitle; ?>
                                                </a>
                                            </h6>
                                            <div class="post-stats clearfix">
                                                <p class="pull-left">
                                                    <i class="fa fa-user"></i>
                                                    <?php
                                                    $user_ID = $post->post_author;
                                                    ?>
                                                    <span><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author_meta('display_name', $user_ID); ?></a></span>
                                                </p>
                                                <p class="pull-left">
                                                    <i class="fa fa-clock-o"></i>
                                                    <?php $beTubedateFormat = get_option('date_format'); ?>
                                                    <span><?php echo get_the_date($beTubedateFormat, $post_id); ?></span>
                                                </p>
                                                <p class="pull-left">
                                                    <i class="fa fa-eye"></i>
                                                    <span><?php echo betube_get_post_views(get_the_ID()); ?></span>
                                                </p>
                                            </div><!--post-stats-->
                                            <div class="post-summary">
                                                <p>
                                                    <?php echo substr(get_the_excerpt(), 0, 260); ?>
                                                </p>
                                            </div><!--post-summary-->
                                            <div class="post-button">
                                                <a href="<?php the_permalink(); ?>" class="secondary-button"><i
                                                            class="fa fa-play-circle"></i><?php esc_html_e('Watch Video', 'betube'); ?>
                                                </a>
                                            </div><!--post-button-->
                                        </div><!--post-des-->
                                    </div><!--post thumb-border-->
                                </div><!--item-->
                                <?php if ($current > $sectionCount) {
                                    break;
                                }; ?>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                        </div><!--End HD Row-->
                    </div><!--End HD tabspanel-->
                </div><!--tabscontent-->
                <?php
                global $redux_demo;
                $betubeAllVideoURL = $redux_demo['all-video-page-link'];
                if (!empty($sectionCategory)) {
                    $currentCatLink = get_category_link($sectionCategory);
                    $currentCatName = get_the_category_by_ID($sectionCategory);
                }
                ?>
                <div class="text-center row-btn">
                    <?php if (!empty($currentCatLink)) { ?>
                        <a class="button radius"
                           href="<?php echo $currentCatLink; ?>"><?php esc_html_e('View All Video In', 'betube'); ?><?php echo $currentCatName; ?></a>
                    <?php } else { ?>
                        <a class="button radius"
                           href="<?php echo $betubeAllVideoURL; ?>"><?php esc_html_e('View All Video', 'betube'); ?></a>
                    <?php } ?>
                </div><!--End View All Button-->
            </div><!--large12-->
        </div><!--row secBg-->
        <!-- newest video -->
    </section>
    <!-- main content -->
<?php } ?>
<?php function beTubeFullWidthHome($sectionTitle, $sectionCategory, $sectionView, $sectionCount, $sectionOrder, $sectionAdsCode)
{
    global $post;
    $post_id = $post->ID;
    ?>
    <section class="content">
        <!--Google Section-->
        <?php if (!empty($sectionAdsCode)) { ?>
            <div class="googleAdv text-center">
                <?php echo $sectionAdsCode; ?>
            </div>
        <?php } ?>
        <!--Google Section-->
        <!--Main Heading-->
        <div class="main-heading">
            <div class="row expanded secBg padding-14">
                <div class="medium-8 small-8 columns">
                    <div class="head-title">
                        <i class="fa fa-film"></i>
                        <h4><?php if (empty($sectionTitle)) {
                                echo $sectionCategory;
                            } else {
                                echo $sectionTitle;
                            } ?></h4>
                    </div>
                </div>
                <div class="medium-4 small-4 columns">
                    <ul class="tabs text-right pull-right" data-tabs id="newVideos">
                        <li class="tabs-title is-active"><a href="#new-all"><?php esc_html_e('All', 'betube'); ?></a>
                        </li>
                        <li class="tabs-title"><a href="#new-hd"><?php esc_html_e('HD', 'betube'); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!--Main Heading-->
        <div class="row expanded secBg">
            <div class="large-12 columns">
                <div class="row column head-text clearfix">
                    <p class="pull-left">
                        <?php esc_html_e('All Videos', 'betube'); ?>&nbsp;:&nbsp;
                        <span><?php echo $totalPost; ?>&nbsp;<?php esc_html_e('Videos posted', 'betube'); ?></span>
                    </p>
                    <div class="grid-system pull-right show-for-large">
                        <a class="secondary-button <?php if ($sectionView == "gridsmall") {
                            echo "current";
                        } ?> grid-default" href="#"><i class="fa fa-th"></i></a>
                        <a class="secondary-button <?php if ($sectionView == "gridmedium") {
                            echo "current";
                        } ?> grid-medium" href="#"><i class="fa fa-th-large"></i></a>
                        <a class="secondary-button <?php if ($sectionView == "listmedium") {
                            echo "current";
                        } ?> list" href="#"><i class="fa fa-th-list"></i></a>
                    </div>
                </div>
                <!--Tab Content-->
                <div class="tabs-content" data-tabs-content="newVideos">
                    <div class="tabs-panel is-active" id="new-all">
                        <div class="row list-group fullwidth-group">
                            <!--Single loop div-->
                            <?php
                            $myClass = "";
                            if ($sectionView == "gridsmall") {
                                $myClass = "group-item-grid-default";
                            } elseif ($sectionView == "gridmedium") {
                                $myClass = "grid-medium";
                            } elseif ($sectionView == "listmedium") {
                                $myClass = "list";
                            }
                            ?>
                            <?php
                            global $paged, $wp_query, $wp;
                            $args = wp_parse_args($wp->matched_query);
                            if (!empty ($args['paged']) && 0 == $paged) {
                                $wp_query->set('paged', $args['paged']);
                                $paged = $args['paged'];
                            }
                            if ($sectionOrder == 'views') {
                                $arags = array(
                                    'post_type' => 'post',
                                    'posts_per_page' => $sectionCount,
                                    'paged' => $paged,
                                    'cat' => $sectionCategory,
                                    'order' => 'DESC',
                                    'meta_key' => 'wpb_post_views_count',
                                    'orderby' => 'meta_value_num'
                                );
                            } else {
                                $arags = array(
                                    'post_type' => 'post',
                                    'posts_per_page' => $sectionCount,
                                    'paged' => $paged,
                                    'cat' => $sectionCategory,
                                    'order' => 'DESC',
                                    'orderby' => $sectionOrder
                                );
                            }
                            $wp_query = new WP_Query($arags);
                            $current = 1;
                            ?>
                            <?php while ($wp_query->have_posts()) : $wp_query->the_post();
                                $current++; ?>
                                <div class="item large-2 medium-6 beetube__matchheight columns end <?php echo $myClass; ?>">
                                    <div class="post thumb-border">
                                        <div class="post-thumb">
                                            <?php
                                            global $post;
                                            $post_id = $post->ID;
                                            $thumbURL = the_post_thumbnail();
                                            if (empty($thumbURL)) {
                                                $thumbURL = betube_thumb_url($post_id);
                                            }
                                            //$thumbURL = betube_thumb_url($post_id);
                                            $altTag = betube_thumb_alt($post_id);
                                            ?>
                                            <img src="<?php echo esc_url($thumbURL); ?>" alt="<?php echo $altTag; ?>"/>

                                            <a href="<?php the_permalink(); ?>" class="hover-posts">
                                                <span><i class="fa fa-play"></i><?php esc_html_e('Watch Video', 'betube'); ?></span>
                                            </a>
                                            <div class="video-stats clearfix">
                                                <?php
                                                $beTubePostHD = get_post_meta($post->ID, 'post_quality', true);
                                                if (!empty($beTubePostHD)) {
                                                    ?>
                                                    <div class="thumb-stats pull-left">
                                                        <h6><?php echo $beTubePostHD; ?></h6>
                                                    </div>
                                                <?php } ?>
                                                <?php
                                                include_once(ABSPATH . 'wp-admin/includes/plugin.php');
                                                if (is_plugin_active("betube-helper/index.php")) {
                                                    ?>
                                                    <div class="thumb-stats pull-left">
                                                        <!--<i class="fa fa-heart"></i>-->
                                                        <span><?php echo get_simple_likes_button(get_the_ID()); ?></span>
                                                    </div>
                                                <?php } ?>
                                                <?php
                                                $beTubePostTime = get_post_meta($post->ID, 'post_time', true);
                                                if (!empty($beTubePostTime)) {
                                                    ?>
                                                    <div class="thumb-stats pull-right">
                                                        <span><?php echo $beTubePostTime; ?></span>
                                                    </div>
                                                <?php } ?>
                                            </div><!--video-stats-->
                                        </div><!--post-thumb-->
                                        <div class="post-des">
                                            <h6>
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php $theTitle = get_the_title();
                                                    echo $theTitle; ?>
                                                </a>
                                            </h6>
                                            <div class="post-stats clearfix">
                                                <p class="pull-left">
                                                    <i class="fa fa-user"></i>
                                                    <?php
                                                    $user_ID = $post->post_author;
                                                    ?>
                                                    <span><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author_meta('display_name', $user_ID); ?></a></span>
                                                </p>
                                                <p class="pull-left">
                                                    <i class="fa fa-clock-o"></i>
                                                    <?php $beTubedateFormat = get_option('date_format'); ?>
                                                    <span><?php echo get_the_date($beTubedateFormat, $post_id); ?></span>
                                                </p>
                                                <p class="pull-left">
                                                    <i class="fa fa-eye"></i>
                                                    <span><?php echo betube_get_post_views(get_the_ID()); ?></span>
                                                </p>
                                            </div><!--post-stats-->
                                            <div class="post-summary">
                                                <p>
                                                    <?php echo substr(get_the_excerpt(), 0, 260); ?>
                                                </p>
                                            </div><!--post-summary-->
                                            <div class="post-button">
                                                <a href="<?php the_permalink(); ?>" class="secondary-button"><i
                                                            class="fa fa-play-circle"></i><?php esc_html_e('Watch Video', 'betube'); ?>
                                                </a>
                                            </div><!--post-button-->
                                        </div><!--post-des-->
                                    </div><!--post thumb-border-->
                                </div><!--item-->
                                <?php if ($current > $sectionCount) {
                                    break;
                                }; ?>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                            <!--Single loop div-->
                        </div><!--row list-group fullwidth-group-->
                    </div><!--new-all-->
                    <div class="tabs-panel" id="popular-hd">
                        <div class="row list-group fullwidth-group">
                            <?php
                            global $paged, $wp_query, $wp;
                            $args = wp_parse_args($wp->matched_query);
                            $temp = $wp_query;
                            $wp_query = null;
                            if ($sectionOrder == 'views') {
                                $args = array(
                                    'post_type' => 'post',
                                    'posts_per_page' => $sectionCount,
                                    'paged' => $paged,
                                    'cat' => $sectionCategory,
                                    'order' => 'DESC',
                                    'meta_key' => 'wpb_post_views_count',
                                    'orderby' => 'meta_value_num',
                                    'meta_query' => array(
                                        array(
                                            'key' => 'hd_post',
                                            'value' => '1',
                                            'compare' => '=='
                                        )
                                    ),
                                );
                            } else {
                                $args = array(
                                    'post_type' => 'post',
                                    'posts_per_page' => $sectionCount,
                                    'paged' => $paged,
                                    'cat' => $sectionCategory,
                                    'order' => 'DESC',
                                    'orderby' => $sectionOrder,
                                    'meta_query' => array(
                                        array(
                                            'key' => 'hd_post',
                                            'value' => '1',
                                            'compare' => '=='
                                        )
                                    ),
                                );
                            }
                            $wp_query = new WP_Query($args);
                            $current = -1;
                            while ($wp_query->have_posts()) : $wp_query->the_post();
                                $betubeHDMeta = get_post_meta($post->ID, 'hd_post', true);
                                ?>
                                <!--Single loop div-->
                                <div class="item large-2 medium-6 beetube__matchheight columns <?php echo $myClass; ?>">
                                    <div class="post thumb-border">
                                        <div class="post-thumb">
                                            <?php
                                            global $post;
                                            $post_id = $post->ID;
                                            $thumbURL = the_post_thumbnail();
                                            if (empty($thumbURL)) {
                                                $thumbURL = betube_thumb_url($post_id);
                                            }
                                            //$thumbURL = betube_thumb_url($post_id);
                                            $altTag = betube_thumb_alt($post_id);
                                            ?>
                                            <img src="<?php echo esc_url($thumbURL); ?>" alt="<?php echo $altTag; ?>"/>

                                            <a href="<?php the_permalink(); ?>" class="hover-posts">
                                                <span><i class="fa fa-play"></i><?php esc_html_e('Watch Video', 'betube'); ?></span>
                                            </a>
                                            <div class="video-stats clearfix">
                                                <?php
                                                $beTubePostHD = get_post_meta($post->ID, 'post_quality', true);
                                                if (!empty($beTubePostHD)) {
                                                    ?>
                                                    <div class="thumb-stats pull-left">
                                                        <h6><?php echo $beTubePostHD; ?></h6>
                                                    </div>
                                                <?php } ?>
                                                <?php
                                                include_once(ABSPATH . 'wp-admin/includes/plugin.php');
                                                if (is_plugin_active("betube-helper/index.php")) {
                                                    ?>
                                                    <div class="thumb-stats pull-left">
                                                        <!--<i class="fa fa-heart"></i>-->
                                                        <span><?php echo get_simple_likes_button(get_the_ID()); ?></span>
                                                    </div>
                                                <?php } ?>
                                                <?php
                                                $beTubePostTime = get_post_meta($post->ID, 'post_time', true);
                                                if (!empty($beTubePostTime)) {
                                                    ?>
                                                    <div class="thumb-stats pull-right">
                                                        <span><?php echo $beTubePostTime; ?></span>
                                                    </div>
                                                <?php } ?>
                                            </div><!--video-stats-->
                                        </div><!--post-thumb-->
                                        <div class="post-des">
                                            <h6>
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php $theTitle = get_the_title();
                                                    echo $theTitle; ?>
                                                </a>
                                            </h6>
                                            <div class="post-stats clearfix">
                                                <p class="pull-left">
                                                    <i class="fa fa-user"></i>
                                                    <?php
                                                    $user_ID = $post->post_author;
                                                    ?>
                                                    <span><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author_meta('display_name', $user_ID); ?></a></span>
                                                </p>
                                                <p class="pull-left">
                                                    <i class="fa fa-clock-o"></i>
                                                    <?php $beTubedateFormat = get_option('date_format'); ?>
                                                    <span><?php echo get_the_date($beTubedateFormat, $post_id); ?></span>
                                                </p>
                                                <p class="pull-left">
                                                    <i class="fa fa-eye"></i>
                                                    <span><?php echo betube_get_post_views(get_the_ID()); ?></span>
                                                </p>
                                            </div><!--post-stats-->
                                            <div class="post-summary">
                                                <p>
                                                    <?php echo substr(get_the_excerpt(), 0, 260); ?>
                                                </p>
                                            </div><!--post-summary-->
                                            <div class="post-button">
                                                <a href="<?php the_permalink(); ?>" class="secondary-button"><i
                                                            class="fa fa-play-circle"></i><?php esc_html_e('Watch Video', 'betube'); ?>
                                                </a>
                                            </div><!--post-button-->
                                        </div><!--post-des-->
                                    </div><!--post thumb-border-->
                                </div><!--item-->
                                <?php if ($current > $sectionCount) {
                                    break;
                                }; ?>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                            <!--Single loop div-->
                        </div><!--row list-group fullwidth-group-->
                    </div><!--popular-hd-->
                </div>
                <!--Tab Content-->
                <?php
                global $redux_demo;
                $betubeAllVideoURL = $redux_demo['all-video-page-link'];
                if (!empty($sectionCategory)) {
                    $currentCatLink = get_category_link($sectionCategory);
                    $currentCatName = get_the_category_by_ID($sectionCategory);
                }
                ?>
                <div class="text-center row-btn">
                    <?php if (!empty($currentCatLink)) { ?>
                        <a class="button radius"
                           href="<?php echo $currentCatLink; ?>"><?php esc_html_e('View All Video In', 'betube'); ?><?php echo $currentCatName; ?></a>
                    <?php } else { ?>
                        <a class="button radius"
                           href="<?php echo $betubeAllVideoURL; ?>"><?php esc_html_e('View All Video', 'betube'); ?></a>
                    <?php } ?>
                </div><!--End View All Button-->
            </div><!--large-12 columns-->
        </div><!--row expanded secBg-->
    </section>
<?php } ?>
<?php function beTubeTwoSidebarHome($sectionTitle, $sectionCategory, $sectionView, $sectionCount, $sectionOrder, $sectionAdsCode)
{
    global $post;
    $post_id = $post->ID;
    ?>
    <!--FullWidth HomePage with Two Sidebar-->
    <!--Google Section-->
    <?php if (!empty($sectionAdsCode)) { ?>
    <div class="googleAdv text-center">
        <?php echo $sectionAdsCode; ?>
    </div>
<?php } ?>
    <!--Google Section-->
    <section class="content content-with-sidebar content-with-l-r-sidebar">
        <div class="main-heading">
            <div class="row secBg padding-14">
                <div class="medium-8 small-8 columns">
                    <div class="head-title">
                        <i class="fa fa-film"></i>
                        <h4><?php if (empty($sectionTitle)) {
                                echo $sectionCategory;
                            } else {
                                echo $sectionTitle;
                            } ?></h4>
                    </div>
                </div>
                <div class="medium-4 small-4 columns">
                    <ul class="tabs text-right pull-right" data-tabs id="newVideos">
                        <li class="tabs-title is-active"><a href="#new-all"><?php esc_html_e('All', 'betube'); ?></a>
                        </li>
                        <li class="tabs-title"><a href="#new-hd"><?php esc_html_e('HD', 'betube'); ?></a></li>
                    </ul>
                </div>
            </div>
        </div><!--main-heading-->
        <div class="row secBg">
            <div class="large-12 columns">
                <div class="row column head-text clearfix">
                    <p class="pull-left">
                        <?php esc_html_e('All Videos', 'betube'); ?>&nbsp;:&nbsp;
                        <span><?php echo $totalPost; ?>&nbsp;<?php esc_html_e('Videos posted', 'betube'); ?></span>
                    </p>
                    <div class="grid-system pull-right show-for-large">
                        <a class="secondary-button <?php if ($sectionView == "gridsmall") {
                            echo "current";
                        } ?> grid-default" href="#"><i class="fa fa-th"></i></a>
                        <a class="secondary-button <?php if ($sectionView == "gridmedium") {
                            echo "current";
                        } ?> grid-medium" href="#"><i class="fa fa-th-large"></i></a>
                        <a class="secondary-button <?php if ($sectionView == "listmedium") {
                            echo "current";
                        } ?> list" href="#"><i class="fa fa-th-list"></i></a>
                    </div>
                </div><!--row column head-text clearfix-->
                <div class="tabs-content" data-tabs-content="newVideos">
                    <div class="tabs-panel is-active" id="new-all">
                        <div class="row list-group">
                            <?php
                            $myClass = "";
                            if ($sectionView == "gridsmall") {
                                $myClass = "group-item-grid-default";
                            } elseif ($sectionView == "gridmedium") {
                                $myClass = "grid-medium";
                            } elseif ($sectionView == "listmedium") {
                                $myClass = "list";
                            }
                            ?>
                            <?php
                            global $paged, $wp_query, $wp;
                            $args = wp_parse_args($wp->matched_query);
                            if (!empty ($args['paged']) && 0 == $paged) {
                                $wp_query->set('paged', $args['paged']);
                                $paged = $args['paged'];
                            }
                            if ($sectionOrder == 'views') {
                                $arags = array(
                                    'post_type' => 'post',
                                    'posts_per_page' => $sectionCount,
                                    'paged' => $paged,
                                    'cat' => $sectionCategory,
                                    'order' => 'DESC',
                                    'meta_key' => 'wpb_post_views_count',
                                    'orderby' => 'meta_value_num'
                                );
                            } else {
                                $arags = array(
                                    'post_type' => 'post',
                                    'posts_per_page' => $sectionCount,
                                    'paged' => $paged,
                                    'cat' => $sectionCategory,
                                    'order' => 'DESC',
                                    'orderby' => $sectionOrder
                                );
                            }
                            $wp_query = new WP_Query($arags);
                            $current = 1;
                            ?>
                            <?php while ($wp_query->have_posts()) : $wp_query->the_post();
                                $current++; ?>
                                <!--Single loop div-->
                                <div class="item large-4 medium-6 beetube__matchheight columns end <?php echo $myClass; ?>">
                                    <div class="post thumb-border">
                                        <div class="post-thumb">
                                            <?php
                                            global $post;
                                            $post_id = $post->ID;
                                            $thumbURL = the_post_thumbnail();
                                            if (empty($thumbURL)) {
                                                $thumbURL = betube_thumb_url($post_id);
                                            }
                                            //$thumbURL = betube_thumb_url($post_id);
                                            $altTag = betube_thumb_alt($post_id);
                                            ?>
                                            <img src="<?php echo esc_url($thumbURL); ?>" alt="<?php echo $altTag; ?>"/>

                                            <a href="<?php the_permalink(); ?>" class="hover-posts">
                                                <span><i class="fa fa-play"></i><?php esc_html_e('Watch Video', 'betube'); ?></span>
                                            </a>
                                            <div class="video-stats clearfix">
                                                <?php
                                                $beTubePostHD = get_post_meta($post->ID, 'post_quality', true);
                                                if (!empty($beTubePostHD)) {
                                                    ?>
                                                    <div class="thumb-stats pull-left">
                                                        <h6><?php echo $beTubePostHD; ?></h6>
                                                    </div>
                                                <?php } ?>
                                                <?php
                                                include_once(ABSPATH . 'wp-admin/includes/plugin.php');
                                                if (is_plugin_active("betube-helper/index.php")) {
                                                    ?>
                                                    <div class="thumb-stats pull-left">
                                                        <!--<i class="fa fa-heart"></i>-->
                                                        <span><?php echo get_simple_likes_button(get_the_ID()); ?></span>
                                                    </div>
                                                <?php } ?>
                                                <?php
                                                $beTubePostTime = get_post_meta($post->ID, 'post_time', true);
                                                if (!empty($beTubePostTime)) {
                                                    ?>
                                                    <div class="thumb-stats pull-right">
                                                        <span><?php echo $beTubePostTime; ?></span>
                                                    </div>
                                                <?php } ?>
                                            </div><!--video-stats-->
                                        </div><!--post-thumb-->
                                        <div class="post-des">
                                            <h6>
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php $theTitle = get_the_title();
                                                    echo $theTitle; ?>
                                                </a>
                                            </h6>
                                            <div class="post-stats clearfix">
                                                <p class="pull-left">
                                                    <i class="fa fa-user"></i>
                                                    <?php
                                                    $user_ID = $post->post_author;
                                                    ?>
                                                    <span><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author_meta('display_name', $user_ID); ?></a></span>
                                                </p>
                                                <p class="pull-left">
                                                    <i class="fa fa-clock-o"></i>
                                                    <?php $beTubedateFormat = get_option('date_format'); ?>
                                                    <span><?php echo get_the_date($beTubedateFormat, $post_id); ?></span>
                                                </p>
                                                <p class="pull-left">
                                                    <i class="fa fa-eye"></i>
                                                    <span><?php echo betube_get_post_views(get_the_ID()); ?></span>
                                                </p>
                                            </div><!--post-stats-->
                                            <div class="post-summary">
                                                <p>
                                                    <?php echo substr(get_the_excerpt(), 0, 260); ?>
                                                </p>
                                            </div><!--post-summary-->
                                            <div class="post-button">
                                                <a href="<?php the_permalink(); ?>" class="secondary-button"><i
                                                            class="fa fa-play-circle"></i><?php esc_html_e('Watch Video', 'betube'); ?>
                                                </a>
                                            </div><!--post-button-->
                                        </div><!--post-des-->
                                    </div><!--post thumb-border-->
                                </div>
                                <!--Single loop div-->
                                <?php if ($current > $sectionCount) {
                                    break;
                                }; ?>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                        </div><!--row list-group-->
                    </div><!--new-all-->
                    <div class="tabs-panel" id="new-hd">
                        <div class="row list-group">
                            <?php
                            global $paged, $wp_query, $wp;
                            $args = wp_parse_args($wp->matched_query);
                            $temp = $wp_query;
                            $wp_query = null;
                            if ($sectionOrder == 'views') {
                                $args = array(
                                    'post_type' => 'post',
                                    'posts_per_page' => $sectionCount,
                                    'paged' => $paged,
                                    'cat' => $sectionCategory,
                                    'order' => 'DESC',
                                    'meta_key' => 'wpb_post_views_count',
                                    'orderby' => 'meta_value_num',
                                    'meta_query' => array(
                                        array(
                                            'key' => 'hd_post',
                                            'value' => '1',
                                            'compare' => '=='
                                        )
                                    ),
                                );
                            } else {
                                $args = array(
                                    'post_type' => 'post',
                                    'posts_per_page' => $sectionCount,
                                    'paged' => $paged,
                                    'cat' => $sectionCategory,
                                    'order' => 'DESC',
                                    'orderby' => $sectionOrder,
                                    'meta_query' => array(
                                        array(
                                            'key' => 'hd_post',
                                            'value' => '1',
                                            'compare' => '=='
                                        )
                                    ),
                                );
                            }
                            $wp_query = new WP_Query($args);
                            $current = -1;
                            while ($wp_query->have_posts()) : $wp_query->the_post();
                                $betubeHDMeta = get_post_meta($post->ID, 'hd_post', true);
                                ?>
                                <!--Single loop div-->
                                <div class="item large-4 medium-6 beetube__matchheight columns end <?php echo $myClass; ?>">
                                    <div class="post thumb-border">
                                        <div class="post-thumb">
                                            <?php
                                            global $post;
                                            $post_id = $post->ID;
                                            $thumbURL = the_post_thumbnail();
                                            if (empty($thumbURL)) {
                                                $thumbURL = betube_thumb_url($post_id);
                                            }
                                            //$thumbURL = betube_thumb_url($post_id);
                                            $altTag = betube_thumb_alt($post_id);
                                            ?>
                                            <img src="<?php echo esc_url($thumbURL); ?>" alt="<?php echo $altTag; ?>"/>

                                            <a href="<?php the_permalink(); ?>" class="hover-posts">
                                                <span><i class="fa fa-play"></i><?php esc_html_e('Watch Video', 'betube'); ?></span>
                                            </a>
                                            <div class="video-stats clearfix">
                                                <?php
                                                $beTubePostHD = get_post_meta($post->ID, 'post_quality', true);
                                                if (!empty($beTubePostHD)) {
                                                    ?>
                                                    <div class="thumb-stats pull-left">
                                                        <h6><?php echo $beTubePostHD; ?></h6>
                                                    </div>
                                                <?php } ?>
                                                <?php
                                                include_once(ABSPATH . 'wp-admin/includes/plugin.php');
                                                if (is_plugin_active("betube-helper/index.php")) {
                                                    ?>
                                                    <div class="thumb-stats pull-left">
                                                        <!--<i class="fa fa-heart"></i>-->
                                                        <span><?php echo get_simple_likes_button(get_the_ID()); ?></span>
                                                    </div>
                                                <?php } ?>
                                                <?php
                                                $beTubePostTime = get_post_meta($post->ID, 'post_time', true);
                                                if (!empty($beTubePostTime)) {
                                                    ?>
                                                    <div class="thumb-stats pull-right">
                                                        <span><?php echo $beTubePostTime; ?></span>
                                                    </div>
                                                <?php } ?>
                                            </div><!--video-stats-->
                                        </div><!--post-thumb-->
                                        <div class="post-des">
                                            <h6>
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php $theTitle = get_the_title();
                                                    echo $theTitle; ?>
                                                </a>
                                            </h6>
                                            <div class="post-stats clearfix">
                                                <p class="pull-left">
                                                    <i class="fa fa-user"></i>
                                                    <?php
                                                    $user_ID = $post->post_author;
                                                    ?>
                                                    <span><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author_meta('display_name', $user_ID); ?></a></span>
                                                </p>
                                                <p class="pull-left">
                                                    <i class="fa fa-clock-o"></i>
                                                    <?php $beTubedateFormat = get_option('date_format'); ?>
                                                    <span><?php echo get_the_date($beTubedateFormat, $post_id); ?></span>
                                                </p>
                                                <p class="pull-left">
                                                    <i class="fa fa-eye"></i>
                                                    <span><?php echo betube_get_post_views(get_the_ID()); ?></span>
                                                </p>
                                            </div><!--post-stats-->
                                            <div class="post-summary">
                                                <p>
                                                    <?php echo substr(get_the_excerpt(), 0, 260); ?>
                                                </p>
                                            </div><!--post-summary-->
                                            <div class="post-button">
                                                <a href="<?php the_permalink(); ?>" class="secondary-button"><i
                                                            class="fa fa-play-circle"></i><?php esc_html_e('Watch Video', 'betube'); ?>
                                                </a>
                                            </div><!--post-button-->
                                        </div><!--post-des-->
                                    </div><!--post thumb-border-->
                                </div>
                                <!--Single loop div-->
                                <?php if ($current > $sectionCount) {
                                    break;
                                }; ?>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                        </div>
                    </div><!--new-hd-->
                </div><!--newVideos-->
                <?php
                global $redux_demo;
                $betubeAllVideoURL = $redux_demo['all-video-page-link'];
                if (!empty($sectionCategory)) {
                    $currentCatLink = get_category_link($sectionCategory);
                    $currentCatName = get_the_category_by_ID($sectionCategory);
                }
                ?>
                <div class="text-center row-btn">
                    <?php if (!empty($currentCatLink)) { ?>
                        <a class="button radius"
                           href="<?php echo $currentCatLink; ?>"><?php esc_html_e('View All Video In', 'betube'); ?><?php echo $currentCatName; ?></a>
                    <?php } else { ?>
                        <a class="button radius"
                           href="<?php echo $betubeAllVideoURL; ?>"><?php esc_html_e('View All Video', 'betube'); ?></a>
                    <?php } ?>
                </div>
            </div><!--large-12 columns-->
        </div><!--row secBg-->
    </section>
    <!--FullWidth HomePage with Two Sidebar-->
<?php } ?>