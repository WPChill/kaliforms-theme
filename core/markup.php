<?php


//Displays the blog title and descripion in home or frontpage
if ( ! function_exists( 'antreas_title' ) ) {
	//add_filter('wp_title', 'antreas_title');
	function antreas_title( $title ) {
		global $page, $paged;

		if ( is_feed() ) {
			return $title;
		}

		$separator   = ' | ';
		$description = get_bloginfo( 'description', 'display' );
		$name        = get_bloginfo( 'name' );

		//Homepage title
		if ( $description && ( is_home() || is_front_page() ) ) {
			$full_title = $title . $separator . $description;
		} else {
			$full_title = $title;
		}

		//Page numbers
		if ( $paged >= 2 || $page >= 2 ) {
			$full_title .= ' | ' . sprintf( __( 'Page %s', 'antreas' ), max( $paged, $page ) );
		}

		return $title;
	}
}


//Displays the current page's title. Used in the main banner area.
if ( ! function_exists( 'antreas_page_title' ) ) {
	function antreas_page_title() {
		global $post;
		if ( isset( $post->ID ) ) {
			$current_id = $post->ID;
		} else {
			$current_id = false;
		}
		$title_tag = function_exists( 'is_woocommerce' ) && is_woocommerce() && is_singular( 'product' ) ? 'span' : 'h1';

		echo '<' . $title_tag . ' class="pagetitle-title heading">';
		if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
			woocommerce_page_title();
		} elseif ( is_category() || is_tag() || is_tax() ) {
			echo single_tag_title( '', true );
		} elseif ( is_author() ) {
			the_author();
		} elseif ( is_date() ) {
			_e( 'Archive', 'antreas' );
		} elseif ( is_404() ) {
			echo __( 'Page Not Found', 'antreas' );
		} elseif ( is_search() ) {
			echo __( 'Search Results for', 'antreas' ) . ' "' . get_search_query() . '"';
		} elseif ( is_home() ) {
			echo get_the_title( get_option( 'page_for_posts' ) );
		} else {
			echo get_the_title( $current_id );
		}
		echo '</' . $title_tag . '>';
	}
}


//Displays the current page's title. Used in the main banner area.
if ( ! function_exists( 'antreas_header_image' ) ) {
	function antreas_header_image() {
		$page_title = antreas_layout_title();
		if ( $page_title != 'minimal' && $page_title != 'none' ) {
			$url = apply_filters( 'antreas_header_image', get_header_image() );
			if ( $url != '' ) {
				return $url;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}


//Displays a Revolution Slider assigned to the current page.
add_action( 'antreas_before_main', 'antreas_header_slider', 5 );
if ( ! function_exists( 'antreas_header_slider' ) ) {
	function antreas_header_slider() {
		if ( function_exists( 'putRevSlider' ) ) {
			$current_id = antreas_current_id();
			if ( is_tax() || is_category() || is_tag() ) {
				$page_slider = antreas_tax_meta( $current_id, 'page_slider' );
			} else {
				$page_slider = get_post_meta( $current_id, 'page_slider', true );
			}

			if ( $page_slider != '0' && $page_slider != '' ) {
				echo '<div id="revslider" class="revslider">';
				putRevSlider( $page_slider );
				echo '</div>';
			}
		}
	}
}



//Add theme-specific body classes
add_filter( 'body_class', 'antreas_body_class' );
function antreas_body_class( $body_classes = '' ) {

	$classes    = '';

	if ( has_post_thumbnail() ) {
		$classes .= ' has-post-thumbnail';
	}

	if ( is_customize_preview() ) {
		$classes .= ' customizer-preview';
	}

	global $post;
	if ( isset( $post ) ) {
		$classes .= ' ' . $post->post_type . '-' . $post->post_name;
	}

	$body_classes[] = esc_attr( $classes );

	return $body_classes;
}


//Display viewport tag
if ( ! function_exists( 'antreas_viewport' ) ) {
	add_action( 'wp_head', 'antreas_viewport' );
	function antreas_viewport() {
		echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>' . "\n";
	}
}


//Print pingback metatag
if ( ! function_exists( 'antreas_pingback' ) ) {
	add_action( 'wp_head', 'antreas_pingback' );
	function antreas_pingback() {
		if ( get_option( 'default_ping_status' ) == 'open' ) {
			echo '<link rel="pingback" href="' . get_bloginfo( 'pingback_url' ) . '"/>' . "\n";
		}
	}
}


//Print charset metatag
if ( ! function_exists( 'antreas_charset' ) ) {
	add_action( 'wp_head', 'antreas_charset' );
	function antreas_charset() {
		echo '<meta charset="' . get_bloginfo( 'charset' ) . '"/>' . "\n";
	}
}


// Display shortcut edit links for logged in users.
if ( ! function_exists( 'antreas_edit' ) ) {
	function antreas_edit( $id = 0, $context = 'display' ) {

		$post = get_post( $id );
		if ( ! $post ) {
			return;
		}

		if ( 'revision' === $post->post_type ) {
			$action = '';
		} elseif ( 'display' == $context ) {
			$action = '&amp;action=edit';
		} else {
			$action = '&action=edit';
		}

		$post_type_object = get_post_type_object( $post->post_type );
		if ( ! $post_type_object ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post->ID ) ) {
			return;
		}

		if ( $post_type_object->_edit_link ) {
			$link = admin_url( sprintf( $post_type_object->_edit_link . $action, $post->ID ) );
		} else {
			$link = '';
		}

		if ( $link ) {
			echo '<a target="_blank" title="' . esc_attr__( 'Edit', 'antreas' ) . '" class="post-edit-link" href="' . esc_url( $link ) . '">' . esc_html__( 'Edit', 'antreas' ) . '</a>';
		}
	}
}

//Print 404 message
if ( ! function_exists( 'antreas_404' ) ) {
	function antreas_404() {
		echo apply_filters( 'antreas_404', __( 'The requested page could not be found. It could have been deleted or changed location. Try searching for it using the search function.', 'antreas' ) );
	}
}





//Displays the search form on search pages
add_action( 'antreas_before_content', 'antreas_search_form' );
if ( ! function_exists( 'antreas_search_form' ) ) {
	function antreas_search_form() {
		if ( is_search() ) {
			$search_query = '';
			if ( isset( $_GET['s'] ) ) {
				$search_query = esc_attr( $_GET['s'] );
			}

			echo '<div class="search-form">';
			echo '<form role="search" method="get" id="search-form" class="search-form" action="' . home_url( '/' ) . '">';
			echo '<input type="text" value="' . $search_query . '" name="s" id="s" />';
			echo '<input type="submit" id="search-submit" value="' . __( 'Search', 'antreas' ) . '" />';
			echo '</form>';
			echo '</div>';

			if ( ! have_posts() ) {
				echo '<p class="search-submit">' . __( 'No results were found. Please try searching with different terms.', 'antreas' ) . '</p>';
			}
		}
	}
}



//Displays the post date
if ( ! function_exists( 'antreas_postpage_date' ) ) {
	function antreas_postpage_date( $display = false, $date_format = '', $format_text = '' ) {
		if ( $display || antreas_get_option( 'postpage_dates' ) === true ) {
			if ( $date_format != '' ) {
				$date_string = get_the_date( $date_format );
			} else {
				$date_format = get_option( 'date_format' );
				$date_string = get_the_date( $date_format );
			}
			if ( $format_text != '' ) {
				$date_string = sprintf( $format_text, $date_string );
			}
			echo '<div class="post-date">' . $date_string . '</div>';
		}
	}
}

//Displays the author link
if ( ! function_exists( 'antreas_postpage_author' ) ) {
	function antreas_postpage_author( $display = false, $format_text = '' ) {
		if ( $display || antreas_get_option( 'postpage_authors' ) === true ) {
			$author_alt = sprintf( esc_attr__( 'View all posts by %s', 'antreas' ), get_the_author() );
			$author     = sprintf( '<a href="%1$s" title="%2$s">%3$s</a>', get_author_posts_url( get_the_author_meta( 'ID' ) ), $author_alt, get_the_author() );
			if ( $format_text != '' ) {
				$author = sprintf( $format_text, $author );
			}
			echo '<div class="post-author">' . $author . '</div>';
		}
	}
}

//Displays the category list for the current post
if ( ! function_exists( 'antreas_postpage_categories' ) ) {
	function antreas_postpage_categories( $display = false, $format_text = '' ) {
		if ( $display || antreas_get_option( 'postpage_categories' ) === true ) {
			$category_list = get_the_category_list( ', ' );
			if ( $format_text != '' ) {
				$category_list = sprintf( $format_text, $category_list );
			}
			echo '<div class="post-category">' . $category_list . '</div>';
		}
	}
}

//Displays the number of comments for the post
if ( ! function_exists( 'antreas_postpage_comments' ) ) {
	function antreas_postpage_comments( $display_always = false, $format_text = '' ) {
		if ( $display_always || antreas_get_option( 'postpage_comments' ) === true ) {
			$comments_num = get_comments_number();

			//Format comment texts
			if ( $format_text != '' ) {
				$text = $format_text;
			} else {
				if ( $comments_num == 0 ) {
					$text = __( 'No Comments', 'antreas' );
				} elseif ( $comments_num == 1 ) {
					$text = __( 'One Comment', 'antreas' );
				} else {
					$text = __( '%1$s Comments', 'antreas' );
				}
			}

			$comments = sprintf( $text, number_format_i18n( $comments_num ) );
			echo '<div class="post-comments">' . sprintf( '<a href="%1$s">%2$s</a>', get_permalink( get_the_ID() ) . '#comments', $comments ) . '</div>';
		}
	}
}






//Displays the author box
if ( ! function_exists( 'antreas_team_links' ) ) {
	function antreas_team_links( $args = null ) {
		$links = get_post_meta( get_the_ID(), 'team_links', true );
		if ( is_array( $links ) ) {
			wp_enqueue_style( 'antreas-fontawesome' );
			echo '<div class="team-member-links">';
			foreach ( $links as $link ) {
				if ( isset( $link['url'] ) && $link['url'] != '' ) {
					echo '<a class="team-member-link" rel="nofollow" href="' . $link['url'] . '" title="' . $link['name'] . '" target="_blank">';
					antreas_icon( $link['icon'] );
					echo '</a>';
				}
			}
			echo '<div class="clear"></div>';
			echo '</div>';
		}

	}
}





//Prints the footer navigation menu
if ( ! function_exists( 'antreas_top_menu' ) ) {
	function antreas_top_menu() {
		if ( has_nav_menu( 'top_menu' ) ) {
			echo '<div id="topmenu" class="topmenu">';
			wp_nav_menu(
				array(
					'menu_class'     => 'menu-top',
					'theme_location' => 'top_menu',
					'depth'          => 0,
					'fallback_cb'    => null,
					'walker'         => new Antreas_Menu_Walker(),
				)
			);
			echo '</div>';
		}
	}
}




//Print comment protected message
if ( ! function_exists( 'antreas_comments_protected' ) ) {
	function antreas_comments_protected() {
		if ( post_password_required() ) {
			echo '<p class="comments-protected">';
			_e( 'This page is protected. Please type the password to be able to read its contents.', 'antreas' );
			echo '</p>';

			return true;
		}

		return false;
	}
}


//Print comment list title
if ( ! function_exists( 'antreas_comments_title' ) ) {
	function antreas_comments_title() {
		echo '<h3 id="comments-title" class="comments-title">';
		if ( get_comments_number() == 1 ) {
			_e( 'One comment', 'antreas' );
		} else {
			printf( __( '%s comments', 'antreas' ), number_format_i18n( get_comments_number() ) );
		}
		echo '</h3>';
	}
}


//Print comment markup
if ( ! function_exists( 'antreas_comment' ) ) {
	function antreas_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;

		//Normal Comments
		switch ( $comment->comment_type ) :
			case '':
				?>
				<li <?php comment_class( 'comment' ); ?> id="comment-<?php comment_ID(); ?>">

				<div class="comment-body">
					<div class="comment-avatar">
						<?php echo get_avatar( $comment, 100 ); ?>
					</div>
					<div class="comment-title">
						<div class="comment-options">
							<?php edit_comment_link( __( 'Edit', 'antreas' ) ); ?>
							<?php
							comment_reply_link(
								array_merge(
									$args,
									array(
										'depth'     => $depth,
										'max_depth' => $args['max_depth'],
									)
								)
							);
							?>
						</div>
						<div class="comment-author">
							<?php echo get_comment_author_link(); ?>
						</div>
						<div class="comment-date">
							<a rel="nofollow" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
								<?php printf( __( '%1$s at %2$s', 'antreas' ), get_comment_date(), get_comment_time() ); ?>
							</a>
						</div>
					</div>

					<div class="comment-content">
						<?php if ( $comment->comment_approved == '0' ) : ?>
							<span class="comment-approval"><?php _e( 'Your comment is awaiting approval.', 'antreas' ); ?></span>
						<?php endif; ?>

						<?php comment_text(); ?>
					</div>
				</div>
				<?php
				break;

			//Pingbacks & Trackbacks
			case 'pingback':
			case 'trackback':
				?>
				<li class="pingback">
				<?php comment_author_link(); ?>
				<?php edit_comment_link( __( 'Edit', 'antreas' ), ' (', ')' ); ?>
				<?php
				break;
		endswitch;
	}
}

//Print comment list pagination
if ( ! function_exists( 'antreas_comments_pagination' ) ) {
	function antreas_comments_pagination() {
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
			echo '<div class="comments-navigation">';
			echo '<div class="comments-previous">';
			previous_comments_link( __( 'Older', 'antreas' ) );
			echo '</div>';
			echo '<div class="comments-next">';
			next_comments_link( __( 'Newer', 'antreas' ) );
			echo '</div>';
			echo '</div>';
		}
	}
}


//Print Tagline title
if ( ! function_exists( 'antreas_tagline_title' ) ) {
	function antreas_tagline_title() {
		$tagline = antreas_get_option( 'home_tagline' );
		if ( $tagline != '' ) {
			echo '<div class="tagline-title">';
			echo $tagline;
			echo '</div>';

		}
	}
}


//Print Tagline content
if ( ! function_exists( 'antreas_tagline_content' ) ) {
	function antreas_tagline_content() {
		$tagline = antreas_get_option( 'home_tagline_content' );
		if ( $tagline != '' ) {
			echo '<div class="tagline-content">';
			echo $tagline;
			echo '</div>';

		}
	}
}


//Print Tagline image
if ( ! function_exists( 'antreas_tagline_image' ) ) {
	function antreas_tagline_image() {
		$tagline = antreas_get_option( 'home_tagline_image' );
		if ( $tagline != '' ) {
			echo '<img class="tagline-image" src="' . $tagline . '"/>';
		}
	}
}


//Print Tagline image
if ( ! function_exists( 'antreas_tagline_link' ) ) {
	function antreas_tagline_link( $class = '' ) {
		$url  = antreas_get_option( 'home_tagline_url' );
		$link = antreas_get_option( 'home_tagline_link' );
		if ( $url != '' && $link != '' ) {
			echo '<a class="tagline-link ' . $class . '" href="' . esc_url( $url ) . '">';
			echo $link;
			echo '</a>';
		}
	}
}
