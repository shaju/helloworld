<?php
require_once("../pearllogin_templatexml.php");
require_once( '../classes/class.token.php');	
require_once( '../classes/class.generaltransactions.php');	
require_once("../common/PhpCommonFunctions.php");
$objcom = new Common();
$objPhpVal = new PhpValidation();
$objDDVal = new dropDownValidation();
$objPwrAtt= new GeneralTransaction();

//$objDB = OpenPearlDataBase::getInstance();

 $option = $_GET['option'];
switch($option)
{   
      case 1:
	   
	  
	 $objPwrAtt->setUserlogin($_SESSION['userName']);
	  	  $objPwrAtt->powerAttest();
	  
	  
	  break;
	  case 2:
	  
	  
	   $type=$_GET['type'];
	  
	   $sro= $_SESSION['loggedinOffice'];	  

	  $objPwrAtt->refno($sro,$type);
	  
	  
	  
	  
	  break;
	  case 3:
	  
	  $date= $objcom->sqlDateformat($_POST['recvd_date']);
	  //$date=$objcom->sqlDateformat($_POST['recvd_date']);
	  $sro= $_SESSION['loggedinOffice'];
	  $objPwrAtt->getNextSlno($sro,$date);
	 
	  break;
	  case 4:
	  $date= $objcom->sqlDateformat($_POST['recvd_date']);	  
	  $sro= $_SESSION['loggedinOffice'];
	  $objPwrAtt->AddAcc_C($sro,$date);	  
	  
	  break;
	  case 5:
	   $transcode=trim($_POST['transcode']);
	  $refno= trim($_POST['refno']);
	 $type = $_GET['type'];
	  $objPwrAtt->Save($refno,$transcode,$type);  
	  
	  
	  
	  break;
	  
	  case 6:
	  $trcode = $_GET['tcode'];
	  $objPwrAtt->calFee($trcode);  	  
	  break;
	  
	  
	  case 7:
	   	  
	  $aryEmptyValues = array();
					$aryEmptyValues['transcode'] = $_POST['transcode'];
					$aryEmptyValues['date'] = $_POST['date'];
					$aryEmptyValues['refno'] = $_POST['refno'];
					$aryEmptyValues['slno'] = $_POST['slno'];
					$aryEmptyValues['amount'] = $_POST['amount'];
					$aryEmptyValues['fee'] = $_POST['fee'];
					$aryEmptyValues['Stamp Duty'] = $_POST['sd'];
					$aryEmptyValues['Surcharge'] = $_POST['sc'];
					$aryEmptyValues['Account'] = $_POST['account'];
					$aryEmptyValues['Remarks'] = $_POST['rmrk'];
					 
					if(!$objPhpVal->_isEmpty($aryEmptyValues)) exit(0);
					
					
					$refArray = array("Ref No"=>$_POST['refno']);
					if(!$objPhpVal->_isSpclChar($refArray,array())) exit(0);
					
					$remArray = array("Remarks"=>$_POST['rmrk']);
					if(!$objPhpVal->_isSpclChar($remArray,array("#",",",".","'","/"))) exit(0);
				    if(!$objPhpVal->_isLen($_POST['transcode'],4,"Transaction Code")) exit(0);
					//if(!$objDDVal->checkSelectOption('nature','trans_code',$_POST['transcode'],"Transaction Code")) exit(0);
			
					if(!$objPhpVal->_isDate($_POST['date'],"Date")) exit(0);
					if(!$objPhpVal->_isDateBeforeToday($_POST['date'],"Date")) exit(0);
					
					
					if(!$objPhpVal->_isInteger($_POST['slno'],"Sl No")) exit(0);
					if(!$objPhpVal->_isInteger($_POST['amount'],"Amount")) exit(0);
					
					
					if(!$objPhpVal->_isDecimal($_POST['fee'],18,2,"Fee")) exit(0);
					if(!$objPhpVal->_isDecimal($_POST['sd'],18,2,"Stamp Duty")) exit(0);
					if(!$objPhpVal->_isDecimal($_POST['sc'],18,2,"Surcharge")) exit(0);
					
					if(!$objPhpVal->_isChar($_POST['account'],"Account Code")) exit(0);
	
	  
	  $transcode=trim($_POST['transcode']);
	  $sro= $_SESSION['loggedinOffice'];
	  $date= trim($_POST['date']);
	  $refno= trim($_POST['refno']);
	  $slno= trim($_POST['slno']);
	  $amount= trim($_POST['amount']);
	  $fee= trim($_POST['fee']);
	  $sd= trim($_POST['sd']);
	  $sc= trim($_POST['sc']);
	  $account= trim($_POST['account']);
	  $rmrk= trim($_POST['rmrk']);
	  
	  $objPwrAtt->ResidInsert($sro,$date,$refno,$slno,$transcode,$amount,$fee,$sd,$sc,$account,$rmrk);
	  
	  break;
	  
	  
	  case 8:
	  
	   $aryEmptyValues = array();
					$aryEmptyValues['recvd_date'] = $_POST['recvd_date'];
					$aryEmptyValues['rcvd'] = $_POST['rcvd'];
					$aryEmptyValues['onacc'] = $_POST['onacc'];
					$aryEmptyValues['amt'] = $_POST['amt'];
					$aryEmptyValues['rfc'] = $_POST['rfc'];
					$aryEmptyValues['det'] = $_POST['det'];
					$aryEmptyValues['amtd'] = $_POST['amtd'];
					$aryEmptyValues['disb_reference'] = $_POST['disb_reference'];
					
					 
					if(!$objPhpVal->_isEmpty($aryEmptyValues)) exit(0);
					
					if(!$objPhpVal->_isDate($_POST['recvd_date'],"Received Date")) exit(0);
					if(!$objPhpVal->_isDateBeforeToday($_POST['recvd_date'],"Received Date")) exit(0);
					if(!$objPhpVal->_isInteger($_POST['amt'],"Amount")) exit(0);
					if(!$objPhpVal->_isInteger($_POST['amtd'],"Amount Disbursed")) exit(0);
					
	  
	  //$trcode = $_GET['tcode'];
	  $sro= $_SESSION['loggedinOffice'];
	  $usr=$_SESSION['userName'];
	  $recvd_date= trim($_POST['recvd_date']);
	  $rcvd= trim($_POST['rcvd']);
	  $onacc= trim($_POST['onacc']);
	  $amt= trim($_POST['amt']);
	  $rfc= trim($_POST['rfc']);
	  $det= trim($_POST['det']);
	  $amtd= trim($_POST['amtd']);
	  $disb_reference= trim($_POST['disb_reference']);
	  
	  $objPwrAtt->Save_C($sro,$usr,$recvd_date,$rcvd,$onacc,$amt,$rfc,$det,$amtd,$disb_reference);  
	  break;
			 
   default:
   
       break;
 }

?>
	