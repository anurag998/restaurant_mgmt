<?php 
	$erritem="";
	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
		$con=mysqli_connect('localhost','root','','dbmsproj');
		if(!$con){
			echo("Connection failed!!");
			}
		else{
			$oid=mysqli_real_escape_string($con,$_POST["orderid"]);
			$iname=mysqli_real_escape_string($con,$_POST["itemname"]);
			$quantity=mysqli_real_escape_string($con,$_POST["quantity"]);
			$checkpresent="select * from order1 where o_id='$oid'";
			$reschk=mysqli_query($con,$checkpresent);  #checks if the order id is already present.
			if(mysqli_num_rows($reschk)==0){
				$addoid="insert into order1 values($oid,0)";
				mysqli_query($con,$addoid);
				$getiid="select i_id from items where i_name='$iname'";
				$chkitem=mysqli_query($con,$getiid);
				if(mysqli_num_rows($chkitem)==1){
					$res=mysqli_fetch_assoc($chkitem);
					$iid=$res["i_id"];
					$addorder="insert into order_details values($oid,$iid,$quantity)";
					mysqli_query($con,$addorder);
				}
				else{
					echo "Item not identified. Please enter the correct item name.";
				}
			}
			else{
				$getiid="select i_id from items where i_name='$iname'";
				$chkitem=mysqli_query($con,$getiid);
				if(mysqli_num_rows($chkitem)==1){
					$res=mysqli_fetch_assoc($chkitem);
					$iid=$res["i_id"];
					$addorder="insert into order_details values($oid,$iid,$quantity)";
					mysqli_query($con,$addorder);
				}
				else{
					$erritem="Item not identified. Please enter the correct item.";
				}

			}

	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>New Order</title>
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css"/>
</head>

<body style="background-image: url('media/neworder.jpg');background-size:cover;">
<nav class="red">
          <div class="nav-wrapper">
      
            <ul class="right ">
				<li><a href="home.php"> Home </a></li>
				</ul>
          </div>
        </nav>
		<div class="container white-text">
<form method="post" action="neworder.php" style="width:180px;
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
	<h2 class="green-text"> New Order </h2>
	Order ID :<input type="text" name="orderid"><br>
	Item Name:<input type="text" name="itemname"><br>
	Quantity:<input type="text" name="quantity"><br>
	<input type="submit" name="submit" vaule="order" class="white-text btn-small"><br>
	<span> <?php echo($erritem)?></span>
</form>
<!-- The span below is for displaying active order id's-->
<br>
<span class="amber-text" style="font-size:20px;">
	<?php
			$con1=mysqli_connect('localhost','root','','dbmsproj');
			$activeid="select * from order1 where billed = 0";
			$resact=mysqli_query($con1,$activeid);
			echo "Active order id's are : <br>";
			while($row=mysqli_fetch_assoc($resact)){
				echo $row["o_id"];
				echo "<br>";
			}
			?>
</span>
</body>
</div>
</html>