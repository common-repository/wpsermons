<?php

$wpsermons_version = "0.8.2";

function wpsermons_installsql () {
   global $wpdb;
   global $wpsermons_version;

   $table_name = $wpdb->prefix . "wpsermons";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
      
      $sql = "CREATE TABLE " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
		title varchar(50),
		speaker varchar(35),
		date date,
		filepath varchar(20),
		notes text,
		shown bool,
	  UNIQUE KEY id (id)
	);";

      require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
      dbDelta($sql);

      update_option("wpsermons_version", $wpsermons_version);

   }
}

?>