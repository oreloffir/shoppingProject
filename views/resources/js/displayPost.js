/**
 * Created by Guy on 6/20/2017.
 */
var displayPost = {
    /*
    * Display Post responsible for all UI functionality.
    * - Display Post Dialog and dialog functionality.
    * - Load more while scrolling.
    * - Show description preview
    * */
    init: function (){
        // External functionality
            // class .postDialog objects on click will show post dialog MUST HAVE postId attribute
        this.postButtons        = $(".postDialog");
            // Show description preview
        this.postMini           = $(".post-mini");
            // load more variables
        this.loadRequest                = false;
                // loadMoreInfo MUST HAVE attributes: pageNumber, postsOrder, category.
        this.loadMoreInfo               = $("#loadMoreInfo");
                // The container to append the loaded posts
        this.postsDisplayContainer      = $("#postsDisplayContainer");

        // Post dialog static display
        this.postDialog         = $("#displayPostModal");       // MUST HAVE postId attribute
        this.postDisplayName    = $("#postDialogDisplayName");
        this.postDialogTimeAgo  = $("#postDialogTimeAgo");
        this.postTitle          = $("#postDialogTitle");
        this.postDescription    = $("#postDialogDescription");
        this.postDialogImage    = $("#postDialogImage");
        this.postSaleUrl        = $("#postDialogUrl");
        this.postCoupn          = $("#postDialogCouponCode");
        this.postErrors         = $("#postDialogErrors");
        this.editPostBtn 	    = $("#editPostBtn");
        this.postDialogPrice    = $("#postDialogPrice");

        // Post dialog comments functionality
        this.addCommentBtn      = $("#addCommentBtn");
        this.commentTA          = $("#postDialogCommentsTA");
        this.postComments       = $("#postDialogComments");
        // Post dialog favorite functionality
        this.postFavBtn         = $("#favoriteBtn");

        // Post dialog Ranking functionality
        this.postRankArea 	    = $("#postRank");
        this.stars 			    = $(".ranking");
        this.postRankCount 	    = $("#postRankingAmount");

        if(!this.postDialogBind)
            this.postDialogBind = false;
        this.bindEvent();
    },
    /*
    * Bind events
    * */
    bindEvent: function (){
        // description preview
        $(this.postMini).each(function () {
            var des     = $(this).children(".post-mini-main").children(".post-mini-img-des");
            var price   = $(this).children(".post-mini-main").children(".post-mini-img-price");
            des.hide();

            $(this).off('mouseenter').mouseenter(function () {
                des.show();
                price.css("bottom", des.height()+10);
            }).off('mouseleave').mouseleave(function () {
                des.hide();
                price.css("bottom", 0);
            });
        });

        // open post dialog open buttons
        $(this.postButtons).each(function (){
            $(this).off('click').on("click", displayPost.getPost);
        });

        // This part have to bind events only once!
        // this.postDialogBind = false; at init()
        // after binding event this.postDialogBind will set to true
        if(!this.postDialogBind) {
            // add comment listener
            this.addCommentBtn.on("touchstart click", this.addComment);
            // add to favorite listener
            this.postFavBtn.on('touchstart click', this.addToFavorites);
            // rank post listener
            $(this.stars).each(function () {
                $(this).mouseenter(displayPost.goldenStars);
                $(this).on("touchstart click", displayPost.rankPost);
            });
            $(this.postRankArea).mouseleave(this.setStars);

            // load more scroll listener
            $(document).scroll(function () {
                var correctPosition = $(document).scrollTop();
                //console.log("correctPosition:"+correctPosition);
                //console.log("(document).height:"+$(document).height());
                if ((correctPosition > $(document).height() - 1000) && !displayPost.loadRequest) {
                    displayPost.loadRequest = true;
                    displayPost.ajaxMore();
                }
            });
            this.postDialogBind = true;
        }
    },
    /*
    * Ajax call to get json object of post
    * */
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
                displayPost.buildPostDialog(callback);
            }
        });
    },
    /*
    * Build post dialog from getPost callback
    * */
    buildPostDialog: function (callback) {
        displayPost.postDisplayName.html(callback.displayName);
        displayPost.postDisplayName.attr("href", "profile.php?id="+callback.publisherId);
        displayPost.postDialogTimeAgo.html(callback.time);
        displayPost.postTitle.html("<a href=\"index.php?category="+callback.category+"\">"+callback.categoryName+"</a> \\ <span>"+callback.title+"</span>");
        displayPost.postDescription.html(callback.description);
        displayPost.postDialogImage.attr("src", "./uploads/"+callback.imagePath);
        displayPost.postDialog.attr("postId", callback['id']);
        displayPost.postDialogPrice.html(callback.price+"$");
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
            var commentHtml = "";
            commentHtml += "<div class=\"row post-dialog-comment\" id=\"comment"+this.id+"\">";
            commentHtml +=      "<div class=\"post-dialog-comment-user col-md-3 col-xs-3\">";
            commentHtml +=          "<div class=\"inline-block\">";
            commentHtml +=              "<div><a href=\"#\">"+this.displayName+"</a></div>";
            commentHtml +=              "<div class=\"post-dialog-comment-time\"\">"+this.time+"</div>";
            commentHtml +=           "</div>";
            commentHtml +=          "<div class=\"inline-block\">";
            if(this.delete)
                commentHtml +=              "<div class=\"close remove-comment-btn\" commentId=\""+this.id+"\">&times;</div>";
            commentHtml +=           "</div>";
            commentHtml +=      "</div>";
            commentHtml +=      "<div class=\"post-dialog-comment-body col-md-9 col-xs-9\">"+this.body+"</div>";
            commentHtml += "</div>";
            displayPost.postComments.append(commentHtml);
        });
        $(".remove-comment-btn").each(function () {
            $(this).on("touchstart click", displayPost.removeComment);
        })
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
    },
    /*
    * add comment
    * */
    addComment: function (e) {
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
                    var commentHtml = "";
                    commentHtml += "<div class=\"row post-dialog-comment\" id=\"comment"+callback.id+"\">";
                    commentHtml +=      "<div class=\"post-dialog-comment-user col-md-3 col-xs-3\">";
                    commentHtml +=          "<div class=\"inline-block\">";
                    commentHtml +=              "<div><a href=\"#\">"+callback.displayName+"</a></div>";
                    commentHtml +=              "<div class=\"post-dialog-comment-time\"\">"+callback.time+"</div>";
                    commentHtml +=           "</div>";
                    commentHtml +=          "<div class=\"inline-block\">";
                    commentHtml +=              "<div class=\"close remove-comment-btn\" commentId=\""+callback.id+"\">&times;</div>";
                    commentHtml +=           "</div>";
                    commentHtml +=      "</div>";
                    commentHtml +=      "<div class=\"post-dialog-comment-body col-md-9 col-xs-9\">"+callback.body+"</div>";
                    commentHtml += "</div>";
                    displayPost.postComments.prepend(commentHtml);
                    $('.remove-comment-btn[commentId="'+callback.id+'"]').on("touchstart click", displayPost.removeComment);
                }
                displayPost.commentTA.val("");
            }
        });
    },
    removeComment: function () {
        var commentId  = $(this).attr("commentId");
        var dataString = "commentId="+commentId;
        $.ajax({
            url: "./ajax/deleteCommentAjax.php",
            type: "POST",
            data: dataString,
            dataType: "json",
            success: function (callback){
                var errors = callback.errors;
                console.log(callback);
                if (typeof errors !== typeof undefined && errors !== false) {
                    displayPost.displayErrors(errors);
                }else if(callback == false){
                    displayPost.displayErrors(["Cannot delete comment"]);
                }else{
                    $("#comment"+commentId).remove();
                }
            }
        });
    },
    /*
    * add to favorite
    * */
    addToFavorites : function () {
        var postId = displayPost.postDialog.attr("postId");
        console.log("add postId="+postId+" to fav\n");
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
    /*
    * update stars ui based on mouse position
    * */
    goldenStars: function(){
        var starIndex = $(displayPost.stars).index(this);
        displayPost.setStars(starIndex);
    },
    /*
    * update ui stars
    * @param number of stars
    * */
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
    /*
    * rank a post
    * */
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
    /*
    * display errors on post dialog
    * @param array of errors
    * */
    displayErrors: function (errors) {
        displayPost.postErrors.html("");
        $(errors).each(function () {
            displayPost.postErrors.append("<div class=\"alert alert-danger text-align-left\">"+this+"</div>")
        });
    },
    /*
    * load more posts to main view
    * based on displayPost.loadMoreInfo parameters
    * */
    ajaxMore: function(){
        dataString = "pageNumber="+displayPost.loadMoreInfo.attr("pageNumber");
        if(displayPost.loadMoreInfo.attr("category"))
            dataString+= "&category="+displayPost.loadMoreInfo.attr("category");
        if(displayPost.loadMoreInfo.attr("postsOrder"))
            dataString+= "&postsOrder="+displayPost.loadMoreInfo.attr("postsOrder");
        console.log(dataString);
        $.ajax({
            url: "ajax/loadMoreAjax.php",
            type: "GET",
            data: dataString,
            dataType: "json",
            success: function(callback){
                if(callback!="0"){
                    console.log(" Ajax suc");
                    displayPost.loadMorefetchResult(callback);
                }
            }
        });
    },
    /*
    * fetch the result from previous step (displayPost.ajaxMore)
    * and build append the ui elements into displayPost.postsDisplayContainer
    * */
    loadMorefetchResult: function(posts){
        var htmlPostsString = "";
        if(!(posts.length == 0)) {
            for (var i = 0; i < posts.length; i += 4) {
                var limit = i + 4;
                htmlPostsString += "<div class=\"row\">";
                for (i; i < limit; i++) {
                    if (posts[i] != undefined) {
                        htmlPostsString += "<div class=\"col-xs-12 col-sm-6 col-md-3\">";
                        htmlPostsString += "<div class=\"post-mini\">";
                        htmlPostsString += "<div class=\"post-mini-top\">";
                        htmlPostsString += "<a href=\"profile.php?id=" + posts[i]['publisherId'] + "\">" + posts[i]['displayName'] + "</a><span>" + posts[i]['time'] + "</span>";
                        htmlPostsString += "</div>";
                        htmlPostsString += "<div class=\"post-mini-title\">";
                        htmlPostsString += "<a href=\"#\" class=\"postDialog\" postId=" + posts[i]['id'] + ">" + posts[i]['title'] + "</a>";
                        htmlPostsString += "</div>";
                        htmlPostsString += "<div class=\"post-mini-main\">";
                        htmlPostsString += "<div class=\"post-mini-img\">";
                        htmlPostsString += "<img src=\"./uploads/" + posts[i]['imagePath'] + "\" class=\"img-responsive postDialog width-min-fluid\" postId=" + posts[i]['id'] + ">";
                        htmlPostsString += "</div>";
                        htmlPostsString += "<div class=\"post-mini-img-des\">";
                        htmlPostsString += "<span>" + posts[i]['description'].substr(0, 200) + "..</span>";
                        htmlPostsString += "</div>";
                        htmlPostsString += "<div class=\"post-mini-img-price circle\"><span>" + posts[i]['price'] + "$</span></div>"
                        htmlPostsString += "</div>";
                        htmlPostsString += "</div>";
                        htmlPostsString += "</div>";
                    }
                }
                htmlPostsString += "</div>";
            }
            displayPost.postsDisplayContainer.append(htmlPostsString);
            displayPost.loadMoreInfo.attr("pageNumber", parseInt(displayPost.loadMoreInfo.attr("pageNumber")) + 1);
            displayPost.loadRequest = false;
            displayPost.init();
        }else{
            htmlPostsString += "<div class=\"row\"><div class=\"col-xs-12 col-sm-12 col-md-12\" style=\"text-align: center;\">No more results</div></div>";
            displayPost.postsDisplayContainer.append(htmlPostsString);
        }
    }
}