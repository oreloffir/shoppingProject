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
        this.postErrors          = $("#postDialogErrors");
        this.bindEvent();
    },
    bindEvent: function (){
       $(this.postButtons).each(function (){
            $(this).on("click", displayPost.getPost);
       });
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
                displayPost.postTitle.html("<a href=\"category.php?id="+callback.category+"\">"+callback.categoryName+" \\ "+callback.title);
                displayPost.postDescription.html(callback.description);
                displayPost.postFavBtn.attr("postId", callback['id']);
                if(callback.favorite) {
                    displayPost.postFavBtn.removeClass("btn-gray");
                }else{
                    if(!displayPost.postFavBtn.hasClass("btn-gray"))
                        displayPost.postFavBtn.addClass("btn-gray");
                }
                displayPost.postComments.html("");
                $(callback.comments).each(function (){
                    displayPost.postComments.append("<div class=\"row border-bottom-grey\"><div class=\"post-dialog-comment-user col-md-3\"><div><a href=\"#\">"+this.displayName+"</a></div><div class=\"post-dialog-comment-time\"\">8 minutes ago</div></div><div class=\"post-dialog-comment-body col-md-9\">"+this.body+"</div></div>");
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

    }
}