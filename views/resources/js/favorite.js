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
        console.log("addToFavorites function "+postId);
        var dataString = "id="+postId;
        $.ajax({
            url: "./ajax/addFavoriteAjax.php",
            type: "POST",
            data: dataString,
            dataType: "json",
            success: function (callback) {
                if(callback.constructor === Array){
                    errorsString = "";
                    callback.errors.forEach(function (error) { errorsString += error })
                        favoritesController.postDialogErrors.html("<div class=\"alert alert-danger text-align-right col-sm-offset-4 col-sm-8\" id=\"postDialogErrors\" >"+errorsString+"</div>");
                }else {
                    if (callback) {
                        if (favoritesController.favoriteBtn.hasClass("btn-gray")) {
                            favoritesController.favoriteBtn.removeClass("btn-gray");
                        } else
                            favoritesController.favoriteBtn.addClass("btn-gray");
                    } else {
                        favoritesController.postDialogErrors.html("<div class=\"alert alert-danger text-align-right col-sm-offset-4 col-sm-8\" id=\"postDialogErrors\" >" + "Database Error" + "</div>");

                    }
                }
            }
        });
    }



}