<?php
//Table database create auto by active

 function DB_tb_create()
{
    global  $wpdb;

    //step1:
    $DBP_tb_name = $wpdb->prefix.'ymese_pdf';

    //step2:
    $DBP_query = "CREATE TABLE $DBP_tb_name(
        id int(110) NOT NULL AUTO_INCREMENT,
        nameissue varchar(255) DEFAULT '',
        urlpdf varchar(255) DEFAULT '',
        dateCreated datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
        )";
  //step 3:
    require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
    dbDelta($DBP_query);
}

?>