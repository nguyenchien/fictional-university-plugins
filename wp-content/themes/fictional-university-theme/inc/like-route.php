<?php
  add_action('rest_api_init', 'universityRegisterLike');
  function universityRegisterLike() {
    register_rest_route('university/v1', '/manageLike/', array(
      'methods' => 'POST',
      'callback' => 'createLike',
    ));
    
    register_rest_route('university/v1', '/manageLike/', array(
      'methods' => 'DELETE',
      'callback' => 'deleteLike',
    ));
  }
  
  function createLike($data) {
    if (is_user_logged_in()) {
      $professor_id = sanitize_text_field($data['professor_id']);
      $existsQuery = new WP_Query(
        array(
          'author' => get_current_user_id(),
          'post_type' =>  'like',
          'meta_query' => array(
            array(
              'key' => 'liked_professor_id',
              'value' => $professor_id,
              'compare' => '=',
            )
          )
        )
      );
      if ($existsQuery->found_posts == 0 && get_post_type($professor_id) == "professor") {
        return wp_insert_post(array(
          'post_type' => 'like',
          'post_status' => 'publish',
          'post_title' => 'Like Title',
          'meta_input' => array(
            'liked_professor_id' => $professor_id
          )
        ));
      } else {
        die("Invalid Professor ID.");
      }
    } else {
      die("You must be logged in for a like.");
    }
  }
  
  function deleteLike($data) {
    $like_id = sanitize_text_field($data['like_id']);
    if (is_user_logged_in() && get_post_type($like_id) == 'like' && get_post_field('post_author', $like_id) == get_current_user_id()) {
      wp_delete_post($like_id, true);
      return "Success deleted a like.";
    } else {
      die('You must be logged in for delete a like.');
    }
  }
?>