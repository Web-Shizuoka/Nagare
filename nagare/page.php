<?php get_header(); ?>

<div class="main" id="ch">
  <div class="c-ch">
    <div class="page_contents">
     
      <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
          <div class="s_thumbnail">
            <?php
              if(has_post_thumbnail()) { ?>
                <img src="<?php the_post_thumbnail_url(); ?>" />
                <?php
                //echo the_post_thumbnail('full');
              }
            ?>
            
          </div><!-- .s_thumbnail -->
          <?php edit_post_link('この記事を編集', '<p class="nagare-no-barba">', '</p>'); ?>
          <h1><?php the_title(); ?></h1>
          <div class="post_date">投稿 <?php the_time('Y/m/d');?><?php if(get_the_time('Y/m/d') != get_the_modified_date('Y/m/d')):?>　更新 <?php the_modified_date('Y/m/d') ?><?php endif;?></div>
          <div class="category_single"><?php the_category(' ') ?></div>
          
          <div class="text">
            <?php the_content(); ?>
          </div><!-- .text -->
          <div class="tags_single">Tags <?php the_tags('', ', '); ?></div>
          
        <?php endwhile; ?>
          
      <?php endif; ?>
            
            
    </div><!-- .single_contents -->
  </div><!-- .c-ch -->
</div><!-- .main -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
