<?php
get_header();  
?>

<article class="single-post">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
    ?>
            <h1 class="post-title"><?php the_title(); ?></h1>
            <div class="post-meta">
                <span class="author">By <?php the_author(); ?></span>
                <span class="date"><?php echo get_the_date(); ?></span>
            </div>
            <div class="post-content">
                <?php the_content(); ?>
            </div>
    <?php
        endwhile;
    endif;
    ?>
</article>

<?php
get_footer();  
?>
