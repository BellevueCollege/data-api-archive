<?php
  
namespace App\Http\Controllers;
  
use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
  
class CourseController extends ApiController{
  
    /** 
     Get all courses. This should probably never be used.
    **/
    public function index(){
  
        $courses  = Course::all();
        return $this->respond($courses);
 
    }
  
    /**
     Get a course based on a given CourseID
    **/
    public function getCourse($courseid){
  
        $course  = Course::where('CourseID', '=', $courseid)->first();
  
        return $this->respond($course);
    }
 
}
?>