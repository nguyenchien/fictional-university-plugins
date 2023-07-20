import $ from 'jquery';

class Like {
  // constructor
  constructor() {
    this.events();
  }
  
  // events
  events () {
    $(".like-box").on("click", this.ourClickDispatcher.bind(this));
  }

  // methods
  ourClickDispatcher(e) {
    var currentLikeBox = $(e.target).closest(".like-box");
    if (currentLikeBox.attr("data-exists") == "yes") {
      this.deleteLike(currentLikeBox);
    } else {
      this.createLike(currentLikeBox);
    }
  }

  createLike(currentLikeBox) {
    let professor_id = currentLikeBox.attr("data-professor");
    $.ajax({
      beforeSend: function (xhr) {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.root_url + '/wp-json/university/v1/manageLike',
      method: 'POST',
      data: {
        "professor_id": professor_id
      },
      success: (response) => {
        console.log(response);
        let likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10);
        likeCount++;
        currentLikeBox.find(".like-count").html(likeCount);
        currentLikeBox.attr("data-exists", "yes");
        currentLikeBox.attr("data-like", response);
      },
      error: (response) => {
        console.log(response);
      },
    })
  }

  deleteLike(currentLikeBox) {
    let like_id = currentLikeBox.attr("data-like");
    $.ajax({
      beforeSend: function (xhr) {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.root_url + '/wp-json/university/v1/manageLike',
      method: 'DELETE',
      data: {
        "like_id": like_id
      },
      success: (response) => {
        console.log(response);
        let likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10);
        likeCount--;
        currentLikeBox.find(".like-count").html(likeCount);
        currentLikeBox.attr("data-exists", "no");
        currentLikeBox.attr("data-like", "");
      },
      error: (response) => {
        console.log(response);
      },
    })
  }
}

export default Like