<?php
/*
  Plugin Name: Are You Paging Attention
  Description: Add new block content with react
  Author: Chien Nguyen
  Version: 1.0
*/
if (!defined('ABSPATH')) exit;

class AreYouPagingAttention {
  function __construct() {
    add_action('init', array($this, 'adminAssets'));
  }

  function adminAssets() {
    wp_register_script('ournewblocktype', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-element'));
    register_block_type('ourplugin/are-you-paging-attention', array(
      'editor_script' => 'ournewblocktype',
      'render_callback' => array($this, 'theHTML')
    ));
  }

  function theHTML($attributes) {
    ob_start(); ?>
    <h3>Today the sky is <?php echo esc_html($attributes['skyColor']) ?> and the grass is <?php echo esc_html($attributes['glassColor']) ?>!</h3>
    <?php return ob_get_clean();
  }
}

$areYouPagingAttention = new AreYouPagingAttention();