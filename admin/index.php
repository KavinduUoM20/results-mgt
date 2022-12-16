<?php
session_start();
if (isset($_SESSION["login"])) {
	if ($_SESSION["login"] != "7893login") {
		header("Location: login.php");
	}
}else{
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Resultsult Uploading Dashboard</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
    	body{
    		background: linear-gradient(to right, #2102ae, #e83a99);
    		margin: 0;
    	}
    	.content{
    		background: #fff;
    		width: 100%;
    		margin-top:10%;
    		/*padding: 20px;*/
    		border-radius: 15px;
    		overflow: hidden;
    		padding-bottom: 20px;
    	}
    	#up{
    		cursor: pointer;
    		border: 1px dashed #BBB;
		  	text-align: center;
		  	background-color: #DDD;
		  	cursor: pointer;
		  	width: 100%;
    	}
    	h2{
    		background: #a005e8;
    		padding: 20px;
    		color: #ffd;
    	}
    	.out{
    		position: fixed;
    		right: 40px;
    		top: 20px;
    	}
    </style>
</head>
<body>
	<div class="out">
		<a href="lg.php?out=234" style="color: #fff;">log out</a>
	</div>
	<div class="container" style="overflow: auto;">
		<div class="col-12">
			<div class="content">
				<div class="col-12">
					<div class="row">
						<div class="h2 col-12" style="padding: 0;border-radius: 15px;">
							<h2 style="text-align: center;">Upload Results (xls files only)</h2>
						</div>
					</div>
					<div class="row">
						<div class="col-12" style="overflow: auto;">
							<table class="table table-bordered text-center mt-4">
								<tr>
									<td colspan="15"><a href="sample/sample.xls">Click here to download sample xls file</a></td>
								</tr>
								<tr>
									<td colspan="15">Column order</td>
								</tr>
								<tr>
									<td>Index No</td>
									<td>Name</td>
									<td>Class</td>
									<td>Sinhala</td>
									<td>Buddhism</td>
									<td>Maths</td>
									<td>Science</td>
									<td>English</td>
									<td>History</td>
									<td>Bucket 1</td>
									<td>sid</td>
									<td>Bucket 2</td>
									<td>sid</td>
									<td>Bucket 3</td>
									<td>sid</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-12 d-flex justify-content-center mt-3">
							<form action="uploading.php" enctype="multipart/form-data" method="POST"> <!--action="uploading.php" enctype="multipart/form-data" method="POST"-->
							  <div class="row">
							    <div class="col-12 col-md-4 mb-2" style="padding: 0;">
							      <select name="class"  class="form-control"  required>
									<option value="C1">Class A</option>
									<option value="C2">Class B</option>
									<option value="C3">Class C</option>
									<option value="C4">Class D</option>
									<option value="C5">Class E</option>
									<option value="C6">Class F</option>
									<option value="C7">Class G</option>
								  </select>
							    </div>
							    <div class="col-12 col-md-4 mb-2" style="width: 260px;">
							      <input type="file" id="default" required name="sheet" onchange="get(this)" style="display: none;" accept=".xls">
							      <div id="up" class="form-control" onclick="select()">Select file</div>
							    </div>
							    <div class="col-12 col-md-4 mb-2" style="padding: 0;text-align: center;width: 100%;">
							      <button type="submit" class="btn btn-primary">Upload</button>
							    </div>
							  </div>
							</form>
						</div>
					</div>
					<div class="row">
						<div class="col-12 mt-4">
							<h3 style="text-align: center;">Subject Codes</h3>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-4" style="overflow: auto;">
							<table class="table table-bordered text-center mt-4">
								<thead class="thead-dark">
									<tr>
										<th colspan="15">Bucket subjects set 1</th>
									</tr>
								</thead>
								<tr>
									<td>Geo</td>
									<td>Geography</td>
								</tr>
								<tr>
									<td>Com</td>
									<td>Business & Accounting Studies</td>
								</tr>
								<tr>
									<td>Tam</td>
									<td>Tamil</td>
								</tr>
								<tr>
									<td>Cit</td>
									<td>Civic Education</td>
								</tr>
								<tr>
									<td>Eunt</td>
									<td>Entrepreneurship Studies</td>
								</tr>
							</table>
						</div>
						<div class="col-4" style="overflow: auto;">
							<table class="table table-bordered text-center mt-4">
								<thead class="thead-dark">
									<tr>
										<th colspan="15">Bucket subjects set 2</th>
									</tr>
								</thead>
								<tr>
									<td>Mus</td>
									<td>Music</td>
								</tr>
								<tr>
									<td>Art</td>
									<td>Art</td>
								</tr>
								<tr>
									<td>Dan</td>
									<td>Dancing</td>
								</tr>
								<tr>
									<td>Dra</td>
									<td>Drama and Theatre</td>
								</tr>
								<tr>
									<td>S.LIT</td>
									<td>Sinhala Literary</td>
								</tr>
								<tr>
									<td>LIT</td>
									<td>English Literary</td>
								</tr>
							</table>
						</div>
						<div class="col-4" style="overflow: auto;">
							<table class="table table-bordered text-center mt-4">
								<thead class="thead-dark">
									<tr>
										<th colspan="15">Bucket subjects set 3</th>
									</tr>
								</thead>
								<tr>
									<td>IT</td>
									<td>Information & Communication Technology</td>
								</tr>
								<tr>
									<td>Hea</td>
									<td>Health & Physical Education</td>
								</tr>
								<tr>
									<td>Craft</td>
									<td>Arts & Crafts</td>
								</tr>
								<tr>
									<td>Agr</td>
									<td>Agriculture & Food Technology</td>
								</tr>
								<tr>
									<td>Hom</td>
									<td>home science</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<footer>
		<p style="text-align: center;bottom: 5px;padding: 20px;color: #fff;">Powerd by <a href="http://otomate.lk/" target="_blank" style="color: #eec9ff">otomate.lk</a></p>
	</footer>
	<script>
		function select(){
			document.getElementById("default").click();
		}
		function get(obj) {
		  var file = obj.value;
		  var fileName = file.split("\\");
		  document.getElementById("up").innerHTML = fileName[fileName.length -1];
		  
		}
	</script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>