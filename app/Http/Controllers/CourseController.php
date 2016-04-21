<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseManager;

class CourseController extends Controller
{
    CONST GET = 'GET';    
    private $courseManager;

    function __construct()
    {
        $this->courseManager = new CourseManager();
    }   
    
    public function viewCourse($sem, $cid){
        return view('single_course', array('semester'=>$sem, 'cid'=>$cid));
    }
    
    public function viewAllCouseInfo(){
        $allCourses = $this->courseManager->sendRestRequest(self::GET, 'viewAllCourseInfo');
        return view('all_courses', array('all_courses' => $allCourses));
    }
    
    public function viewAllCourseInfoByCurrentSemester() {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllCourseInfoByCurrentSemester');
    }
    
    public function viewAllCourseEvents($sem, $cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllCourseEvents', ['cid'=>$cid]);
    }
    
    public function viewAllCourseInfoBySemester($sem, $cid){
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllCourseInfoBySemester', ['semester'=>$sem]);
    }
    
    public function viewAllAnnouncementCount($sem, $cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllAnnouncementCount', ['cid'=>$cid]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        echo "creat";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
