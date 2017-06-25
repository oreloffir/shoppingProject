/**
 * Created by Guy on 6/20/2017.
 */
var displayPost = {
    init: function (){
        this.postButtons        = $(".postDialog");
        this.postDialog         = $("#displayPostModal");
        this.postDisplayName    = $("#postDialogDisplayName");
        this.postDialogTimeAgo  = $("#postDialogTimeAgo");
        this.postTitle          = $("#postDialogTitle");
        this.postDescription    = $("#postDialogDescription");
        this.postFavBtn         = $("#favoriteBtn");
        this.postComments       = $("#postDialogComments");
        this.postSaleUrl        = $("#postDialogUrl");
        this.postCoupn          = $("#postDialogCouponCode");
        this.postErrors         = $("#postDialogErrors");
        this.addCommentBtn      = $("#addCommentBtn");
        this.commentTA          = $("#postDialogCommentsTA");
        this.editPostBtn 	    = $("#editPostBtn");
        this.postRankArea 	    = $("#postRank");
        this.stars 			    = $(".ranking");
        this.postRankCount 	    = $("#postRankingAmount");
        this.bindEvent();
    },
    bindEvent: function (){
       $(this.postButtons).each(function (){
            $(this).on("click", displayPost.getPost);
       });
        this.addCommentBtn.on("touchstart click", this.addComment);
        this.postFavBtn.on('touchstart click', this.addToFavorites);

        $(this.stars).each(function(){
            $(this).mouseenter(displayPost.goldenStars);
            $(this).on("touchstart click", displayPost.rankPost);
        });
        $(this.postRankArea).mouseleave(this.setStars);
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
                displayPost.postDisplayName.attr("href", "profile.php?id="+callback.publisherId);
                displayPost.postDialogTimeAgo.html(callback.time);
                displayPost.postTitle.html("<a href=\"index.php?category="+callback.category+"\">"+callback.categoryName+"</a> \\ "+callback.title);
                displayPost.postDescription.html(callback.description);
                displayPost.postDialog.attr("postId", callback['id']);
                if(callback.editPost){
                    displayPost.editPostBtn.attr("href", "editPost.php?postId="+callback['id']);
                    displayPost.editPostBtn.show();
                }else{
                    displayPost.editPostBtn.hide();
                }
                if(callback.favorite) {
                    displayPost.postFavBtn.removeClass("btn-gray");
                }else{
                    if(!displayPost.postFavBtn.hasClass("btn-gray"))
                        displayPost.postFavBtn.addClass("btn-gray");
                }
                displayPost.postComments.html("");
                $(callback.comments).each(function (){
                    displayPost.postComments.append("<div class=\"row post-dialog-comment\"><div class=\"post-dialog-comment-user col-md-2\"><div><a href=\"#\">"+this.displayName+"</a></div><div class=\"post-dialog-comment-time\"\">"+this.time+"</div></div><div class=\"post-dialog-comment-body col-md-10\">"+this.body+"</div></div>");
                });
                displayPost.postSaleUrl.attr("href", callback.saleUrl);
                if(callback.couponCode)
                    displayPost.postCoupn.html("<code>Coupon: "+callback.couponCode+"</code>")
                else
                    displayPost.postCoupn.html("");
                displayPost.postErrors.html("");
                var postRank = Math.round(callback.rank);
                displayPost.postRankArea.attr("postrank",postRank);
                displayPost.setStars(postRank);
                displayPost.postRankCount.html(callback.rankCount);
                displayPost.postDialog.modal('show');
                console.log(callback);
            }
        });
    },
    addComment: function (e) {
        console.log("click on comment");
        e.preventDefault();
        var postId      = displayPost.postDialog.attr("postId");
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
                    displayPost.postComments.prepend("<div class=\"row post-dialog-comment\"><div class=\"post-dialog-comment-user col-md-3\"><div><a href=\"#\">"+callback.displayName+"</a></div><div class=\"post-dialog-comment-time\"\">less then a minute</div></div><div class=\"post-dialog-comment-body col-md-9\">"+callback.body+"</div></div>");
                    displayPost.commentTA.val("");
                }
            }
        });
    },
    addToFavorites : function () {
        var postId = displayPost.postDialog.attr("postId");
        console.log("In addToFavorites function with postId="+postId+"\n");
        var dataString = "postid="+postId;
        $.ajax({
            url: "./ajax/addFavoriteAjax.php",
            type: "POST",
            data: dataString,
            dataType: "json",
            success: function (callback){
                var errors = callback.errors;
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
    goldenStars: function(){
        var starIndex = $(displayPost.stars).index(this);
        displayPost.setStars(starIndex);
    },
    setStars: function(numberOfStars){
        if(!$.isNumeric(numberOfStars))
            numberOfStars = displayPost.postRankArea.attr('postrank');
        for(var i = 0; i < 5; i++){
            if(i > numberOfStars-1)
                $(displayPost.stars.get(i)).removeClass("gold");
            else
                $(displayPost.stars.get(i)).addClass("gold");
        }
    },
    rankPost: function(){
        var postId 		= displayPost.postDialog.attr("postId");
        var rank 		= $(displayPost.stars).index(this) + 1;
        var dataString 	= "postid="+postId+"&postrank="+rank;
        $.ajax({
            url: "./ajax/rankPostAjax.php",
            type: "POST",
            data: dataString,
            dataType: "json",
            success: function (callback){
                var errors = callback.errors;
                if (typeof errors !== typeof undefined && errors !== false) {
                    displayPost.displayErrors(errors);
                }else{
                    displayPost.postRankArea.attr("postrank", Math.round(callback.rank));
                    displayPost.setStars(Math.round(callback.rank));
                    if(callback.increaseRankCount)
                        displayPost.postRankCount.html(parseInt(displayPost.postRankCount.html())+1);
                }
            }
        });
    },
    displayErrors: function (errors) {
        displayPost.postErrors.html("");
        $(errors).each(function () {
            displayPost.postErrors.append("<div class=\"alert alert-danger text-align-left\">"+this+"</div>")
        });
    }
}