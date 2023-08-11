import React from 'react';
import ReactDOM from 'react-dom';
import "./frontend.scss";

const divsToUpdate = document.querySelectorAll('.paying-attention-update-me');
divsToUpdate.forEach(function(item){
  const data = JSON.parse(item.querySelector('pre').innerHTML);
  ReactDOM.render(<Quiz {...data} />, item);
  item.classList.remove('paying-attention-update-me');
});

function Quiz(props) {
  console.log(props);
  return (
    <div className="paying-attention-frontend">
      <p>{props.question}</p>
      <ul>
        {props.answer.map((item)=>{
          return (
            <li>{item}</li>
          )
        })}
      </ul>
    </div>
  )
}