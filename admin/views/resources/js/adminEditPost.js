/**
 * Created by Orel on 6/27/2017.
 */

var adminEditPost = {
    init: function() {
        this.showBtns       = $(".displayPostDialogBtn");
        this.deleteBtn      = $(".delete-post-btn");
        this.alertDialog    = $("#alert-modal");
        this.postIdField    = $("#postIdField");
        this.editPostErrors = $("#editPostErrors");

        this.bindEvent();

    },
    bindEvent: function() {
        /*--- Display Post Bind Event--- */
        $(this.showBtns).each(function () {
            $(this).on("click", function (e) {
                e.preventDefault();
                if($(this).attr("postId") != undefined){
                    // Get Post to display for report
                    adminEditPost.getPost($(this).attr("postId"));
                }else{
                    // Get Post to display for edit
                    adminEditPost.getPost(adminEditPost.postIdField.val());
                }
            })
        })
        displayPost.init();

        /*--- Delete Post Bind Event--- */
        $(this.deleteBtn).on('click',function () {
            if(!(adminEditPost.postIdField.val() == "")){
                adminEditPost.alertDialog.modal({
                    show: 'true'
                });
                var removeBtn = $("#confirmDeleteBtn");
                removeBtn.on('click',function () {
                    var $postId = adminEditPost.postIdField.val();
                    adminEditPost.alertDialog.modal('hide')
                    adminEditPost.deletePost($postId);
                })
            }
        })
    },

    deletePost: function ($postId) {
        var dataString  = "postId="+$postId;
        $.ajax({
            url: "./ajax/deletePostAjax.php",
            type: "POST",
            data: dataString,
            dataType: "json",
            success: function(callback){
                if(callback == true){
                    adminEditPost.editPostErrors.html("<div class=\"col-md-10 alert alert-success\" id=\"editPostErrors\">Post has been deleted</div>")
                }else{
                    adminEditPost.editPostErrors.html("<div class=\"col-md-10 alert alert-danger\" id=\"editPostErrors\">"+callback.errors+"</div>")
                }


            }
        });
    },


    getPost: function($postId) {
        var postId = $postId;
        var dataString = "id="+postId;
        $.ajax({
            url: "../ajax/getPostAjax.php",
            type: "GET",
            data: dataString,
            dataType: "json",
            success: function(callback){
                console.log("callback = "+ callback);
                displayPost.buildPostDialog(callback , true);
            }
        });
    }
}