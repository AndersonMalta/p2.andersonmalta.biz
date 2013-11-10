<form method='POST' action='/users/p_login'>

    Email<br>
    <input type='text' name='email' style="width: 300px">    
    <br><br>

    Password<br>
    <input type='password' name='password' style="width: 300px">
    <br><br>

    <?php if(isset($error)): ?>
        <div class='error'>
            Login failed. Please double check your email and password.
        </div>
        <br>
    <?php endif; ?>

    <input type='submit' value='Log in'>

</form>