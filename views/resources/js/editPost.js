/**
 * Created by Orel on 6/24/2017.
 */
var editPostController = {
    init: function() {
        this.editPostForm	 = $("#editPostForm");
        this.editPostErrors   = $("#editPostErrors");
        this.couponBox 		 = $("#couponBox");
        this.couponCodeGroup = $("#couponCodeGroup");;
        this.bindEvent();
        $(document).ready(this.browseImage);


    },

    bindEvent: function(){
        this.editPostForm.submit(this.addPost);
        this.couponBox.change(this.changeCouponBox);
        this.changeCouponBox();
    },

    addPost: function(e){
        e.preventDefault();
        var self = editPostController;
        var dataString = self.editPostForm.serialize();
        console.log(dataString);
        $.ajax({
            url: "./ajax/addPostAjax.php",
            type: $(this).attr("method"),
            dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(callback){
                console.log(callback);
                if (callback.constructor === Array){
                    errorsString = "";
                    callback.forEach(function (error) { errorsString += error+" \n" });
                    console.log(errorsString);
                    self.editPostErrors.html("<div class=\"col-md-offset-4 col-md-8 alert alert-danger text-align-left\" role=\"\" >"+errorsString+"</div>");
                }else{
                    window.location.replace("../index.php");
                }
            }
        });
    },

    changeCouponBox: function () {
        if(editPostController.couponBox.is(':checked')){
            editPostController.couponCodeGroup.removeClass("hide");
        }else{
            editPostController.couponCodeGroup.addClass("hide");
        }

    },

    // preview the uploaded image
    browseImage : function () {
        $(document).on('change', '.btn-file :file', function() {
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