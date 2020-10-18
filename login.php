<?php
require_once 'header .php';
$error = $user = $pass = "";

if (isset($_POST[ 'user']))
{
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    if ($user == "" || $pass == "")
    $error = 'Not all fileds were entered';
else
{
    $result = querMysql("SELECT user ,pass fROM memebers WHERE user='$user' AND pass='$pass'");

    if ($result->num_rows == 0)
    {
        $error = "Invalid Login attempt";
    }
    else 
    {
        $_SESSION[ 'user'] = $user;
        $_SESSION[ 'pass'] = $pass;
        die("You are now logged in. Please <a data-transition='slide'
        href='members.php?view=$user'>click here</a> to continue.</div>
        </body></html>");
    }
}

echo <<<_END
<form method='post' action='login.php'>
<div data-role='fieldcontain'>
<lable></lable>
<span class='error'>$error</span>
</div>
<div date-role='fieldcontain'>
<lable></lable>
Please enter your details to log in
</div>
<div data-role='fieldcontain'>
<lable>Username</lable>
<input type='text' maxlength='225' name='user' value='$user'>
</div>
<div data-role='fieldcontain'>
<lable>Password</lable>
<input type='text' maxlength='225' name='Password' value='$Password'>
</div>
<div data-role='fieldcontain'>
<lable></lable>
<input data-transition='slide' type='submit' value='login'>
</div>
</form>
</div>
</body>
</html>
_END;
?>
