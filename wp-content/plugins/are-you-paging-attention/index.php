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
    register_block_type(__DIR__, array(
      'render_callback' => array($this, 'theHTML')
    ));
  }

  function theHTML($attributes) {
    ob_start(); ?>
    
    <div class="paying-attention-update-me"><pre style="display: none;"><?php echo wp_json_encode($attributes); ?></pre></div>
    
    <?php return ob_get_clean();
  }
}

$areYouPagingAttention = new AreYouPagingAttention();