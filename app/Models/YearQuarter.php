<?php namespace App\Models;
  
use Illuminate\Database\Eloquent\Model;
  
class YearQuarter extends Model
{
    /**
    * Model for a YearQuarter, BC's version of a term.
    **/
     protected $table = 'vw_YearQuarter';
     protected $connection = 'ods';
     protected $primaryKey = null; //Lumen will convert the YearQuarterID value to an integer if we make it aware of it
     //protected $primaryKey = 'YearQuarterID';
}
?>