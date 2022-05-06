<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class clientApp extends Model
{
    
	use Sortable;


    protected $fillable = [ 'nameissue', 'created_at' ];


	public $sortable = ['id', 'nameissue', 'urlpdf', 'created_at','updated_at'];
}
