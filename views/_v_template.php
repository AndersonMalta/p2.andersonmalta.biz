<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
					
	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	<!-- CSS for all pages -->
	<link rel="stylesheet" href="/css/profile.css" type="text/css">
	<!-- favicon -->
	<link rel="icon" type="image/png" href="uploads/images/favicon-30.ico"/>
	
</head>

<body>	
	<div id="wrapper">

		<div id="logo">
			<a href="index.php">| Tattler</a>
		</div><!--end of logo-->

		<!-- Menu for users who are logged in -->
        <br>
        <?php if($user): ?>
            <div class="sign_log">
                <ul>
                    <li>
                        <a href='/users/profile'>Profile</a>
                    </li>
                    <li>
                        <a href='/posts/add'>New Post</a>
                    </li>
                    <li>
                        <a href='/posts/index'>All Posts</a>
                    </li>
                    <li>
                        <a href='/posts/following'>Friends' Posts</a>
                    </li>
                    <li>
                        <a href='/posts/users'>All Users</a>
                    </li>
                    <li>
                        <a href='/users/logout'>Logout</a>
                    </li>
                </ul>
            </div><!--end of sign_log-->

            <!-- Menu options for users who are not logged in -->
        <?php else: ?>

            <div class="sign_log">
                <ul>
                    <li>
                        <a href='/users/signup'>| Sign Up</a>
                    </li>
                    <li>
                        <a href='/users/login'>| Log In</a>
                    </li>
                </ul>
            </div><!--end of sign_log-->

        <?php endif; ?>
        

		<div class="empty"></div><!--end of empty - just a class to clear floats-->

		<div id="mouth">
			<img src="/uploads/images/bouche.gif" alt="mouth gossiping"/>
		</div><!--end of mouth-->

	<?php if(isset($content)) echo $content; ?>

	</div><!--end of wrapper-->


	<div id="footer">

		<div id="footerLinks"><p>Follow us
            	<a href="http://www.facebook.com/SriRadheyFlowers" target="_new">FACEBOOK</a> |
              	<a href="https://twitter.com/Sri_Radhey" target="_new">TWITTER</a> |
                <a href="https://plus.google.com/u/0/b/116342925950160345906/116342925950160345906/posts" target="_new">GOOGLE+</a> |
                <a href="http://www.sri-radhey.com/cms/" target="_new">OUR BLOG</a> </p>
     	</div><!--end of footerLinks-->

        <div class="empty"></div><!--clear-->
            
     	<div id="footNotes">
            <p>Copyright © 2013 Tattler</p>
            <p>Site Design by<a href="http://www.andersonmalta.com" target="_new">Anderson Malta</a></p>
     	</div><!--end of footNotes-->

	</div><!--end of footer-->

	<?php if(isset($client_files_body)) echo $client_files_body; ?>
	
</body>
</html>