/**
 * Created by Guy on 6/20/2017.
 */
var displayPost = {
    init: function (){
        this.postButtons = $(".postDialog");
        this.postDialog  = $("#displayPostModal");
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
                $("#postDialogDisplayName").html(callback.displayName);
                $("#postDialogTitle").html(callback.category+" \\ "+callback.title);
                $("#postDialogDescription").html(callback.description);
                $("#favoriteBtn").attr("postId", callback['id']);
                $("#postDialogComments").html("");
                $(callback.comments).each(function (){
                    $("#postDialogComments").append("<div class=\"row border-bottom-grey\"><div class=\"post-dialog-comment-user col-md-3\"><div><a href=\"#\">"+this.displayName+"</a></div><div class=\"post-dialog-comment-time\"\">8 minutes ago</div></div><div class=\"post-dialog-comment-body col-md-9\">"+this.body+"</div></div>");
                });
                $("#postDialogUrl").attr("href", callback.saleUrl);
                if(callback.couponCode)
                    $("#postDialogCouponCode").html("<code>Coupon: "+callback.couponCode+"</code>")
                displayPost.postDialog.modal('show');
                console.log(callback);
            }
        });

    }
}