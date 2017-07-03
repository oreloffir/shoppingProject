/**
 * Created by Orel on 6/30/2017.
 */

var adminEditUser = {
    init: function () {
        this.editUserForm   = $("#editUserForm");
        this.userId         = $("#userIdField");
        this.displayName    = $("#displayNameField");
        this.email          = $("#emailField");
        this.type           = $("#userType");
        this.newPassword    = $("#newPasswordField");
        this.editUserErrors = $("#editUserErrors");

        adminEditUser.bindEvent();
    },

    bindEvent: function () {
        this.editUserForm.submit(this.editUser);
    },

    editUser: function (e) {
        e.preventDefault();
        $.ajax({
            url: "./ajax/editUserAjax.php",
            type: $(this).attr("method"),
            dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(callback){
                console.log("callback = "+ callback);

                if (callback.constructor === Array){
                    errorsString = "";
                    callback.errors.forEach(function (error) { errorsString += error+" \n" });
                    console.log(errorsString);
                    adminEditUser.editUserErrors.html("<div class=\"col-md-offset-4 alert alert-danger\" id=\"editPostErrors\">"+callback.errors+"</div>")
                }else{
                    adminEditUser.editUserErrors.html("<div class=\"col-md-offset-4 alert alert-success\" id=\"editPostErrors\">User ID: "+callback+" has been edited</div>")
                }
            }
        });

    }
}
