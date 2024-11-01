<script language="JavaScript" type="text/javascript">
<!--
var ap_instances = new Array();

function ap_stopAll(playerID) {
	for(var i = 0;i<ap_instances.length;i++) {
		try {
			if(ap_instances[i] != playerID) document.getElementById("audioplayer" + ap_instances[i].toString()).SetVariable("closePlayer", 1);
			else document.getElementById("audioplayer" + ap_instances[i].toString()).SetVariable("closePlayer", 0);
		} catch( errorObject ) {
			// stop any errors
		}
	}
}

function ap_registerPlayers() {
	var objectID;
	var objectTags = document.getElementsByTagName("object");
	for(var i=0;i<objectTags.length;i++) {
		objectID = objectTags[i].id;
		if(objectID.indexOf("audioplayer") == 0) {
			ap_instances[i] = objectID.substring(11, objectID.length);
		}
	}
}

var ap_clearID = setInterval( ap_registerPlayers, 100 );

//-->
</script>

<?php

global $wpdb;
$table_name = $wpdb->prefix."wpsermons";
$siteurl = get_option('siteurl');

$query = "SELECT title,speaker,date,notes,filepath from ".$table_name." where shown=1 order by date desc";
$wpdb->query($query);
$num = $wpdb->num_rows;

if($num==0){
echo "<p>There are no sermons posted at this time. Please come back later.</p>";
}
else{
?>
<table width="100%">
<?
			 
$x=0;
while($x<$num){

$title = $wpdb->get_var($query,0,$x);
$speaker = $wpdb->get_var($query,1,$x);
$date = $wpdb->get_var($query,2,$x);
$date = date("m/d/Y", strtotime($date));
$notes = $wpdb->get_var($query,3,$x);
$filepath = $wpdb->get_var($query,4,$x);

			 echo "<tr>\n";
			 		 echo "<th><strong>$title</strong></th>\n";
					 echo "<th>$speaker</th>\n";
					 echo "<th>$date</th>\n";
					 echo "<th><a href='".$siteurl."/wp-content/plugins/wpsermons/uploads/".$filepath.".mp3'>Download</a></th>\n";
			 echo "</tr>\n";
			 
			 echo "<tr>\n";
			 		 echo "<td colspan='4'>\n";
					 echo "<object type='application/x-shockwave-flash' data='".$siteurl."/wp-content/plugins/wpsermons/player.swf' id='audioplayer".($x+1)."' height='24' width='290'><param name='movie' value='".$siteurl."/wp-content/plugins/wpsermons/player.swf'/><param name='FlashVars' value='playerID=".($x+1)."&amp;bg=0xf8f8f8&amp;leftbg=0xeeeeee&amp;lefticon=0x666666&amp;rightbg=0xcccccc&amp;rightbghover=0x999999&amp;righticon=0x666666&amp;righticonhover=0xffffff&amp;text=0x666666&amp;slider=0x666666&amp;track=0xFFFFFF&amp;border=0x666666&amp;loader=0x9FFFB8&amp;soundFile=".$siteurl."/wp-content/plugins/wpsermons/uploads/".$filepath.".mp3'/><param name='quality' value='high'/><param name='menu' value='false'/><param name='wmode' value='transparent'/></object><br />\n";
					 if($notes!="") echo "<strong>Notes:</strong> $notes\n";
					 echo "</td>\n";
			 		 echo "</tr>\n";

$x++;
}//end while
?>
</table>
<?
}//end else
?>