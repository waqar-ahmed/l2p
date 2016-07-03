<?php

namespace App\Http\Controllers;

/**
 * Description of SemesterController
 *
 * @author odgiiv
 */
class SemesterController extends L2pController {

    public function viewAllSemesters() {
        $semesters = array();
        $allCourses = $this->sendRequest(self::GET, 'viewAllCourseInfo');
        if($allCourses['Status']) {
            foreach($allCourses['dataSet'] as $course) {
                if(!in_array($course['semester'], $semesters)) {
                    array_push($semesters, $course['semester']);
                }
            }
        }
        $arr = array();
        $sortedSemesters = $this->sortSemesters($semesters);
        array_walk($sortedSemesters, function ($key, $semester) use (&$arr) {
            return $arr[] = array('sem'=>$key,'name'=>$semester);
        });
        return $this->jsonResponse(self::STATUS_TRUE, $arr);
    }

    public function _sortSemesters(Request $request) {
        return $this->sortSemesters(array_map('trim', explode(',', $request->input('semesters'))));
    }

    private function sortSemesters($semesters) {
        if(is_null($semesters)) {
            return nul;
        }
        $sortedSemesters = array();
        $this->sort($semesters, function ($val1, $val2) {
            if($val1 === $val2) {
                return 0;
            }
            if((int)substr($val1, 2) > (int)substr($val2, 2)) {
               return 1;
            } else if((int)substr($val1, 2) < (int)substr($val2, 2)) {
                return -1;
            } else {
                if('w' === substr($val1, 0, 1)) {
                    return 1;
                } else if('s' === substr($val1, 0, 1)) {
                    return -1;
                }
            }
        });
        foreach($semesters as $sem) {
            $fullText = $sem;
            switch (substr($sem, 0, 2)) {
                case 'ss':
                    $fullText = 'Summer semester ';
                    break;
                case 'ws':
                    $fullText = 'Winter semester ';
                    break;
            }
            if ($fullText != $sem) {
                $fullText .=  (2000 + (int)(substr($sem, 2)));
            }
            $sortedSemesters += array($fullText=>$sem);
        }
        return $sortedSemesters;
    }

    protected function sort(&$array, $compareFunc, $order='asc') {
        if(1 >= count($array)) {
            return $array;
        }
        foreach($array as $ind1=>$val1) {
            foreach ($array as $ind2=>$val2) {
                switch ($compareFunc($val1, $val2)){
                    case 1:
                        if('asc' === $order) {
                            $this->swap($ind1, $ind2, $array);
                        }
                        break;
                    case -1:
                        if('des'=== $order) {
                            $this->swap($ind1, $ind2, $array);
                        }
                        break;
                    case 0:
                        break;
                }
            }
        }
        return $array;
    }

    protected function swap($ind1, $ind2, &$array) {
        if(0 >= count($array) ||  $ind1 < 0 || $ind2 < 0 || $ind1 === $ind2
                || count($array) <= $ind1 || count($array) <= $ind2) {
            return $array; //FIXME: or throw exception
        }
        $temp = $array[$ind1];
        $array[$ind1] = $array[$ind2];
        $array[$ind2] = $temp;
    }
}
