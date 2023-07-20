<?php get_header(); 
  pageBanner();
?>
  <?php
    while(have_posts()) {
      the_post(); ?>
      <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
          <p>
            <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Home Programs</a> <span class="metabox__main"><?php the_title(); ?></span>
          </p>
        </div>
        <div class="generic-content">
          <?php the_field('main_body_content'); ?>
        </div>
        <?php
            $relatedProfessors = new WP_Query(
              array(
                'post_type' => 'professor',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC',
                'meta_query' => array(
                  array(
                    'key' => 'related_programs',
                    'value' => get_the_ID(),
                    'compare' => 'LIKE'
                  )
                )
              )
            );
            if ($relatedProfessors->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">'. get_the_title() .' Professor</h2>';
            echo '<ul class="professor-cards">';
            while($relatedProfessors->have_posts()) {
              $relatedProfessors->the_post(); ?>
              <li class="professor-card__list-item">
                <a href="<?php the_permalink(); ?>" class="professor-card">
                  <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>" alt="">
                  <span class="professor-card__name"><?php the_title(); ?></span>
                </a>
              </li>
            <?php }
              echo '</ul>';
              wp_reset_postdata();
            }
          ?>
          
        <?php
            $today = date('Ymd');
            $relatedEvents = new WP_Query(
              array(
                'post_type' => 'event',
                'posts_per_page' => 2,
                'meta_key' => 'event_date',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'meta_query' => array(
                  array(
                    'key' => 'event_date',
                    'value' => $today,
                    'type' => 'numeric',
                    'compare' => '>='
                  ),
                  array(
                    'key' => 'related_programs',
                    'value' => get_the_ID(),
                    'compare' => 'LIKE'
                  )
                )
              )
            );
            if ($relatedEvents->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Upcoming '. get_the_title() .' Event</h2>';
            while($relatedEvents->have_posts()) {
              $relatedEvents->the_post();
              get_template_part('template-parts/content-event');
            }
              wp_reset_postdata();
            }
          ?>
      </div>
      <?php
    }
  ?>
<?php get_footer(); ?>