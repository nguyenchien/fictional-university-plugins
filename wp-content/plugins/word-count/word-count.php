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
    add_action('admin_init', array($this, 'settings'));
  }
  function settings() {
    add_settings_section( 'wcp_first_section', null, null, 'word-count-settings-page' );

    // Display Location
    add_settings_field( 'wcp_location', 'Display Location', array($this, 'locationHTML'), 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_location', array('sanitize_callback'=>'sanitize_text_field', 'default'=>'0'));

    // Headline Text
    add_settings_field( 'wcp_headline', 'Headline Text', array($this, 'headlineHTML'), 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_headline', array('sanitize_callback'=>'sanitize_text_field', 'default'=>'Headline Text'));

    // Word Count
    add_settings_field( 'wcp_wordcount', 'Word Count', array($this, 'wordcountHTML'), 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_wordcount', array('sanitize_callback'=>'sanitize_text_field', 'default'=>'1'));
  }

  function wordcountHTML() { ?>
    <input type="checkbox" name="wcp_wordcount" value="1" <?php checked(get_option('wcp_wordcount'), '1'); ?>>
  <?php }

  function headlineHTML() { ?>
    <input type="text" name="wcp_headline" value="<?php echo get_option('wcp_headline'); ?>">
  <?php }

  function locationHTML() { ?>
    <select name="wcp_location">
      <option value="0" <?php selected(get_option('wcp_location'), '0'); ?>>Beginning of post</option>
      <option value="1" <?php selected(get_option('wcp_location'), '1'); ?>>End of post</option>
    </select>
  <?php }
  function adminPage() {
    add_options_page('Word Count Settings', 'Word Count', 'manage_options', 'word-count-settings-page', array($this, 'ourHTML'));
  }
  function ourHTML() { ?>
    <div class="wrap">
      <h1>Word Count Settings</h1>
      <form action="options.php" method="post">
        <?php
          settings_fields('wordcountplugin');
          do_settings_sections('word-count-settings-page');
          submit_button();
        ?>
      </form>
    </div>
  <?php }
}
$wordCount = new WordCount();