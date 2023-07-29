wp.blocks.registerBlockType('ourplugin/are-you-paging-attention', {
  title: 'Are you paging attention?',
  icon: 'smiley',
  category: 'common',
  edit: function() {
    return wp.element.createElement("h2", null, "This is from admin screen");
  },
  save: function() {
    return wp.element.createElement("h2", null, "This is from frontend screen");
  },
});