<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Welcome to Tatller</title>
</head>

<body>
<?php if(isset($user_name)): ?>
<h2>This is the profile for <?=$user_name?></h2>
<?php else: ?>
<h2>No use has been specified</h2>
<?php endif; ?>
</body>
</html>
