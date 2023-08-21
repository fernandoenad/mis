<?php
require('maincore.php');
$checkStudent = dbquery("select * from student inner join studcontacts on stud_no = studCont_stud_no inner join studenroll on stud_no=enrol_stud_no where (stud_no='".$_GET['grade_stud_no']."' and enrol_sy='$current_sy')");
$dataStudent = dbarray($checkStudent);

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
	</head>
	  <body>
		<table width='100%' border='0' cellpadding="0" cellspacing="0">
			<tr>
				<td width='20%' align="center">
					<img src="./assets/images/students/<?php echo $_GET['grade_stud_no'];?>.jpg" alt="" style="max-width:143px" />
			    </td>
				<td align='center'>
					<font size="+1"><b>PARENT'S COMMUNICATION RECORD</b></font><BR><BR>
					<small>
					<table width="100%" border="0">
						<tr>
							<td width="20%">Name of Student: </td>
							<td><b><u><?php echo strtoupper($dataStudent['stud_lname'].", ".$dataStudent['stud_fname']." ".substr($dataStudent['stud_mname'],0,1).".");?></u></b></td>
							<td width="18%">Year & Section</td>
							<td><b><u><?php echo $dataStudent['enrol_level']." - ".$dataStudent['enrol_section'];?></u></b></td>
						</tr>
						<tr>
							<td>Address:</td>
							<td><b><u><small><small><small><?php echo $dataStudent['stud_residence'];?></small></small></small></u></b></td>
							<td>School Year</td>
							<td><b><u><?php echo $current_sy . "-" . ($current_sy + 1);?></u></b></td>
						</tr>
						<tr>
							<td>Father's Name</td>
							<td><b><u><?php echo $dataStudent['studCont_stud_flname'];?>, <?php echo $dataStudent['studCont_stud_ffname'];?></u></b></td>
							<td>Adviser</td>
							<td><b><u><?php echo "";?></u></b></td>
						</tr>
						<tr>
							<td>Mother's Name</td>
							<td><b><u><?php echo $dataStudent['studCont_stud_mlname'];?>, <?php echo $dataStudent['studCont_stud_mfname'];?></u></b></td>
							<td>Contact #</td>
							<td><b><u><?php echo $dataStudent['studCont_stud_gcontact'];?></u></b></td>
						</tr>
						<tr>
							<td>Guardian's Name</td>
							<td colspan="3"><b><u><?php echo $dataStudent['studCont_stud_glname'];?>, <?php echo $dataStudent['studCont_stud_gfname'];?></u></b></td>
						</tr>
					</table>
					</small>
				</td>
			</tr>
		</table><br>
		<table width='100%' border='1' cellpadding="0" cellspacing="0">
			<tr>
				<th width="8%">Quarter</th>
				<th width="13%">Date</th>
				<th>Activity</th>
				<th width="18%">Action Taken</th>
				<th width="13%">Signature</th>

			</tr>
			<tr height="700">
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>

			</tr>
		</table>
	 </body>
</html>