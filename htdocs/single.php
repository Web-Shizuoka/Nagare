<?php get_header(); ?>

<div class="main" id="ch">
  <div class="c-ch">
    <div class="single_contents">
     
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
          <?php edit_post_link('この記事を編集', '<p>', '</p>'); ?>
          <h1><?php the_title(); ?></h1>
          <div class="post_date"><span class="icon_post_date"> <?php the_time('Y/m/d');?></span><?php if(get_the_time('Y/m/d') != get_the_modified_date('Y/m/d')):?><span class="icon_modify_date"> <?php the_modified_date('Y/m/d') ?></span><?php endif;?></div>
          <div class="category_single"><?php the_category(' ') ?></div>
          
          <div class="text">
            <?php the_content(); ?>
          </div><!-- .text -->
          <div class="tags_single">Tags <?php the_tags('', ', '); ?></div>
          
        <?php endwhile; ?>
          
        <div class="nav_below">
          <div class="nav_previous"><?php previous_post_link('%link', '&lt; PREVIOUS'); ?></div>
          <div class="nav_next"><?php next_post_link('%link', 'NEXT &gt;'); ?></div>
        </div><!-- /.nav-nav_below -->
       
      <?php endif; ?>
            
            
    </div><!-- .single_contents -->
  </div><!-- .c-ch -->
</div><!-- .main -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
