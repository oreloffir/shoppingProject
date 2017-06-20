var loginController = {
	init: function() {
		this.submitAction	= $("#submit_action");
		this.loginForm		= $("#login_form");
		this.bindEvent();
	},
	bindEvent: function(){
		this.loginForm.submit(this.doLogin);
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
				console.log(callback);
			}
		});
	}
}