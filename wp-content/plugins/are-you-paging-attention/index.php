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
    wp_register_style('quizeditcss', plugin_dir_url(__FILE__) . 'build/index.css');
    wp_register_script('ournewblocktype', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-element', 'wp-editor'));
    register_block_type('ourplugin/are-you-paging-attention', array(
      'editor_script' => 'ournewblocktype',
      'editor_style' => 'quizeditcss',
      'render_callback' => array($this, 'theHTML')
    ));
  }

  function theHTML($attributes) {
    if (!is_admin()) {
      wp_enqueue_style('attentionFrontendStyle', plugin_dir_url(__FILE__).'/build/frontend.css');
      wp_enqueue_script('attentionFrontendScript', plugin_dir_url(__FILE__).'/build/frontend.js', array('wp-element'));
    }
    ob_start(); ?>
    
    <div class="paying-attention-update-me"></div>
    
    <?php return ob_get_clean();
  }
}

$areYouPagingAttention = new AreYouPagingAttention();