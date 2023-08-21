<?php
require ('maincore.php');


if(isset($_GET['reset'])){
	$learnerno = $_GET['learnerno'];
	$learnerlrn = $_GET['learnerlrn'];
	$password = substr(md5("P@ssw0rd"),0,50);
	$updateAccess = dbquery("update student set stud_password='".$password."' where stud_no='".$learnerno."'");
	header("Location: ./login.php?username=$learnerlrn");
}

if(isset($_POST['submit'])){
	$firstname = strtoupper($_POST['firstname']);
	$lastname = strtoupper($_POST['lastname']);
	$birthdate = $_POST['birthdate'];
	$resultLookupChk = dbquery("SELECT * FROM student WHERE (stud_fname='".$firstname."' AND stud_lname='".$lastname."' AND stud_bdate='".$birthdate."')");
	$rowLookupChk = dbrows($resultLookupChk);

	if ($rowLookupChk > 0){
		$found = true;
		$dataLookupChk = dbarray($resultLookupChk);
		$learnerLRN = $dataLookupChk['stud_lrn'];
		$learnerNo = $dataLookupChk['stud_no'];
	} 
	else {
		$found = false;
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="The official website of San Agustin National High School - Sagbayan, Bohol">
    <meta name="author" content="Fernando B. Enad">
	<meta name="keywords" content="San Agustin NHS, San Agustin National High School">
    <link rel="icon" href="./assets/images/seal.png">
    <title><?php echo $current_school_short;?> MIS- Learner LRN Lookup Form</title>
	
    <!-- Bootstrap -->
    <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="./assets/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
     
	<!--
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
    -->
	<link rel="stylesheet" href="./assets/css/style.css">
	<link rel="stylesheet" href="./assets/css/signin.css">
	<link href="./assets/css/select2.css" rel="stylesheet">
	<link href="./assets/css/bootstrap.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="./assets/js/html5shiv.min.js"></script>
      <script src="./assets/js/respond.min.js"></script>
    <![endif]-->
	<script type="text/javascript" src="./assets/js/jquery.js"></script>
	<script type="text/javascript" src="./assets/boostrap/js/bootstrap.min.js"></script>
	<script type="text/javascript">
    $(window).load(function(){
        $('#myModal').modal('show');
    });
	</script>
	
</head>
<body >
    <!--[if lt IE 9]>
        <p class="chromeframe"><span class="glyphicon glyphicon-warning-sign"></span> You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> to better experience this site.</p>
    <![endif]-->
	<div id="wrap">
		<div class="navbar navbar-fixed-top navbar-default hidden-print" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<span class="navbar-brand">
						<img class="logo" src="./assets/images/sanhs_logo.png" alt="SANHS" style="height: 20px; margin-top: -2px"/>
					</span>
					<span class="navbar-brand"><?php echo $current_school_short;?> MIS</span>
				</div>
				

			</div>
		</div><br>

		
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-4 col-md-offset-4">
					<div class="account-wall">
						<div id="my-tab-content" class="tab-content">
							<div class="tab-pane active" id="login">
								
								<img class="profile-img" src="./assets/images/sanhs_logo.png" alt="">
								<h3 align="center">Learner LRN Lookup Form</h3>
								<form class="form-signin" action="studeLookup.php" method="post">
									<input type="text" id="firstname" name="firstname" maxlength="50" class="form-control" placeholder="Firstname" value="" required autofocus>
									<input type="text" id="lastname" name="lastname" maxlength="50" class="form-control" placeholder="Lastname" value="" required>
									<input type="date" id="birthdate" name="birthdate" maxlength="50" class="form-control" placeholder="Birthdate" value="" required>
									<input type="submit" name="submit" class="btn btn-lg btn-default btn-block" value="Lookup LRN" />
									<hr/>
									<?php 
									if(isset($_POST['submit'])){
										echo "<h4>Result</h4>";
										
										if($found==true){
											echo "<p>Hi $firstname $lastname, your LRN is <b>" . $learnerLRN . "</b>.</p>";
											echo "If the result is correct, you may reset your password by clicking <a href='?reset=yes&learnerno=$learnerNo&learnerlrn=$learnerLRN' onclick=\"return confirm('You are about to change your password to P@ssw0rd, are you sure?')\">here</a>, otherwise, contact the School Registrar.";
										}
										else {
											echo "<p>LRN not found, please try looking up again!</p>";
										}
									} 
									else {
										echo "<h4>Instruction</h4>";
										echo "<p>Fill-out the fields accurately to get the expected results.</p>";
									}
									?>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>


</div>



	
	<div id="footer">
		<div class="container">
			<p class="text-muted" style="margin-top:20px"><small> Copyright &copy; 2016. <a href="">School Management Information System</a> by <a href="mailto:fernando.enad@deped.gov.ph">Fernando B. Enad</a> (San Agustin NHS - Sagbayan, Bohol). All rights reserved.</small></p>
		</div>
	</div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="./assets/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript">
	  !function($) {
		$("input[type='password']").keypress(function(e) {
			var kc = e.which; //get keycode
			var isUp = (kc >= 65 && kc <= 90) ? true : false; // uppercase
			var isLow = (kc >= 97 && kc <= 122) ? true : false; // lowercase
			// event.shiftKey does not seem to be normalized by jQuery(?) for IE8-
			var isShift = ( e.shiftKey ) ? e.shiftKey : ( (kc == 16) ? true : false ); // shift is pressed

			// uppercase w/out shift or lowercase with shift == caps lock
			if ( (isUp && !isShift) || (isLow && isShift) ) {
				$(this).tooltip({placement: 'right', title: 'Capslock is on', trigger: 'manual'})
					   .tooltip('show');
			} else {
				$(this).tooltip('hide');
			}

		});
		$(document).on('click', '.dropdown-menu', function (e) {
		  if ($(e.target).parent().hasClass('keep_open_close')) {
			e.preventDefault();

			return;
		  }


		  $(this).hasClass('keep_open') && e.stopPropagation(); // This replace if conditional.
		});
	  }(jQuery);
	</script>
		<script src="./announcements.js"></script>
        <script src="./assets/js/announcer.js"></script>	

  </body>
</html>