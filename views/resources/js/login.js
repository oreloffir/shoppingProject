var loginController = {
	init: function(isHeader = true) {
        this.ajaxPrefix         = "";
		this.loginForm			= $("#login_form");
        this.loginErrors    	= $("#loginErrors");
        this.emailField         = $("#emailField");
        this.passwordField      = $("#passwordField");


		if(isHeader){
			this.isHeader 			= isHeader;
            this.addionalUserNavBar = $("#addionalUserNavBar"); // Favorites , Admin panel(if needed).
            this.userNavBar 		= $("#userNavBar"); // Logout / Login , Sign Up.
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
	    if(loginController.validation()){
            var dataString = loginController.loginForm.serialize();
            $.ajax({
                url: loginController.ajaxPrefix+"./ajax/loginAjax.php",
                type: "POST",
                data: dataString,
                dataType: "json",
                success: function (callback) {
                    if (!callback.errors && loginController.isHeader) {
                        userAreaString = "<li id=\"navbarFavorites\"><a href=\"favorites.php\">Favorites</a></li>";
                        if(callback['type'] == 1) {
                            userAreaString += "<li class=\"dropdown\">";
                            userAreaString +=       "<a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">Admin <span class=\"caret\"></span></a>";
                            userAreaString +=       "<ul class=\"dropdown-menu\">";
                            userAreaString +=           "<li><a href=\"./admin/adminEditPost.php\">Edit post</a></li>"
                            userAreaString +=           "<li><a href=\"./admin/adminUsers.php\">Users</a></li>";
                            userAreaString +=           "<li><a href=\"./admin/adminReports.php\">Reports</a></li>";
                            userAreaString += "</ul></li>";
                        }
                        loginController.addionalUserNavBar.html(userAreaString);

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
                            console.log("Errors");
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
    },
	doLogout: function (e){
        e.preventDefault();
        $.ajax({
            url: loginController.ajaxPrefix+"./ajax/logoutAjax.php",
            type: "GET",
            dataType: "json",
            success: function(callback){
                if(callback){
                    loginController.userNavBar.html("<li><a href=\"./views/sign_up_view.php\">Sign up <span class=\"glyphicon glyphicon-user\"></span></a></li>"+
						"<li><a href=\"#\" data-toggle=\"modal\" data-target=\"#popUpWindow\">Login <span class=\"glyphicon glyphicon-log-in\"></span></a></li>");
                    loginController.addionalUserNavBar.html("");
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