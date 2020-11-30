<?php get_header(); ?>

<div class="main" id="ch">
  <div class="c-ch">
    <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
        <div class="flex_one_post">
          <div class="post_thumbnail_">
            <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
              <?php
                if(has_post_thumbnail()) {
                  echo the_post_thumbnail('medium');
                } else {
                  ?><img src="<?php bloginfo('template_url'); ?>/images/default.png" /><?php
                }
              ?>
            </a>
          </div><!-- .post_thumbnail_ -->
          
          <div class="post_info_">
            <h2 class="post_title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
            <div class="post_date"><span class="icon_post_date"> <?php the_time('Y/m/d');?></span><?php if(get_the_time('Y/m/d') != get_the_modified_date('Y/m/d')):?><span class="icon_modify_date"> <?php the_modified_date('Y/m/d') ?></span><?php endif;?></div>
            <div class="category_index"><?php the_category(' ') ?></div>
            <div class="ogdescription_index"><?php echo get_post_meta($post->ID , 'og_description' ,true); ?></div>
          </div><!-- .post_info_ -->
          
        </div><!-- .one_post -->
        
      <?php endwhile; ?>
        
      <div class="nav-below">
        <span class="nav-previous"><?php next_posts_link('古い記事へ') ?></span>
        <span class="nav-next"><?php previous_posts_link('新しい記事へ') ?></span>
      </div><!-- .nav-below -->
     
    <?php else : ?>
     
        <h2 class="title">記事が見つかりませんでした。</h2>
        <p>検索で見つかるかもしれません。</p><br />
        <?php get_search_form(); ?>
     
    <?php endif; ?>
  </div><!-- .c-ch -->
        
</div><!-- .main -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
