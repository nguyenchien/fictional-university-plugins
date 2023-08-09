import './index.scss';
import {TextControl, Flex, FlexBlock, FlexItem, Button, Icon} from "@wordpress/components";
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
      <div className="paying-attention-edit-block">
        <TextControl label='Question?' />
        <p>Answer:</p>
        <Flex>
          <FlexBlock>
            <TextControl/>
          </FlexBlock>
          <FlexItem>
            <Button>
              <Icon icon="star-empty" />
            </Button>
          </FlexItem>
          <FlexItem>
            <Button>Delete</Button>
          </FlexItem>
        </Flex>
      </div>
    );
  },
  save: function(props) {
    return null;
  }
});