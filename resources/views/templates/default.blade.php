<DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Programa</title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
		
		<script src="https://code.jquery.com/jquery-2.2.0.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		

		<!-- estos son para la tabla editable de control -->
<!-- 		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="mindmup-editabletable.js"></script>
		<script src="numeric-input-example.js"></script> -->
		
	</head>
	<body>
		@include('templates.partials.navigation')
		<div bgcolor="#E6E6FA"  class="container-fluid">
			@include('templates.partials.alerts')
			@yield('content')
		</div>
	</body>
	<footer>
		
	</footer>	
</html>