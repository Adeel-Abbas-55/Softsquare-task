<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package JM-theme
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>





		<!-- displaying rating stars on FE -->
		<?php
$rating = get_post_meta(get_the_ID(), '_page_rating', true);

if ($rating) {
    $stars = str_repeat('⭐', intval($rating));
    echo '<p>Rating: ' . $stars . '</p>';
} else {
    echo '<p>No rating set.</p>';
}
?>




	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
