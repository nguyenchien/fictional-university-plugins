import "./index.scss"
import {useSelect} from "@wordpress/data"

wp.blocks.registerBlockType("ourplugin/featured-professor", {
  title: "Professor Callout",
  description: "Include a short description and link to a professor of your choice",
  icon: "welcome-learn-more",
  category: "common",
  attributes: {
    professorID: {type: "string"}
  },
  edit: EditComponent,
  save: function () {
    return null
  }
})

function EditComponent(props) {
  // get all professor
  const allProfessor = useSelect(select => {
    return select("core").getEntityRecords("postType", "professor", {per_page: -1});
  });
  console.log(props);
  
  if (allProfessor == undefined) return <p>loading...</p>;
  
  return (
    <div className="featured-professor-wrapper">
      <div className="professor-select-container">
        <select onChange={e => {props.setAttributes({professorID: e.target.value})}}>
          <option value="">Select a option</option>
          {allProfessor && allProfessor.map(professor => {
            return <option value={professor.id} selected={props.attributes.professorID==professor.id}>{professor.title.rendered}</option>
          })}
        </select>
      </div>
      <div>
        The HTML preview of the selected professor will appear here.
      </div>
    </div>
  )
}