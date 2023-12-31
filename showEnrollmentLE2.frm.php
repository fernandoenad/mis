<?php
session_start();
require ('maincore.php');
?>
<!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">School Enrollment Summary - Late Enrollees (2<sup>nd</sup> Sem, SHS)</h4>
      </div>
      <div class="modal-body">
		<div class="card-body">
				<table class="table table-condensed">
					<thead>
						<th style="width:50px">Level</th>
						<th style="width:150px">Section</th>
						<th class="text-center">Male</th>
						<th class="text-center">Female</th>
						<th class="text-center">Total</th>
					</thead>
					<tbody>
					<?php
					$totalMale=0;
					$totalFemale=0;
					$checkClasses= dbquery("SELECT * FROM section WHERE (section_sy='".$_GET['enrol_sy']."' and section_level>10)ORDER BY section_level ASC, section_name ASC");
					while($dataClasses = dbarray($checkClasses)){
					if(substr($dataClasses['section_name'],0,2)!="Z_"){
					?>
					<tr>
						<td><?php echo $dataClasses['section_level'];?></td>
						<td><a href="" onclick="window.open('classList2.php?enrol_sy=<?php echo $_GET['enrol_sy'];?>&classProfile=<?php echo $dataClasses['section_name'];?>&status=late2', '', 'width=800, height=600'); return false;"><?php echo $dataClasses['section_name'];?></a></td>
						<?php
						$checkLateDates = dbquery("select * from settings where settings_sy='".$_GET['enrol_sy']."'");
						$dataLateDates = dbarray($checkLateDates);
						$checkMale = dbquery("SELECT * FROM studenroll INNER JOIN student ON enrol_stud_no=stud_no WHERE (enrol_sy='".$dataLateDates['settings_sy']."' AND studenroll.enrol_admitdate2>'".$dataLateDates['settings_late2']."' AND enrol_section='".$dataClasses['section_name']."' AND stud_gender='MALE')");
						$countMale = dbrows($checkMale);
						$totalMale += $countMale;
						?>
						<td align="center"><?php echo $countMale;?></td>
						<?php
						$checkFemale = dbquery("SELECT * FROM studenroll INNER JOIN student ON enrol_stud_no=stud_no WHERE (enrol_sy='".$dataLateDates['settings_sy']."' AND studenroll.enrol_admitdate2>'".$dataLateDates['settings_late2']."' AND enrol_section='".$dataClasses['section_name']."' AND stud_gender='FEMALE')");
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
						<td align="right"><b><a href="" onclick="window.open('classList3.php?enrol_sy=<?php echo $_GET['enrol_sy'];?>&status=late2', '', 'width=850, height=600'); return false;">TOTAL</a></td>
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
