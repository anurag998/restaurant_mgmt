<?php 
session_start();
if (isset($_SESSION["islogin"]) && $_SESSION["islogin"]==1)
{
header("location:edit.php");
}
else
{
$errid=$errpass=$errlogin="";
$errval=0;

if($_SERVER["REQUEST_METHOD"]=="POST")
{
	if($_POST["loginid"]=="")
	{
		$errid="**Login-Id is required";
		$errval="1";
	}
	if($_POST["Password"]=="")
	{
		$errpass="**Password field is required";
		$errval=1;
	}
	if($errval==0)
	{
		$db=mysqli_connect('localhost','root','','minigames');
		if(!$db)
		{
			echo "Can't connect to the database!";
		}
		else
		{
			$id=mysqli_real_escape_string($db,$_POST["loginid"]);
			$pass=mysqli_real_escape_string($db,$_POST["Password"]);
			$sql="select * from logininfo where loginid='$id' and password='$pass'";
			$result=mysqli_query($db,$sql);
			if(mysqli_num_rows($result)==1)
			{
				$_SESSION["loginid"]=$id;
				$_SESSION["islogin"]=1;
				header("location: edit.php");
			}
			else
			{
				$errlogin="Login-Id and password doesn't match!!";
			}
		}
	}
}
}
?>
<html>
<title> Admin</title>
<link type="text/css" rel="stylesheet" href="css/materialize.min.css"/>
<body style="background-image: url('media/log.jpg');background-size:cover;">
<nav class="red">
          <div class="nav-wrapper">
      
            <ul class="right ">
				<li><a href="home.php"> Home </a></li>
				</ul>
          </div>
        </nav>
		<div class="container">
<h2> Admin Login</h2>
<br>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
style="width:180px;font-size:30px;
background:rgba(0,0,0,0.5);
color:#ffffff;
position:absolute;
transform:translate(-50%,-50%);
top:50%;
left:50%;
width: 400px;
height: 600px;
padding-top: 40px;
padding-left:70px;
padding-right:70px;">
Login ID:
<input type="text" name = "loginid"> <br>
<span style="color:red; font-size: 20px;"><?php echo $errid ?></span><br>
Password:
<input type="password" name ="Password" ><br>
<span style="color:red; font-size: 20px;"><?php echo $errpass ?></span><br>
<button class="btn-large"> Login</button><br><br>
<span style="color:red;font-size: 20px;"><?php echo $errlogin?></span>

</form>
</body>
</div>
</html>