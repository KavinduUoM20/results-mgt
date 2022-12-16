<style>
	table {
    	border-collapse: collapse;
    }  
	td{
		border:1px solid gray;
		padding: 0.2em 1em;
	}
</style>
<?php
ob_start();
$uploaddir = 'upload/';
$uploadfile = $uploaddir . basename($_FILES['sheet']['name']);
$cla = $_POST['class'];
//echo $cla."<br><br>";

echo '<pre>';
if (move_uploaded_file($_FILES['sheet']['tmp_name'], $uploadfile)) {
    echo "File is valid.\n\n\n";
} else {
    echo "Possible file upload attack!\n";
}

include 'library/reader.php';

require 'db.php';


$data = new Spreadsheet_Excel_Reader(); 

$data->read($uploadfile);
$vali_1 = array("index no","name","sin","bud","mat","sci","eng","his","1b","","2b","","3b","");
$col_lat = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O");
$sub_lib = array("sin" => 1,"bud" => 2,"mat" => 3,"sci" => 4,"eng" => 5,"his" => 6,
	"geo" => 7,"com" => 8,"tam" => 9,"cit" => 10,"eunt" => 11,
	"mus" => 12,"art" => 13,"dan" => 14,"dra" => 15,"s.lit" => 16,"lit" => 17,
	"it" => 18,"hea" => 19,"craft" => 20,"agr" => 21,"hom" =>22
	);

/* -------- Sheet validation ----------------------------------*/
$valid = false;
for ($i=1; $i <= 14 ; $i++) { 
	if (isset($data->sheets[0]['cells'][1][$i])) {
		$v = strtolower(trim($data->sheets[0]['cells'][1][$i]," "));
	}else{
		$v = "";
	}
	if ($v == $vali_1[$i-1]){
		$valid = true;
	}else{
		$valid = false;
		echo "Column ".$col_lat[$i-1]." is wrong !";	
		break;
	} 
}
echo "\n";
if ($valid) {
	for ($row=2; $row <= $data->sheets[0]['numRows']; $row++) { 
		if (array_key_exists(strtolower(trim($data->sheets[0]['cells'][$row][10]," ")), $sub_lib)) {
			if (array_key_exists(strtolower(trim($data->sheets[0]['cells'][$row][12]," ")), $sub_lib)) {
				if (array_key_exists(strtolower(trim($data->sheets[0]['cells'][$row][14]," ")), $sub_lib)) {
					$valid = true;
				}else{
					$valid = false;
					echo "Wrong Subject code in N".$row." ! <a href = 'index.php'>Click here to try again.</a><br>";
					break;
				}
			}else{
				$valid = false;
				echo "Wrong Subject code in L".$row." ! <a href = 'index.php'>Click here to try again.</a><br>";
				break;
			}
		}else{
			$valid = false;
			echo "Wrong Subject code in J".$row." ! <a href = 'index.php'>Click here to try again.</a><br>";
			break;
		}
	}
}else{
	echo "<br><br>Column order is wrong ! <a href = 'index.php'>Click here to try again.</a><br>";
}
/*  ----------------- end of sheet validation ------------------*/	

if ($valid){
    
	echo "<br><table>";

	for ($row=2; $row <= $data->sheets[0]['numRows']; $row++) { 
		$index = $data->sheets[0]['cells'][$row][1];
		$name = $data->sheets[0]['cells'][$row][2];
		$sql_1 = "INSERT INTO student(`index`,`name`,`class_cid`) VALUES('$index','$name','$cla')";
	    mysqli_query($con, $sql_1);
		//echo mysqli_error($con)."<br>";
		echo "<tr>";
		echo "<td>".$index."</td>";
		echo "<td>".$name."</td>";
		$total = 0;
		for ($i=3; $i <= 13 ; $i++) { 
			
			if ($i<9 && $i>=3) {
				$sid = ($i-2);
				$marks = trim($data->sheets[0]['cells'][$row][$i]," ");
				//echo "<td>".($i-3)." : ".$data->sheets[0]['cells'][$row][$i]."</td>";
			}else{
				if ($i == 10 || $i == 12 || $i == 14) {
					continue;
				}
				$sid = $sub_lib[strtolower(trim($data->sheets[0]['cells'][$row][$i+1]," "))];
				$marks = trim($data->sheets[0]['cells'][$row][$i]," ");
				//echo "<td>".$sub_lib[strtolower(trim($data->sheets[0]['cells'][$row][$i+1]," "))]." : " .$data->sheets[0]['cells'][$row][$i]."</td>";
			}
			$sql_2 = "INSERT INTO report(`student_index`,`subject_subid`,`mark`) VALUES('$index','$sid','$marks')";
			$total = $total + $marks;
			mysqli_query($con, $sql_2);
			echo "<td>".$sid." : ".$marks."</td>";
			
		}
		$avg = $total / 9;
		$avg = round($avg, 3);
		echo "<td>Total : ".$total."</td>";
		echo "<td>AVg : ".$avg."</td>";
		echo "</tr>";
		$sql_3 = "UPDATE student SET `total` = '$total',`avg` = '$avg' WHERE `index` = '$index'";
		mysqli_query($con, $sql_3);
	}
	echo "</table>";
	//$sql_3 = "INSERT INTO student(`index`,`name`,`class_cid`) VALUES('$index','$name','$cla')";
	$sql = "select * from student where `class_cid` = '$cla'";
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
	$result_1 = mysqli_query($con, $sql);
	if (mysqli_num_rows($result_1) > 0) {
		$run = 0;
		while($row = mysqli_fetch_array($result_1)) {
			$id = $result[$row["index"]]["exam_no"];
			$place = $result[$row["index"]]["position"];
			$sql_4 = "UPDATE student SET `place` = '$place' WHERE `index` = '$id'";
			mysqli_query($con, $sql_4);
		}
	}
    echo "<br><br><h2>File uploaded !<a href = 'index.php'> click here to go back</a></h2>";
	//header("Location: index.php");
}else{
	echo "<br><br>Uploading Fail !<br><br>";
}
?>