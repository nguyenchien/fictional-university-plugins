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
    add_menu_page('Our Word Filter', 'Our Word Filter', 'manage_options', 'ourWordFilterPage', array($this, 'ourWordFilterHTML'), 'dashicons-smiley', 100);
    add_submenu_page('ourWordFilterPage', 'Word List', 'Word List', 'manage_options', 'ourWordFilterPage', array($this, 'ourWordFilterHTML'));
    add_submenu_page('ourWordFilterPage', 'Word Filter Options', 'Options', 'manage_options', 'word-filter-options', array($this, 'optionsSubPage'));
  }
  function ourWordFilterHTML() { ?>
    <p>hello 123</p>
  <? }
  function optionsSubPage() { ?>
    <p>hello options</p>
  <? }
}
$ourWordFilterPlugin = new ourWordFilterPlugin();