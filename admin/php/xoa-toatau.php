<?php 
$conn=require_once("../lib/connection.php");
	if(isset($_GET["id"]))
	{
	$id=$_GET["id"];
	$sql="DELETE FROM toatau WHERE matoa='".$id."'";
	$query=pg_query($conn,$sql);
	if(!$query){
		header('Location:../pages/toatau.php?id=dl0');
	}
	else
	header('Location:../pages/toatau.php?id=dl1');
	}
 ?>