<?php
$bill=0;
$disp="";
if($_SERVER["REQUEST_METHOD"]=="POST")
	{
		$con=mysqli_connect('localhost','root','','dbmsproj');
		if(!$con){
			echo("Connection failed!!");
			}
		else{
			$oidforbilling=mysqli_real_escape_string($con,$_POST["oidforbilling"]);
			$canbebilled="select * from order1 where o_id='$oidforbilling' and billed=0";
			$res_can=mysqli_query($con,$canbebilled);
			if(mysqli_num_rows($res_can)==0)
			{
				$disp="Order ID not active. Please enter a valid Order id";
			}
			else
			{
			$getbill="select i_id,quantity from order_details where o_id='$oidforbilling'";
			$res=mysqli_query($con,$getbill);
			if(mysqli_num_rows($res)>0 ){
				while($row=mysqli_fetch_assoc($res)){
					$item=$row["i_id"];
					$getcost="select cost from items where i_id=$item";
					$resin=mysqli_query($con,$getcost);
					$rowin=mysqli_fetch_assoc($resin);
					$cost=$rowin["cost"];
					$quantity=$row["quantity"];
					$bill=$bill+$cost*$quantity;
				}
				$upd="update order1 set billed=1 where billed=0 and o_id='$oidforbilling'";
				mysqli_query($con,$upd);
				$disp="Bill amount is RS.".$bill;
			}	
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Bill</title>
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css"/>	
</head>
<body style="background-image: url('media/bill.jpg');background-size:cover;"> 
<nav class="red">
          <div class="nav-wrapper">
      
            <ul class="right ">
				<li><a href="home.php"> Home </a></li>
				</ul>
          </div>
        </nav>
		<div class="container white-text">
<h1> Generate Bill </h1>
<form method="post" action="bill.php" style="width:180px;
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
   <h4 class="green-text">Enter the Order-Id for billing:</h4><br>
<input type="text" name="oidforbilling"><br><br>
<input type="submit" name="submit" value="Generate Bill" class="white-text btn-small">
</form>
<!-- The span below is for displaying active order id's-->
<span style="color:grey;">
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
<br><br><br><br>
<!-- The span below is for displaying the bill or invalid order id error-->
<span><?php echo $disp?></span>
</body>
		</div>
</html>