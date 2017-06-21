var addPostController = {
	init: function() {
		this.addPostForm	 = $("#add_post_form");
        this.addPostErrors   = $("#addPostErrors");
        this.couponBox 		 = $("#couponBox");
        this.couponCodeGroup = $("#couponCodeGroup");
        this.flag = false;
        this.bindEvent();
	},

	bindEvent: function(){
		this.addPostForm.submit(this.addPost);
		this.couponBox.change(this.changeCouponBox);
	},

    addPost: function(e){
        e.preventDefault();
        var self = addPostController;
        var dataString = self.addPostForm.serialize();
        console.log(dataString);
        $.ajax({
            url: "../ajax/addPostAjax.php",
            type: $(this).attr("method"),
            dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(callback){
                console.log(callback);
                if (callback.constructor === Array){
                    errorsString = "";
                    callback.errors.forEach(function (error) { errorsString += error+" \n" });
                    console.log(errorsString);
                    self.addPostErrors.html("<div class=\"col-md-offset-4 col-md-8 alert alert-danger text-align-right\" role=\"\" >"+errorsString+"</div>");
                }else{
                    //window.location.replace("../index.php");
                }


            }
        });
    },

    changeCouponBox: function () {
		if(addPostController.flag){
            addPostController.couponCodeGroup.addClass("hide");
            addPostController.flag = false;
		}else{
            addPostController.couponCodeGroup.removeClass("hide");
            addPostController.flag = true;
		}

    }
}