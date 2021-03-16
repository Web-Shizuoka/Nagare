        </div><!-- .contents -->
      </div><!-- .wrap -->
    </main>
    
    <footer>
      <div class="wrap">
        <?php dynamic_sidebar( 'footer-widget' ); ?>
        <?php
          wp_nav_menu( array( 
            'theme_location' => 'nav_footer_menu',
            'menu_class' => 'nagare_footer_menu',
            'container' => 'nav',
            'depth' => 1,
          ) ); 
        ?>
        <p class="copyright">&copy; <a href="<?php bloginfo('url'); ?>" class="blog_title"><?php echo get_bloginfo('name'); ?></a></p>
      </div><!-- .wrap -->
    </footer>
    
    <div class="mobile_foot_band">
      <div class="mobile_menu_btn" id="mobile_menu_btn">
        <span class="ham_line ham_line1"></span>
        <span class="ham_line ham_line2"></span>
        <span class="ham_line ham_line3"></span>
      </div>
    </div><!-- .mobile_foot_band -->
    
    <div id="modal_overlay"></div>
    
    <div class="mobile_menu" id="mobile_menu">
      <?php
        wp_nav_menu( array( 
          'theme_location' => 'nav_mobile_btn',
          'container' => 'nav',
          'menu_class' => 'mobile_menu_class',
          'link_before' => '<span class="mobile_menu_click">',
          'link_after' => '</span>',
        ) ); 
      ?>
    </div><!-- .mobile_menu -->
    
    <?php wp_footer(); ?>
  </body>
  <script>
    Barba.Pjax.init();
  </script>
</html>