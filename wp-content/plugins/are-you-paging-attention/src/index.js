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
        <p><TextControl label='Question?' style={{fontSize: "20px"}} /></p>
        <p>Answer:</p>
        <Flex>
          <FlexBlock>
            <TextControl/>
          </FlexBlock>
          <FlexItem>
            <Button>
              <Icon icon="star-empty" className='mark-as-correct' />
            </Button>
          </FlexItem>
          <FlexItem>
            <Button isLink className='attention-delete'>Delete</Button>
          </FlexItem>
        </Flex>
        <p><Button isPrimary>Add another answer</Button></p>
      </div>
    );
  },
  save: function(props) {
    return null;
  }
});