<?php
session_start();
require ('maincore.php');
?>
<!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">School Enrollment Summary - Senior HS (<?php echo $_GET['enrol_track'];?> Track) </h4>
      </div>
      <div class="modal-body">
		<div class="card-body">
				<table class="table table-condensed">
					<thead>
						<th style="width:50px">Level</th>
						<th style="width:150px">Strand</th>
						<th class="text-center">Male</th>
						<th class="text-center">Female</th>
						<th class="text-center">Total</th>
					</thead>
					<tbody>
					<?php
					$checkClasses= dbquery("SELECT * FROM studenroll WHERE (enrol_sy='".$_GET['enrol_sy']."' and enrol_level>'10' and enrol_track='".$_GET['enrol_track']."') group by enrol_strand, enrol_level ORDER BY enrol_level ASC");
					while($dataClasses = dbarray($checkClasses)){
					if(substr($dataClasses['section_name'],0,2)!="Z_"){
					?>
					<tr>
						<td><?php echo $dataClasses['enrol_level'];?></td>
						<td><?php echo $dataClasses['enrol_strand'];?></td>
						<?php
						$checkMale = dbquery("SELECT * FROM studenroll INNER JOIN student ON enrol_stud_no=stud_no WHERE (enrol_sy='".$_GET['enrol_sy']."' AND enrol_level='".$dataClasses['enrol_level']."' and enrol_strand='".$dataClasses['enrol_strand']."' AND stud_gender='MALE')");
						$countMale = dbrows($checkMale);
						$totalMale += $countMale;
						?>
						<td align="center"><?php echo $countMale;?></td>
						<?php
						$checkFemale = dbquery("SELECT * FROM studenroll INNER JOIN student ON enrol_stud_no=stud_no WHERE (enrol_sy='".$_GET['enrol_sy']."' AND enrol_level='".$dataClasses['enrol_level']."' and enrol_strand='".$dataClasses['enrol_strand']."' AND stud_gender='FEMALE')");
						$countFemale = dbrows($checkFemale);
						$totalFemale += $countFemale;
						?>
						<td align="center"><?php echo $countFemale;?></td>
						<td align="center"><?php echo $countMale+$countFemale;?></td>
					</tr>
					<?php		
					}
					}
					?>
					<tr align="center">
						<td></td>
						<td align="right"><b>TOTAL</a></td>
						<td><b><?php echo $totalMale;?></td>
						<td><b><?php echo $totalFemale;?></td>
						<td><b><?php echo $totalMale+$totalFemale;?></td>
					</tr>
					</tbody>
				</table>
		</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	  </form>
    </div>
