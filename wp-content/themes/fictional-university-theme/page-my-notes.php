<?php get_header(); 
  pageBanner(array(
    'title' => 'My Notes',
    'subtitle' => 'It make me get better',
  ));
?>
  <div class="container container--narrow page-section">
    <div class="create-note">
      <h2 class="headline headline--medium">Create New Note</h2>
      <input type="text" class="new-note-title" placeholder="Title">
      <textarea class="new-note-body" placeholder="Your Note here..."></textarea>
      <span class="submit-note">Create Note</span>
      <span class="note-limit-message">You have reached your note limit (3 notes/user). Please delete one and add more!</span>
      <span class="note-limit-message note-unauthorized">You have <a href="<?php echo wp_login_url(); ?>">login</a> for note. If you haven't an account. Please <a href="<?php echo wp_registration_url(); ?>">register</a> here!</span>
    </div>
    <ul id="my-notes" class="min-list link-list">
      <?php 
        $myNotes = new WP_Query(array(
          'post_type' => 'note',
          'posts_per_page' => -1,
          'author' => get_current_user_id(),
        ));
        
        while($myNotes->have_posts()) {
          $myNotes->the_post();
      ?>
          <li data-id="<?php echo get_the_ID(); ?>">
            <input class="note-title-field" readonly type="text" value="<?php echo str_replace('Private: ','',esc_attr(get_the_title())); ?>">
            <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
            <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
            <textarea class="note-body-field" readonly><?php echo esc_textarea(get_the_content()); ?></textarea>
            <span class="update-note btn btn--blue btn--small"><i class="fa fa-save" aria-hidden="true"></i> Save</span>
          </li>
        <?php }
      ?>
    </ul>
  </div>
<?php get_footer(); ?>