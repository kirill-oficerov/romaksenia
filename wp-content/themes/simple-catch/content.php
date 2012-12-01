<?php
/**
 * This is the template that displays content for index and archive page
 *
 * @package Catch Themes
 * @subpackage Simple_Catch
 * @since Simple Catch 1.3.2
 */
global $wp_object_cache;
?>

			<?php if ( have_posts() ) : 
                while( have_posts() ):the_post(); ?>	

                        <?php
	                    global $post;
	                    $tags = $wp_object_cache->get($post->ID, 'category_relationships');
	                    $isEvent = false;
	                    foreach($tags as $key=>$tag) {
		                    if($tag->name == 'Ивенты') {
			                    $isEvent = true;
			                    break;
		                    }
	                    }
	                    if($isEvent) {
		                    continue;
	                    }?>
                <div <?php post_class(); ?> >
	                <?
                        //If category has thumbnail it displays thumbnail and excerpt of content else excerpt only
                        if ( has_post_thumbnail() ) : ?>
<!--                            <div class="col3 post-img">-->
<!--                                <a href="--><?php //the_permalink(); ?><!--" title="--><?php //printf( esc_attr__( 'Permalink to %s', 'simplecatch' ), the_title_attribute( 'echo=0' ) ); ?><!--">--><?php //the_post_thumbnail( 'featured' ); ?><!--</a>-->
<!--                            </div> <!-- .col3 -->
<!--                            -->
<!--                            <div class="col5">-->
                        <?php else : ?>
                        <?php endif; ?>

	                    <div class="col8">

                                <h2 class="entry-title">
	                                <a href="<?php the_permalink() ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'simplecatch' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" ><?php the_title(); ?></a>
                                </h2>
	                <?
                    // tags
                    // ( $key, $group = 'default', $force = false, &$found = null )
					$tags = $wp_object_cache->get($post->ID, 'category_relationships');
                    $output = '<ul class="category-list tags">';
                    foreach($tags as $key => $tag) {
	                    if(!is_null($tag->category_settings)) {
							$categorySettings = unserialize($tag->category_settings);
	                    }
	                    $output .= '<li ' . (isset($categorySettings['class']) ? 'class="' . $categorySettings['class'] . '"' : '') . ' ><a  href="' . HTTP_HOST . '/category/' . $tag->slug . '">' . $tag->name . '</a></li>';
	                    unset($categorySettings);
                    }
                    $output .= '</ul>';
	                echo $output;
	                ?>


	                    <?php $excerpt = the_excerpt(false);
		                    $contentBegin = strrpos($excerpt, '<p rel="begin-of-the-excerpt-text">');
		                    $content = substr($excerpt, $contentBegin);
		                    $addThis = substr($excerpt, 35, $contentBegin);
		                    echo $addThis;
		                    ?>
		                    <div class="clear" style="height: 1px; width: 1px; "></div>

		                    <div style="text-align: center; ">
			                    <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'simplecatch' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_post_thumbnail( 'featured' ); ?></a>
		                    </div>


		                    <? echo $content ?>

	                    </div>
                         
                            <div class="row-end"></div>
                    </div><!-- .post -->
                    <hr />
                    
          			<?php endwhile;
                    
            		// Checking WP Page Numbers plugin exist
					if ( function_exists('wp_pagenavi' ) ) : 
						wp_pagenavi();
					
					// Checking WP-PageNaviplugin exist
					elseif ( function_exists('wp_page_numbers' ) ) : 
						wp_page_numbers();
						   
					else: 
						global $wp_query;
						if ( $wp_query->max_num_pages > 1 ) : 
					?>
							<ul class="default-wp-page">
								<li class="previous"><?php next_posts_link( __( 'Previous', 'simplecatch' ) ); ?></li>
								<li class="next"><?php previous_posts_link( __( 'Next', 'simplecatch' ) ); ?></li>
							</ul>
                        <?php endif;
 					endif; 
                    ?>

                    			
			<?php else : ?>
                    <div class="post">
                        <h2><?php _e( 'Not found', 'simplecatch' ); ?></h2>
                        <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'simplecatch' ); ?></p>
                        <?php get_search_form(); ?>
                    </div><!-- .post -->
			
			<?php endif; ?>