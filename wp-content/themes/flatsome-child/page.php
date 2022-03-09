<?php
/**
 * The template for displaying all pages
 * 
 * @package flatsome-child
 * @author giangnh 
 */

if(flatsome_option('pages_template') != 'default'){
	get_template_part( 'page', flatsome_option('pages_template'));
	return;
}else{

	get_header();
	do_action( 'flatsome_before_page'); ?>
<div id="content" class="content-area page-wrapper-row" role="main">
	<div class="entry-content-row">
			<?php if(get_theme_mod('default_title', 0)){ ?>
				<header class="entry-header">
					<h1 class="entry-title mb uppercase"><?php the_title(); ?></h1>
				</header>
				<?php } ?>

				<?php while ( have_posts() ) : the_post(); ?>
					<?php do_action( 'flatsome_before_page_content' ); ?>
					
						<?php the_content(); ?>

						<?php if ( comments_open() || '0' != get_comments_number() ){
							comments_template(); } ?>

					<?php do_action( 'flatsome_after_page_content' ); ?>
				<?php endwhile; // end of the loop. ?>
	</div>
</div>
<?php
	get_footer();
}