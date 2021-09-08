<?php
$enable=0;
$status="";
$con=mysqli_connect('localhost','root','','dbmsproj');
		if(!$con){
			echo("Connection failed!!");
			}
		else{
			$check="select * from order1 where billed=0";
			$res=mysqli_query($con,$check);
			if(mysqli_num_rows($res)>0){
				$enable=0;
				echo ("You can't perform menu operations while there is a customer on the table. <br> Please ensure that all the customers are billed before performing menu operations.<br>
					You will be redirected in 10 seconds!!");
				header("refresh:10;url=home.php");
			}
			else{
				$enable=1;
			}
		}
		if($_SERVER["REQUEST_METHOD"]=="POST" and $enable==1)
			{
				$aitem=mysqli_real_escape_string($con,$_POST["aitem"]);
				$itemtype=mysqli_real_escape_string($con,$_POST["itemtype"]);
				$icost=mysqli_real_escape_string($con,$_POST["icost"]);
				$addquery="insert into items values(DEFAULT,'$aitem','$itemtype','$icost')";
					mysqli_query($con,$addquery);
					$status= "Item Added Successfully";
					
			}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Add item</title>
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css"/>
</head>
<body style="background-image: url('media/item.jpg');background-size:cover;">
<nav class="red">
          <div class="nav-wrapper">
      
            <ul class="right ">
				<li><a href="home.php"> Home </a></li>
				</ul>
          </div>
        </nav>
	
<div class="row white-text">
            <div class="col s6" style="background:rgba(0,0,0,0.5);height:800px">	
<h1 class="yellow-text">Add Item to the Menu</h1>
<form action="additem.php" method="post">
	Item-Name<input type="text" name="aitem">
	Item-Type<input type="text" name="itemtype">
	Item-cost<input type="text" name="icost">
	<input type="submit" name="submit" value="Add" class="btn-small">
</form>
<!-- This span is for displaying if the item is Added or not-->
<span> <?php echo $status;?></span>

	  </div>
	  <div class="col s2"></div>
      <div class="col s4" style="height:800px;
background:rgba(0,0,0,0.8);
color:#ffc107;
width: 400px;"><!-- This span is for Displaying the Menu -->
	<span class="deep-orange-text" style="font-size:30px;">
	<h1 class="yellow-text">MENU</h1>
		<?php
			$con1=mysqli_connect('localhost','root','','dbmsproj');
			$getmenu="select * from items";
			$menu=mysqli_query($con1,$getmenu);
			
			while($row=mysqli_fetch_assoc($menu)){
				echo $row["i_name"];
				echo "<br>";
			}
			?>
	</span>

	  </div>
    </div>

		
</body>
</html>