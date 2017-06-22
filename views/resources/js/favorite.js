/**
 * Created by Orel on 6/21/2017.
 */
var favoritesController = {
    init : function () {
        this.favoriteBtn      = $("#favoriteBtn");
        this.postDialogErrors = $("#postDialogErrors");
        this.bindEvent();
    },

    bindEvent : function () {
        this.favoriteBtn.click(favoritesController.addToFavorites);
    },

    checkClass : function (element, className) {
        return (' ' + element.className + ' ').indexOf(' ' + className + ' ') > -1;
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
                var attr = $(callback).attr('errors');
                console.log(attr);
                if (typeof attr !== typeof undefined && attr !== false) {
                    console.log("\ncallback = errors ");
                    errorsString = "";
                    $(callback.errors).each(function () {
                        errorsString += this;
                    });
                    favoritesController.postDialogErrors.html("<div class=\"alert alert-danger text-align-left\">"+errorsString+"</div>");
                }else {
                    if (callback) {
                        if (favoritesController.favoriteBtn.hasClass("btn-gray")) {
                            favoritesController.favoriteBtn.removeClass("btn-gray");
                        }else
                            favoritesController.favoriteBtn.addClass("btn-gray");
                    } else {
                        favoritesController.postDialogErrors.html("<div class=\"alert alert-danger text-align-left\">" + "Database Error" + "</div>");
                    }
                }
            }
        });
    }



}