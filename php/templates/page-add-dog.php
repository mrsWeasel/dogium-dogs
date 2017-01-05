<?php
/*
Template Name: Add Dog
*/
/**
 * The template for displaying the 'Add Dog' page.
 * 
 * @since 1.0.0
 * @author Laura Heino
 * @uses ACF
 *
 */
defined( 'ABSPATH' ) or die( 'No direct access allowed.' );

if ( is_user_logged_in() ) {
	acf_form_head();
}

get_header();
?>
<header id="page-header">
    <div class="row">
        <div class="medium-8 medium-centered columns">
            <h1 class="text-center white text-shadow"><?php the_title();?></h1>
        </div>
    </div>
</header>

<div id="page-full-width" role="main">	

 <?php while ( have_posts() ) : the_post(); ?>
   <article <?php post_class('main-content') ?> id="post-<?php the_ID(); ?>">
       <div class="entry-content">
           <?php if (!is_user_logged_in()) : ?>
           		<div class="callout warning">
           			<p><?php echo sprintf(
           			__('Only logged in users are allowed to add dogs. Please <a href="%s">log in</a> or register.', 'dogium-dog'),
           			wp_login_url( get_permalink() ) 
           			); ?></p>
           		</div>
           <?php else : ?>
           	Olet kirjautunut.		
           <?php endif; ?>

       </div>
   </article>
 <?php endwhile;?>

</div> 

<?php
get_footer();