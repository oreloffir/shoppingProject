var addPostController = {
	init: function() {
		this.submitAction	= $("#submit_action");
		this.addPostForm	= $("#add_post_form");
		this.bindEvent();
	},
	bindEvent: function(){
		this.addPostForm.submit(this.addPost);
	},
	addPost: function(e){
		e.preventDefault();
		var self = addPostController;
		var dataString = self.addPostForm.serialize();
		console.log(dataString);
		$.ajax({
			url: "../ajax/addPostAjax.php",
			type: "POST",
			data: dataString,
			dataType: "json",
			success: function(callback){
				console.log(callback);
			}
		});
	}
}