<?php
  // register custom rest api: search route
  require get_theme_file_path('/inc/search-route.php');

  // register custom rest api: like route
  require get_theme_file_path('/inc/like-route.php');

  // page banner
  function pageBanner($args = array()) {
    if (!isset($args['title'])) {
      $args['title'] = get_the_title();
    }
    if (!isset($args['subtitle'])) {
      $args['subtitle'] = get_field('page_banner_sub_title');
    }
    if (!isset($args['photo'])) {
        if (get_field('page_banner_background_image') && !is_archive() && !is_home()) {
          $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {
          $args['photo'] = get_theme_file_uri('images/ocean.jpg');
        }
    }
    ?>
    <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
        <div class="page-banner__intro">
          <p><?php echo $args['subtitle']; ?></p>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php
  // add style, script for theme
  add_action('wp_enqueue_scripts', 'university_files');
  function university_files() {
    //wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyAQj28zH-bp5biS8H1qjAdiADOqzyVLn7c', NULL, '1.0', true);
    wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('font-google', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_style', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_style', get_theme_file_uri('/build/index.css'));
    wp_localize_script('main-university-js', 'universityData', array(
      'root_url' => get_site_url(),
      'nonce' => wp_create_nonce('wp_rest')
    ));
  }
  
  // hook setting feature for theme
  add_action('after_setup_theme', 'university_features');
  function university_features() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
    register_nav_menus(array(
      'headerMenuLocation' => 'Header Menu Location',
      'footerMenuLocation01' => 'Footer Menu Location 01',
      'footerMenuLocation02' => 'Footer Menu Location 02',
    ));
  }

  // hook pre get posts
  add_action('pre_get_posts', 'university_adjust_posts');
  function university_adjust_posts($query) {
    if ( !is_admin() && $query->is_main_query() && is_post_type_archive('event') ) {
      $today = date('Ymd');
      $query->set('meta_key', 'event_date');
      $query->set('orderby', 'meta_value_num');
      $query->set('order', 'ASC');
      $query->set('meta_query', array (
        array(
          'key' => 'event_date',
          'value' => $today,
          'type' => 'numeric',
          'compare' => '>='
        )
      ));
    }
    
    if ( !is_admin() && $query->is_main_query() && is_post_type_archive('program') ) {
      $query->set('order_by', 'title');
      $query->set('order', 'ASC');
      $query->set('posts_per_page', -1);
    }
  }
  
  add_filter('acf/fields/google_map/api', 'universityMapKey');
  function universityMapKey($api) {
    $api['key'] = 'AIzaSyAQj28zH-bp5biS8H1qjAdiADOqzyVLn7c';
    return $api;
  }
  
  // register_rest_field api
  add_action('rest_api_init', 'university_custom_rest');
  function university_custom_rest() {
    // register field: authorName
    register_rest_field( 'post', 'authorName', array(
      'get_callback' => 'get_post_meta_for_api'
    ));
    
    // register field: userNoteCount
    register_rest_field( 'note', 'userNoteCount', array(
      'get_callback' => function(){
        return count_user_posts(get_current_user_id(), 'note');
      },
    ));
  }
  function get_post_meta_for_api() {
    return get_the_author();
  }
  
  // redirect subscriber accounts out of admin and go to home page
  add_action('admin_init','redirectSubtoFrontEnd');
  function redirectSubtoFrontEnd() {
    $ourCurrentUser = wp_get_current_user();
    if (count($ourCurrentUser->roles) == 1 && $ourCurrentUser->roles[0] === 'subscriber') {
      wp_redirect(site_url('/'));
      exit;
    }
  }
  
  // hide admin bar for subscriber accounts
  add_action('wp_loaded','hideSubAdminBar');
  function hideSubAdminBar() {
    $ourCurrentUser = wp_get_current_user();
    if (count($ourCurrentUser->roles) == 1 && $ourCurrentUser->roles[0] === 'subscriber') {
      show_admin_bar(false);
    }
  }
  
  // customize login screen
  add_filter( 'login_headerurl', 'myLoginLogoUrl' );
  function myLoginLogoUrl() {
    return esc_url(site_url('/'));
  }
  
  add_filter( 'login_headertext', 'myLoginLogoTxt' );
  function myLoginLogoTxt() {
    return get_bloginfo();
  }
  
  add_filter( 'login_enqueue_scripts', 'myLoginCss' );
  function myLoginCss() {
    wp_enqueue_style('font-google', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_style', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_style', get_theme_file_uri('/build/index.css'));
  }
  
  // limit note
  add_filter('wp_insert_post_data', 'makeNoteLimit', 11, 2);
  function makeNoteLimit($data, $postarr) {
    $user = wp_get_current_user();
    $isAdmin = $user->roles[0] == 'administrator';
    if ($data['post_type'] == 'note') {
      if (count_user_posts(get_current_user_id(), 'note') > 2 && !$postarr['ID']) {
        die('You have reached your note limit.');
      }
      $data['post_title'] = sanitize_text_field($data['post_title']);
      $data['post_content'] = sanitize_textarea_field($data['post_content']);
    }
    return $data;
  }

  // exclude content from plugin All In One
  // ai1wm_exclude_themes_from_export the path is already wp-content/themes/
  add_filter('ai1wm_exclude_themes_from_export', 'ignoreCertainFiles');
  function ignoreCertainFiles($exclude_filters) {
    $exclude_filters[] = 'fictional-university-theme/node_modules';
    return $exclude_filters;
  }
?>