import './index.scss';
import {TextControl, Flex, FlexBlock, FlexItem, Button, Icon} from "@wordpress/components";

// check start function save post
function ourStartFunction() {
  let locked = false;

  wp.data.subscribe(function() {
    const results = wp.data.select("core/block-editor").getBlocks().filter(function(block) {
      return block.name == "ourplugin/are-you-paging-attention" && block.correctAnswer == undefined;
    });

    if (results.length && locked == false) {
      locked = true;
      wp.data.dispatch("core/editor").lockPostSaving("noanswer");
    }

    if (!results.length && locked) {
      locked = false;
      wp.data.dispatch("core/editor").unlockPostSaving("noanswer");
    }
  })
}
// ourStartFunction();

wp.blocks.registerBlockType('ourplugin/are-you-paging-attention', {
  title: 'Are you paging attention?',
  icon: 'smiley',
  category: 'common',
  attributes: {
    question: {type: "string"},
    answer: {type: "array", default: ["red", "green"]},
    correctAnswer: {type: "number", default: undefined},
  },
  edit: EditComponent,
  save: function() {
    return null;
  },
});

// Edit Component
function EditComponent(props) {
  function updateQuestion(value) {
    props.setAttributes({question: value});
  }
  // add answer
  function addAnswer() {
    props.setAttributes({answer: props.attributes.answer.concat([""])});
  }

  // delete answer
  function deleteAnswer(indexToDelete) {
    const newAnswer = props.attributes.answer.filter((item, index)=>{
      return index != indexToDelete;
    });
    props.setAttributes({answer: newAnswer}); 

    if (indexToDelete == props.attributes.correctAnswer) {
      props.setAttributes({correctAnswer: undefined});
    }
  }

  // mark answer correct
  function markAnsCorrect(index) {
    props.setAttributes({correctAnswer: index});
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
      {props.attributes.answer.map((item, index)=>{

          // change answer
          function changeAnswer(newValue) {
            const newAnswer = props.attributes.answer.concat([]);
            newAnswer[index] = newValue;
            props.setAttributes({answer: newAnswer});
          }

          return (
            <Flex>
              <FlexBlock>
                <TextControl 
                  value={item} 
                  onChange={changeAnswer}
                  autoFocus={true}
                />
              </FlexBlock>
              <FlexItem>
                <Button onClick={() => markAnsCorrect(index)}>
                  <Icon 
                    icon={index == props.attributes.correctAnswer ? 'star-filled' : 'star-empty'}
                    className='mark-as-correct'
                  />
                </Button>
              </FlexItem>
              <FlexItem>
                <Button 
                  isLink 
                  className='attention-delete'
                  onClick={()=>deleteAnswer(index)}
                >Delete</Button>
              </FlexItem>
            </Flex>
          )
      })}
      <p><Button 
          isPrimary
          onClick={addAnswer}
        >Add another answer</Button></p>
    </div>
  );
}