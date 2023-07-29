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
    add_action('admin_init', array($this, 'ourSettings'));
    if (get_option('plugin_words_to_filter')) {
      add_filter('the_content', array($this, 'filterLogic'));
    }
  }
  function ourSettings() {
    add_settings_section('replacement-text-section', null, null, 'word-filter-options');
    register_setting('replacementFields', 'replacementText');
    add_settings_field('replacement-text', 'Filtered Text', array($this, 'replacementFieldsdHTML'), 'word-filter-options', 'replacement-text-section');
  }
  function replacementfieldsdHTML() { ?>
    <input type="text" name="replacementText" value="<?php echo esc_attr(get_option('replacementText', '***')); ?>">
    <p class="description">Leave blank to simple remove the filtered words.</p>
  <?php }
  function filterLogic($content) {
    $badWords = explode(',', get_option('plugin_words_to_filter'));
    $badWordsTrimmed = array_map('trim', $badWords);
    return str_ireplace($badWordsTrimmed, esc_html(get_option('replacementText', '***')), $content);
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
  function handleSubmitForm() {
    if (wp_verify_nonce($_POST['ourNonce'], 'saveFilterWords') && current_user_can('manage_options')) {
      update_option('plugin_words_to_filter', sanitize_text_field($_POST['plugin_words_to_filter'])); ?>
      <div class="updated">
        <p>Your filtered words were saved.</p>
      </div>  
    <?php } else { ?>
      <div class="error">
        <p>Sorry, You do not have permisson to perform this action.</p>
      </div>
    <?php }
    
  }
  function ourWordFilterHTML() { ?>
    <div class="wrap">
      <h1>Word Filter</h1>
      <?php if (isset($_POST['justsubmitted']) && $_POST['justsubmitted'] == "true") $this->handleSubmitForm(); ?>
      <form method="POST">
        <input type="hidden" name="justsubmitted" value="true">
        <?php wp_nonce_field('saveFilterWords', 'ourNonce'); ?>
        <label for="plugin_words_to_filter">
          <p>Enter a <strong>momma-separated</strong> list of words to filter from your site content.</p>
          <div class="word-filter__flex-container">
            <textarea name="plugin_words_to_filter" id="plugin_words_to_filter" placeholder="bad, mean, abc, xyz"><?php echo esc_textarea(get_option('plugin_words_to_filter')); ?></textarea>
          </div>
          <input type="submit" name="submit" class="button button-primary" value="Save Changes">
        </label>
      </form>
    </div>
  <?php }
  function optionsSubPage() { ?>
    <div class="wrap">
      <h1>Words Filter Options</h1>
      <form action="options.php" method="post">
        <?php 
          settings_errors();
          settings_fields('replacementFields');
          do_settings_sections('word-filter-options');
          submit_button(); 
        ?>
      </form>
    </div>
  <?php }
}
$ourWordFilterPlugin = new ourWordFilterPlugin();