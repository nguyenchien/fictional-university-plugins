import "./index.scss"

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
  return (
    <div className="featured-professor-wrapper">
      <div className="professor-select-container">
        <select onChange={(e)=>{props.setAttributes({professorID: e.target.value})}}>
          <option value="">Select a option</option>
          <option value="1" selected={props.attributes.professorID == 1}>professor 1</option>
          <option value="2" selected={props.attributes.professorID == 2}>professor 2</option>
          <option value="3" selected={props.attributes.professorID == 3}>professor 3</option>
        </select>
      </div>
      <div>
        The HTML preview of the selected professor will appear here.
      </div>
    </div>
  )
}