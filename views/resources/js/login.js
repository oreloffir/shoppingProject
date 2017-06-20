var loginController = {
	init: function() {
		this.submitAction	= $("#submit_action");
		this.loginForm		= $("#login_form");
		this.userNavBar 	= $("#userNavBar");
		this.popUpLogin     = $("#popUpWindow");
		this.loginErrors    = $("#loginErrors")
		this.logoutBtn		= $("#logoutBtn");
		this.bindEvent();
	},
	bindEvent: function(){
		this.loginForm.submit(this.doLogin);
		this.logoutBtn.click(this.doLogout);
	},
	doLogin: function(e){
		e.preventDefault();
		var self = loginController;
		var dataString = self.loginForm.serialize();
		console.log(dataString);
		$.ajax({
			url: "./ajax/loginAjax.php",
			type: "POST",
			data: dataString,
			dataType: "json",
			success: function(callback){
				if(!callback.errors){
                    loginController.userNavBar.html("<li><a href=\"#\"><span class=\"glyphicon glyphicon-user\"></span>"+callback['displayName']+"</a></li>"+
						"<li><a href=\"#\" id=\"logoutBtn\">Logout <span class=\"glyphicon glyphicon-log-out\"></span></a></li>");
                    loginController.logoutBtn = $("#logoutBtn");
                    loginController.logoutBtn.click(loginController.doLogout);
                    loginController.popUpLogin.modal('toggle');
				}else{
				    errorsString = "";
                    callback.errors.forEach(function (error) { errorsString += error })
                    loginController.loginErrors.html("<div class=\"alert alert-danger text-align-right\" role=\"\" >"+errorsString+"</div>");
                }

			}
		});
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
                }
			}
        });
	}
}