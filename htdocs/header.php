<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico">
    <!--[if lt IE 9]>
    <script src="//cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico">
    <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico">
    <link rel="apple-touch-icon" href="<?php bloginfo('template_url'); ?>/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/images/android-chrome-256x256.png">
    
    <?php wp_head(); ?>
    
    <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
    <script>
      var googletag = googletag || {};
      googletag.cmd = googletag.cmd || [];
      
      (function () {
        var gads = document.createElement('script');
        gads.async = true;
        gads.type = 'text/javascript';
        gads.id = 'leapin_gat';
        var useSSL = 'https:' == document.location.protocol;
        gads.src = (useSSL ? 'https:' : 'http:') +
            '//www.googletagservices.com/tag/js/gpt.js';
        var node = document.getElementsByTagName('script')[0];
        node.parentNode.insertBefore(gads, node);
      })();
      
      // GPT slot
      var gptAdSlots = [];
      
      googletag.cmd.push(function () {
          // defineSlots
          gptAdSlots[0] = googletag.defineSlot('/21870634244/wp.web-shizuoka.net', [[336, 280], [300, 250], [728, 90]], 'div-gpt-ad-1572933303259-0').addService(googletag.pubads());
          gptAdSlots[1] = googletag.defineSlot('/21870634244/wp2', [[336, 280], [300, 250], [728, 90]], 'div-gpt-ad-1572933415196-0').addService(googletag.pubads());
          gptAdSlots[2] = googletag.defineSlot('/21870634244/side1', [[336, 280], [300, 250]], 'div-gpt-ad-1572933511534-0').addService(googletag.pubads());
          // set SRA
          // define size mapping
          var mapping0 = googletag.sizeMapping()
              .addSize([1030, 0], [728, 90]) //desktop
              .addSize([768, 0], [728, 90]) //tablet
              .addSize([481, 0], [336, 280]) //mobile
              .addSize([0, 0], [234, 60]) //smaller than mobile
              .build();
          gptAdSlots[0].defineSizeMapping(mapping0);
          
          // define size mapping
          var mapping1 = googletag.sizeMapping()
              .addSize([1030, 0], [728, 90]) //desktop
              .addSize([768, 0], [728, 90]) //tablet
              .addSize([481, 0], [336, 280]) //mobile
              .addSize([0, 0], [234, 60]) //smaller than mobile
              .build();
          gptAdSlots[1].defineSizeMapping(mapping1);
          
          // define size mapping
          var mapping2 = googletag.sizeMapping()
              .addSize([481, 0], [336, 280]) //mobile
              .addSize([0, 0], [300, 250]) //smaller than mobile
              .build();
          gptAdSlots[2].defineSizeMapping(mapping2);
          
          googletag.pubads().enableSingleRequest();
          // fetch ads
          googletag.enableServices();
      });
    </script>
  </head>
  <body <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage">
    <header>
      <div class="wrap">
        <div id="logo">
          <?php if(is_home()): // ホーム ?>
            <h1 class="site_title"><a href="<?php bloginfo('url'); ?>" class="blog_title"><?php bloginfo('name'); ?></a></h1>
          <?php else: // ホーム以外 ?>
            <p class="site_title"><a href="<?php bloginfo('url'); ?>" class="blog_title"><?php bloginfo('name'); ?></a></p>
          <?php endif; ?>
          <?php
            wp_nav_menu( array( 
              'theme_location' => 'nav_menu_header',
              'menu_class' => 'nagare_header_menu',
              'container' => 'nav',
              'depth' => 1,
            ) ); 
          ?>
        </div><!-- .logo -->
      </div><!-- .wrap -->
    </header>
    
    <main id="main_contents">
      <div class="wrap">
        <div class="contents">