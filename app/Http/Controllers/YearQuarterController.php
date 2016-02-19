<?php
  
namespace App\Http\Controllers;
  
use App\Models\YearQuarter;
use App\Http\Transformers\YearQuarterTransformer;
use App\Http\Controllers\Controller;
use App\Http\Serializers\CustomDataArraySerializer;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use DB;

class YearQuarterController extends ApiController {
  
  const WRAPPER = "terms";
  
  /**
  * Return all YearQuarters
  **/
  public function index(){
  
        $yqrs  = YearQuarter::all();
        $collection = new Collection($yqrs, new YearQuarterTransformer);
        
        $fractal = new Manager;
        $data = $fractal->createData($collection)->toArray();
        
        return $this->respond($data);
 
    }
  
    /**
    * Get YearQuarter based on a given YearQuarterID
    **/
    public function getYearQuarter($yqrid){
  
        $yqr = YearQuarter::where('YearQuarterID', '=', $yqrid)->first();
  
        $item = new Item($yqr, new YearQuarterTransformer, self::WRAPPER);
        $fractal = new Manager;
        $fractal->setSerializer(new CustomDataArraySerializer);
        $data = $fractal->createData($item)->toArray();
        
        return $this->respond($data);
    }
    
    /**
    * Get current YearQuarter
    **/
    public function getCurrentYearQuarter() {
        $yqr = YearQuarter::current()->first();
        
        $item = new Item($yqr, new YearQuarterTransformer, self::WRAPPER);
        
        $fractal = new Manager;
        $fractal->setSerializer(new CustomDataArraySerializer);
        $data = $fractal->createData($item)->toArray();
        
        return $this->respond($data);
    }
    
    /**
    * Returns "active" YearQuarters
    **/
    public function getViewableYearQuarters() {

        //get max quarters to be shown
        $max_yqr = config('app.yearquarter_maxactive');
        $lookahead = config('app.yearquarter_lookahead');
        $timezone = new \DateTimeZone(config("app.timezone"));
                    
        //Create now date/time object
        $now = new \DateTime();
        $now->setTimezone($timezone);
        $now_string = $now->format("Y-m-d H:i:s");
        
        //Create lookahead date
        $la_date = $now->add(new \DateInterval('P'.$lookahead.'D'));
        $la_string = $la_date->format("Y-m-d H:i:s");
        
        //Use Eloquent query builder to query results
        //DB::connection('ods')->enableQueryLog();
        $yqrs = DB::connection('ods')
            ->table('vw_YearQuarter')
            ->join('vw_WebRegistrationSetting', 'vw_WebRegistrationSetting.YearQuarterID', '=', 'vw_YearQuarter.YearQuarterID')
            ->where(function ($query) { 
                $lookahead = config('app.yearquarter_lookahead');
                $timezone = new \DateTimeZone("America/Los_Angeles");
					        
	            //Create now date/time object
		        $now = new \DateTime();
		        $now->setTimezone($timezone);
                $now_string = $now->format("Y-m-d H:i:s");
                
                //Create lookahead date
                $la_date = $now->add(new \DateInterval('P'.$lookahead.'D'));
                $la_string = $la_date->format("Y-m-d H:i:s");
                
                $query->whereNotNull('vw_WebRegistrationSetting.FirstRegistrationDate')
                ->where('vw_WebRegistrationSetting.FirstRegistrationDate', '<=', $la_string )
                ->orWhere('vw_YearQuarter.LastClassDay', '<=', $now_string );
            })
            ->select('vw_YearQuarter.YearQuarterID', 'vw_YearQuarter.Title', 'vw_YearQuarter.FirstClassDay', 'vw_YearQuarter.LastClassDay', 'vw_YearQuarter.AcademicYear')
            ->orderBy('vw_YearQuarter.FirstClassDay', 'desc')
            ->take($max_yqr)
            ->get();
         //$queries = DB::connection('ods')->getQueryLog();
         //dd($queries);  

         //When using the Eloquent query builder, we must "hydrate" the results back to collection of objects
         $yqr_hydrated = YearQuarter::hydrate($yqrs);
         $collection = new Collection($yqr_hydrated, new YearQuarterTransformer, self::WRAPPER);
         
         //Set data serializer
         $fractal = new Manager;
         $fractal->setSerializer(new CustomDataArraySerializer);
         $data = $fractal->createData($collection)->toArray();

         return $this->respond($data);
    }

}
?>