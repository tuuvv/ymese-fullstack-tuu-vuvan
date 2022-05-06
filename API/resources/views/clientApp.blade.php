<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client App</title>
</head>


<!-- Bootstrap CDN -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <?php
error_reporting(E_ERROR | E_PARSE);

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
  .example th a{
    text-decoration: none !important; 
    color: white  !important;
  }
</style>



<div class="container">
    <h3 class="text-center">App Client</h3>
    <table class="table table-bordered example">
        <tr>
            <?php //var_dump($all); die();
            
            ?>
            <th>@sortablelink('nameissue')</th>
            <th>@sortablelink('created_at')</th>
            <th>DownLoad Link</th>
        </tr>
        <?php if($all->count()):
            foreach($all as $key => $product):?>
                <tr>

                    <td>{{ $product->nameissue }}</td>
                    <td>{{ $product->created_at }}</td>
                    <td><a href="{{ $product->urlpdf }}" target="_blank" class="none">{{ $product->nameissue }}</a></td>
                   
                </tr>
           <?php endforeach;
        endif; ?>
    </table>
{{ $all->links()}}
</div>

<body>
    
</body>
</html>