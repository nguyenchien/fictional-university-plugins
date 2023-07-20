<?php get_header(); 
  pageBanner(array(
    'title' => 'All Campuses',
    'subtitle' => 'All campuses going in here'
  ));
?>
<div class="container container--narrow page-section">
  <div class="acf-map">
  <?php
    while(have_posts()) {
      the_post();
      $mapLocation = get_field('map_location');
      the_title();
      ?>
      <div class="marker" data-lat="<?php echo $mapLocation['lat']; ?>" data-lng="<?php echo $mapLocation['lng']; ?>"></div>
    <?php }
  ?>
  </div>
  <div class="pagination">
    <?php
      echo paginate_links();
    ?>
  </div>
</div>
<?php get_footer(); ?>