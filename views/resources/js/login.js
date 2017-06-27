var loginController = {
	init: function(isHeader = true) {
		this.loginForm			= $("#login_form");
        this.loginErrors    	= $("#loginErrors");
        this.emailField         = $("#emailField");
        this.passwordField      = $("#passwordField");


		if(isHeader){
			this.isHeader 			= isHeader;
            this.userNavBar 		= $("#userNavBar");
            this.popUpLogin     	= $("#popUpWindow");
            this.logoutBtn			= $("#logoutBtn");
            this.favoritesNavBar 	= $("#navbarFavorites");
		}
		this.bindEvent();
	},
	bindEvent: function(){
		this.loginForm.submit(this.doLogin);
        if(loginController.isHeader){
            this.logoutBtn.click(this.doLogout);
        }
	},
	doLogin: function(e){
        e.preventDefault();
	    if(!loginController.validation());
        else {
            var self = loginController;
            var dataString = self.loginForm.serialize();
            $.ajax({
                url: "./ajax/loginAjax.php",
                type: "POST",
                data: dataString,
                dataType: "json",
                success: function (callback) {
                    if (!callback.errors && loginController.isHeader) {
                        loginController.userNavBar.html("<li><a href=\"profile.php\"><span class=\"glyphicon glyphicon-user\"></span>" + callback['displayName'] + "</a></li>" +
                            "<li><a href=\"#\" id=\"logoutBtn\">Logout <span class=\"glyphicon glyphicon-log-out\"></span></a></li>");
                        loginController.logoutBtn = $("#logoutBtn");
                        loginController.logoutBtn.click(loginController.doLogout);
                        loginController.favoritesNavBar.show();
                        loginController.popUpLogin.modal('toggle');
                    } else {
                        if (!callback.errors && !loginController.isHeader) {
                            window.location.replace("./index.php");
                        } else {
                            errorsString = "";
                            callback.errors.forEach(function (error) {
                                errorsString += error
                            })
                            loginController.loginErrors.html("<div class=\"alert alert-danger text-align-left\" role=\"\" >" + errorsString + "</div>");
                        }
                    }
                }
            });
        }
        console.log("add");
    },
	doLogout: function (e){
        e.preventDefault();
        $.ajax({
            url: "./ajax/logoutAjax.php",
            type: "GET",
            dataType: "json",
            success: function(callback){
                if(callback){
                    loginController.userNavBar.html("<li><a href=\"./views/sign_up_view.php\">Sign up <span class=\"glyphicon glyphicon-user\"></span></a></li>"+
						"<li><a href=\"#\" data-toggle=\"modal\" data-target=\"#popUpWindow\">Login <span class=\"glyphicon glyphicon-log-in\"></span></a></li>");
                    loginController.favoritesNavBar.hide();
                }
			}
        });
	},

    validation: function (){
	    errors = $.makeArray();

        if(loginController.emailField.val().length == 0)
            errors.push("Please enter email");
        if(loginController.passwordField.val().length == 0)
            errors.push("Please enter password");


        if(errors.length != 0){
            errorsString = "";
            $.each(errors, function( index, error ) {
                errorsString += error +"<br/>";
            });
            loginController.loginErrors.html("<div class=\"alert alert-danger text-align-left\" role=\"\" >"+errorsString+"</div>");
            return false;
        }
        return true;
    }
}