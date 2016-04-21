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
    
    public function viewAllCourseEvents($sem=Null, $cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllCourseEvents', ['cid'=>$cid]);
    }
    
    public function viewAllCourseInfoBySemester($sem=Null, $cid){
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllCourseInfoBySemester', ['semester'=>$sem]);
    }
    
    public function viewAllAnouncementCount($sem=Null, $cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllAnnouncementCount', ['cid'=>$cid]);
    }
    
    public function viewAllAnouncements($sem=Null, $cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllAnnouncements', ['cid'=>$cid]);
    }
    
    public function viewActiveFeatures($sem=Null, $cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewActiveFeatures', ['cid'=>$cid]);
    }
    
    public function viewAllAssignments($sem=Null, $cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllAssignments', ['cid'=>$cid]);
    }
    
    public function viewAllCounts($sem=Null, $cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllCounts', ['cid'=>$cid]);
    }       
    
    public function viewAllDiscussionItemCount($sem=Null, $cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllDiscussionItemCount', ['cid'=>$cid]);
    }       
    
    public function viewAllDiscussionItems($sem=Null, $cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllDiscussionItems', ['cid'=>$cid]);
    }       
    
    public function viewAllDiscussionRootItems($sem=Null, $cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllDiscussionRootItems', ['cid'=>$cid]);
    }       
    
    public function viewAllEmails($sem=Null, $cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllEmails', ['cid'=>$cid]);
    }       
    
    public function viewAllHyperlinkCount($sem=Null, $cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllHyperlinkCount', ['cid'=>$cid]);
    }       
    
    public function viewAllHyperlinks($sem=Null, $cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllHyperlinks', ['cid'=>$cid]);
    }       
    
    public function viewAllLearningMaterials($sem=Null, $cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllLearningMaterials', ['cid'=>$cid]);
    }       
    
    public function viewAllLearningObjects($sem=Null, $cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllLearningObjects', ['cid'=>$cid]);
    }   
    
    public function viewAllLiteratures($sem=Null, $cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllLiterature', ['cid'=>$cid]);
    }   
    
    public function viewAllLiteraturesCount($sem=Null, $cid) {
        return $this->courseManager->sendRestRequest(self::GET, 'viewAllLiteratureCount', ['cid'=>$cid]);
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
