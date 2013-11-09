<!--
/* 
 * Sign Up Form
 * 
*/
-->

<form method='POST' action='/users/p_signup'>

    <h2>Sign-up:</h2>

    First Name<br>
    <input class="field" type='text' name='first_name'>
    <br>

    Last Name<br>
    <input class="field" type='text' name='last_name'>
    <br>

    Email<br>
    <input class="field" type='text' name='email'>
    <br>

    Password<br>
    <input class="field" type='password' name='password' placeholder='Remember me!'>
    <br>
    
    <!--Error Message-->
    <?php if(isset($error)): ?>
            <div class='error'>
                    <p>Have  you forgotten something?</p>
            </div>
            <br>
    <?php endif; ?>
    
    <input class="button" type='submit' value='Sign up'>

</form>

