<?php
  function generateProfessorHTML($id) {
    $professorQuery = new WP_Query(array(
      'post_type' => 'professor',
      'p' => $id,
    ));
    
    while($professorQuery->have_posts()) {
      $professorQuery->the_post();
      ob_start(); ?>
      <div class="professor-callout">
        <div class="professor-callout__photo" style="background-image: url(<?php the_post_thumbnail_url('professorPortrait'); ?>)"></div>
        <div class="professor-callout__text">
          <h5><?php echo the_title(); ?></h5>
          <p><?php echo wp_trim_words(get_the_content(), 30, '...') ?></p>
          <p>
            <b>Name teaches:</b>
            <?php
              $relatedPrograms = get_field('related_programs');
              foreach ($relatedPrograms as $key => $program) {
                echo get_the_title($program);
                if ($key != array_key_last($relatedPrograms) && count($relatedPrograms) > 1) {
                  echo ', ';
                }
              }
            ?>
          </p>
          <p>Learn more about <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
        </div>
      </div>
    <?php
      wp_reset_postdata();
      return ob_get_clean();
    }
  }
?>