<?php
// Start the session
session_start();
require ('maincore.php');		

if($_SESSION["user_pass"]=="P@ssw0rd" || ($_SESSION["user_name"]=="sanhs.admin" && $_SESSION["user_pass"]=="09205001182")){
	header("Location: login2.php");
}
	
if(!isset($_SESSION["sanhsMIS_logged"])){
	header("Location: login.php?prev_url=".urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"));
}
else if(isset($_SESSION["sanhsMIS_logged"]) && $_SESSION["sanhsMIS_logged"]!=TRUE){
	header("Location: login.php?prev_url=".urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"));
}
else {
	$password = substr(md5($_SESSION["user_pass"]),0,50);
	$checkUser = dbquery("select * from users where (user_name='".$_SESSION["user_name"]."' AND user_pass='".$password."' AND user_status='1')");
	$rowLoginCheckUser= dbrows($checkUser);
	$checkStudent= dbquery("SELECT * FROM student WHERE (stud_lrn='".$_SESSION["user_name"]."' AND stud_password='".$password."' AND stud_status=1)");
	$rowLoginCheckStudent= dbrows($checkStudent);
	if ($rowLoginCheckUser > 0){}
	else if ($rowLoginCheckStudent > 0){}
	else {
		header("Location: login.php?prev_url=".urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"));
	}
	
}




if(isset($_GET['showProfile']) && isset($_SESSION["user_role"]) && $_SESSION["user_role"]==0 && $_SESSION["userid"]!=$_GET['showProfile']){
	header("Location: ./?page=student&showProfile=".$_SESSION['userid']."&tab=history");
} elseif(isset($_GET['id']) && isset($_SESSION["user_role"]) && $_SESSION["user_role"]==0 && $_SESSION["userid"]!=$_GET['id']){
	header("Location: ./?page=studentEnroll&id=".$_SESSION['userid']);
}

/*
if(isset($_SESSION["user_role"]) && $_SESSION["user_role"]==2 && $_SESSION["userid"]!=$_GET['showProfile']){
	header("Location: ./?page=teacher&showProfile=".$_SESSION['userid']);
}
*/


if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time();

if(!isset($_GET['page'])){
    if($_SESSION["user_role"]==1 || $_SESSION["user_role"]==3){
	    header("Location: ./?page=class&enrol_sy=$current_sy");
    } else if($_SESSION["user_role"]==2){
	    header("Location: ./?page=teacher&showProfile=".$_SESSION["userid"]."&tab=info");
    } else {
        header("Location: ./?page=student&showProfile=".$_SESSION["userid"]."&tab=history");
    }
}
	

require ('header.inc.php');

	if(isset($_GET['page'])){
		if($_GET['page']=="student"){
			if(isset($_GET['showProfile'])){
				require('studentProfile.inc.php');
			} elseif(isset($_GET['createProfile']) && $_SESSION["user_role"]>0){
				require('studentNew.inc.php');
			} elseif(isset($_GET['updateProfile']) && $_SESSION["user_role"]>0){
				require('studentUpdate.inc.php');
			} elseif(isset($_GET['searchProfile']) && $_SESSION["user_role"]>0){
				require('studentUpdate.inc.php');
			} elseif(isset($_GET['earlyRegistration']) && $_SESSION["user_role"]>0){
				require('earlyRegistrationDashboard.inc.php');
			} else{
			    if($_SESSION["user_role"]>0) {
				    require('studentDashboard.inc.php');
				} else{
				    require('accessdenied.inc.php');
				}
			}
		} else if($_GET['page']=="studentEnroll"){
			if(isset($_GET['id'])){
				require('studentEnroll.inc.php');
			} else{
				require('accessdenied.inc.php');
			}
		} else if($_GET['page']=="teacher" && $_SESSION["user_role"]>0){
			if(isset($_GET['showProfile'])){
				require('teacherProfile.inc.php');
			} elseif(isset($_GET['createProfile'])){
				require('teacherNew.inc.php');
			} elseif(isset($_GET['updateProfile'])){
				require('teacherUpdate.inc.php');
			} elseif(isset($_GET['searchProfile'])){
				require('teacherUpdate.inc.php');
			} elseif(isset($_GET['showDTR'])){
				require('teacherDTR.inc.php');
			} elseif(isset($_GET['approveDTR'])){
				require('teacherDTRApprove.inc.php');
			} elseif(isset($_GET['reports'])){
				require('teacherDTRreport.inc.php');
			} elseif(isset($_GET['realtime'])){
				require('teacherDTRreport.inc.php');
			} elseif(isset($_GET['showSALN'])){
				require('teacherSALN.inc.php');
			} elseif(isset($_GET['editSALN'])){
				require('teacherSALNedit.inc.php');
			} elseif(isset($_GET['manageSALN'])){
				require('teacherSALNmanage.inc.php');
			} elseif(isset($_GET['showProperty'])){
				require('teacherProperty.inc.php');
			} elseif(isset($_GET['manageProperty'])){
				require('teacherPropertymanage.inc.php');
			} else{
				require('teacherDashboard.inc.php');
			}
		} elseif($_GET['page']=="class" && $_SESSION["user_role"]>0){
			if(isset($_GET['classProfile'])){
				require('classProfile.inc.php');
			}
			else{
				require('classDashboard.inc.php');
			}
		} elseif($_GET['page']=="schedule" && $_SESSION["user_role"]>0){
			require('classSchedule.inc.php');
		} elseif($_GET['page']=="admin" && $_SESSION["user_role"]>0){
			require('admin.inc.php');
		} elseif($_GET['page']=="settings" && $_SESSION["user_role"]>0){
			require('config.inc.php');
		} elseif($_GET['page']=="sectioning" && $_SESSION["user_role"]>0){
			require('sectioningDashboard.inc.php');
		} elseif($_GET['page']=="sectioning2" && $_SESSION["user_role"]>0){
			require('sectioningDashboard2.inc.php');
		} elseif($_GET['page']=="prospectus" && $_SESSION["user_role"]>0){
			require('prospectusDashboard.inc.php');
		} elseif($_GET['page']=="offerings" && $_SESSION["user_role"]>0){
			require('classSchedule.inc.php');
		} elseif($_GET['page']=="loads" && $_SESSION["user_role"]>0){
			require('teacherLoad.inc.php');
		} elseif($_GET['page']=="load" && $_SESSION["user_role"]>0){
			require('teacherLoad.inc.php');
		} elseif($_GET['page']=="financials" && $_SESSION["user_role"]>0){
			require('financialsDashboard.inc.php');
		} elseif($_GET['page']=="reports" && $_SESSION["user_role"]>0){
			require('reportFinancialDashboard.inc.php');
		} elseif($_GET['page']=="reportsSum" && $_SESSION["user_role"]>0){
			require('reportFinancialDashboard2.inc.php');
		} elseif($_GET['page']=="assessments" && $_SESSION["user_role"]>0){
			require('assessmentsDashboard.inc.php');
		} elseif($_GET['page']=="receiptSearch" && $_SESSION["user_role"]>0){
			require('receiptDashboard.inc.php');
		} elseif($_GET['page']=="dropdowns" && $_SESSION["user_role"]>0){
			require('dropdownsDashboard.inc.php');
		} elseif($_GET['page']=="settingsfi" && $_SESSION["user_role"]>0){
			require('settingsfi.inc.php');
		} elseif($_GET['page']=="settingsdb" && $_SESSION["user_role"]>0){
			require('settingsdb.inc.php');
		} elseif($_GET['page']=="settingsia" && $_SESSION["user_role"]>0){
			require('settingsia.inc.php');
		} elseif($_GET['page']=="restoredb" && $_SESSION["user_role"]>0){
			require('restoredb.inc.php');
		} elseif($_GET['page']=="sf7header" && $_SESSION["user_role"]>0){
			require('sf7header.inc.php');
		} else {
		    require('accessdenied.inc.php');
		}
		
	}

require ('footer.inc.php');
/***
if(isset($_GET['ua']) && $_GET['ua']=="Yes"){
		$lockstudent = dbquery("update student set stud_status='0' where stud_no='".$_SESSION["userid"]."'");
		?>
		<script>
			alert("Account was lockedout due to the hacking attempt.");
		</script>
		<?php
		// remove all session variables
		session_unset(); 
		// destroy the session 
		session_destroy(); 

		setcookie("freichat_user", "LOGGED_IN", time()-3600, "/"); 
}
***/
?>
<script>
    $(document).ready(function({
    var url = "costam#active"
     var url2 = url.split('#')[1];

     var script = '#myTab a[href="#'+url2+'"]';

     $(script).tab('show');
    }));
</script>



