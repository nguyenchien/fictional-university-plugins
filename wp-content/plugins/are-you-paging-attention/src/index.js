import './index.scss';
import {TextControl, Flex, FlexBlock, FlexItem, Button, Icon} from "@wordpress/components";
wp.blocks.registerBlockType('ourplugin/are-you-paging-attention', {
  title: 'Are you paging attention?',
  icon: 'smiley',
  category: 'common',
  attributes: {
    question: {type: "string"},
    answer: {type: "array", default: ["red", "green", "yellow"]},
  },
  edit: function(props) {
    function updateQuestion(value) {
      props.setAttributes({question: value});
    }
    return (
      <div className="paying-attention-edit-block">
        <p><TextControl
            label='Question?'
            style={{fontSize: "20px"}}
            value={props.attributes.question}
            onChange={updateQuestion}
          /></p>
        <p>Answer:</p>
        {props.attributes.answer.map((answer, index)=>{
            function changeAnswer(newValue) {
              const newAnswer = props.attributes.answer.concat([]);
              newAnswer[index] = newValue;
              props.setAttributes({answer: newAnswer});
            }
            return (
              <Flex>
                <FlexBlock>
                  <TextControl value={answer} onChange={changeAnswer} />
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
            )
        })}
        <p><Button isPrimary>Add another answer</Button></p>
      </div>
    );
  },
  save: function(props) {
    return null;
  }
});