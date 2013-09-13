<?php
require_once("class.gridView.php");
require_once("class.audittrail.php"); 
require_once("class.lang.php");
require_once("class.common.php");

class GeneralTransaction extends User
{



public function getUserlogin() {
		return $this->user_login;
	}
	public function setUserlogin($user_login) {
		$this->user_login = $user_login;
	} 
public function gnTransactionFrm()
{
$sro=$_SESSION['loggedinOffice'];
 $qrysro="select * from public.sro where code like '$sro'";
$resultSro=$this->executeQueryNew($qrysro);



$query="delete from account where docno like '%PA%' or docno like '%PW%' or docno like '%R%' ";
$this->executeQueryNew($query);





?>
 <table  align="center" cellpadding="0"  cellspacing="1" width="100%" style="border-style: solid; border-width: 0px; border-color: #000"><!-- for border -->
  <tr><td  align="center"colspan="6" class="mainHeading">General Transactions</td></tr>
</table>
<div class="li_curve">
 <table  align="center" cellpadding="0"  cellspacing="1" width="100%" style="border-style: solid; border-width: 0px; border-color: #000"><!-- for border -->
 <br />
		<tr class="alignLabels"></tr>
					 
                              <tr>
								
								 <td class="alignLabels" width="25%">Sro</td>
                          <td class="alignInputs" width="25%">
						  
										 
                                           <select  class="selectInputs" id="sro" name="sro"  >
										   <?php
										   if($resultSro)
											 {	
											 while($rows=$resultSro->fetchRow()) 
												{	
										   ?>
										   
										   <option value="<?php echo $rows['code'];?>" selected> <?php if($_SESSION['userLanguage']=='1'){ echo trim($rows['eng_name']);}else if ($_SESSION['userLanguage']=='2'){echo trim($rows['name']);}?> </option>
			<?php 
					} 
					}
			?>
								
								 </select>
						  </td>
								
								
								
                                       
										<td class="alignLabels" width="10%">Date</td>
                                        <td class="alignInputs"  >
                                          <input  type="text" class="textInputs" name="date" id="date" value="<?php echo date("d/m/Y");?>" maxlength="10" autocomplete="off" readonly >
										</td></tr>
  </table>
										<br /><br />
										<div align="center" class="curvedd" style="width:740px; text-align:center">
										<span class="NoteStyle"><strong>Select Transaction</strong></span>
										<br /><br />
										<!--<div align="left" style="text-align:inherit; width:125px; height:75px;  border-style:solid; border-width:1px;"><strong>Power Attestation</strong></div>-->
										<br /><br />
										<tr>
										
										<td class="alignLabels" width="25%"><input type="radio" name="select_type" id="select_type" value="power_attestation" onclick="submitFrm();" /> <strong>Power Attestation</strong> </td>
										<td class="alignLabels" width="25%"></td>
										<td class="alignLabels" width="25%"><input type="radio" name="select_type" id="select_type" value="power_attestation_r" onclick="submitFrm();" /> <strong>Power Attestation(Residence)</strong> </td>
										<td class="alignLabels" width="25%"></td>
										</tr>
										<tr>
										<td class="alignLabels" width="25%"><input type="radio" name="select_type" id="select_type" value="power_attestation_j" onclick="submitFrm();" /> <strong>Power Attestation(Jail/Hospital)</strong> </td>
										<td class="alignLabels" width="25%">
									</td>
										<td class="alignLabels" width="25%"><input type="radio" name="select_type" id="select_type" value="accountC" onclick="submitFrm();" /> <strong>Make Entries In Account C</strong> </td>
										<td class="alignLabels" width="25%"></td>
										</tr>
										<tr>
										<td class="alignLabels" width="25%"><input type="radio" name="select_type" id="select_type" value="others" onclick="submitFrm();" /> <strong>Others</strong> </td>
										<td class="alignLabels" width="25%">

										</td>
										<td class="alignLabels" width="25%">
										</td>
										<td class="alignLabels" width="25%"></td>
										</tr>
										</div>
										<div id="divcontent" align="center">
										
			 
			</div>

</div>
<?php
}

public function powerAttest()
{
echo $user_login = $this->getUserlogin();
?>
<div id="" >
<table  align="center" cellpadding="0"  cellspacing="1" width="100%" style="border-style: solid; border-width: 0px; border-color: #000"><!-- for border -->
  <tr><td  align="center"colspan="6" class="mainHeading">Power Attestation</td></tr>
  </table>
</div>
<?php

}


//******************************************

public function refno($sro,$type)
			{
			
$query="delete from account where docno like '%PA%' or docno like '%PW%' or docno like '%R%' ";
$this->executeQueryNew($query);


					 $currentYear=date("Y");
				 
				if($type=="power_attestation_r")
				{
					$transcode='5201';
				 	 $qryrefno="select coalesce(max(attend_no),0) as attend_no from serial_no where year='$currentYear' and sro_code='$sro'";
				 }
				 else if($type=="power_attestation")
				 {
				 	$transcode='5101';
				 	 $qryrefno="select coalesce(max(attest_no),0) as attest_no from serial_no where year='$currentYear' and sro_code='$sro'";
				 }
				 else if($type=="power_attestation_j")
				 {
				 	$transcode='5202';
				 	$qryrefno="select coalesce(max(attend_no),0) as attend_no from serial_no where year='$currentYear' and sro_code='$sro'";
				 }
				 else if($type=="accountC")
				 {
				 	$qryrefno="select coalesce(max(attend_no),0) as attend_no from serial_no where year='$currentYear' and sro_code='$sro'";
				 }
				 else  //others
				 {
				 //echo "others";
				 	$qryrefno="select coalesce(max(gt_no),0) as attend_no from serial_no where year='$currentYear' and sro_code='$sro'";
				 }
				 
					 $result=$this->executeQueryNew($qryrefno);
					 $rowrefno=$result->fetchRow();
					
				 

		?>
		        	
						  <?php
					$currentYear=date("Y");
					$currentDate=date("d/m/Y");
					
					$bookno='0';
					$date= Common::sqlDateformat($currentDate);
					
					
					
					if($type=="power_attestation_r")
				{
				 	  $sql="select coalesce(max(slno),0)+1 as next_slno 
				from account where sro_code = '$sro' and year = '$currentYear' and  bookno ='$bookno' and  
				docno like 'PA'||(select attend_no  from serial_no where sro_code = '$sro' and year = '$currentYear')  
				and date = '$date' and trans_code='$transcode'";
				$rrr=OpenPearlDataBase::getInstance()->getOne($sql); 
				 ?>
				 
				 <table width="100%"  align="center" >
					<br />
					  <tr><td  align="center"colspan="6" class="mainHeading">Power Attestation(Residence)</td></tr>
                       <tr>
                          <td class="alignLabels" width="25%">Slno</td>
                          <td class="alignInputs" width="25%">
							<input type="text" name="slno" class="textInputs" readonly id="slno" value="<?php  echo $rrr;?>" autocomplete="off" style="width:90px">			 
                                           
						 
						  
						  </td>
                          <td class="alignLabels" width="25%">Ref :No</td>
						  
						  <input type="hidden" id="data" name="data" value="<?php echo $rowrefno['attend_no'];?>">
						  
					     <td class="alignInputs" width="25%"><input type="text" class="textInputs" readonly  name="refno" id="refno" 
						 
						 value="<?php echo 'PA'.$rowrefno['attend_no'];?>" ></td>
					 </tr>
					  <tr>
                                        <td  class="alignLabels" colspan="1">Trans.Code</td>
                                        <td class="alignInputs" >
										
                                         <?php
										 	//$qrytranscode="select * from nature where account not in ('M','T')";
											$qrytranscode="select trans_code,description from public.nature where account not in ('M','T')
											 and trans_code = '$transcode'";
											$result=$this->executeQueryNew($qrytranscode);
											
										 ?>
										 
                                           <select  class="selectInputs" id="transcode" name="transcode" >
                                           <!--  <option value="0" selected>&nbsp;--Select--&nbsp;</option> -->
                                            <?php
                                            if($result)
											{
                                              while($rowtranscode=$result->fetchRow())
											    
										       { 
											   ?>
                                            <option value='<?php echo $rowtranscode['trans_code'];?>' selected>
											 <?php echo $rowtranscode['trans_code']." - ".$rowtranscode['description'];?> </option>
                                            <?php
                                               }
                                            }

                                      ?>
                                        </select></td>
										<td  class="alignLabels" colspan="1">Amount</td>
                                        <td class="alignInputs" colspan="1">
                                         
                                            <!--<input type="text" name="amount" id="amount"  class="textInputs" onBlur="javascipt:getFees(this.form);">-->
											  <input type="text" name="amount" id="amount"  class="textInputs" 
											  onBlur="javascipt:showFee(this.form);" onKeyPress="return decimalDigitsCheck(event,'amount','18','2')">
                                         </td>
                                       
                                      </tr>
									    

					</table>
					
					
					
					<?php
				
				
				
				
				 }
				 else if($type=="power_attestation")
				 {
				 	$sql="select coalesce(max(slno),0)+1 as next_slno 
				from account where sro_code = '$sro' and year = '$currentYear' and  bookno ='$bookno' and  
				docno like 'PW'||(select attend_no  from serial_no where sro_code = '$sro' and year = '$currentYear')  
				and date = '$date' and trans_code='$transcode'";
				
				$rrr=OpenPearlDataBase::getInstance()->getOne($sql); 
				 ?>
				 <table width="100%"  align="center" >
					<br />
					  <tr><td  align="center"colspan="6" class="mainHeading">Power Attestation</td></tr>
                       <tr>
                          <td class="alignLabels" width="25%">Slno</td>
                          <td class="alignInputs" width="25%">
							<input type="text" name="slno" class="textInputs" readonly id="slno" value="<?php  echo $rrr;?>" autocomplete="off" style="width:90px">			 
                          
						  </td>
                          <td class="alignLabels" width="25%">Ref :No</td>
						  
						  <input type="hidden" id="data" name="data" value="<?php echo $rowrefno['attest_no'];?>">
						  
					     <td class="alignInputs" width="25%"><input type="text" class="textInputs" readonly  name="refno" id="refno" value="<?php echo 'PW'.$rowrefno['attest_no'];?>" ></td>
					 </tr>
					  <tr>
                                        <td  class="alignLabels" colspan="1">Trans.Code</td>
                                        <td class="alignInputs" >
										
                                         <?php
										 	//$qrytranscode="select * from nature where account not in ('M','T')";
											 $qrytranscode="select trans_code,description from public.nature where account not in ('M','T')
											 and trans_code = '$transcode'";
											$result=$this->executeQueryNew($qrytranscode);
											
										 ?>
										 
                                           <select  class="selectInputs" id="transcode" name="transcode" >
                                           <!--  <option value="0" selected>&nbsp;--Select--&nbsp;</option> -->
                                            <?php
                                            if($result)
											{
                                              while($rowtranscode=$result->fetchRow())
											    
										       { 
											   ?>
                                            <option value='<?php echo $rowtranscode['trans_code'];?>' selected>
											 <?php echo $rowtranscode['trans_code']." - ".$rowtranscode['description'];?> </option>
                                            <?php
                                               }
                                            }

                                      ?>
                                        </select></td>
										<td  class="alignLabels" colspan="1">Amount</td>
                                        <td class="alignInputs" colspan="1">
                                         
                                            <!--<input type="text" name="amount" id="amount"  class="textInputs" onBlur="javascipt:getFees(this.form);">-->
											  <input type="text" name="amount" id="amount"  class="textInputs" 
											  onBlur="javascipt:showFee(this.form);" onKeyPress="return decimalDigitsCheck(event,'amount','18','2')">
                                         </td>
                                       
                                      </tr>
									    

					</table>
					
					
					
					<?php
				
					 
				 }
				 else if($type=="power_attestation_j")
				 {
				 	$sql="select coalesce(max(slno),0)+1 as next_slno 
				from account where sro_code = '$sro' and year = '$currentYear' and  bookno ='$bookno' and  
				docno like 'PA'||(select attend_no  from serial_no where sro_code = '$sro' and year = '$currentYear')  
				and date = '$date' and trans_code='$transcode'";
				
				$rrr=OpenPearlDataBase::getInstance()->getOne($sql); 
				 ?>
				 
				 <table width="100%"  align="center" >
					<br />
					  <tr><td  align="center"colspan="6" class="mainHeading">Power Attestation(Jail/Hospital)</td></tr>
                       <tr>
                          <td class="alignLabels" width="25%">Slno</td>
                          <td class="alignInputs" width="25%">
							<input type="text" name="slno" class="textInputs" readonly id="slno" value="<?php  echo $rrr;?>" autocomplete="off" style="width:90px">			 
                                           
						 
						  
						  </td>
                          <td class="alignLabels" width="25%">Ref :No</td>
						  
						  <input type="hidden" id="data" name="data" value="<?php echo $rowrefno['attend_no'];?>">
						  
					     <td class="alignInputs" width="25%"><input type="text" class="textInputs" readonly  name="refno" id="refno" 
						 
						 value="<?php echo 'PA'.$rowrefno['attend_no'];?>" ></td>
					 </tr>
					  <tr>
                                        <td  class="alignLabels" colspan="1">Trans.Code</td>
                                        <td class="alignInputs" >
										
                                         <?php
										 	//$qrytranscode="select * from nature where account not in ('M','T')";
											$qrytranscode="select trans_code,description from public.nature where account not in ('M','T')
											 and trans_code = '$transcode'";
											$result=$this->executeQueryNew($qrytranscode);
											
										 ?>
										 
                                           <select  class="selectInputs" id="transcode" name="transcode" >
                                           <!--  <option value="0" selected>&nbsp;--Select--&nbsp;</option> -->
                                            <?php
                                            if($result)
											{
                                              while($rowtranscode=$result->fetchRow())
											    
										       { 
											   ?>
                                            <option value='<?php echo $rowtranscode['trans_code'];?>' selected>
											 <?php echo $rowtranscode['trans_code']." - ".$rowtranscode['description'];?> </option>
                                            <?php
                                               }
                                            }

                                      ?>
                                        </select></td>
										<td  class="alignLabels" colspan="1">Amount</td>
                                        <td class="alignInputs" colspan="1">
                                         
                                            <!--<input type="text" name="amount" id="amount"  class="textInputs" onBlur="javascipt:getFees(this.form);">-->
											  <input type="text" name="amount" id="amount"  class="textInputs" 
											  onBlur="javascipt:showFee(this.form);" onKeyPress="return decimalDigitsCheck(event,'amount','18','2')">
                                         </td>
                                       
                                      </tr>
									    

					</table>
					
					
					
					<?php
					$rrr= OpenPearlDataBase::getInstance()->getOne($sql); 
				
				 }
				 else if($type=="accountC")
				 {
				 	?>
				 <div id="acc_C">
				 <table width="100%"  align="center" >
					<br />
					  <tr><td  align="center"colspan="6" class="mainHeading">Account 'C' (Suspence Account)</td></tr>
					</table> 
					  <div class="note_table">
					   <strong>NOTE : </strong>Suspense Collections where receipts are not issued only may be entered directly in the account 'C'. Collections in account 'C' for which receipts are issued either along with registration of a document or through General Transaction will be included automatically. Disbursements can be accounted in the respective accounts through General Transactions/ G.S. / S.S etc. After the disbursement activity, reference and cross references may be entered directly in account 'C'.</td>
  
					  </div>
					  <br />
					  <table width="100%"  align="center" >
                       <tr>
					    <td class="alignLabels" width="25%" style="text-align:right">Select a Date</td>
        <td class="alignInputs" style="text-align:left">
          <input type="text" name="recvd_date" id="recvd_date" style="width:100px" class="textInputs" maxlength="10" autocomplete="off" onBlur="javascipt:Slno(this.form);">
          <a href="javascript:NewCssCal('recvd_date','ddMMyyyy')"><img src="images/cal.gif"  alt="Pick a date" align="absbottom"></a> </td>
		  
                          <td class="alignLabels" width="25%">Slno</td>
                          <td class="alignInputs" width="25%">
						  
						  <?php
						 // $slno = $this->getNextSlno($sro,$objcom->sqlDateformat($_GET['recvd_date']));
						// $slno = $this->getNextSlno($sro,$date);
						 
						  ?>
						  <div id="divslno">
						  <input type="text" name="slno1" class="textInputs" readonly id="slno" value="<?php  //echo $slno;?>" autocomplete="off" style="width:90px">	
						  </div>
									 
                           	  
						  </td>
						  
                         
					 </tr>
					  <tr>
                                        <td class="alignLabels" width="25%">Recieved From</td>
						  
					     <td class="alignInputs" width="25%"><input type="text" class="textInputs"   name="rcvd" id="rcvd"  ></td>
						 
										<td  class="alignLabels" colspan="1">On Account of</td>
                                        <td class="alignInputs" colspan="1">
                                         
                                            <!--<input type="text" name="amount" id="amount"  class="textInputs" onBlur="javascipt:getFees(this.form);">-->
											  <input type="text" name="onacc" id="onacc"  class="textInputs" >
                                         </td>
                                       
                                      </tr>
									    
									<tr>
                                        <td class="alignLabels" width="25%">Amount</td>
						  
					     <td class="alignInputs" width="25%"><input type="text" class="textInputs"   name="amt" id="amt"  ></td>
						 
										<td  class="alignLabels" colspan="1">Reference and Cross reference to disbursement</td>

                                        <td class="alignInputs" colspan="1">
                                         
                                            <!--<input type="text" name="amount" id="amount"  class="textInputs" onBlur="javascipt:getFees(this.form);">-->
											  <input type="text" name="rfc" id="rfc"  class="textInputs" >
                                         </td>
                                       
                                      </tr>
									  
									  <tr>
                                        <td class="alignLabels" width="25%">Details of Disbursement</td>
						  
					     <td class="alignInputs" width="25%"><input type="text" class="textInputs"   name="det" id="det"  ></td>
						 
										<td  class="alignLabels" colspan="1">Amount Disbursed</td>
                                        <td class="alignInputs" colspan="1">
                                         
                                            <!--<input type="text" name="amount" id="amount"  class="textInputs" onBlur="javascipt:getFees(this.form);">-->
											  <input type="text" name="amtd" id="amtd"  class="textInputs" >
                                         </td>
                                       
                                      </tr>
									  
									   <tr>
                                        <td class="alignLabels" width="25%">Reference and Cross reference to Collections with the Receipt No.</td>
						  
					     <td class="alignInputs" width="25%" height="15%"><textarea name="disb_reference" id="disb_reference" cols="30" rows="3" class="textInputs">
            <?php //echo $aryDispValues['disb_reference']; ?>
        </textarea></td>
						 
										<td  class="alignLabels" colspan="1"></td>
                                        <td class="alignInputs" colspan="1">
                                         
                                            
                                         </td>
                                       
                                      </tr>
									  
								 <tr>
								 
								 <td class="subHeading" align="center" colspan="4">
											   <!--<input name="Next" type="button" class="btnStyle"   
											   value="Add" style="width:165px " onClick="javascipt:nextData_C(this.form);"  >-->
											   <input name="Next" type="button" class="btnStyle"   
											   value="Save" style="width:165px " onClick="javascipt:saveAcc_C(this.form);"  >
										 </td>
								 
								 
								 
   <!-- <td colspan="4" style="text-align:center; background-color:#ebeffa">
        <input  type="button" name="save_btn" value="Save Data" class="btnStyle" onClick="saveAcc_C(this.form)" style="width:120px">
        &nbsp;&nbsp;&nbsp;
        <input  type="button" name="save_btn" value="Reset / Add New" class="btnStyle" onClick="resetForm()" style="width:120px">
    </td>
  </tr>	  
-->
					</table>
					
					</div>
					
					<?php
				 }
				 else  //others
				 {
				 	//echo "others";
					
					
					 $sql="select coalesce(max(slno),0)+1 as next_slno 
				from account where sro_code = '$sro' and year = '$currentYear' and  bookno ='$bookno' and  
				docno like 'R'||(select gt_no  from serial_no where sro_code = '$sro' and year = '$currentYear')  
				and date = '$date'";
				$rrr=OpenPearlDataBase::getInstance()->getOne($sql); 
				 ?>
				 
				 <table width="100%"  align="center" >
					<br />
					  <tr><td  align="center"colspan="6" class="mainHeading">Others</td></tr>
                       <tr>
                          <td class="alignLabels" width="25%">Slno</td>
                          <td class="alignInputs" width="25%">
							<input type="text" name="slno" class="textInputs" readonly id="slno" value="<?php  echo $rrr;?>" autocomplete="off" style="width:90px">			 
                                           
						 
						  
						  </td>
                          <td class="alignLabels" width="25%">Ref :No</td>
						  
						  <input type="hidden" id="data" name="data" value="<?php echo $rowrefno['attend_no'];?>">
						  
					     <td class="alignInputs" width="25%"><input type="text" class="textInputs" readonly  name="refno" id="refno" 
						 
						 value="<?php echo 'R'.$rowrefno['attend_no'];?>" ></td>
					 </tr>
					  <tr>
                                        <td  class="alignLabels" colspan="1">Trans.Code</td>
                                        <td class="alignInputs" >
										
                                         <?php
										 	//$qrytranscode="select * from nature where account not in ('M','T')";
											$qrytranscode="select trans_code,description from public.nature where account not in ('M','T') ";
											$result=$this->executeQueryNew($qrytranscode);
											
										 ?>
										 
                                           <select  class="selectInputs" id="transcode" name="transcode" >
                                           <!--  <option value="0" selected>&nbsp;--Select--&nbsp;</option> -->
                                            <?php
                                            if($result)
											{
                                              while($rowtranscode=$result->fetchRow())
											    
										       { 
											   ?>
                                            <option value='<?php echo $rowtranscode['trans_code'];?>' selected>
											 <?php echo $rowtranscode['trans_code']." - ".$rowtranscode['description'];?> </option>
                                            <?php
                                               }
                                            }

                                      ?>
                                        </select></td>
										<td  class="alignLabels" colspan="1">Amount</td>
                                        <td class="alignInputs" colspan="1">
                                         
                                            <!--<input type="text" name="amount" id="amount"  class="textInputs" onBlur="javascipt:getFees(this.form);">-->
											  <input type="text" name="amount" id="amount"  class="textInputs" 
											  onBlur="javascipt:showFee(this.form);" onKeyPress="return decimalDigitsCheck(event,'amount','18','2')">
                                         </td>
                                       
                                      </tr>
									    

					</table>
					
					
					
					<?php
					
					
					
					
					
					
				 }
					

     		 // $result=$this->executeQueryNew($sql);
					// $rw=$result->fetchRow();
					
				 
					 ?>
							
					
					<div id="div_fee_dtls" align="center">
					

</div>
<div id="div_fee_dtls1" align="center">
					

</div>
				<table>	
				
					</table>
					
					<?php
			} 
			
			
			
			
	public function getNextSlno($sroCode,$ymdrecvdDate)
{
    try
    {
	//echo $ymdrecvdDate;
	//echo $date= Common::sqlDateformat($ymdrecvdDate);
	//echo $date1= $objcom->sqlDateformat($ymdrecvdDate);
        //$sql = "select coalesce(max(slno),0)+1 from account_c where sro_code = '".$sroCode."' and recvd_date = '".$ymdrecvdDate."'"; //      
       // echo $rr= OpenPearlDataBase::getInstance()->getOne($sql);
	     $sql = "select coalesce(max(slno),0)+1 as sl from account_c where sro_code = '".$sroCode."' and recvd_date = '".$ymdrecvdDate."'";
		 $result=$this->executeQueryStmt($sql);			
		 $rows=$result->fetchRow();
		echo $sln= $rows['sl'];
 
		
    }
    catch(Exception $ex)
    {
	
        echo "Mesg:Failed While Finding Next Slno.";
        exit(0);
    }
    
}
			




 public  function calFee($trcode)
            {
                $qryFee="select * from public.nature where trans_code='$trcode' and  account not in ('M','T')";
                $result=$this->executeQueryNew($qryFee);
                $rowFee=$result->fetchRow();
                
			
                ?>
				
				<?php
				//calculating variables
				  $amt=$_POST['amount'];
				  $_POST['lbody'] = 'P';
				 
		 
						 if(($amt%100)>0)
						 {
						 $wamt = $amt + (100 - ($amt%100));
						 }
						 else
						 { 
						 $wamt = $amt;
						 }
						
						//Calculations on fee//
						
					//-----------P-----------------------
					if($rowFee["rf_fp"]=="P")
					{
						 $fee =$wamt *($rowFee["rf_rate"]/ 100);
						 if(($rowFee["rf_max"]!=0 )&($fee >$rowFee["rf_max"]))
						 {
						  $fee=$rowFee["rf_max"];
						 }
					 
					}
					//-------------F---------------
					if($rowFee["rf_fp"]=="F")
					{
       					 $fee = $rowFee["rf_rate"];
					}
					//-------------U--------------
					if($rowFee["rf_fp"]=="U")
					{
						 $fee = $amt*$rowFee["rf_rate"];
						 if(($rowFee["rf_max"]!=0 )&($fee >$rowFee["rf_max"]))
						 {
						  $fee=$rowFee["rf_max"];
						 }
					}
				
				?>
				<?php
				//calculating stamp  & surcharge
				
				if($_POST['lbody']=="P")
				{
					if($rowFee["sd_pf"]=="P")
					{
					 $stamp = ($wamt*($rowFee["sd_panch"]/ 100));
					}
					else
					{
					 $stamp = $rowFee["sd_panch"];
					}
					if($rowFee["sc_fp"]=="P")
					{
					 $charge = ($wamt*($rowFee["sc_panch"]/ 100));
					}
					else
					{
					 $charge = $rowFee["sc_panch"];
					}
					
				}
				if($_POST['lbody']=="M")
				{
					if($rowFee["sd_pf"]=="P")
					{
					 $stamp = ($wamt*($rowFee["sd_mun"]/ 100));
					}
					else
					{
					 $stamp = $rowFee["sd_mun"];
					}
					if($rowFee["sc_fp"]=="P")
					{
					 $charge = ($wamt*($rowFee["sc_mun"]/ 100));
					}
					else
					{
					 $charge = $rowFee["sc_mun"];
					}
				}
				
				if($_POST['lbody']=="C")
				{
					if($rowFee["sd_pf"]=="P")
					{
					 $stamp = ($wamt*($rowFee["sd_corp"]/ 100));
					}
					else
					{
					 $stamp = $rowFee["sd_corp"];
					}
					if($rowFee["sc_fp"]=="P")
					{
					 $charge = ($wamt*($rowFee["sc_corp"]/ 100));
					}
					else
					{
					 $charge = $rowFee["sc_corp"];
					}
				}
				?>
				 
                    <table width="100%" align="center">
                         <tr>
                                        <td  class="alignLabels" width="25%" >Fee</td>
                                        <td class="alignInputs" width="25%">

                                            <input type="text" name="fee"  id="fee" class="textInputs" 
											value="<?php echo $fee; ?>" onKeyPress="return decimalDigitsCheck(event,'amount','18','2')">
                                        </td>
                                        <td class="alignLabels"  width="25%">Stamp Duty </td>
										<td class="alignInputs" width="25%">
										<input type="text" name="sd" id="sd"   class="textInputs"  
										value="<?php echo $stamp;?>" onKeyPress="return decimalDigitsCheck(event,'amount','18','2')" ></td>
                      </tr>
                                      <tr>
                                        <td class="alignLabels"  width="25%">Sur Charge</td>

                                        <td class="alignInputs"  width="25%">
                                          <input type="text" name="sc" id="sc"   class="textInputs"  
										  value="<?php echo $charge;?>" onKeyPress="return decimalDigitsCheck(event,'amount','18','2')">
                                       </td>

                                        <td class="alignLabels" width="13%">Account </td>
                                        <td class="alignInputs">
										<input type="text"   name="account" readonly  maxlength="1"  id="account"class="textInputs" 
										value="<?php echo $rowFee["account"];?>">
										</td>

                                      </tr>
									  
									 <tr>
                                        <td class="alignLabels"  width="25%">Remarks</td>

                                        <td class="alignInputs"  width="25%">
                                          <input type="text" name="rmrk" id="rmrk"   class="textInputs" >
                                       </td>

                                        <td class="alignLabels" width="13%"> </td>
                                        <td class="alignInputs">
										
										</td>

                      </tr> 
						 <tr>
                                        <!--<td class="subHeading" align="center" colspan="2">
										<input name="save" type="button" class="btnStyle"   
										value="Save" style="width:165px " onClick="javascipt:saveData(this.form);"  >
										</td>-->
										
										 <td class="subHeading" align="center" colspan="4">
											   <input name="Next" type="button" class="btnStyle"   
											   value="Add" style="width:165px " onClick="javascipt:nextData(this.form);"  >
										 </td>
										 
										<!-- <td class="subHeading" align="center" colspan="1">
											<input name="Print" type="button" class="btnStyle"   
											value="Print" style="width:165px " onClick="javascipt:printData(this.form);">
										</td>
										<td class="subHeading" >&nbsp;</td>-->
										 
                                      </tr>				  
                    </table>

               
            <?php
            }// function closing



 public  function ResidInsert($sro,$date,$refno,$slno,$transcode,$amount,$fee,$sd,$sc,$account,$rmrk)
 {


 	$query="select COALESCE(max(receipt_no),0),COALESCE(max(attend_no),0) from serial_no where  year='".date('Y')."'";
    $result=OpenPearlDataBase::getInstance()->executeQueryOrdered($query);
    $rows=$result->fetchRow();
     $receipt_no= $rows[0];
	//echo $date;
	
	$date1= Common::sqlDateformat($date);
	
	 $atndno= $rows[1];
	
	$yr=date('Y');
 	$user_login = $_SESSION['userName'];
 	    $sql = "INSERT INTO account(
            sro_code,year, bookno, docno, date, slno, trans_code, 
            amount, acc_code, regn_fee, stamp_duty, sur_charge, receipt_no, 
            remarks,server_timestamp, insrt_centraldb, 
            user_login, time_stamp)
    VALUES ('$sro', '$yr', 0, '$refno', '$date1',$slno,'$transcode', 
            $amount,'$account', $fee, $sd,$sc, $receipt_no, 
            '$rmrk',current_timestamp, 
            1,'$user_login',current_timestamp)";

$result=$this->executeQueryStmt($sql);
	if($result!="error")
	{
	//echo $sql="update  serial_no set receipt_no= (select max(receipt_no)+1 from serial_no where year='$yr') " ;
   // $result=$this->executeQueryNew($sql);
	
		 //echo "Added Successfully";
		 
 $sql="SELECT year, bookno, docno,slno, trans_code, 
       amount, acc_code, regn_fee FROM account where year='$yr' and docno='$refno' and bookno=0 and trans_code='$transcode' " ;
$result=$this->executeQueryNew($sql);

?>

<table width="100%"  class="subTable">
		    
			<thead>
			<tr><td colspan="8" align="left"  class="subHeading" height="10"><font size="-1">Added Items</font></td></tr>
			<tr>
			<th><h4>Year</h4></th>
			<th><h4>Bookno</h4></th>
			<th><h4>Docno</h4></th>
			<th><h4>Slno</h4></th>
			<th><h4>Amount</h4></th>
			<th><h4>Acc Code</h4></th>
			<th><h4>Reg Fee</h4></th>
			<th><h4>Trans Code</h4></th>
</tr>
</thead>
<?php

while($rows=$result->fetchRow())
{
?>
			<tr align="center"><!-- style="background-image:url(images/sub_tab_header.jpg);"-->
				<td ><font size="-1"><?php echo $rows['year']; ?></font></td>
				<td><font size="-1"><?php echo $rows['bookno']; ?></font></td>
				<td ><font size="-1"><?php echo $rows['docno']; ?></font></td>
				<td ><font size="-1"><?php echo $rows['slno']; ?></font></td>
				<td><font size="-1"><?php echo $rows['amount']; ?></font></td>
				<td ><font size="-1"><?php echo $rows['acc_code']; ?></font></td>
				<td ><font size="-1"><?php echo $rows['regn_fee']; ?></font></td>
				<td ><font size="-1"><?php echo $rows['trans_code']; ?></font></td>
				</tr>
<?php
    }
	?>
 <tr>
                                        <td class="subHeading" align="center" colspan="8">
										<input name="save" type="button" class="btnStyle"   
										value="Save & Print Reciept" style="width:165px " onClick="javascipt:saveData(this.form);"  >
										</td>
								
                                      </tr>		
</table>




<?php
    }
    else
         echo "Error Occured";   
	
 
 }
 
 
 public  function AddAcc_C($sro,$date)
 {
		 
 $sql="SELECT recvd_date,slno, recvd_from, onaccountof,recvd_amt, rec_reference, 
       disb_details, disb_amt, disb_reference FROM account_c where sro_code='$sro' and recvd_date='$date' order by slno" ;
$result=$this->executeQueryNew($sql);

?>

<table width="100%"  class="subTable">
		    
			<thead>
			<tr><td colspan="8" align="left" class="subHeading" height="10"><font size="-1">Added Items</font></td></tr>
			<tr>
			
			<th><h4>Slno</h4></th>
			<th><h4>Recieved From</h4></th>
			<th><h4>On acc of</h4></th>
			<th><h4>Amount</h4></th>
			<th><h4>Rec Ref</h4></th>
			<th><h4>Disb Det</h4></th>
			<th><h4>Disb Amt</h4></th>
			<th><h4>Disb ref</h4></th>
			
</tr>
</thead>
<?php

while($rows=$result->fetchRow())
{
?>
			<tr align="center"><!-- style="background-image:url(images/sub_tab_header.jpg);"-->
				
				<td><font size="-1"><?php echo $rows['slno']; ?></font></td>
				<td ><font size="-1"><?php echo $rows['recvd_from']; ?></font></td>
				<td ><font size="-1"><?php echo $rows['onaccountof']; ?></font></td>
				<td><font size="-1"><?php echo $rows['recvd_amt']; ?></font></td>
				<td ><font size="-1"><?php echo $rows['rec_reference']; ?></font></td>
				<td ><font size="-1"><?php echo $rows['disb_details']; ?></font></td>
				<td ><font size="-1"><?php echo $rows['disb_amt']; ?></font></td>
				<td ><font size="-1"><?php echo $rows['disb_reference']; ?></font></td>
				</tr>
<?php
    }
	?>
 
</table>

<?php
    
 
 }
 
 
 
 
 
 
 
 
 
 function Save_C($sro,$usr,$recvd_date,$rcvd,$onacc,$amt,$rfc,$det,$amtd,$disb_reference)
 {
 //echo $sln = $this->getNextSlno($sro,$recvd_date);
 $rcvddate= Common::sqlDateformat($recvd_date);
 $sql = "select coalesce(max(slno),0)+1  as sl from account_c where sro_code = '$sro' and recvd_date = '$rcvddate'";
 $result=$this->executeQueryStmt($sql);			
 $rows=$result->fetchRow();
$sln= $rows['sl'];
 
 try
    {
         	   $sql = "insert into account_c
                (sro_code, user_login, time_stamp, recvd_date, recvd_from, onaccountof, 
                recvd_amt,rec_reference, disb_details, disb_amt, 
                disb_reference, slno)
                values ('$sro','$usr',current_timestamp,'$rcvddate','$rcvd','$onacc','$amt','$rfc','$det','$amtd','$disb_reference','$sln')";
        $result=$this->executeQueryNew($sql);
                if($result==true)
                {
					echo "Mesg: Success";
				}
				else
					echo "Mesg: Error";
				
    }
    catch(Exception $exp)
    {
        return false;  
    }

 }
 
 
 function Save($refno,$transcode,$type)
 {

 $sro= $_SESSION['loggedinOffice'];
 $year1=date('Y');
 								$ObjLang= new Language();
								$Lang = $ObjLang->lang_English();
								$dbInstance= OpenPearlDataBase::getInstance();
								
       $sq="insert into maccount(sro_code,year, bookno, docno, date, slno, trans_code, amount, acc_code, regn_fee, stamp_duty, sur_charge, receipt_no, remarks,server_timestamp, 
insrt_centraldb, user_login, time_stamp)
	 select sro_code,year, bookno, docno, date, slno, trans_code, amount, acc_code, regn_fee, stamp_duty, sur_charge, receipt_no, remarks,server_timestamp, 
insrt_centraldb, user_login, current_timestamp from account where year='".date('Y')."' and bookno=0 and docno='$refno' ";
	$result=$this->executeQueryStmt($sq);
	if($result!="error")
	{
		
		 if($type=='power_attestation')
		{
		 //echo $type;
		  $sq1="delete from account where year='".date('Y')."' and bookno=0 and docno='$refno';" ;
		   $sq1.="update serial_no set attest_no= (select max(attest_no)+1 from serial_no where year='".date('Y')."')  where year='".date('Y')."' and sro_code='$sro';";
		   $sq1.="update serial_no set receipt_no=(select max(receipt_no)+1 from serial_no where year='".date('Y')."' and sro_code='$sro') where year='".date('Y')."' and sro_code='$sro' ;";
		 
		 }
		else if($type=='others')
		{
		 $sq1="delete from account where year='".date('Y')."' and bookno=0 and docno='$refno';" ;
		 $sq1.="update serial_no set gt_no= (select max(gt_no)+1 from serial_no where year='".date('Y')."')  where year='".date('Y')."' and sro_code='$sro';";
		 $sq1.="update serial_no set receipt_no=(select max(receipt_no)+1 from serial_no where year='".date('Y')."' and sro_code='$sro') where year='".date('Y')."' and sro_code='$sro' ;";
		 }
		 else
		 {
		 $sq1="delete from account where year='".date('Y')."' and bookno=0 and docno='$refno';" ;
		 $sq1.="update serial_no set attend_no= (select max(attend_no)+1 from serial_no where year='".date('Y')."') where year='".date('Y')."' and sro_code='$sro'  ;";
		 $sq1.="update serial_no set receipt_no=(select max(receipt_no)+1 from serial_no where year='".date('Y')."' and sro_code='$sro') where year='".date('Y')."' and sro_code='$sro' ;";
		 }
		 
		// echo $sq1;
		 
		$res=$this->executeQueryStmt($sq1);
		if($res!="error")
		{
			//echo "Success";
		
		$sqlrec="select max(receipt_no) as rec from serial_no where year='".date('Y')."' and sro_code='$sro' ";
		$rec=$this->executeQueryStmt($sqlrec);
	    $rowss=$rec->fetchRow();
		//echo $rowss[];
		
			
		   $sqlrec="select year,docno,date,trans_code,amount,receipt_no,remarks from maccount where year='".date('Y')."' and bookno=0 and docno='$refno'";
			$res=$this->executeQueryStmt($sqlrec);			
			//$rows=$res->fetchRow();
			
			//echo "numrows".
			$numrows=$res->numRows();
			if($numrows>0)
			{
			
				$amt=0;
				//$rmk="";
				while($rows1=$res->fetchRow())
				{
					$rmk[]=$rows1['remarks'].",";
					//$rmk=$rmk." , ".$rows1['remarks'];
					$amt=$amt+$rows1['amount'];
					//echo $rows1['amount'];
				}
				
				
			
			?>
<table bgcolor="#FFFFFF" width="375px" border="2px" align="center"  cellpadding="0" cellspacing="1">

							  <tr align="center">
							<td colspan="4" align="center">
		
								<div id="divToPrint" align="center" style="font-size:14px ">
									 <table align="center" width="90%" cellpadding="2" cellspacing="2">
		
									  <tr>
										<td align="center" colspan="3"  ><img src="images/kerala_state_logo.jpg"></td>
									  </tr>
									  <tr>
									   <td align="center"  colspan="3" ><B><font size="2px">
									Department of Registration, Kerala </font></B></td>
										  </tr>
								  <tr>
									<td  colspan="3"   > <div align="center">Receipt <b><i> <?php //echo "ASDSAA "?></i></b></div></td>
								  </tr>
	<!--                              <tr>
									<td  colspan="3"   > <div align="center"><?php //echo $langarr['TransId'];?>  : <b><?php //echo trim($rows["trans_id"]);?></b></div></td>
								  </tr>-->
								  <tr>
									<td  colspan="3"  >&nbsp;</td>
								  </tr>
								  <tr>
									<td  colspan="2" ><?php echo "Docno" ?>: <font face="Times New Roman, Times, serif" size="-1"><b><i><?php echo $refno;?>/<?php echo $year1;?></i></b></font></td>
									 <td  colspan="1" align="right">Receipt.No : <font face="Times New Roman, Times, serif" size="-1" color="#CC0000"><b><i><?php echo $rowss['rec'];?></i></b></font></td>
								  </tr>
								  <tr>
									<td colspan="3" align="justify">
									
											  <font face="Times New Roman, Times, serif" size="-1"><?php 
											  foreach($rmk as $rmrk)
											  { 
											  	//echo $list = implode(',', $rmrk); 
												print $rmrk;
											  }
											  
											  
											  
											  ?><?php //echo $Lang['sree'];?> <b><i><?php //echo $appname; ?></i></b> <?php //echo $Lang['rcpt_1'];?></font>
									</td>
								  </tr>
								  <tr>
									<td colspan="3">
										<table width="100%"  cellspacing="0" cellpadding="1" border="1" bordercolor="#000000"  style="border-collapse:collapse ">
										  <tr>
											<td width="70%">&nbsp;</td>
											<td width="30%" align="center"><?php echo $Lang['rcpt_8']; ?></td>
										  </tr>
										   <tr>
											<td style="padding-left:10px; ">
											<font face="Times New Roman, Times, serif" size="0">
												<?php 												
												//echo $des;
												$sq="select description from public.nature where trans_code='$transcode'";
												$res=$this->executeQueryStmt($sq);			
												$rows=$res->fetchRow();
												echo $rows['description'];
												
												?>
											</font>                                        </td>
										
											<td align="right" style="padding-right:10px; "><font face="Times New Roman, Times, serif" size="-1"><?php echo $amt;?></font></td>
										  </tr>
										  <tr>
											<td align="right" style="padding-right:10px; "><font face="Times New Roman, Times, serif" size="0"><?php echo $Lang['rcpt_4']; ?></font></td>
											<td align="right" style="padding-right:10px; "><font face="Times New Roman, Times, serif" size="-1"><b><i>
                                                                                        <?php
                                                                                        if(($_POST['transcode'] == "EC99")||($_POST['transcode']=="CC99"))
			                                                                  echo " - ";
                                                                                        echo  $amt.".00"."/-"; ?>
                                                                                                    </i></b></font></td>
										  </tr>
										</table>
	
									</td>
								  </tr>
								  <tr>
									<td colspan="3" align="justify"> 
										<font face="Times New Roman, Times, serif" size="-1"><b><i>
										<?php echo "(".$this->int_to_words((int)trim($amt)). " Only)"; ?>
										</i></b></font>
									</td>
								  </tr>
								 <!-- <tr>
									<td colspan="3">&nbsp;
										
									</td>
								  </tr>-->
								  <tr>
								<td colspan="3">
								<?php
									$qr = "select name from public.sro where code = '".trim($_SESSION['loggedinOffice'])."'";
									  $result=OpenPearlDataBase::getInstance()->executeQueryOrdered($qr);
  		  							$rows=$result->fetchRow();
								?>
									<font face="Times New Roman, Times, serif" size="-1"><?php echo $rows[0]; ?></font>
								</td>
							  </tr>

							  <tr>
							  	<td colspan="1">
									<font face="Times New Roman, Times, serif" size="-1"><?php echo date("d-m-Y");?></font>
								</td>
								<td align="right" colspan="2"><font face="Times New Roman, Times, serif" size="0">
									സബ് രജിസ്ട്രാര്‍
								</font></td>
							  </tr>

							   <tr>
							  	<td colspan="3" align="justify">
										<font face="Times New Roman, Times, serif" size="0"><?php echo "ഈ പകര്‍പ്പ് ------- മാണ്ട് ----- മാസം --------------- ന്---------------- മണിക്ക് തിര്യെ കൊടുക്കാന്‍ തയ്യാറാകും."; ?></font>
								</td>
							  </tr>
							  <tr>
							  	<td colspan="3">&nbsp;

								</td>
							  </tr>
							  <tr>
							  	<td colspan="3" align="right">
										<font face="Times New Roman, Times, serif" size="0"><?php echo "സബ് രജിസ്ട്രാര്‍"; ?></font>
								</td>
							  </tr>

							  <tr>
							  	<td colspan="3" align="justify">
										<font face="Times New Roman, Times, serif" size="1"><?php echo "നോട്ട്:- പകര്‍പ്പ് തയ്യാറാകുന്ന തീയതി മുതല്‍ 15 ദിവസത്തിന്നകം തിര്യെ വാങ്ങാത്ത പക്ഷം അതില്‍ പിന്നീട് താമസിക്കുന്ന ഓരോ 30 ദിവസത്തിനോ അതിന്‍റെ ഭാഗത്തിനോ 25 രൂപ വീതമുള്ളതും എന്നാല്‍ പരമാവധി 100 രൂപയില്‍ കവിയാത്തതുമായ പിഴ ഈടാക്കപ്പെടും. "; ?></font>
								</td>
							  </tr>
									  
									  
								  </table>
								</div>
								<table>
									<tr>
										<td colspan="2" align="center" valign="middle">
											<input  name="btnPrint" type="button" class="btnStyle" id="btnPrint" onClick="ClickHereToPrint();" value="Print" style="width: 100px"/>
										   <input  name="btnClose" type="button" class="btnStyle" id="btnClose" onClick="close1();" value="Close" style="width: 100px"/>
										</td>
							      </tr>
								</table>
						</td>
						  </tr>	</table>
<?php
			
			//}
			
		}
		else
		echo "Error";
	}
	else
		echo "Error";
 
 }
 

 }
}//end of class
?>