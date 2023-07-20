import $ from "jquery";

class MyNotes {
  /* constructor
  ====================================================*/
  constructor() {
    this.events();
  }
  
  /* events
  ====================================================*/
  events() {
    $("#myNotes").on("click", ".delete-note", this.deleteNote);
    $("#myNotes").on("click", ".edit-note", this.editNote.bind(this));
    $("#myNotes").on("click", ".update-note", this.updateNote.bind(this));
    $(".submit-note").on("click", this.createNote.bind(this));
  }
  
  /* methods
  ====================================================*/
  // edit note
  editNote(e) {
    var thisNote = $(e.target).parents('li');
    if (thisNote.data("state") == 'editable') {
      this.makeNoteReadOnly(thisNote);
    } else {
      this.makeNoteEditable(thisNote);
    }
  }
  makeNoteEditable(thisNote) {
    thisNote.find(".edit-note").html('<i class="fa fa-close""></i> Cancel');
    thisNote.find(".note-title-field, .note-body-field").removeAttr('readonly').addClass("note-active-field");
    thisNote.find(".update-note").addClass("update-note--visible");
    thisNote.data("state", "editable");
  }
  makeNoteReadOnly(thisNote) {
    thisNote.find(".edit-note").html('<i class="fa fa-pencil""></i> Edit');
    thisNote.find(".note-title-field, .note-body-field").attr('readonly', 'readonly').removeClass("note-active-field");
    thisNote.find(".update-note").removeClass("update-note--visible");
    thisNote.data("state", "cancel");
  }
  
  // create note
  createNote(e) {
    var createNoteData = {
      'title': $(".new-note-title").val(),
      'content': $(".new-note-body").val(),
      'status': 'publish',
    };
    if ($(".new-note-title").val() === "" || $(".new-note-body").val() === "") {
      alert("Please enter a title or body of your new note!");
      return false;
    };
    $.ajax({
      beforeSend: function (xhr) {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.root_url + '/wp-json/wp/v2/note/',
      method: 'POST',
      data: createNoteData,
      success: (response) => {
        $(".new-note-title, .new-note-body").val('');
        $(".new-note-title").focus();
        $(`
          <li data-id="${response.id}">
            <input class="note-title-field" readonly type="text" value="${response.title.raw}">
            <span class="edit-note"><i class="fa fa-pencil"></i> Edit</span>
            <span class="delete-note"><i class="fa fa-trash-o"></i> Delete</span>
            <textarea class="note-body-field" readonly>${response.content.raw}</textarea>
            <span class="update-note btn btn--blue btn--small"><i class="fa fa-save"></i> Save</span>
          </li>
        `).prependTo("#myNotes").hide().slideDown();
        console.log('success');
        console.log(response);
      },
      error: (response) => {
        console.log('error');
        console.log(response);
        let respondText = response.responseText.replace('\n  ', '');
        if (respondText == 'You have reached your note limit.') {
          $(".note-limit-message").addClass('active');
        }
      }
    });
  }
  
  // update note
  updateNote(e) {
    var thisNote = $(e.target).parents('li');
    var updateNoteData = {
      'title': thisNote.find(".note-title-field").val(),
      'content': thisNote.find(".note-body-field").val(),
    };
    $.ajax({
      beforeSend: function (xhr) {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
      method: 'POST',
      data: updateNoteData,
      success: (response) => {
        this.makeNoteReadOnly(thisNote);
        console.log('success');
        console.log(response);
      },
      error: (response) => {
        console.log('error');
        console.log(response);
      }
    })
  }
  
  // delete note
  deleteNote(e) {
    var thisNote = $(e.target).parents('li');
    $.ajax({
      beforeSend: function (xhr) {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
      method: 'DELETE',
      success: (response) => {
        thisNote.slideUp();
        console.log('success');
        console.log(response);
        if (response.userNoteCount < 4) {
          $(".note-limit-message").removeClass('active');
        }
      },
      error: (response) => {
        console.log('error');
        console.log(response);
      }
    })
  }
}

export default MyNotes;