<?php
/**
 * Template Name: Linkable Home Page
 */

add_filter( 'body_class', 'body_class_wpse_85793', 10, 2 );
function body_class_wpse_85793( $classes, $class ) {
    if ( ! in_array('home', $classes) ) {
	    $classes[] = 'home';
    }
	return $classes;
}
get_header();
?>

<div class="entry-content home-entry-content">

<?php
global $user_ID;

$headline = get_field('headline');
$video_url = get_field('video_url');
$video_embed_code = get_field('video_embed_code');
$website_icon = get_field('website_owners_icon');
$website_text = get_field('website_owners_text');
$website_link = get_field('website_owners_button_link');
$website_button_text = get_field('website_owners_');
$author_icon = get_field('author_icon');
$author_text = get_field('author_text');
$author_link = get_field('author_button_link');
$author_button_text = get_field('author_button_text');
$icon_intro_text = get_field('below_laptop_text');

echo '<div class="linkable-home-header">' . $headline . '</div>';

	echo $video_embed_code;

echo '<div class="linkable-home-video">';

	echo '<div class="home-arrow">';
	
		echo '<div class="arrow-wrapper".';
			echo '<span>Watch our short intro video</span>';
			echo '<img class="watch-arrow" src="'. get_site_url() .'/wp-content/themes/linkable/images/watch-video-arrow-white.png">';
		echo '</div>';


	echo '<img class="laptop-screen" src="'. get_site_url() .'/wp-content/themes/linkable/images/linkable-home-screen.png" alt="laptop screen">';
	
	echo '</div>';
	
echo'</div>';

echo '<div class="home-icon-intros">';

	echo '<div class="icon-intro-text">';
		echo $icon_intro_text;
	echo '</div>';
	
	echo '<div class="icon-wrapper">';

		echo '<div class="website-owners">';
		echo '<i class="fa fa-' . $website_icon . '"></i>';
		echo $website_text;
		echo '<a class="shortcode-button button" href="' . $website_link . '">' . $website_button_text . '<i class="fa fa-chevron-circle-right"></i></a>';
		echo '<div class="see-how"><a href="/content-marketers/">See how it works</a></div>';	
		echo '</div>';
	
		echo '<div class="content-authors">';
		echo '<i class="fa fa-' . $author_icon . '"></i>';
		echo $author_text;
		echo '<a class="shortcode-button button" href="' . $author_link . '">' . $author_button_text . '<i class="fa fa-chevron-circle-right"></i></a>';
		echo '<div class="see-how"><a href="/content-authors/">See how it works</a></div>';	
		echo '</div>';
		
		
	echo '</div>';
	
echo '</div>';

?>

</div>
<?php get_footer(); ?>