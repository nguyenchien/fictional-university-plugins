<?php

/*
  Plugin Name: Featured Professor Block Type
  Version: 1.0
  Author: Your Name Here
  Author URI: https://www.udemy.com/user/bradschiff/
*/


if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
require_once plugin_dir_path(__FILE__) . 'inc/generateProfessorHTML.php';

class FeaturedProfessor {
  function __construct() {
    add_action('init', [$this, 'onInit']);
    add_action('rest_api_init', [$this, 'professorHTML']);
  }
  
  function professorHTML() {
    register_rest_route('featuredProfessor/v1', 'getHTML', array(
      'methods' => WP_REST_SERVER::READABLE,
      'callback' => [$this, 'getProfessorHTML']
    ));
  }
  
  function getProfessorHTML($data) {
    return generateProfessorHTML($data['professorID']);
  }

  function onInit() {
    wp_register_script('featuredProfessorScript', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-i18n', 'wp-editor'));
    wp_register_style('featuredProfessorStyle', plugin_dir_url(__FILE__) . 'build/index.css');

    register_block_type('ourplugin/featured-professor', array(
      'render_callback' => [$this, 'renderCallback'],
      'editor_script' => 'featuredProfessorScript',
      'editor_style' => 'featuredProfessorStyle'
    ));
  }
  
  function renderCallback($attributes) {
    if (isset($attributes['professorID'])) {
      wp_enqueue_style('featuredProfessorStyle');
      return generateProfessorHTML($attributes['professorID']);
    } else {
      return null;
    }
  }
  
}

$featuredProfessor = new FeaturedProfessor();
?>