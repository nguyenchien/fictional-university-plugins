<?php
/*
  Plugin Name: Word Count
  Description: This is a test plugin
  Author: Chien Nguyen
  Version: 1.0
*/
class WordCount {
  function __construct() {
    add_action('admin_menu', array($this, 'adminPage'));
  }
  function adminPage() {
    add_options_page('Word Count Settings', 'Word Count', 'manage_options', 'word-count-settings', array($this, 'wordCountHTML'));
  }
  function wordCountHTML() { ?>
    <div class="wrap">
      <h1>Word Count Settings</h1>
    </div>
  <?php }
}
$wordCount = new WordCount();