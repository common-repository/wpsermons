<?php
global $wpdb;
$table_name = $wpdb->prefix."wpsermons";
	
	function checkpostdata($data){
		if(get_magic_quotes_gpc()){
			return $data;
			}
		else{
			return addslashes($data);
			}
	}
?>
<script type="text/javascript" language="javascript">
<!--
function uploadjs(){
var title = document.uploadform.title.value;
var speaker = document.uploadform.speaker.value;
var date = document.uploadform.date.value;

if(title=="" || speaker=="" || date==""){
document.uploadform.uploadsubmit.disabled=true;
}
else{
document.uploadform.uploadsubmit.disabled=false;
}
}
-->
</script>

<style type="text/css">
<!--
button{
	background: #f4f4f4;
	border: 1px solid #b2b2b2;
	color: #000;
	font:  13px Verdana, Arial, Helvetica, sans-serif;
	margin: 1px;
	padding: 3px;
}
.error, #message{
margin: 0 0 25px 0;
}
.instructions{
background: #f0f0f0;
border: 2px solid #999;
padding: 5px;
}
-->
</style>

<?php
if(isset($_GET['state']) && isset($_GET['id']) && $_GET['state']=="edit"){
?>
<div class="wrap">
<h2>Edit Sermon</h2>
<?php
$editquery = "SELECT title,speaker,date,notes from ".$table_name." where id=".$_GET['id'];
$result = $wpdb->query($editquery) or die("There was an error retrieving the data. Please try again.");
$title = $wpdb->get_var($editquery,0,0);
$speaker = $wpdb->get_var($editquery,1,0);
$date = $wpdb->get_var($editquery,2,0);
$date = date("m/d/Y", strtotime($date));
$notes = $wpdb->get_var($editquery,3,0);
?>
<form action="<?=$_SERVER['PHP_SELF']?>?page=wpsermons/managesermons.php" method="post">
<table>
			 <tr>
			 		 <td width="140"><strong>Sermon Title:</strong></td>
					 <td width="270"><input type="text" name="title" value="<?=$title?>" maxlength="50" /></td>
			 </tr>
			 <tr>
			 		 <td><strong>Speaker's Name:</strong></td>
					 <td><input type="text" name="speaker" value="<?=$speaker?>" maxlength="30" /></td>
			 </tr>
			 <tr>
			 		 <td><strong>Date (of sermon):</strong></td>
					 <td><input type="text" name="date" value="<?=$date?>" /> <strong>mm/dd/yyyy</strong></td>
			 </tr>
			 <tr>
			 		 <td><strong>Notes:</strong></td>
					 <td><textarea name="notes" cols="25" rows="5"><?=$notes?></textarea></td>
			 </tr>
			 <tr>
			 		 <td><input type="hidden" name="id" value="<?=$_GET['id']?>" /></td>
					 <td><input type="submit" name="editsubmit" value="Edit" /></td>
			 </tr>
</table>
</form>
</div>
<?php
}
if(isset($_GET['state']) && isset($_GET['id']) && $_GET['state']=="delete"){
?>
<div class="wrap">
<h2>Delete Sermon</h2>
<?php
$deletequery = "SELECT title,speaker,date,filepath from ".$table_name." where id=".$_GET['id'];
$result = $wpdb->query($deletequery) or die("There was an error retrieving the data. Please try again.");
$title = $wpdb->get_var($deletequery,0,0);
$speaker = $wpdb->get_var($deletequery,1,0);
$date = $wpdb->get_var($deletequery,2,0);
$date = date("m/d/Y", strtotime($date));
$filepath = $wpdb->get_var($deletequery,3,0);
?>
<p>You are about to delete this sermon:</p>
<p><strong>Title:</strong> <?=$title?><br />
<strong>Speaker:</strong> <?=$speaker?><br />
<strong>Date:</strong> <?=$date?></p>

<form action="<?=$_SERVER['PHP_SELF']?>?page=wpsermons/managesermons.php" method="post">
<input type="hidden" name="id" value="<?=$_GET['id']?>" />
<input type="hidden" name="filepath" value="<?=$filepath?>" />
<input type="submit" name="deletesubmit" value="Delete" /> 
<button onclick="window.location='<?=$_SERVER['PHP_SELF']?>?page=wpsermons/managesermons.php'">Cancel</button>
</form>

</div>
<?php }?>

<div class="wrap">
<?php 
if(isset($_POST['uploadsubmit'])){
	//process mp3 file
	$extension = strrchr($_FILES['sermon']['name'], ".");
	if($extension==".mp3"){
	$time = time();
	move_uploaded_file($_FILES['sermon']['tmp_name'],"../wp-content/plugins/wpsermons/uploads/".$time.".mp3") or die();
	
	//manage post data

	$title = checkpostdata($_POST['title']);
	$speaker = checkpostdata($_POST['speaker']);
	$date = date("Y-m-d",strtotime($_POST['date']));
	$filepath = $time;
		if(get_magic_quotes_gpc()){
		 $notes = htmlspecialchars($_POST['notes']);
		 }
		else{
		 $notes = addslashes(htmlspecialchars($_POST['notes']));
		 }
	$shown = $_POST['shown'];
		if($shown=="yes"){
		 $shown=1;
		}
		else{
		 $shown=0;
		}
	$insert = "INSERT INTO " . $table_name .
            " (title,speaker,date,filepath,notes,shown) " .
            "VALUES ('$title','$speaker','$date',$filepath,'$notes',$shown)";

  $results = $wpdb->query( $insert ) or die(mysql_error());
	
	echo "<div id='message' class='updated fade'><p>Upload Successful</p></div>\n";
	
	}
	else{
		echo "<div class='error'><p>Audio file must be in .mp3 format! That was a ".$extension." (".$_FILES['sermon']['type'].")</p></div>";
	}
}


if(isset($_POST['editsubmit'])){

$title = checkpostdata($_POST['title']);
$speaker = checkpostdata($_POST['speaker']);
$date = date("Y-m-d",strtotime($_POST['date']));
	if(get_magic_quotes_gpc()){
	 $notes = htmlspecialchars($_POST['notes']);
	 }
	else{
	 $notes = addslashes(htmlspecialchars($_POST['notes']));
	 }
$id = $_POST['id'];

$update = "UPDATE " . $table_name . " SET ".
            "title='$title', " .
						"speaker='$speaker', " .
            "date='$date', " .
            "notes='$notes' " .
            "WHERE id=$id";

  $results = $wpdb->query( $update ) or die(mysql_error());
	
	echo "<div id='message' class='updated fade'><p>Edit Successful</p></div>\n";
	
	 
}
if(isset($_POST['deletesubmit'])){

unlink("../wp-content/plugins/wpsermons/uploads/".$_POST['filepath'].".mp3");

$delete = "DELETE from ".$table_name." WHERE id=".$_POST['id'];

  $results = $wpdb->query( $delete ) or die(mysql_error());
	echo "<div id='message' class='updated fade'><p>Sermon Deleted</p></div>\n";
	

}

if(isset($_POST['viewsubmit'])){
$viewquery = "SELECT id from ".$table_name." ORDER BY date DESC";
$result = $wpdb->query( $viewquery );
$num = $wpdb->num_rows;

$y=0;
while($y<$num){
$id = $wpdb->get_var($viewquery,0,$y);
$checkbox = $_POST['s-'.$id];

if($checkbox == "yes"){
$newnum = 1;
} else{
$newnum = 0;
}
$wpdb->query("UPDATE ".$table_name." SET shown=".$newnum." WHERE id=".$id);

$y++;
}//end y while

echo "<div id='message' class='updated fade'><p>Sermons Shown Updated Successfully</p></div>\n";

}

?> 
<h2>Upload New Sermon</h2>

<form name="uploadform" action="<?=$_SERVER['PHP_SELF'].'?page=wpsermons/managesermons.php'?>" method="post" enctype="multipart/form-data">
<table>
			 <tr>
			 		 <td width="140"><strong>Sermon MP3:</strong></td>
					 <td width="270"><input type="file" name="sermon" /></td>
					 <td valign="top" rowspan="7">
					 		 <div class="instructions">
							 <h3>Upload Instructions</h3>
							 <ul>
							 		 <li>All fields are required with the exception of the <strong>Notes</strong> field.</li>
									 <li>Please enter a valid date in mm/dd/yyyy form or you could run into errors.</li>
									 <li>Please click the Upload button <strong>only once</strong> and wait for it to finish processing the upload. The MP3 file will most likely be a very large file and it will take some time to upload it depending on your connection speed. Please allow several minutes for upload to process.</li>
							 </ul>
							 </div>
					 </td>
			 </tr>
			 <tr>
			 		 <td><strong>Sermon Title:</strong></td>
					 <td><input type="text" name="title" maxlength="50" onkeyup="uploadjs()" /></td>
			 </tr>
			 <tr>
			 		 <td><strong>Speaker's Name:</strong></td>
					 <td><input type="text" name="speaker" maxlength="30" onkeyup="uploadjs()" /></td>
			 </tr>
			 <tr>
			 		 <td><strong>Date (of sermon):</strong></td>
					 <td><input type="text" name="date" onkeyup="uploadjs()" /> <strong>mm/dd/yyyy</strong></td>
			 </tr>
			 <tr>
			 		 <td><strong>Notes:</strong></td>
					 <td><textarea name="notes" cols="25" rows="5"></textarea></td>
			 </tr>
			 <tr>
			 		 <td><strong>Shown:</strong></td>
					 <td><input type="checkbox" name="shown" value="yes" checked="checked"/></td>
			 </tr>
			 <tr>
			 		 <td></td>
					 <td><input type="submit" name="uploadsubmit" value="Upload" disabled="disabled" onclick="document.getElementById('loader').innerHTML='<img src=../wp-content/plugins/wpsermons/loading.gif />Uploading... please wait'" />
					 		 <div id="loader"></div>
					 </td>
			 </tr>
</table>
</form>
</div>

<div class="wrap">

<h2>View/Edit/Delete Sermons</h2>
<?php
$query = "SELECT id,title,speaker,date,shown from ".$table_name." ORDER BY date DESC";
$result = $wpdb->query( $query );
$num = $wpdb->num_rows;
if($num==0){
echo "<p>No sermons uploaded yet.</p>";
}
else{
?>

<form action="<?=$_SERVER['PHP_SELF']?>?page=wpsermons/managesermons.php" method="post">

<table class="widefat">
	<thead>
	<tr>

	<th scope="col"><div style="text-align: center">ID</div></th>
	<th scope="col">Title</th>
	<th scope="col">Speaker</th>
	<th scope="col">Date</th>
	<th scope="col" colspan="2"><div style="text-align: center">Actions</div></th>
	<th scope="col">Shown</th>
	</tr>
	</thead>
	<tbody id="the-list">
<?php

$x=0;
$alternate="alternate";
while($x<$num){
$id = $wpdb->get_var($query,0,$x);
$title = $wpdb->get_var($query,1,$x);
$speaker = $wpdb->get_var($query,2,$x);
$date = $wpdb->get_var($query,3,$x);
$shown = $wpdb->get_var($query,4,$x);

echo "<tr id='sermon-$id' class='$alternate'>\n";
echo "<th scope='row' style='text-align: center;'>$id</th>\n";
echo "<td>$title</td>\n";
echo "<td>$speaker</td>\n";
echo "<td>$date</td>\n";
echo "<td><a href='".$_SERVER['PHP_SELF']."?page=wpsermons/managesermons.php&state=edit&id=$id' class='edit'>Edit</a></td>\n";
echo "<td><a href='".$_SERVER['PHP_SELF']."?page=wpsermons/managesermons.php&state=delete&id=$id' class='delete'>Delete</a></td>\n";
echo "<td><input type='checkbox' name='s-$id' value='yes'";
if ($shown==1) echo "checked='checked'";
echo " /></td>\n";
echo "</tr>\n";


$x++;
if($alternate=="alternate"){
$alternate="";
}
else{
$alternate="alternate";
}
}//end x while

?>
		
	</tbody>
</table>
<div style="text-align: right">
<input type="submit" name="viewsubmit" value="Update Sermons Shown" />
</div>
</form>
<?php }?>
</div>