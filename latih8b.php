<html>
<?php
$username="admin";
$password="123";
?>
<body>
 

<form method="post">
Username :<input type="text" name="user"><br>
password :<input type="pass"><br>
<input type="submit" value="login">
</form>
<?php
if($_SERVER['REQUEST_METHOD']=="POST")
{
if($_POST['user']==$username AND $_POST['pass']==$password)
    {
        echo "berhasil";
    }else{
        echo "gagal";
    }
}
?>
</body>
</html>
