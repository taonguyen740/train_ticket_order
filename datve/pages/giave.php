 <html>
<?php
include("../template/giotau_giave_template.php");
 ?>
<!-- khi da an submit -->
 <?php
if(isset($_POST["btn_search"]))
{
	$machuyen=$_POST["machuyen"];$_SESSION["machuyen"]=$machuyen;
	$magadi=$_POST["magadi"];$_SESSION["magadi"]=$magadi;
	$magaden=$_POST["magaden"];$_SESSION["magaden"]=$magaden;
	$ngaydi=$_POST["ngaydi"];$_SESSION["ngaydi"]=$ngaydi;
	$sql1="select * from gadung where machuyen='".$machuyen."' order by sttdung";
	$sql2="select * from chuyentau where machuyen='".$machuyen."' ";
	$sql3="select maloaitoa,tenloaitoa from loaitoa";
	$query=pg_query($conn,$sql2);
	$row2=pg_fetch_array($query);
	$magadau=$row2["magadau"];
	$magacuoi=$row2["magacuoi"];
	$giokhoihanh=$row2["giokhoihanh"];
	$gioketthuc=$row2["gioketthuc"];
}
 ?>
<!-- Khi an vao link xac nhan chuyen tau -->
 <?php
if(isset($_GET["magadau"]) and isset($_GET["magacuoi"]))
{
	$magadau=$_GET["magadau"];
	$magacuoi=$_GET["magacuoi"];
}
 if(!isset($_GET["machuyen"]) and !isset($_POST["machuyen"]))
	{
		$sql="select machuyen,tenchuyen from chuyentau where magadau='".$magadau."' and magacuoi='".$magacuoi."'";
		$query=pg_query($conn,$sql);
		$row=pg_fetch_array($query);
		$machuyen=$row["machuyen"];
	}
if(isset($_GET["machuyen"])) $machuyen=$_GET["machuyen"];
 ?>
 <!--Sau khi chon mac -->
 <script>
 	 function chon_mac_tau () {
 	 	var x = document.getElementById("mySelect").value;
 	 	var y=<?php   $str="&magadau=".$magadau."&magacuoi=".$magacuoi."";echo "'".$str."';" ;?>
 	 	var link="giave.php?machuyen="+x+y;
 	   <?php print 'window.location.href=link'?>;
 	    	 }
 	 function chieu_di()
 	 	{
 	 		var ditu = document.getElementById("mySelect").value;
 	 		var gadau=<?php echo "'".$magadau."';" ;?>
 	 		if(gadau!=ditu)
 	 		{
 	 			var y=<?php   $str="magadau=".$magacuoi."&magacuoi=".$magadau."";echo "'".$str."';" ;?>
		 	 	var link="giave.php?"+y;
		 	   <?php print 'window.location.href=link'?>;
 	 		}
 	 	}
 	    	 </script>
<div style="margin-left: 26%">
	<!-- FORM -->
 <form action="giave.php" method="POST" name="TIM_GIO_TAU">
	<br>
	Chiều
	<select name="chieu" id="chieudi" onChange="chieu_di()">
		<option value="<?php echo $magadau; ?>"><?php echo get_name_ga($magadau,$conn),"-",get_name_ga($magacuoi,$conn); ?></option>
		<option value="<?php echo $magacuoi; ?>"><?php echo get_name_ga($magacuoi,$conn),"-",get_name_ga($magadau,$conn); ?></option>
	</select>
	<br>
	Mác Tàu
	<select name="machuyen" id="mySelect" onChange="chon_mac_tau()">
		<option value="<?php echo $machuyen;?>"><?php echo $machuyen; ?></option>
		<?php
		$sql="select machuyen,tenchuyen from chuyentau where magadau='".$magadau."' and magacuoi='".$magacuoi."'";
		$query=pg_query($conn,$sql);
		while($row=pg_fetch_array($query))
		{
			$machuyen_tmp=$row["machuyen"];
			if($machuyen_tmp==$machuyen)continue;
		 ?>
		 <option value="<?php echo $machuyen_tmp; ?>"><?php echo $machuyen_tmp; ?></option>
		 <?php } ?>
	</select>
	<br>
	Ngày Đi <input type="date" name="ngaydi" value=<?php echo date("Y-m-d"); ?>>
	<br>
	<br>
	Ga Đi
	<?php
	$sql="select maga from gadung where machuyen='".$machuyen."' order by sttdung";
	$query=pg_query($conn,$sql);
	 ?>
	 <select name="magadi" id="2">
	 	<?php
	 	while($row=pg_fetch_array($query))
	 	{
	 	 ?>
	 	 <option value="<?php echo $row["maga"]; ?>"><?php echo get_name_ga($row["maga"],$conn); ?></option>
	 	 <?php } ?>
	 	 <option value="<?php echo $magacuoi; ?>"><?php echo get_name_ga($magacuoi,$conn); ?></option>
	 </select>
	 Ga Đến
	<?php
	$sql="select maga from gadung where machuyen='".$machuyen."' order by sttdung desc;";
	$query=pg_query($conn,$sql);
	 ?>
	 <select name="magaden" id="2">
	 	<?php
	 	while($row=pg_fetch_array($query))
	 	{
	 	 ?>
	 	 <option value="<?php echo $row["maga"]; ?>"><?php echo get_name_ga($row["maga"],$conn); ?></option>
	 	 <?php } ?>
	 </select>
	 <p>
	 	<input type="submit" name="btn_search" value="Tìm Kiếm">
	 </p>
</form>

<h3> Giá Vé </h3>
 	<table class="table table-hover">
 		<thead>
 			<tr>
 				<th></th>
 				<th>Loại Chỗ</th>
 				<th>Giá Vé</th>
 				<th>Đơn vị</th>
 			</tr>
 		</thead>
 		<tbody>
 			<?php
 			$query=pg_query($conn,$sql3);
 			while($row=pg_fetch_array($query))
 			{
 				$maloaitoa=$row["maloaitoa"];$tenloaitoa=$row["tenloaitoa"];
 			 ?>
 			 <tr>
 			 	<td><?php echo $maloaitoa; ?></td>
 			 	<td><?php echo $tenloaitoa; ?></td>
 			 	<td><?php echo gianiemyet($conn,$machuyen,$magadi,$magaden,$maloaitoa); ?></td>
 			 	<td>đồng</td>
 			 </tr>
 			 <?php } ?>
 		</tbody>
 	</table>
</div>
</html>
<?php
function gianiemyet($conn,$machuyen,$magadi,$magaden,$maloaitoa)
{
	$sql="select heso from loaitoa where maloaitoa='".$maloaitoa."'";
	$query=pg_query($conn,$sql);
	$row=pg_fetch_array($query);
	$heso=$row["heso"];
	$sql="select giatien from gianiemyet where machuyen='".$machuyen."' and maga='".$magadi."'";
	$query=pg_query($conn,$sql);
	$row=pg_fetch_array($query);
	$gia_gadi=$row["giatien"];
	$sql="select giatien from gianiemyet where machuyen='".$machuyen."' and maga='".$magaden."'";
	$query=pg_query($conn,$sql);
	$row=pg_fetch_array($query);
	$gia_gaden=$row["giatien"];
	$kq=$heso*($gia_gaden-$gia_gadi);
	echo $kq;
}
 ?>