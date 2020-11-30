<?php
function nagare_css_js() {
  wp_enqueue_style( 'font-awesome', '//use.fontawesome.com/releases/v5.6.1/css/all.css');
  wp_enqueue_style( 'style', get_template_directory_uri() . '/htdocs/assets/img/style.css', array( 'font-awesome' ));
  
  wp_enqueue_script( 'plugins', get_template_directory_uri() . '/htdocs/assets/js/plugins.js', '', '', true );
  wp_enqueue_script( 'nagare-index', get_template_directory_uri() . '/htdocs/assets/js/index.js', array( 'plugins' ), '', true );
}
add_action( 'wp_enqueue_scripts', 'nagare_css_js' );
/**
 * 初期ウィジェットを無効化
 */
function remove_widgets(){
  unregister_widget('WP_Widget_Calendar'); //カレンダー

}
add_action('widgets_init', 'remove_widgets');

// ウィジェットエリア
// サイドバーのウィジェット
register_sidebar( array(
  'name' => __( 'Side Widget' ),
  'id' => 'side-widget',
  'before_widget' => '<li class="widget-container">',
  'after_widget' => '</li>',
  'before_title' => '<h3>',
  'after_title' => '</h3>',
) );

// フッターエリアのウィジェット
register_sidebar( array(
  'name' => __( 'Footer Widget' ),
  'id' => 'footer-widget',
  'before_widget' => '<div class="widget-area"><ul><li class="widget-container">',
  'after_widget' => '</li></ul></div>',
  'before_title' => '<h3>',
  'after_title' => '</h3>',
) );

// アイキャッチ画像
add_theme_support( 'post-thumbnails' );


// カスタムナビゲーションメニュー
add_theme_support('menus');

register_nav_menus( array(
  'nav_menu_header' => 'ヘッダーメニュー',
  'nav_footer_menu'  => 'フッターメニュー',
  'nav_mobile_btn'  => 'モバイルメニュー',
) );

// ツールバー非表示
add_filter('show_admin_bar', '__return_false');

// 記事編集リンクカスタマイズ
add_filter('edit_post_link', 'my_post_link');
function my_post_link($output) {
  return str_replace('<a ', '<a class="nagare-no-barba" ', $output);
}

/*** カスタムフィールド項目定義 ***
 *
 * $meta_arr[$id] = array($name,$array,$option);
 *   $id:     キー
 *   $name:   項目名
 *   $array:  保存データ形式（'array':配列、'single':テキスト）
 *   $option: オプション項目
 *   checkboxの場合は配列として登録される
 */

$meta_arr['og_title'] = array('OGPタイトル', 'single');
$meta_arr['og_description'] = array('OGP説明文', 'single');
/*** カスタムフィールドコンテンツの作り込み ***/
function ogp_meta_boxes() {
  global $post, $meta_arr;
  //metaの現在の登録値を取得（可変変数）
  foreach($meta_arr as $meta => $meta_val) {
    $true = ( $meta_val[1] == 'single' )? true: false;
    $val = $meta.'_Val';
    $nam = $meta.'_Nam';
    $$nam = $meta_val[0];
    $$val = get_post_meta( $post->ID, $meta, $true );
  }
 
  ?>
  <div class="postbox postbox_teachers">
    
    <dl>
        <dt><?php echo $og_title_Nam; ?></dt>
        <dd><input name="og_title" type="text" value="<?php echo $og_title_Val; ?>" style="width:30%"></dd>
        
        <dt><?php echo $og_description_Nam; ?></dt>
        <dd><textarea name="og_description" type="textfield" rows="4" style="width:90%"><?php echo $og_description_Val ?></textarea></dd>
    </dl>
    
  </div>
  <?php
}

add_action('admin_menu', 'create_meta_box');
/*** 投稿画面にカスタムフィールドのセクションを追加 ***/
function create_meta_box() {
  if ( function_exists('add_meta_box') )
    add_meta_box( 'ogp', 'OGP登録', 'ogp_meta_boxes', 'post', 'normal', 'high' );
}

add_action('save_post', 'save_postdata');
/*** カスタムフィールド入力値の保存 ***/
function save_postdata( $post_id ) {
  global $post, $meta_arr;
  foreach($meta_arr as $meta => $arr) {
    $true = ( $arr == 'single' )? true: false;
    $meta_cur = get_post_meta($post_id, $meta, $true);
    $meta_new = $_POST[$meta];
    
    // テキストエリア内の改行コードを無効に
    if($meta == "og_description") {
      $meta_new = str_replace(array("\r\n", "\r", "\n"), '', $meta_new);
    }
    
    if( $meta_cur == "" && $meta_new != "") {
        add_post_meta($post_id, $meta, $meta_new, true);
    } elseif ( $meta_cur != $meta_new ) {
        update_post_meta($post_id, $meta, $meta_new);
    } elseif ( $meta_new == "" ) {
        delete_post_meta($post_id, $meta, get_post_meta($post_id, $meta_cur, true));
    }
  }
}

// headタグ内に任意のコードを読み込む
function head_original_load(){
  
  if(is_single() || is_page()){
    //common
    if($head_original_code = get_post_meta(get_the_ID(), 'og_description', false)){
      foreach($head_original_code as $head_code){
        echo "<meta name=\"description\" content=\"" .$head_code . "\" />\n";
      }
    }
    echo "<link rel=\"canonical\" href=\"" . get_permalink(get_the_ID()) . "\" />\n";
    
    //facebook
    if($head_original_code = get_post_meta(get_the_ID(), 'og_title', false)){
      foreach($head_original_code as $head_code){
        echo "<meta property=\"og:title\" content=\"" .$head_code . "\" />\n";
      }
    }
    
    echo "<meta property=\"og:type\" content=\"article\" />\n";
    
    if($head_original_code = get_post_meta(get_the_ID(), 'og_description', false)){
      foreach($head_original_code as $head_code){
        echo "<meta property=\"og:description\" content=\"" .$head_code . "\" />\n";
      }
    }
    
    echo "<meta property=\"og:url\" content=\"" . get_permalink(get_the_ID()) . "\" />\n";
    
    if( has_post_thumbnail(get_the_ID())){
      foreach($head_original_code as $head_code){
        echo "<meta property=\"og:image\" content=\"" . get_the_post_thumbnail_url( get_the_ID(), 'full' ) . "\">\n";
      }
    }
    
    echo "<meta property=\"og:site_name\" content=\"" . get_bloginfo('name') . "\" />\n";
    
    //twitter
    echo "<meta property=\"twitter:card\" content=\"summary_large_image\" />\n";
    echo "<meta property=\"twitter:site\" content=\"" . home_url() . "\" />\n";
    
    if( has_post_thumbnail(get_the_ID())){
      foreach($head_original_code as $head_code){
        echo "<meta property=\"twitter:image\" content=\"" . get_the_post_thumbnail_url( get_the_ID(), 'full' ) . "\">\n";
      }
    }
    
    if($head_original_code = get_post_meta(get_the_ID(), 'og_title', false)){
      foreach($head_original_code as $head_code){
        echo "<meta property=\"twitter:title\" content=\"" .$head_code . "\" />\n";
      }
    }
    
    if($head_original_code = get_post_meta(get_the_ID(), 'og_description', false)){
      foreach($head_original_code as $head_code){
        echo "<meta property=\"twitter:description\" content=\"" .$head_code . "\" />\n";
      }
    }
    
    echo "<meta property=\"twitter:url\" content=\"" . get_permalink(get_the_ID()) . "\" />\n";
    
  } else {
    $http = is_ssl() ? 'https' : 'http' . '://';
    $url = $http . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    
    // common
    echo "<meta name=\"description\" content=\"" . get_bloginfo('description') . "\" />\n";
    echo "<link rel=\"canonical\" content=\"" . $url . "\" />\n";
    
    // facebook
    echo "<meta property=\"og:title\" content=\"" . get_bloginfo('name') . "\" />\n";
    echo "<meta property=\"og:type\" content=\"website\" />\n";
    echo "<meta property=\"og:description\" content=\"" . get_bloginfo('description') . "\" />\n";
    echo "<meta property=\"og:url\" content=\"" . $url . "\" />\n";
    echo "<meta property=\"og:image\" content=\"" . get_bloginfo('stylesheet_directory') . "/images/ogimage.png\">\n";
    echo "<meta property=\"og:site_name\" content=\"" . get_bloginfo('name') . "\" />\n";
    
    // twitter
    echo "<meta property=\"twitter:card\" content=\"summary_large_image\" />\n";
    echo "<meta property=\"twitter:site\" content=\"" . home_url() . "\" />\n";
    echo "<meta property=\"twitter:image\" content=\"" . get_bloginfo('stylesheet_directory') . "/images/ogimage.png\">\n";
    echo "<meta property=\"twitter:title\" content=\"" . get_bloginfo('name') . "\" />\n";
    echo "<meta property=\"twitter:description\" content=\"" . get_bloginfo('description') . "\" />\n";
    echo "<meta property=\"twitter:url\" content=\"" . $url . "\" />\n";
  }
}
add_action('wp_head', 'head_original_load');

add_theme_support('title-tag');


//追記
function my_plugin_block_categories( $categories, $post ) {
  return array_merge(
    $categories,
    array(
      array(
        'slug' => 'nagare',   //ブロックカテゴリーのスラッグ
        'title' => 'Nagare',  //ブロックカテゴリーの表示名
        'icon'  => 'palmtree',    //アイコンの指定（Dashicons名）
      ),
    )
  );
}
add_filter( 'block_categories', 'my_plugin_block_categories', 10, 2 );

function width_100_block_cgb_block_assets() { // phpcs:ignore
    // Register block styles for both frontend + backend.
    $block_url = get_template_directory_uri() . "/width-100-block/dist";
    wp_register_style(
        'width-100_block-cgb-style-css', // Handle.
        "$block_url/blocks.style.build.css",
        array( 'wp-editor' ), // Dependency to include the CSS after it.
        null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
    );

    // Register block editor script for backend.
    wp_register_script(
        'width-100_block-cgb-block-js', // Handle.
        "$block_url/blocks.build.js",
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), // Dependencies, defined above.
        null, // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime   Gets file modification time.
        true // Enqueue the script in the footer.
    );

    // Register block editor styles for backend.
    wp_register_style(
        'width-100_block-cgb-block-editor-css', // Handle.
        "$block_url/blocks.editor.build.css",
        array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
        null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
    );

    /**
     * Register Gutenberg block on server-side.
     *
     * Register the block on server-side to ensure that the block
     * scripts and styles for both frontend and backend are
     * enqueued when the editor loads.
     *
     * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
     * @since 1.16.0
     */
    register_block_type(
        'nagare/block-width-100', array(
            // Enqueue blocks.style.build.css on both frontend & backend.
            'style'         => 'width-100_block-cgb-style-css',
            // Enqueue blocks.build.js in the editor only.
            'editor_script' => 'width-100_block-cgb-block-js',
            // Enqueue blocks.editor.build.css in the editor only.
            'editor_style'  => 'width-100_block-cgb-block-editor-css',
        )
    );
}

function width_100_wrapper_cgb_block_assets() { // phpcs:ignore
    // Register block styles for both frontend + backend.
    $block_url = get_template_directory_uri() . "/width-100-wrapper/dist";
    wp_register_style(
        'width-100_wrapper-cgb-style-css', // Handle.
        "$block_url/blocks.style.build.css",
        array( 'wp-editor' ), // Dependency to include the CSS after it.
        null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
    );

    // Register block editor script for backend.
    wp_register_script(
        'width-100_wrapper-cgb-block-js', // Handle.
        "$block_url/blocks.build.js",
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), // Dependencies, defined above.
        null, // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime   Gets file modification time.
        true // Enqueue the script in the footer.
    );

    // Register block editor styles for backend.
    wp_register_style(
        'width-100_wrapper-cgb-block-editor-css', // Handle.
        "$block_url/blocks.editor.build.css",
        array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
        null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
    );

    /**
     * Register Gutenberg block on server-side.
     *
     * Register the block on server-side to ensure that the block
     * scripts and styles for both frontend and backend are
     * enqueued when the editor loads.
     *
     * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
     * @since 1.16.0
     */
    register_block_type(
        'nagare/wrapper-width-100', array(
            // Enqueue blocks.style.build.css on both frontend & backend.
            'style'         => 'width-100_wrapper-cgb-style-css',
            // Enqueue blocks.build.js in the editor only.
            'editor_script' => 'width-100_wrapper-cgb-block-js',
            // Enqueue blocks.editor.build.css in the editor only.
            'editor_style'  => 'width-100_wrapper-cgb-block-editor-css',
        )
    );
}
// Hook: Block assets.
add_action( 'init', 'width_100_block_cgb_block_assets' );
add_action( 'init', 'width_100_wrapper_cgb_block_assets' );


//エディターへのスタイル適用
if ( ! function_exists( 'nagare_2column_setup' ) ) :
  function nagare_2column_setup() {
      add_theme_support( 'editor-styles' );
      add_editor_style( 'style-editor.css' );
  }
endif;
add_action( 'after_setup_theme', 'nagare_2column_setup' );
ini_set('mysql.trace_mode',0);