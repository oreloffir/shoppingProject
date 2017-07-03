/**
 * Created by Orel on 6/20/2017.
 */
var SignUpController = {
    init:function () {
        this.signUpForm	= $("#sign_up_form");
        this.signUpErrors    = $("#signUpErrors");
        this.bindEvent();
    },

    bindEvent: function () {
        this.signUpForm.submit(this.doSignUp);
    },

    doSignUp: function (e) {
        e.preventDefault();
        var self = SignUpController;
        var dataString = self.signUpForm.serialize();
        //console.log(dataString);
        $.ajax({
            url: "../ajax/signUpAjax.php",
            type: "POST",
            data: dataString,
            dataType: "json",
            success: function (callback){
                console.log("callback ="+callback);
                if(callback.constructor === Array){
                    errorsString = "";
                    callback.forEach(function (error) { errorsString += error+" <br\>" })
                    SignUpController.signUpErrors.html("<div class=\"alert alert-danger text-align-right col-sm-offset-4 col-sm-8\" role=\"\" >"+errorsString+"</div>");
                }else
                    window.location.replace("../index.php");
            }
        });
    }
}