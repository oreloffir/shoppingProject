/**
 * Created by Orel on 6/27/2017.
 */

var adminShowPost = {
    init: function() {
        this.showBtns = $(".displayPostDialogBtn");
        this.postIdField = $("#postIdField");
            // Post dialog static display
        this.bindEvent();
    },
    bindEvent: function() {
        $(this.showBtns).each(function () {
            $(this).on("click", function (e) {
                e.preventDefault();
                if($(this).attr("postId") != undefined){
                    adminShowPost.getPost($(this).attr("postId"));
                }else{
                    adminShowPost.getPost(adminShowPost.postIdField.val());
                }
            })
        })
        displayPost.init();
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