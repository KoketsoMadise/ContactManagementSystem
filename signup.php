<?php
require_once 'header.php';

echo <<<_END
    <scrip>
    function checkUser(user)
    {
        if (user.value == '')
        {
            $('#used').html('&nbsp;')
            return
        }

        $.post
        (
            'checkuser.php',
            { user : user.value },
            funtion(data)
            {
                $('#used').html(data)
            }
        )
    }
    </scrip>
_END;

$error = $user = $pass = "";
if (isset($_SESSION['user])) destroySession();

if (isset($_POST['user']))
{
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    if ($user == "" || $pass == "")
    $error = 'Not all fileds were entered<br><br>';
else
{
    $result = querMysql("SELECT * fROM memebers WHERE user='$user'");

    if ($result->num_row)
    $error = 'that username already excists<br><br>';
    else
    {
        querMysql("INSERT INTO members VAULES('$user', '$pass')");
        die('<h4>Account created</4>Please log in.</div></body></html>');
    }
  }
}

echo <<<_END
    <form method='post' action='signup.php'>$error
    <div data-role='filedcontain'>
    <lable></lable>
    Please enter your details to sign up
    </div>
     <div data-role='filedcontain'>
     <lable>Username</lable>
     <input type='text' maxlength='255' name='user' value=$user'
        onBlur='checkUser(this)'>
        <lable></lable><div id='used'>&nbsp;</div>
        </div>
        <div data-role='filedcontain'>
        <lable>Password</lable>
        <input type='text' maxlength='255' name='pass' value=$pass'
        </div>
        <div data-role='filedcontain'>
        <lable></lable>
        <input data-transition='slide' type='sumbit' value='sign up'>
        </div>
        </div>
        </body>
        </html>
        _END;
        ?>
