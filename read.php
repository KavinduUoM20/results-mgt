<?php
require 'admin/db.php';

function gra($m) {
  if ($m >= 75) {
  	$gr = "A";
  }elseif ($m >= 65) {
  	$gr = "B";
  }elseif ($m >= 50) {
  	$gr = "C";
  }elseif ($m >= 35) {
  	$gr = "S";
  }else{
  	$gr = "F";
  }
  return $gr;
}

$id = $_GET['id']; //$sql_q = "select * from student where `index` = '22762'";
$sql_q = "select student.*, class.class from student left join class on
student.class_cid = class.cid where student.index = '$id'"; 
$result = mysqli_query($con, $sql_q); 
if (mysqli_num_rows($result) == 0) {
	echo "<div class='resdetails' style='color:##566573  ;text-align:center;'>This index number is not valid.</div>";
}else{
	$row = mysqli_fetch_array($result); 
	$index = $row['index'];$name = $row['name'];$class = $row['class'];$total =$row['total'];$avg = $row['avg'];$place = $row['place'];

	//echo "Index : $index <br> Name : $name <br> Class : $class <br> Total : $total <br>Average : $avg <br> place : $place<br><br>";

	$sql_q = "select report.*, subject.subject from report left join subject on report.subject_subid = subject.subid where report.student_index = '$id'";

	$result = mysqli_query($con, $sql_q);
	$marks = array();
	$subject = array();
	$run = 0;
	if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_array($result)) {
		$marks[$run] = $row['mark'];
		$subject[$run] = $row['subject'];
		$run++;
	}
	}

	$sql = "select student.index,student.total from student";
	$result = mysqli_query($con, $sql);
	$mark = array();
	if (mysqli_num_rows($result) > 0) {
		$run = 0;
		while($row = mysqli_fetch_array($result)) {
			$mark[$row["index"]] = $row["total"];
		}
	}
	arsort($mark);// It orders high to low by value. You could avoid this with a simple ORDER BY clause in SQL.

	$result = array();
	$pos = $real_pos = 0;
	$prev_score = -1;
	foreach ($mark as $exam_n => $score) {
	    $real_pos += 1;// Natural position.
	    $pos = ($prev_score != $score) ? $real_pos : $pos;// If I have same score, I have same position in ranking, otherwise, natural position.
	    $result[$exam_n] = array(
	                     "score" => $score, 
	                     "position" => $pos, 
	                     "exam_no" => $exam_n
	                     );
	    $prev_score = $score;// update last score.
	}
	$gr = $result[$id]["position"];


	echo '<center>
	        <div style="padding: 20px;">
	            <h5 style="color: #CD0B0B ;">2<sup>nd</sup> Term Test - Grade 11</h5>
	        </div>
	    </center>
		<div class="row" id="resinner">
			<div class="col-lg-6">
		        <table>
		            <tr>
		                <td>Examination </td>
		                <td style="padding-left:20px;padding-right:5px;">-</td>
		                <td>
		                    <div class="resdetails">2<SUP>nd</SUP> Term Test</div>
		                </td>
		            </tr>
		            <tr>
		                <td>Duration </td>
		                <td style="padding-left:20px;padding-right:5px;">-</td>
		                <td>
		                    <div class="resdetails">21 To 26 September</div>  
		                </td>
		            </tr>
		            <tr>
		                <td>Index No </td>
		                <td style="padding-left:20px;padding-right:5px;">-</td>
		                <td>
		                    <div class="resdetails">'.$index.'</div>   
		                </td>
		            </tr>
		            <tr>
		                <td>Name </td>
		                <td style="padding-left:20px;padding-right:5px;">-</td>
		                <td>
		                    <div class="resdetails">'.$name.'</div>   
		                </td>
		            </tr>
		            <tr>
		                <td>Total </td>
		                <td style="padding-left:20px;padding-right:5px;">-</td>
		                <td>
		                    <div class="resdetails">'.$total.'</div>   
		                </td>
		            </tr>
		            <tr>
		                <td>Average </td>
		                <td style="padding-left:20px;padding-right:5px;">-</td>
		                <td>
		                    <div class="resdetails">'.$avg.'</div>   
		                </td>
		            </tr>
		            <tr>
		                <td>Class </td>
		                <td style="padding-left:20px;padding-right:5px;">-</td>
		                <td>
		                    <div class="resdetails">11-'.$class.'</div>   
		                </td>
		            </tr>
		            <tr>
		                <td>Class Rank </td>
		                <td style="padding-left:20px;padding-right:5px;">-</td>
		                <td>
		                    <div class="resdetails">'.$place.'</div>   
		                </td>
		            </tr>
		            <tr>
		                <td>Grade Rank </td>
		                <td style="padding-left:20px;padding-right:5px;">-</td>
		                <td>
		                    <div class="resdetails">'.$gr.'</div>   
		                </td>
		            </tr>
		        </table>
		    </div>
		    <div class="col-lg-6">
		        <table>
		            <tr>
		                <td><b>'.$subject[0].'</b></td>
		                <td>
		                    <div class="resicon">'.gra($marks[0]).'</div>
		                </td>
		                <td>
		                	<!--div class=""> ('.$marks[0].')</div-->
		                </td>
		            </tr>
		            <tr>
		                <td><b>'.$subject[1].'</b></td>
		                <td>
		                    <div class="resicon">'.gra($marks[1]).'</div>
		                </td>
		                <td>
		                	<!--div class=""> ('.$marks[1].')</div-->
		                </td>
		            </tr>
		            <tr>
		                <td><b>'.$subject[2].'</b></td>
		                <td>
		                    <div class="resicon">'.gra($marks[2]).'</div>
		                </td>
		                <td>
		                	<!--div class=""> ('.$marks[2].')</div-->
		                </td>
		            </tr>
		            <tr>
		                <td><b>'.$subject[3].'</b></td>
		                <td>
		                    <div class="resicon">'.gra($marks[3]).'</div>
		                </td>
		                <td>
		                	<!--div class=""> ('.$marks[3].')</div-->
		                </td>
		            </tr>
		            <tr>
		                <td><b>'.$subject[4].'</b></td>
		                <td>
		                    <div class="resicon">'.gra($marks[4]).'</div>
		                </td>
		                <td>
		                	<!--div class=""> ('.$marks[4].')</div-->
		                </td>
		            </tr>
		            <tr>
		                <td><b>'.$subject[5].'</b></td>
		                <td>
		                    <div class="resicon">'.gra($marks[5]).'</div>
		                </td>
		                <td>
		                	<!--div class=""> ('.$marks[5].')</div-->
		                </td>
		            </tr>
		            <tr>
		                <td><b>'.$subject[6].'</b></td>
		                <td>
		                    <div class="resicon">'.gra($marks[6]).'</div>
		                </td>
		                <td>
		                	<!--div class=""> ('.$marks[6].')</div-->
		                </td>
		            </tr>
		            <tr>
		                <td><b>'.$subject[7].'</b></td>
		                <td>
		                    <div class="resicon">'.gra($marks[7]).'</div>
		                </td>
		                <td>
		                	<!--div class=""> ('.$marks[7].')</div-->
		                </td>
		            </tr>
		            <tr>
		                <td><b>'.$subject[8].'</b></td>
		                <td>
		                    <div class="resicon">'.gra($marks[8]).'</div>
		                </td>
		                <td>
		                	<!--div class=""> ('.$marks[8].')</div-->
		                </td>
		            </tr>
		        </table>
	    	</div>
	    </div>';
	}
?>