wp.blocks.registerBlockType('ourplugin/are-you-paging-attention', {
  title: 'Are you paging attention?',
  icon: 'smiley',
  category: 'common',
  edit: function() {
    return (
      <div className="wrap">
        <h4>This is a h4 tag</h4>
        <p>This is a text form JSX</p>
      </div>
    );
  },
  save: function() {
    return (
      <div className="wrap">
        <h2>h2 form frontend</h2>
        <h3>h3 form frontend</h3>
      </div>
    )
  },
});