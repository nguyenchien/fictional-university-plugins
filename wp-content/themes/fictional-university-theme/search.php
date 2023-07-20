<?php
 get_header();

  pageBanner(array(
    'title' => 'Search Results',
    'subtitle' => 'Your searched for &quot;'.esc_html(get_search_query(false)).'&quot;',
  ))
?>
<div class="container container--narrow page-section">
  <?php
    if ( have_posts() ) {
      while(have_posts()) {
        the_post();
    
        get_template_part('template-parts/content', get_post_type());
      }
    } else {
      echo '<p style="margin-bottom: 50px;">No result matched! Please try a again!</p>';
      get_search_form();
    }
  ?>
  <div class="pagination"><?php echo paginate_links(); ?></div>
</div>
<?php get_footer(); ?>