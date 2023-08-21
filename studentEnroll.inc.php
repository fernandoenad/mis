	<?php
if(isset($_GET['showProfile'])) {
	$searchStudent = $_GET['showProfile'];
}
else{
	$searchStudent = "a";
}




	$result = dbquery("SELECT * FROM student WHERE stud_no='".$searchStudent."'");
	$rows = dbrows($result);
	$data = dbarray($result);

?>


		<div class="pagecontent container">
			<div class="page-header" style="margin-top: 20px">
				<h1>Enrollment</h1>
			</div>  
			
			
<div class="clearfix" style="margin-bottom: 5px;"></div>
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-default">
                
                <div class="panel-body">
					<div class="row-fluid">
						<h3>Enrollment (<?php echo $current_sem;?><sup><?php echo ($current_sem==1 ? "st" : "nd");?></sup> Semester, SY <?php echo $current_sy;?>-<?php echo $current_sy+1;?>)</h3>
						<?php
						$bar_signs = 0;
						$enrollment = 0;
						$remarks = 0;
						$status = 0;
						
						
						$resultRemarks = dbquery("SELECT * FROM studenroll WHERE enrol_stud_no='".$_GET['id']."' ORDER BY enrol_sy DESC");
						$dataRemarks = dbarray($resultRemarks);
						if($current_sy - $dataRemarks['enrol_sy'] != 1) { $bar_signs++; $enrollment++;}
						if($dataRemarks['enrol_remarks'] != "-") { $bar_signs++; $remarks++; }
						if($dataRemarks['enrol_status2'] != "PROMOTED") { $bar_signs++; $status++; }
						 
						if($bar_signs>0){ 
						?>
							<div class="jumbotron jumbotron-fluid">
							  <div class="container bg-danger">
								<h3 class="display-4 text-danger">Not qualified for online enrollment!</h3>
								You are not qualified for online enrollment due to the following reasons:
								<ol>
									<?php if($enrollment > 0) { ?>
									<li><?php echo "You are already enrolled or you have an enrollment gap."; ?> Click <a href="?page=student&showProfile=<?php echo $_GET['id'];?>&tab=schedule">here</a> for your class schedule.</li>
									<?php } ?>
									<?php if($remarks > 0) { ?>
									<li><?php echo "You have some invalidating remarks."; ?></li>
									<?php } ?>
									<?php if($status > 0) { ?>
									<li><?php echo "You have some issues with your enrollment status."; ?></li>
									<?php } ?>
								</ol>
								Please do the manual enrollment at the SANHS Campus in the Office of the School Registrar.
								<br>
								<br>
							  </div>
							</div>
						<?php								
						} else {
							?>
							<div class="jumbotron jumbotron-fluid">
							  <div class="container bg-success">
								<h3 class="display-4 text-success"><strong>Congratulations, you are eligible for online enrollment!</strong></h3>
								
								<?php
								$newlevel = $dataRemarks['enrol_level']+1;
								if($newlevel==8 || $newlevel==10 || $newlevel==12){ 
									$resultNewSection = dbquery("SELECT * FROM proposedsection WHERE prop_lrn='".$_GET['id']."' AND prop_sy='".$current_sy."'");
									$dataNewSection = dbarray($resultNewSection);
									?>
									<p>You are pre-assigned to <strong>Grade <?php echo $newlevel;?></strong>, <strong>Section <?php echo $dataNewSection['prop_section'];?></strong>! 
									<br>If you wish you enroll in an online class or transfer to another section, please do the manual enrollment at the SANHS Campus in the Office of the School Registrar, otherwise,
									click the <strong>Enroll</strong> button to proceed.<p/>
									<p class="lead">
										<a class="btn btn-success btn-lg" href="#" role="button">Enroll</a>
									</p>
								<?php
								} else if($newlevel==9 || $newlevel==11){ 
									$resultNewSection = dbquery("SELECT * FROM proposedsection WHERE prop_lrn='".$_GET['id']."' AND prop_sy='".$current_sy."'");
									$dataNewSection = dbarray($resultNewSection);
									?>
									<p>You are pre-assigned to <strong>Grade <?php echo $newlevel;?></strong>, <strong>Section <?php echo $dataNewSection['prop_section'];?></strong>! <br>Click the enroll button to proceed.<p/>
									<p class="lead">
										<a class="btn btn-success btn-lg" href="#" role="button">Enroll</a>
									</p>
								<?php
								}
								?>
							  </div>
							</div>
							<?php
						}
						?>

					</div>
            </div>
        </div>
    </div>



              </div>
            </div>
          </div>
        </div>
<?php
if(isset($_GET['status']) && $_GET['status']=="successful")	{
?>	
	<script>
		alert('Image was uploaded successfully!');
	</script>		
<?php
} 
else if(isset($_GET['status']) && $_GET['status']=="failed")	{
?>
	<script>
		alert('An error was encountered!');
	</script>	
<?php
}
?>