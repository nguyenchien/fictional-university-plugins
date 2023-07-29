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
    add_action('enqueue_block_editor_assets', array($this, 'adminAssets'));
  }
  function adminAssets() {
    wp_enqueue_script('ournewblocktype', plugin_dir_url(__FILE__).'build/index.js', array('wp-blocks', 'wp-element'));
  }
}

$areYouPagingAttention = new AreYouPagingAttention();