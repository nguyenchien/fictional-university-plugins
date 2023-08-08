wp.blocks.registerBlockType('ourplugin/are-you-paging-attention', {
  title: 'Are you paging attention?',
  icon: 'smiley',
  category: 'common',
  attributes: {
    skyColor: {type: "string"},
    glassColor: {type: "string"},
  },
  edit: function(props) {
    function updateSkyColor(event) {
      props.setAttributes({skyColor: event.target.value});
    }
    function updateGlassColor(event) {
      props.setAttributes({glassColor: event.target.value});
    }
    return (
      <div>
        <input type="text" placeholder="sky color" value={props.attributes.skyColor} onChange={updateSkyColor} />
        <input type="text" placeholder="glass color" value={props.attributes.glassColor} onChange={updateGlassColor} />
      </div>
    );
  },
  save: function(props) {
    return null;
  }
});