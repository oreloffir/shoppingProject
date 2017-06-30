<html>
<head>
	<title>login example</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<script src="views/resources/js/login.js" type="text/javascript"></script>
</head>
<body>
	<form id="login_form">
		<table>
			<tr>
				<td>Email:</td>
				<td><input type="text" name="email" id="email_field"></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="password" name="password" id="password_field"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" id="submit_action"></td>
			</tr>
		</table>
	</form>
<script>
	loginController.init();
</script>
</body>
</html>