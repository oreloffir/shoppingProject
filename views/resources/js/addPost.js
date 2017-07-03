var addPostController = {
	init: function() {
		this.addPostForm	 = $("#add_post_form");
        this.addPostErrors   = $("#addPostErrors");
        this.couponBox 		 = $("#couponBox");
        this.couponCodeGroup = $("#couponCodeGroup");
        this.browseImageBtn     = $("#file");
        this.flag = false;
        this.bindEvent();
        $(document).ready(this.browseImage);

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
            url: "./ajax/addPostAjax.php",
            type: $(this).attr("method"),
            dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(callback){
                if (callback.errors.constructor === Array){
                    console.log("callback = errors");
                    errorsString = "";
                    callback.errors.forEach(function (error) { errorsString += error+" <br\>" });
                    self.addPostErrors.html("<div class=\"col-md-8 alert alert-danger text-align-left\" role=\"\" >"+errorsString+"</div>");
                }else{
                    console.log("add post");
                    window.location.replace("./index.php");
                }
                console.log("bye");
            },
            error: function (callback) {
                console.log(callback);
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

    },

    // preview
    browseImage : function () {
        $(document).on('change', '#file', function() {
            var input = $(this),
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function(event, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = label;

            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }

        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#file").change(function(){
            readURL(this);
        });
    }


}