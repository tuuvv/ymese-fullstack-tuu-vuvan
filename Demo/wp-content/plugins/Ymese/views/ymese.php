<h1> Automation unit test . Generation blog single page and convert to pdf</h1>
<!-- Bootstrap CDN -->

<script src='http://internationalsamuel.com/wp-includes/js/jquery/jquery.min.js?ver=3.6.0' id='jquery-core-js'></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
 <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

 <?php
error_reporting(E_ERROR | E_PARSE);
    global  $wpdb;
    $table = $wpdb->prefix.'ymese_pdf';
    $querystr  = "SELECT * FROM  $table ";
    $datas = $wpdb->get_results($querystr, OBJECT);

?>
<style>
 .example {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }
  
  .example td, .example th {
    border: 1px solid #98b0b3;
    padding: 8px;
  }
  
  .example tr:nth-child(even){background-color: #d7f2f5;}
  
  .example tr:hover {background-color: #bef3f7;}
  
  .example th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4d7b80;
    color: white;
  }
  p a{
    text-decoration: none; 
  }
</style>
<td><a href="javascript:void(0)" data-id="<?php echo $item->id; ?>" class="btn btn-success runcp">Generation blog</a></td>
<table id="example" class="wp-list-table example">
<thead>
    <tr>
        <th>Name</th>
        <th>Create Date</th>
        <th>DownLoad Link</th>
      
    </tr>
</thead>
<tbody>
    <?php foreach($datas as $item): ?>
    <tr>
        <td><?php echo $item->nameissue;?></td>
        <td><?php echo $item->dateCreated	;?></td>
        
        <td><a href="<?php echo $item->urlpdf; ?>" target="_blank" class="none"><?php echo $item->nameissue;?></a></td>
    </tr>
    <?php endforeach;?>
    </tbody>
</table>
<!--///////////////////////////////////////////////////////-->
  <script>
jQuery(document).ready(function() {
      
   
    jQuery('#example').DataTable( {
      
        } );
    
   /////////////////////// chức năng spin lại post lỗi ////////////////////////////////////
   jQuery(document).on("click", ".runcp", function(){
     console.log("chạy cào");
       var postdata = "action=runcp" ;
       jQuery.post(ajaxurl, postdata, function(response) {
            
            console.log(response);
            setTimeout(function() {
                location.reload();
            }, 1300);
         });
       
      });
    
})
    
  </script>