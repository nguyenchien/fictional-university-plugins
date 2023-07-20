<?php
  add_action('rest_api_init', 'universityRegisterSearch');
  function universityRegisterSearch() {
    register_rest_route('university/v1', '/search/', array(
      'methods' => 'GET',
      'callback' => 'universitySearchResult',
    ));
  }
  function universitySearchResult($data) {
    $mainQuery = new WP_Query(
      array (
        'post_type' => array('post', 'page', 'event', 'program', 'professor', 'campus'),
        's' => sanitize_text_field($data['term'])
      )
    );
    $result = array(
      'generalData' => array(),
      'events' => array(),
      'programs' => array(),
      'professor' => array(),
      'campuses' => array(),
    );
    while($mainQuery->have_posts()) {
      $mainQuery->the_post();
      if (get_post_type() == 'post' || get_post_type() == 'page') {
        array_push($result['generalData'], array (
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'postType' => get_post_type(),
          'authorName' => get_the_author(),
        ));
      }
      if (get_post_type() == 'event') {
        $eventDay = new DateTime(get_field('event_date'));
        $month = $eventDay->format('M');
        $day = $eventDay->format('d');
        $description = wp_trim_words(get_the_content(), 5);
        array_push($result['events'], array (
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'month' => $month,
          'day' => $day,
          'description' => $description,
        ));
      }
      if (get_post_type() == 'program') {
        $relatedCampus = get_field('related_campus');
        if ($relatedCampus) {
          foreach ($relatedCampus as $campus) {
            array_push($result['campuses'], array (
              'title' => get_the_title($campus),
              'permalink' => get_the_permalink($campus),
            ));
          }
        }
        array_push($result['programs'], array (
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'id' => get_the_ID(),
        ));
      }
      if (get_post_type() == 'professor') {
        array_push($result['professor'], array (
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'image' => get_the_post_thumbnail_url(get_the_ID(), 'professorLandscape'),
        ));
      }
      if (get_post_type() == 'campus') {
        array_push($result['campuses'], array (
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
        ));
      }
    }
    
    
    // get professor related with program
    if ($result['programs']) {
      $programMetaQuery = array('relation' => 'OR');
      foreach ($result['programs'] as $item) {
        array_push($programMetaQuery, array(
          'key' => 'related_programs',
          'value' => $item['id'],
          'compare' => 'LIKE'
        ));
      }
      
      $programRelatedQuery = new WP_Query(
        array(
          'post_type' => array('professor', 'event'),
          'meta_query' => $programMetaQuery,
        )
      );
      
      while ($programRelatedQuery->have_posts()) {
        $programRelatedQuery->the_post();
        if (get_post_type() == 'professor') {
          array_push($result['professor'], array (
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
            'image' => get_the_post_thumbnail_url(get_the_ID(), 'professorLandscape'),
          ));
        }
        
        if (get_post_type() == 'event') {
          $eventDay = new DateTime(get_field('event_date'));
          $month = $eventDay->format('M');
          $day = $eventDay->format('d');
          $description = wp_trim_words(get_the_content(), 5);
          array_push($result['events'], array (
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
            'month' => $month,
            'day' => $day,
            'description' => $description,
          ));
        }
      }
      
      $result['professor'] = array_values(array_unique($result['professor'], SORT_REGULAR));
      $result['events'] = array_values(array_unique($result['events'], SORT_REGULAR));
    }
    
    return $result;
  }
?>