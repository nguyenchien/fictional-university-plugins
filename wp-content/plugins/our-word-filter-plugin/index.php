<?php
/*
  Plugin Name: Our Word Filter Plugin
  Description: Filter words in the content
  Author: Chien Nguyen
  Version: 1.0
*/
if (!defined('ABSPATH')) exit;
class ourWordFilterPlugin {
  function __construct() {
    add_action('admin_menu', array($this, 'ourMenu'));
  }
  function ourMenu() {
    $mainPageHook = add_menu_page('Our Word Filter', 'Our Word Filter', 'manage_options', 'ourWordFilterPage', array($this, 'ourWordFilterHTML'), plugin_dir_url(__FILE__).'custom.svg', 100);
    add_submenu_page('ourWordFilterPage', 'Word List', 'Word List', 'manage_options', 'ourWordFilterPage', array($this, 'ourWordFilterHTML'));
    add_submenu_page('ourWordFilterPage', 'Word Filter Options', 'Options', 'manage_options', 'word-filter-options', array($this, 'optionsSubPage'));
    add_action("load-{$mainPageHook}", array($this, 'mainPageAssess'));
  }
  function mainPageAssess() {
    wp_enqueue_style('filterAdminCss', plugin_dir_url( __FILE__).'style.css');
  }
  function handleSubmit() {
    echo 'hello 123';
  }
  function ourWordFilterHTML() { ?>
    <div class="wrap">
      <h1>Word Filter</h1>
      <?php if (isset($_POST['justsubmitted']) && $_POST['justsubmitted'] == "true") $this->handleSubmit(); ?>
      <form method="POST">
        <input type="hidden" name="justsubmitted" value="true">
        <label for="plugin_words_to_filter">
          <p>Enter a <strong>momma-separated</strong> list of words to filter from your site content.</p>
          <div class="word-filter__flex-container">
            <textarea name="plugin_words_to_filter" id="plugin_words_to_filter" placeholder="bad, mean, abc, xyz"></textarea>
          </div>
          <input type="submit" name="submit" class="button button-primary" value="Save Changes">
        </label>
      </form>
    </div>
  <?php }
  function optionsSubPage() { ?>
    <p>hello options</p>
  <?php }
}
$ourWordFilterPlugin = new ourWordFilterPlugin();