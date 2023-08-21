<?php
require('maincore.php');
require_once('BasicExcel/Reader.php');
\BasicExcel\Reader::registerAutoloader();


$resultSection = dbquery("SELECT * FROM section WHERE (section_name='".$_GET['classProfile']."' AND section_sy='".$_GET['enrol_sy']."')");
$dataSection = dbarray($resultSection);

if($dataSection['section_level']>10){
	if($_GET['term']=="grade_q1" || $_GET['term']=="grade_q2" || $_GET['term']=="grade_sem1"){
		$active_sem = 1;
	}
	else if($_GET['term']=="grade_q3" || $_GET['term']=="grade_q4" || $_GET['term']=="grade_sem2"){
		$active_sem = 2;
	}
	else{
		$active_sem = "";
	}
} else {
	$active_sem = 12;
}
	
$header = array('LRN', 'LEARNER\'S NAME Name)', 'Sex');
$checkCourses = dbquery("SELECT * FROM class INNER JOIN prospectus ON class.class_pros_no=prospectus.pros_no WHERE (class.class_sy='".$_GET['enrol_sy']."' AND class.class_section_no='".$dataSection['section_no']."' and class_sem='".$active_sem."') ORDER BY class_sem ASC, pros_sort ASC, pros_title ASC");

while($dataCourses = dbarray($checkCourses)){
    if(substr($dataCourses['pros_title'], 0, 3) == "***"){
	} else{
	    array_push($header, $dataCourses['pros_title']);
	}
}

$data=array($header);

$result= dbquery("SELECT * FROM studenroll INNER JOIN student on studenroll.enrol_stud_no=student.stud_no WHERE (studenroll.enrol_sy='".$_GET['enrol_sy']."' AND studenroll.enrol_section='".$_GET['classProfile']."') ORDER BY stud_gender ASC, stud_lname ASC, stud_fname ASC");

while($row = dbarray($result)){
	$stud_data = array($row['stud_lrn'], $row['stud_fname']." ".$row['stud_lname'], ucwords(strtolower($row['stud_gender'])));
	$gradedUnits1=0;
	$aveQ1=0;
	$grade=0;
	
	$resultGrade1 = dbquery("SELECT * FROM grade INNER JOIN class ON grade.grade_class_no=class.class_no INNER JOIN prospectus ON class.class_pros_no=prospectus.pros_no WHERE (grade.grade_stud_no='".$row['stud_no']."' AND class.class_sy='".$row['enrol_sy']."' and class_sem='".$active_sem."') ORDER BY class_sem ASC, pros_sort ASC, pros_title asc");

	while($dataGrade1 = dbarray($resultGrade1)){
	    if(substr($dataGrade1['pros_title'], 0, 3) == "***"){
	    } else{
    	    $countUnits+=$dataGrade1['pros_unit'];
    	    
    		if($_GET['term']=="grade_q1"){
    			$grade = $dataGrade1['grade_q1'];
    		} else if($_GET['term']=="grade_q2"){
    			$grade = $dataGrade1['grade_q2'];
    		} else if($_GET['term']=="grade_q3" && $dataSection['section_level']>10){
    			$grade = $dataGrade1['grade_q1'];
    		} else if($_GET['term']=="grade_q3"){
    			$grade = $dataGrade1['grade_q3'];
    		} else if($_GET['term']=="grade_q4" && $dataSection['section_level']>10){
    			$grade = $dataGrade1['grade_q2'];
    		} else if($_GET['term']=="grade_q4"){
    			$grade = $dataGrade1['grade_q4'];
    		} else{
    			$grade = $dataGrade1['grade_final'];
    		}

    	    array_push($stud_data, $grade);
	    }
	}	
    array_push($data, $stud_data);
}

try {
    $csvwriter = new \BasicExcel\Writer\Csv(); //or \Xls || \Xlsx
    $csvwriter->fromArray($data);
    //$csvwriter->writeFile('myfilename.csv');
    //OR
    $csvwriter->download($_GET['classProfile'].'.csv');
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}


