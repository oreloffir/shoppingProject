/**
 * Created by Guy on 6/20/2017.
 */
var displayPost = {
    init: function (){
        this.postButtons        = $(".postDialog");
        this.postDialog         = $("#displayPostModal");
        this.postDisplayName    = $("#postDialogDisplayName");
        this.postTitle          = $("#postDialogTitle");
        this.postDescription    = $("#postDialogDescription");
        this.postFavBtn         = $("#favoriteBtn");
        this.postComments       = $("#postDialogComments");
        this.postSaleUrl        = $("#postDialogUrl");
        this.postCoupn          = $("#postDialogCouponCode");
        this.postErrors         = $("#postDialogErrors");
        this.addCommentBtn      = $("#addCommentBtn");
        this.commentTA          = $("#postDialogCommentsTA");
        this.bindEvent();
    },
    bindEvent: function (){
       $(this.postButtons).each(function (){
            $(this).on("click", displayPost.getPost);
       });
        this.addCommentBtn.on("touchstart click", this.addComment);
        this.postFavBtn.on('touchstart click', this.addToFavorites);
    },
    getPost: function(e) {
        e.preventDefault();
        var postId = $(this).attr("postId");
        var dataString = "id="+postId;
        $.ajax({
            url: "./ajax/getPostAjax.php",
            type: "GET",
            data: dataString,
            dataType: "json",
            success: function(callback){
                displayPost.postDisplayName.html(callback.displayName);
                displayPost.postTitle.html("<a href=\"index.php?category="+callback.category+"\">"+callback.categoryName+"</a> \\ "+callback.title);
                displayPost.postDescription.html(callback.description);
                displayPost.addCommentBtn.attr("postId", callback['id']);
                displayPost.postFavBtn.attr("postId", callback['id']);
                if(callback.favorite) {
                    displayPost.postFavBtn.removeClass("btn-gray");
                }else{
                    if(!displayPost.postFavBtn.hasClass("btn-gray"))
                        displayPost.postFavBtn.addClass("btn-gray");
                }
                displayPost.postComments.html("");
                $(callback.comments).each(function (){
                    displayPost.postComments.append("<div class=\"row border-bottom-grey\"><div class=\"post-dialog-comment-user col-md-3\"><div><a href=\"#\">"+this.displayName+"</a></div><div class=\"post-dialog-comment-time\"\">"+this.time+"</div></div><div class=\"post-dialog-comment-body col-md-9\">"+this.body+"</div></div>");
                });
                displayPost.postSaleUrl.attr("href", callback.saleUrl);
                if(callback.couponCode)
                    displayPost.postCoupn.html("<code>Coupon: "+callback.couponCode+"</code>")
                else
                    displayPost.postCoupn.html("");
                displayPost.postErrors.html("");
                displayPost.postDialog.modal('show');
                console.log(callback);
            }
        });
    },
    addComment: function (e) {
        console.log("click on comment");
        e.preventDefault();
        var postId      = $(this).attr("postId");
        var commentBody = displayPost.commentTA.val();
        var dataString  = "postid="+postId+"&commentbody="+commentBody;
        $.ajax({
            url: "./ajax/addCommentAjax.php",
            type: "POST",
            data: dataString,
            dataType: "json",
            success: function (callback){
                var errors = callback.errors;
                console.log(errors);
                if (typeof errors !== typeof undefined && errors !== false) {
                    displayPost.displayErrors(errors);
                }else{
                    displayPost.postComments.prepend("<div class=\"row border-bottom-grey\"><div class=\"post-dialog-comment-user col-md-3\"><div><a href=\"#\">"+callback.displayName+"</a></div><div class=\"post-dialog-comment-time\"\">less then a minute</div></div><div class=\"post-dialog-comment-body col-md-9\">"+callback.body+"</div></div>");
                    displayPost.commentTA.val("");
                }
            }
        });
    },
    addToFavorites : function () {
        var postId = $(this).attr("postId");
        console.log("In addToFavorites function with postId="+postId+"\n");
        var dataString = "id="+postId;
        $.ajax({
            url: "./ajax/addFavoriteAjax.php",
            type: "POST",
            data: dataString,
            dataType: "json",
            success: function (callback){
                var errors = callback.errors;
                console.log(errors);
                if (typeof errors !== typeof undefined && errors !== false) {
                    displayPost.displayErrors(errors);
                }else{
                    if (callback) {
                        if (displayPost.postFavBtn.hasClass("btn-gray")) {
                            displayPost.postFavBtn.removeClass("btn-gray");
                        }else
                            displayPost.postFavBtn.addClass("btn-gray");
                    } else {
                        displayPost.postErrors.html("<div class=\"alert alert-danger text-align-left\">" + "Database Error" + "</div>");
                    }
                }
            }
        });
    },
    displayErrors: function (errors) {
        var errorsString = "";
        $(errors).each(function () {
            errorsString += this;
        });
        displayPost.postErrors.html("<div class=\"alert alert-danger text-align-left\">"+errorsString+"</div>");
    }
}