<?php
/**
 * Template Name: Blog Page Template
 * Description: A custom template for the blog page.
 */

get_header();  // This includes the header.php file
?>

<div class="blog-page-content">
    <h1>Blog Page</h1>
    <section class="blog-grid">
    <style>
        .blog-grid {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .blog-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            background: white;
        }

        .blog-card:hover {
            transform: translateY(-5px);
        }

        .card-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-content {
            padding: 20px;
        }

        .tags {
            display: flex;
            gap: 10px;
            margin-bottom: 12px;
        }

        .tag {
            background: #ffE4E6;
            color: #e11d48;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        .tag.blue {
            background: #E0F2FE;
            color: #0369A1;
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 12px;
            color: #1a1a1a;
            line-height: 1.4;
        }

        .card-date {
            color: #666;
            font-size: 14px;
        }
    </style>

<div class="grid-container">
        <?php
        $args = array(
            'posts_per_page' => 6, 
            'post_type' => 'post',  
            'paged' => get_query_var('paged') ? get_query_var('paged') : 1, 
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
        ?>
                <!-- Card for each blog post -->
                <article class="blog-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title(); ?>" class="card-image">
                        </a>
                    <?php endif; ?>
                    <div class="card-content">
                        <div class="tags">
                            <?php the_tags('<span class="tag">', '</span><span class="tag">', '</span>'); ?>
                        </div>
                        <h2 class="card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="card-date"><?php echo get_the_date(); ?></div>
                    </div>
                </article>
        <?php
            endwhile;
        endif;

        wp_reset_postdata();
        ?>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php
        echo paginate_links(array(
            'total' => $query->max_num_pages
        ));
        ?>
    </div>
</section>
</div>

<?php
get_footer();  // This includes the footer.php file
?>
