********************************
  Plugin use for site
********************************
1. Advanced Custom Fields
2. Members - Membership & User Role Editor Plugin
3. Regenerate Thumbnails


********************************
  Custom Post Type by plugin code
********************************
<?php
/*
  Plugin Name:  University Post Types
  Version:      1.0
  Author:       Chien Nguyen
*/
function university_post_types() {
  // event post type
  register_post_type('event', array(
    'capability_type' => 'event',
    'map_meta_cap' => true,
    'supports' => array('title', 'editor', 'excerpt'),
    'has_archive' => true,
    'rewrite' => array('slug' => 'events'),
    'public' => true,
    'show_in_rest' => true,
    'labels' => array(
      'name' => 'Events',
      'add_new_item' => 'Add New Event',
      'edit_item' => 'Edit Event',
      'all_items' => 'All Events',
      'singular_name' => 'Event'
    ),
    'menu_icon' => 'dashicons-calendar'
  ));
  
  // program post type
  register_post_type('program', array(
    'supports' => array('title'),
    'has_archive' => true,
    'rewrite' => array('slug' => 'programs'),
    'public' => true,
    'show_in_rest' => true,
    'labels' => array(
      'name' => 'Programs',
      'add_new_item' => 'Add New Program',
      'edit_item' => 'Edit Program',
      'all_items' => 'All Programs',
      'singular_name' => 'Program'
    ),
    'menu_icon' => 'dashicons-awards'
  ));
  
  // professor post type
  register_post_type('professor', array(
    'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
    'public' => true,
    'show_in_rest' => true,
    'labels' => array(
      'name' => 'Professors',
      'add_new_item' => 'Add New Professor',
      'edit_item' => 'Edit Professor',
      'all_items' => 'All Professors',
      'singular_name' => 'Professor'
    ),
    'menu_icon' => 'dashicons-welcome-learn-more'
  ));
  
  // campus post type
  register_post_type('campus', array(
    'capability_type' => 'campus',
    'map_meta_cap' => true,
    'supports' => array('title', 'editor', 'excerpt'),
    'has_archive' => true,
    'rewrite' => array('slug' => 'campuses'),
    'public' => true,
    'show_in_rest' => true,
    'labels' => array(
      'name' => 'Campuses',
      'add_new_item' => 'Add New Campus',
      'edit_item' => 'Edit Campus',
      'all_items' => 'All Campuses',
      'singular_name' => 'Campus'
    ),
    'menu_icon' => 'dashicons-location-alt'
  ));
  
  // note post type
  register_post_type('note', array(
    'capability_type' => 'note',
    'map_meta_cap' => true,
    'show_in_rest' => true,
    'supports' => array('title', 'editor'),
    'public' => true,
    // 'show_ui' => true,
    'labels' => array(
      'name' => 'Notes',
      'add_new_item' => 'Add New Note',
      'edit_item' => 'Edit Note',
      'all_items' => 'All Notes',
      'singular_name' => 'Note'
    ),
    'menu_icon' => 'dashicons-welcome-write-blog'
  ));

  // like post type
  register_post_type('like', array(
    'show_in_rest' => true,
    'supports' => array('title'),
    'public' => true,
    'labels' => array(
      'name' => 'Likes',
      'add_new_item' => 'Add New Like',
      'edit_item' => 'Edit Like',
      'all_items' => 'All Likes',
      'singular_name' => 'Like'
    ),
    'menu_icon' => 'dashicons-heart'
  ));
}
add_action('init', 'university_post_types');

********************************
  FIX for live reload / browser sync / browsersync
********************************

1. Install Browser Sync: npm install browser-sync


2. Install NPM Run All: npm install npm-run-all


3. Create a new file in the src folder called `browser-sync.config.js` with this code inside it:
module.exports = {
	proxy: "path-local-dev",
	notify: false,
	files: ["build/css/*.min.css", "build/js/*.min.js", "**/*.php"],
};

4. Then, open package.json and make sure your "scripts" section looks like this:
"scripts": {
    "watch-bs": "npm-run-all --parallel sync start",
    "build": "wp-scripts build",
    "start": "wp-scripts start",
    "sync": "browser-sync start --config src/browser-sync.config.js",
    "dev": "wp-scripts start",
    "devFast": "wp-scripts start",
    "test": "echo \"Error: no test specified\" && exit 1"
  },

5. Now, instead of running `npm run start` you will use `npm run watch-bs`