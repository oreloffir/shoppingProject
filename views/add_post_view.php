<html>
<head>
	<title>Add Post</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<script src="./resources/js/addPost.js" type="text/javascript"></script>
</head>
<body>
	<form id="add_post_form">
		<table>
			<tr>
				<td>Post title</td>
				<td><input type="text" name="title" id="title_field"></td>
			</tr>
			<tr>
				<td>Post description</td>
				<td><input type="text" name="description" id="description_field"></td>
			</tr>
			<tr>
				<td>sale URL</td>
				<td><input type="text" name="URL" id="URL_field"></td>
			</tr>
			<tr>
				<td>Add image</td>
				<td><input type="text" name="image" id="image_field"></td>
			</tr>
			<tr>
				<td>Category</td>
				<td><input type="text" name="category" id="category_field"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" id="submit_action"></td>
			</tr>
		</table>
	</form>
<script>
	addPostController.init();
</script>
</body>
</html>