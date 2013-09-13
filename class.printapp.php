<?php //start of php1
$status='N';
$langarr="";
require_once("class.gridView.php");
require_once("class.user.php");
class  printapp extends User
{//start of class

var $place=null;
    //********************************************************Load  Application************************************************************************************
	function Loadapplnform()
        {
?>
             <table  align="center" cellpadding="0" cellspacing="1" width="100%" style="border-style: solid; border-width: 1px; border-color: #000"><!-- for border -->
                <tr>
                <td >

                    <table  border="0" align="center" cellpadding="0"  cellspacing="2.5" width="100%">
                     <tr>
                      <td >
                      <tr>
                            <td align="center" colspan="4" class="mainHeading"><strong><font size="-1">PRINT APPLICATION</font> </strong></td>
                      </tr>
                         <tr>
                            <td align="center" colspan="4" class="alignLabels">
                             <span class="mandatoryCaption"> <span class="mandatorySign">*</span> Mandatory fields </span>
                            </td>
                        </tr>
                         <tr>
			  <td class="alignLabels" ><span class="mandatorySign">*</span>Application Type</td>
			  <td class="alignInputs">
			    <select class="selectInputs" id="ddltype" name="ddltype"   tabindex="1"  >
				    			<option value="0">--Select--</option>
                                <option value="EC" ><?php echo "EC"; ?></option>
                                <option value="CC"><?php echo "CC"; ?></option>
                                <!--<option value="LC"><?php //echo "LC"; ?></option>-->
                </select>
			 </td>
			 </tr>
 
                          <tr>
			  <td class="alignLabels" >GsNo/SSNo</td>
			  <td class="alignInputs">
			     <input AUTOCOMPLETE=OFF  type="text"  class="textInputs" id="txtgsno" name="txtgsno"  maxlength="6">
			 </td>
			 </tr>

                         
                        <tr style="display:none">
			  <td class="alignLabels" >Receipt No</td>
			  <td class="alignInputs">
			     <input AUTOCOMPLETE=OFF  type="text"  class="textInputs" id="txtreceipt" name="txtreceipt"  maxlength="8">
			 </td>
			 </tr>
                         <tr>
			  <td class="alignLabels" >Year</td>
			  <td class="alignInputs">
			     <input AUTOCOMPLETE=OFF  type="text"  class="textInputs" id="txtyear" name="txtyear" value="<?php echo date("Y");?>"  maxlength="4">
			 </td>
			 </tr>
			 <tr>
			  <!--<td class="alignLabels" >Select Type</td>
			  <td class="alignInputs">
			     <input type="radio" name="select_type" id="select_type" value="issued" /> Certificate Issued               
				  <input type="radio" name="select_type" id="select_type" value="notissued" /> Certificate Not Issued 
			 </td>-->
			 </tr>


                          <tr>
                              <td  colspan="2" style=" background-color: #F2F7F9" align="center">
			     <input  type="button" name="btnviewtapp" tabindex="34" onClick="viewapp()"  class="btnStyle" value="View Application">
			 </td>
			 </tr>
                         
                  </table>

                </td >
                </tr>
             </table>

                    <?php
        }

         //********************************************************Load  Application************************************************************************************

        function viewAppln($year,$no,$apptype)
        {
		 $type='';
		
		
		$place= $_SESSION['loggedinOffice'];

            try
                {
                $pto=false;
                if($apptype=='EC')
                {
				 $qry="select name from public.sro where code='$place'";
                $rslt=OpenPearlDataBase::getInstance()->executeQuery($qry);
				$rows_sr=$rslt->fetchRow();
				
				 //$type=='notissued';
				
				//if($type=='notissued')
				//{
				
		  $query="select sro_code,appname,addr1,addr2,pin,email,collectec,date(appdate) as appdate,date(search_from) as search_from,date(search_to) as search_to,remarks,extravillages,
	 		extraclaimants,typeofec,modeofpayment,phone,mobile,appfee,priorityfee,ownershipfee,searchfee,
			fees,ecyear,gsno,owner,stat,appfee,villagefee from ecregister where gsno=$no and  ecyear='$year' and stat='S' and coalesce(applicationstatus,'N') not in ('D')";
			
			//else if($type=='issued')
			//{
			 $result=OpenPearlDataBase::getInstance()->executeQuery($query);
		 //$rows=$result->fetchRow();
		 
		 $numrs=$result->numRows();
		 //}
		 if($numrs<=0)
                {
				 $type='issued';
			  $query="select sro_code,appname,addr1,addr2,pin,email,collectec,date(appdate) as appdate,date(search_from) as search_from,date(search_to) as search_to,remarks,extravillages,
	 		extraclaimants,typeofec,modeofpayment,phone,mobile,appfee,priorityfee,ownershipfee,searchfee,
			fees,ecyear,gsno,owner,stat,appfee,villagefee from mecregister where gsno=$no and  ecyear='$year' and stat='S' and coalesce(applicationstatus,'N') not in ('D')";
			
			//}
			
		 $result=OpenPearlDataBase::getInstance()->executeQuery($query);
		 $numrs=$result->numRows();
		 $rows=$result->fetchRow();
		 }
		 else if($numrs>0)
                {  $type='notissued';
					$rows=$result->fetchRow();
                }
		 if($rows==0)
		 {
		 //echo "Mesg: No Such Application Exists";
		 ?>
		<div align="center">
		<br>
		<img src="images/nodata.png" alt="no data" />
		</div>
		<?php
		 exit(0);
		 }
	         $dcode=substr($rows['sro_code'],0,2);

if($type=='notissued')
				{
		  $query="select v.eng_name,s.name,surno,sbdvnno,rsurno,rsbdvnno,hr_acre,ar_cent,unit_mf,sqm_sqlink,ecyear,gsno,east,west,north,south,d.eng_name as desam from ecsurnos e inner join public.village v
			on e.vcode=v.vcode  and v.dcode= e.dcode and v.tcode =e. tcode and v.srocode = e.sro_code and  v.vcode= e.vcode inner join public.sro s on s.code=e.sro_code
			left outer join public.desam d on d.dcode= e.dcode and d.tcode =e. tcode and d.vcode = e.vcode and d.code = e.desam
			where  gsno=$no and  ecyear='$year' and stat='S'  and coalesce(applicationstatus,'N') not in ('D') GROUP BY v.eng_name,s.name,surno,sbdvnno,rsurno,rsbdvnno,hr_acre,ar_cent,unit_mf,sqm_sqlink,ecyear,d.eng_name,
 			gsno,desam,east,west,north,south ORDER BY v.eng_name ";
			
			}
			else if($type=='issued')
				{
		 $query="select v.eng_name,s.name,surno,sbdvnno,rsurno,rsbdvnno,hr_acre,ar_cent,unit_mf,sqm_sqlink,ecyear,gsno,east,west,north,south,d.eng_name as desam from mecsurnos e inner join public.village v
			on e.vcode=v.vcode  and v.dcode= e.dcode and v.tcode =e. tcode and v.srocode = e.sro_code and  v.vcode= e.vcode inner join public.sro s on s.code=e.sro_code
			left outer join public.desam d on d.dcode= e.dcode and d.tcode =e. tcode and d.vcode = e.vcode and d.code = e.desam
			where  gsno=$no and  ecyear='$year' and stat='S'  and coalesce(applicationstatus,'N') not in ('D') GROUP BY v.eng_name,s.name,surno,sbdvnno,rsurno,rsbdvnno,hr_acre,ar_cent,unit_mf,sqm_sqlink,ecyear,d.eng_name,
 			gsno,desam,east,west,north,south ORDER BY v.eng_name ";
			
			}
		$result_surno=OpenPearlDataBase::getInstance()->executeQuery($query);
		$result_surnonew=OpenPearlDataBase::getInstance()->executeQuery($query);
		
	
		$result_new=OpenPearlDataBase::getInstance()->executeQuery($query);

		// $rows_surno=$result_surno->fetchRow();
		$numsurno=$result_surno->numRows();
		if($numsurno>1)
		{
			$pto=true;
		}
if($type=='notissued')
{
		 $query="select docyear,docno from ecdocnos where  gsno=$no and  ecyear='$year' and stat='S'    and coalesce(applicationstatus,'N') not in ('D') order by docyear,docno";
		 }
		else if($type=='issued')
         {
		 $query="select docyear,docno from mecdocnos where  gsno=$no and  ecyear='$year' and stat='S'    and coalesce(applicationstatus,'N') not in ('D') order by docyear,docno";
		 }

		$result_docno=OpenPearlDataBase::getInstance()->executeQuery($query);

		$rows_docno=$result_docno->fetchRow();
		$numdocno=$result_docno->numRows();
		if($numdocno>1)
		{
			$pto=true;
		}

  ?>
  
  
   <?php
  if($type=='notissued')
{
    $sql = "select PU.fname||' '||PU.lname as prepared_user
			from  ecregister MECR inner join public_user PU
			on cast(MECR.prep_by as int) = PU.user_id
			where MECR.gsno = $no and MECR.ecyear = '$year' and sro_code = '$place'";
			}
			else if($type=='issued')
             {
   $sql = "select PU.fname||' '||PU.lname as prepared_user
			from  mecregister MECR inner join public_user PU
			on cast(MECR.prep_by as int) = PU.user_id
			where MECR.gsno = $no and MECR.ecyear = '$year' and sro_code = '$place'";
			}
		$preparedUser = OpenPearlDataBase::getInstance()->executeQuery($sql);
		
		$prusr=$preparedUser->fetchRow();
		
		//return true;
		
		 	if($type=='notissued')
               {	
		 $sql1 = "select PU.fname||' '||PU.lname as verified_user
			from  ecregister_a MECRA inner join public_user PU
			on cast(MECRA.verified_by as int) = PU.user_id
			where MECRA.gsno = $no and MECRA.ecyear = '$year' and MECRA.sro_code = '$place'";
			}
			else if($type=='issued')
               {	
		 $sql1 = "select PU.fname||' '||PU.lname as verified_user
			from  mecregister_a MECRA inner join public_user PU
			on cast(MECRA.verified_by as int) = PU.user_id
			where MECRA.gsno = $no and MECRA.ecyear = '$year' and MECRA.sro_code = '$place'";
			}
		$verifiedUser = OpenPearlDataBase::getInstance()->executeQuery($sql1);
		
		$vrfdusr=$verifiedUser->fetchRow();
		
		//return true;
  
  ?>
 <div id="divToPrint">
 <table width="100%" height="95" border="1" align="center" cellpadding="1" cellspacing="0"><!-- for border -->
 <tr>
<td style="padding:10px; ">
<table  border="0" align="center" cellpadding="0" cellspacing="2.5" width="100%">
  <tr>
    <td colspan="2"><div align="center" class="style1"><font face="Times New Roman, Times, serif" size="+1"><b>Form No 20</b> </font></div></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">Order No. 515(a) </div></td>
  </tr>
   <tr>
    <td colspan="2"><div align="center" class="style1"><font face="Times New Roman, Times, serif" size="+2"><b>പരക്കെ (പൊതു) തിരച്ചില്‍ അപേക്ഷ</b> </font></div></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;

	</td>
  </tr>
  <tr>
    <td ><font  size="0">അപേക്ഷകന്‍റെ പേരും മേല്‍വിലാസവും:</font>

    <?php echo $rows['appname'] . "," . $rows['addr1'] . "," .$rows['addr2'] .",". $rows['pin']; ?></td></tr><tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>

  <tr>
  <td colspan="2"><div align="center"><font  size="0"><?php echo $rows_sr['name']; ?> സബ് രജിസ്ട്രാര്‍ അവര്‍കള്‍ക്ക്</font></div></td>
  </tr>
  
  <tr>
     <td colspan="2" style="padding-left:5px; "><font  size="0">താങ്കളുടെ ആഫീസിലെ പുസ്തകങ്ങള്‍ പരിശോധിച്ചു താഴെ വിവരിക്കുന്ന വസ്തുക്കളെ സംബന്ധിച്ചു ഒരു ബാധ്യത സര്‍ട്ടിഫികറ്റ്
തരുവാന്‍ അപേക്ഷിക്കുന്നു </font>.</td>

<tr>
    <td colspan="2">&nbsp;</td>
  </tr>

  <tr>
    <td colspan="2">
     <table  border="1" align="center" cellpadding="1" cellspacing="0" width="100%">
        <tr>
          <td width="438" style="padding-left:5px "><font  size="0">വസ്തു കിടക്കുന്ന വില്ലേജ്<br>
          (പകുതി) ദേശം </font></td>
          <td width="386" style="padding-left:5px "><?php while($rows_new=$result_new->fetchRow()) { 
		  //echo $rows_new['eng_name'] .",". $rows_new['desam'] ;
		   $array[]= $rows_new['eng_name'] .",". $rows_new['desam'];
		  
		 $array1= array_unique($array);
		
		   } if(isset($array1))
		   {
		    foreach($array1 as $value) {
  print $value;
}
}
		   //print_r($array1); 
		  ?>;</td>
        </tr>
       <tr>
          <td style="padding-left:5px "><font  size="0">വസ്തുവിന്‍റെ പേരും സര്‍വ്വേ നമ്പരും<br>
          വിസ്തീര്‍ണവും </font></td>
          <td style="border-right-color:#FFFFFF; border-top-color:#FFFFFF;">
		  <?php
		 if($numsurno>0 )
		 {
		  ?>
		  <table style="border:thin; border-collapse:collapse; border-bottom-color:#FFFFFF; border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF;" bordercolor="#FFFFFF" border="1" align="center" cellpadding="1" cellspacing="0" width="100%">
		  
		  
		 <thead>
				<tr>
					<th style="border-right-color:#666666; "><font color="#666666">Surno</font></th>
					<th style="border-right-color:#666666; "><font color="#666666">Subdvn</font></th>
					<th style="border-right-color:#666666; "><font color="#666666">ReSurno</font></th>                    
					<th style="border-right-color:#666666; "><font color="#666666">ReSubDvno</font></th>
					<?php
					//if($rows_surno['unit_mf']==1)
		// $U="M";
		// else
		 //$U= "F";
                 //if ($U=="M"){?>
					<th style="border-right-color:#666666;"><font color="#666666">Hectare/Acre</font></th>
					<th style="border-right-color:#666666;"><font color="#666666">Are/Cent</font></th>
					<th style="border-right-color:#FFFFFF;"><font color="#666666">sqMetre/sqLink</font></th>
					<?php
					//}
					//elseif ($U=="F")
					//{
					?>
					<!--<th>Acre</th>
					<th>cent</th>
					<th>sqlink</th>-->
					<?php
					//}
					?>
				    
				</tr>
			</thead>
			<tr>
			</tr>
			<?php 
			//$place= $rows_surno['name'];
			///$numsurno=$result_surno->numRows();
			$i=0;
			while($rows_surno=$result_surno->fetchRow())
		 {
			$i++;
		  ?>
			<tr>
			<td align="center" style="padding-left:5px; border-right-color:#333333; border-top-color:#000000;">
			<?php $qry='';
        if($rows_surno['surno']!='' and $rows_surno['surno']!=0)
                        echo $qry=$rows_surno['surno']; ?>
			</td>
			
			<td align="center" style="padding-left:5px;border-right-color:#333333; border-top-color:#000000; ">
			<?php
			if($rows_surno['sbdvnno']!='')
                       echo $rows_surno['sbdvnno']; ?>
			</td>
			<td align="center" style="padding-left:5px; border-right-color:#333333; border-top-color:#000000; ">
			<?php
			if($rows_surno['rsurno']!='' and $rows_surno['rsurno']!=0)
                        echo $qry=$rows_surno['rsurno']; ?>
			</td>
			<td align="center" style="padding-left:5px; border-right-color:#333333; border-top-color:#000000; ">
			<?php
			if($rows_surno['rsbdvnno']!='')
                        echo $qry=$rows_surno['rsbdvnno'];
			?>
			</td>
			<?php
			 if($rows_surno['unit_mf']==1)
		 $U="M";
		 else
		 $U= "F";
                 if ($U=="M")
				 {
				 $str='';
			?>
			<td align="center" style="padding-left:5px; border-right-color:#333333; border-top-color:#000000;" >
			<?php
			
			if($rows_surno['hr_acre']!='' and $rows_surno['hr_acre']!=0)
                        echo $str=$rows_surno['hr_acre']." Hr ";
			?>
			
			</td>
			<td align="center" style="padding-left:5px; border-right-color:#333333; border-top-color:#000000; ">
			<?php
				
			if($rows_surno['ar_cent']!='' and $rows_surno['ar_cent']!=0)
                         echo $str=$rows_surno['ar_cent']." Ar ";
			?>
			</td>
			<td align="center" style="padding-left:5px; border-right-color:#FFFFFF; border-top-color:#000000; ">
			<?php
				
			if($rows_surno['sqm_sqlink']!='' and $rows_surno['sqm_sqlink']!=0.00)
                        echo $str=$rows_surno['sqm_sqlink']." Sqm ";
			?>
			</td>
			<?php
			}
			elseif ($U=="F")
					{
					$str='';
			?>
			<td align="center" style="padding-left:5px; border-right-color:#333333; border-top-color:#000000;border-left-color:#000000; ">
			<?php 
			if($rows_surno['hr_acre']!='' and $rows_surno['hr_acre']!=0)
                        echo $str=$rows_surno['hr_acre']." Acre ";
			?>
			</td>
			<td align="center" style="padding-left:5px; border-right-color:#333333; border-top-color:#000000; ">
			<?php
			if($rows_surno['ar_cent']!='' and $rows_surno['ar_cent']!=0)
                        echo $str=$rows_surno['ar_cent']." Cent ";
			?>
			</td>
			<td align="center" style="padding-left:5px; border-right-color:#FFFFFF; border-top-color:#000000; ">
			<?php
			if($rows_surno['sqm_sqlink']!='' and $rows_surno['sqm_sqlink']!=0.00)
                        echo $str=$rows_surno['sqm_sqlink']." SqLk ";
			?>
			</td>
			<?php
			}
			
			?>
			</tr>
			<?php
			if($i==5)
			break;
			}
			?>
		</table>
	  <?php
	  }
	  //while($rows_surno=$result_surno->fetchRow())
		// {
		
		/// $numsurno=$result_surno->numRows();
		
		 
		 
		 
		 
	//$qry='';
       // if($rows_surno['surno']!='' and $rows_surno['surno']!=0)
                       //  $qry="Sur: ".$rows_surno['surno'];
                   //  if($rows_surno['sbdvnno']!='' and $rows_surno['sbdvnno']!=0)
                        // $qry=$qry." SubDvn: ".$rows_surno['sbdvnno'];
                    //if($rows_surno['rsurno']!='' and $rows_surno['rsurno']!=0)
                         //$qry=$qry." ReSur: ".$rows_surno['rsurno'];
                   // if($rows_surno['rsbdvnno']!='' and $rows_surno['rsbdvnno']!=0)
                         //$qry=$qry." ReSubDvn: ".$rows_surno['rsbdvnno'];
		//-------------echo  " Sur: ".$rows_surno['surno'] . " SubDvn: ".$rows_surno['sbdvnno']. " ReSur: ".$rows_surno['rsurno']. " ReSubDvn: ".$rows_surno['rsbdvnno'];
                   // echo $qry;
		?>
		 <!--<br>--> <?php
		 
		 
		 //if($rows_surno['unit_mf']==1)
//		 $U="M";
//		 else
//		 $U= "F";
//                 if ($U=="M")
//                 {$str='';
//				 
//			
//                     if($rows_surno['hr_acre']!='' and $rows_surno['hr_acre']!=0)
//                         $str=$rows_surno['hr_acre']." Hr ";
//                     if($rows_surno['ar_cent']!='' and $rows_surno['ar_cent']!=0)
//                         $str=$str.$rows_surno['ar_cent']." Ar ";
//                     if($rows_surno['sqm_sqlink']!='' and $rows_surno['sqm_sqlink']!=0.00)
//                         $str=$str.$rows_surno['sqm_sqlink']." Sqm ";
//
//                  echo  $str;
//                 }
//                 elseif ($U=="F")
//                 {$str='';
//                     if($rows_surno['hr_acre']!='' and $rows_surno['hr_acre']!=0)
//                         $str=$rows_surno['hr_acre']." Acre ";
//                     if($rows_surno['ar_cent']!='' and $rows_surno['ar_cent']!=0)
//                         $str=$str.$rows_surno['ar_cent']." Cent ";
//                     if($rows_surno['sqm_sqlink']!='' and $rows_surno['sqm_sqlink']!=0.00)
//                         $str=$str.$rows_surno['sqm_sqlink']." SqLk ";
//
//                  echo  $str;
//                 }
		  //echo  " HrAc: ".$rows_surno['hr_acre'] . " Ar_cent: ".$rows_surno['ar_cent']. " Unit: ". $U. " Sqm_Sqlink: ".$rows_surno['sqm_sqlink'];
		//}  // end of while loop***************************
                 ?>		  </td>
        </tr>
        <tr>
          <td style="padding-left:5px "><font  size="0">വസ്തുവിന്‍റെ നാലതിരുകള്‍</font></td>
          <td style="padding-left:5px "><br />  
		          <?php
				  $sr=0;
				   while($rows_surno1=$result_surnonew->fetchRow()) 
				   {  
				   $sr++;
				   $bndry[]= "Bndry:".$rows_surno1['east']." (E) " . $rows_surno1['west']." (W)  ". $rows_surno1['north']." (N)  ".$rows_surno1['south']."  (S)"."<br />";
				  $bndry1=array_unique($bndry);
				  if($sr==5)
				  {
				  break;
				  }
				   }
				   if(isset($bndry1))
				   {
				  foreach($bndry1 as $val)
				 {
 print $val;
				 }
				 }
				  ?><br /></td>
        </tr>
	<tr>
         <td style="padding-left:5px "><font  size="0">മുന്‍ ആധാര വിവരം </font></td>

          <td style="padding-left:5px ">

	  <?php
	 /*  if($numdocno>3)$rowcnt=3;else $rowcnt=$numdocno;
	 while($rows_docno=$result_docno->fetchRow())
	  { */
	  echo  $rows_docno['docno'] . "/".$rows_docno['docyear'];
	  //}
	  ?>	  </td>
        </tr>
        <tr>
           <td style="padding-left:5px "><font  size="0">തിരഞ്ഞു നോക്കേണ്ടുന്ന ആണ്ടുകള്‍</font> </td>
          <td style="padding-left:5px "> <?php echo $this->sqlDateformat($rows['search_from']) ;?> <font  size="0">മുതല്‍ </font>. <?php echo $this->sqlDateformat($rows['search_to']);?><font  size="0">വരെ</font></td>
        </tr>
      </table> </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
  <td  colspan="2"><font  size="0">മേല്‍ വിവരിച്ച വസ്തുക്കള്‍ ഒറ്റമുതലാണെന്നും എന്‍റെ അറിവില്‍ പെട്ടിടത്തോളം </font><?php echo "  ". $rows['owner'];?>
    <font  size="0"> ടെ/ന്‍റെ വകയാണെന്നും ഞാന്‍ ഇതിനാല്‍ സാക്ഷ്യപ്പെടുത്തുന്നു.</font> <br></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
     <td colspan="2"><font  size="0">സ്ഥലം :<?php echo $rows_sr['name'];?></font></td>
  </tr>
  <tr>
     <td><font  size="0">തീയതി :</font><?php echo $this->sqlDateformat($rows['appdate']); ?></td>
	<td align="right">Online Application</td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">GS No: <?php echo "  ".$rows['gsno'];?> of <?php echo $rows['ecyear'];?>; </div></td>
  </tr>
  <tr>
    <td colspan="2">Total Fee <?php echo $rows['fees'];?> (<?php echo "Application fee:" .$rows['appfee']; echo ",Search Fee:" .$rows['searchfee'];if($rows['priorityfee']!="") echo ",Priority Fee:" .$rows['priorityfee']; else echo ",Priority Fee:0";?>) </td>
  </tr>
  
   <tr>
    <td colspan="2">Search made in index II ans S I of .................................... </td>
  </tr>
  <tr>
    <td colspan="2">for years.........to .................Documents found Vide, </td>
  </tr>
  <tr>
    <td colspan="2">First Search <?php 
	 if($prusr['prepared_user']!='')
	echo "made by:".$prusr['prepared_user'];
	else
	echo "not done"; ?> </td>
  </tr>
  <tr>
    <td colspan="2">Second Search <?php
	 if($vrfdusr['verified_user']!='' and $prusr['prepared_user']!=$vrfdusr['verified_user']) 
	 echo "made by:".$vrfdusr['verified_user'];
	 else echo "not done." ?> </td>
  </tr>
  <tr>
    <td colspan="2">Verified by:<?php
	 if($prusr['prepared_user']!='' and $vrfdusr['verified_user']!='' and $prusr['prepared_user']!=$vrfdusr['verified_user'])
	 echo $prusr['prepared_user'];
	 else
	 echo "not done." ?> </td>
  </tr>
 <!-- <tr>
    <td colspan="2">EC prepared by.............................................................. </td>
  </tr>-->
  <!--<tr>
    <td  colspan="2">Compared by&nbsp;&nbsp;}&nbsp;&nbsp;&nbsp;&nbsp;Reader...............</td>
  </tr>
  <tr>
    <td colspan="2" style="padding-left:85px; ">}&nbsp;&nbsp;&nbsp;&nbsp;Examiner...............</td>
  </tr>-->
  <tr>
    <td colspan="2" style="padding-left:85px; ">}</td>
  </tr>
  <tr>
    <td colspan="2">EC read on&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}</td>
	<td> </td>
  </tr>
<tr>
<td colspan="2" align="center">
	<input  name="btnPrint" type="button" class="btnStyle" id="btnPrint" onClick="ClickHereToPrint();" value="Print" style="width: 100px" />
	
</td>
</tr>

</table>
     </td>
    </tr>
</table>
<!--</div>
-->
<?php
  if ($pto==true)
  {
$this->addPageBreak();
 if($numsurno>5)
 {
 if($type=='notissued')
               {
  $query="select v.eng_name,surno,sbdvnno,rsurno,rsbdvnno,hr_acre,ar_cent,unit_mf,sqm_sqlink,ecyear,gsno,desam,east,west,north,south from
  ecsurnos e inner join public.village v
			on e.vcode=v.vcode  and v.dcode= e.dcode and v.tcode =e. tcode and v.srocode = e.sro_code and  v.vcode= e.vcode inner join public.sro s on s.code=e.sro_code
			where  gsno=$no and  ecyear='$year' and stat='S'    and coalesce(applicationstatus,'N') not in ('D') GROUP BY v.eng_name,s.name,surno,sbdvnno,rsurno,rsbdvnno,hr_acre,ar_cent,unit_mf,sqm_sqlink,ecyear,
 			gsno,desam,east,west,north,south ORDER BY v.eng_name  offset 5";
			}
			else if($type=='issued')
               {
  $query="select v.eng_name,surno,sbdvnno,rsurno,rsbdvnno,hr_acre,ar_cent,unit_mf,sqm_sqlink,ecyear,gsno,desam,east,west,north,south from
  mecsurnos e inner join public.village v
			on e.vcode=v.vcode  and v.dcode= e.dcode and v.tcode =e. tcode and v.srocode = e.sro_code and  v.vcode= e.vcode inner join public.sro s on s.code=e.sro_code
			where  gsno=$no and  ecyear='$year' and stat='S'    and coalesce(applicationstatus,'N') not in ('D') GROUP BY v.eng_name,s.name,surno,sbdvnno,rsurno,rsbdvnno,hr_acre,ar_cent,unit_mf,sqm_sqlink,ecyear,
 			gsno,desam,east,west,north,south ORDER BY v.eng_name  offset 5";
			}
		$result_surno=OpenPearlDataBase::getInstance()->executeQuery($query);

		//$rows_surno=$result_surno->fetchRow();
		//$numsurno=$result_surno->numRows();
  }

if($numdocno>0)
		{
		 if($type=='notissued')
               {
		$query="select docyear,docno from ecdocnos where  gsno=$no and  ecyear='$year' and stat='S'    and applicationstatus not in ('D') order by slno ";
		}
		else if($type=='issued')
               {
		$query="select docyear,docno from mecdocnos where  gsno=$no and  ecyear='$year' and stat='S'    and applicationstatus not in ('D') order by slno ";
		}
		///$query="select * from ecdocnos";
		$result_docno=OpenPearlDataBase::getInstance()->executeQuery($query);

		$rows_docno=$result_docno->fetchRow();
		//$numdocno=$result_docno->numRows();


		}
		if($numsurno>5)
       {
 ?>
<!--<div id="divProperty">-->
 <table  border="1" align="center" cellpadding="1" cellspacing="0" width="100%"><!-- for border -->
<tr>
<td style="padding:10px; ">
	<?php
	 //if($numsurno>1)
      // {
	?>
	
	<table  border="0" align="left" cellpadding="0"  cellspacing="2.5" width="100%">


	  <?php
	  $vname="";
		 while($rows_surno=$result_surno->fetchRow())
		 {
			//echo  " Sur: ".$rows_surno['surno'] . " SubDvn: ".$rows_surno['sbdvnno']. " ReSur: ".$rows_surno['rsurno']. " ReSubDvn: ".$rows_surno['rsbdvnno'];

		if($vname!=$rows_surno['eng_name'])
		{
		?>
		 <tr><th><?php echo $rows_surno['eng_name']; ?></th></tr>
		<tr>
		<td colspan=4>		------------------------------------------------------------------------------------------------------------------------------------
		</td></tr>
		<?php
		$vname=$rows_surno['eng_name'];
		}
		 ?>

		 <br>
		 <tr>
		 <td width="15%">
		 Sur_Sbd :<?php echo $rows_surno['surno'] ;
		 if(trim($rows_surno['sbdvnno'])!='')
		  echo "| ".$rows_surno['sbdvnno']; ?>
		 </td>
		 <td width="20%">
		 ReSur_Resub:<?php echo $rows_surno['rsurno'] ;
		 if(trim($rows_surno['rsbdvnno'])!='')
		 echo "| ".$rows_surno['rsbdvnno']; ?>
		 </td>
		 <td width="20%">
		 <?php
		 if($rows_surno['unit_mf']==1)
		 $U="M";
		 else
		 $U= "F";
		 
		 if($U=="M")
		 {
		 $hr="Hr";
		 $ar="Are";
		 $sqm="sqm";
		 }
		 else if($U=="F")
		 {
		 $hr="Acre";
		 $ar="cent";
		 $sqm="SqLk";
		 }
		 
		 if($rows_surno['hr_acre']!=0 or $rows_surno['ar_cent']!=0 or $rows_surno['sqm_sqlink']!=0.00)
		 {
		 ?>
		<!-- H/Ac/Ar--><?php // echo "(".$U."):";
		 if($rows_surno['hr_acre']!=0 ) echo $rows_surno['hr_acre'].$hr;
		 if($rows_surno['ar_cent']!=0 ) echo " ".$rows_surno['ar_cent'].$ar;
		 if($rows_surno['sqm_sqlink']!=0 ) echo " ".$rows_surno['sqm_sqlink'].$sqm;
		 }
		 ?>
		  </td>
        <!--</tr>
	  <tr>-->
	  
		 <td>
		 
		 <br />
		 Bndry:<?php echo $rows_surno['east']."(E) ";
		 echo $rows_surno['west']."(W) ";
		 echo $rows_surno['north']."(N) ";
		 echo $rows_surno['south']."(S) ";
		 ?>
		 
		 </td>
	  </tr>
 <!--</table>-->
		<?php

		}//end of loop

            }//end of if
		 ?>
</table>
    </td>
   </tr>
</table>



<!--//*********************************************************-->
<?php
 if($numdocno>1)
       {
	?>
<table  border="1" align="center" cellpadding="1" cellspacing="0" width="100%"><!-- for border -->
<tr>
<td style="padding:10px; "> 

	<table  border="0" align="left" cellpadding="0"  cellspacing="2.5" width="100%">

<tr>
                <th align="left">Previous document Details<br /><br /><br />
                <td colspan="4"></td>
          </tr>
                <tr>
               <td>
					------------------------------------------------------------------------------------------------------------------------------------</td>
                </tr>
                
                <tr>
                <td>
                <?php
                $i=0;
                while($rows_docno=$result_docno->fetchRow())
                {
                echo  $rows_docno['docno'] . "/".$rows_docno['docyear']." ; ";
                $i++;
                if($i==12)
                {
                ?>
                <br>
                <?php
                }
                }
                ?>
                </td>
                </tr>
	</table>
	</td>
   </tr>
   
</table>
</div>

	
	
 <?php
 }
  }


//*******************************
 

}
?>
<!--<div id="divBtn">
<table align="center"  width="100%">
	<tr align="center">
	<td colspan="2" align="center">
	<input  name="btnPrint" type="button" class="btnStyle" id="btnPrint" onClick="ClickHereToPrint();" value="Print" style="width: 100px" />
	</td>
	</tr>
	</table>
	</div>-->
<?php
}
       catch(Exception $e)
  {
	echo "Mesg:Failed While Printing Application";
  }  
        }

//******************************************************************************************************
function addPageBreak()
#Common Page Break for all Reports
{		 
?>
 <h1 style="page-break-after:always"></h1>
<?php
}

function viewCCAppln($year,$no,$apptype,$receipt)
{
try
{  
		$ObjLang= new Language();
		$Lang = $ObjLang->lang_English();

	   $query="select appname, addr1, addr2, trans_code,exe_name,exe_surname,cl_name,cl_surname,docyear,docno,bookno,ssno,app_fees,s_fees 
		 from ccregister where  applicationstatus in ('C') and ccyear='$year' and ssno='$no'";
		 if($receipt!="") 
		 $query.=" and receiptno=$receipt";
		 
		 //$query="select appname, addr1, addr2, trans_code,exe_name,exe_surname,cl_name,cl_surname,docyear,docno,bookno,ssno 
		 //from ccregister where  applicationstatus in ('D','I','F','C') and stat='P' and ccyear='$year' and ssno='$no'";

		 //echo $query="select * from ccregister where applicationstatus='C' and stat='P' and ccyear='$year' and ssno=$no";
		 $result=OpenPearlDataBase::getInstance()->executeQuery($query);
		 $numrows=$result->numRows();
		 //$rows=$result->fetchRow();
		 if($numrows<=0)
		 {
		  $query="select appname, addr1, addr2, trans_code,exe_name,exe_surname,cl_name,cl_surname,docyear,docno,bookno,ssno,app_fees,s_fees 
		 from mccregister where  applicationstatus in ('C') and ccyear='$year' and ssno='$no'";
		 if($receipt!="") 
		 $query.=" and receiptno=$receipt";
		 
		 $result=OpenPearlDataBase::getInstance()->executeQuery($query);
		 $rows=$result->fetchRow();
		 }
		 else if($numrows>0)
		 {
		 $rows=$result->fetchRow();
		 }
		 
		 
		 if($rows==0)
		 {
		 //echo "Mesg: No Such Application Exists";
		 ?>
		<div align="center">
		<br>
		<img src="images/nodata.png" alt="no data" />
		</div>
		<?php
		 exit(0);
		 }
		 
		 $ofc=$_SESSION['loggedinOffice'];
		 $usr=$_SESSION['userName'];
		 
		 $qur_usr="select is_sro from public_user where user_officecode='$ofc' and user_name = '$usr'";
		$result_usr=OpenPearlDataBase::getInstance()->getOne($qur_usr);
		 
		 if($result_usr == 't')
		 {
		 	 $query_sro = "select name from public.sro where code = '$ofc'";
			$result_sro=OpenPearlDataBase::getInstance()->getOne($query_sro);
		 }
		 else
		 if($result_usr == 'f')
		 {
		 	 $query_sro = "select name from public.office_code where code = '$ofc'";
			$result_sro=OpenPearlDataBase::getInstance()->getOne($query_sro);
		 }
		 
		 $totfee=$rows['app_fees']+$rows['s_fees'];
?>
<div id="divToPrint">
 <table width="100%" height="50"  border="1" align="center" cellpadding="1" cellspacing="0"><!-- for border -->
<tr>
<td style="padding-bottom:20px; padding-left:50px; padding-right:50px; padding-top:10px; ">  
<table  border="0" align="center" cellpadding="0"  cellspacing="2.5" width="100%">
  <tr>
    <td colspan="2"><div align="center" class="style1"><font face="Times New Roman, Times, serif" size="+1"><b>Form No 19</b> </font></div></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">Order No. 515(a) </div></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center" class="style1"><font face="Times New Roman, Times, serif" size="+1"><b><?php echo $Lang['cc_form_1'];?></b></font></div></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;
		
	</td>
  </tr>
  <tr>
    <td >
		<font  size="-2"><?php echo $Lang['cc_form_2'];?> : <b><?php echo $rows['appname'];?></b></font>

	</td></tr>
  <tr>
  <tr>
    <td colspan="2"><font size="-2"><?php echo $Lang['cc_form_3'];?> : <b><?php echo $rows['addr1'];?> , <?php echo $rows['addr2'];?></b></font></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" ><?php echo $result_sro; ?> <font  size="-2"><?php echo $Lang['cc_form_4'];?>, </font></td>
    <tr>
    <td colspan="2" style=" padding-left:25px; "><font  size="-2"><?php echo $Lang['cc_form_5'];?> :</font> </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
<!--  </tr>-->
  
    <tr>
    <td colspan="2"><font  size="-2"><?php echo $Lang['cc_form_6'];?> : <b><?php echo $rows['trans_code'];?></b></font></td>
  </tr>
    
 <!-- </tr>-->
  
    <tr>
    <td colspan="2"><font  size="-2"><?php echo $Lang['cc_form_7'];?> : <b><?php echo $rows['exe_name'];?>, <?php echo $rows['exe_surname'];?></b></font></td>
  </tr>
    
 <!-- </tr>-->
  
    <tr>
    <td colspan="2"><font  size="-2"><?php echo $Lang['cc_form_8'];?> : <b><?php echo $rows['cl_name'];?>, <?php echo $rows['cl_surname'];?></b></font></td>
  </tr>   
  <!--</tr>-->
    <tr>
    <td colspan="2"><font  size="-2"><?php echo $Lang['cc_form_9'];?> : </font></td>
  </tr>
    
  <!--</tr>-->
  
    <tr>
    <td colspan="2"><font  size="-2"><?php echo $Lang['cc_form_10'];?> : </font></td>
  </tr>
    
  <!--</tr>-->
  
    <tr>
    <td colspan="2"><font  size="-2"><?php echo $Lang['cc_form_11'];?> : <b><?php echo $rows['docyear'];?></b></font></td>
  </tr>
    
  <!--</tr>-->
  
    <tr>
    <td colspan="2"><font  size="-2"><?php echo $Lang['cc_form_12'];?> : <b><?php echo $rows['docno'];?>/<?php echo $rows['bookno'];?>/<?php echo $rows['docyear'];?></b></font></td>
  </tr>
 <!-- </tr>-->
    <tr>
    <td colspan="2" width="100%"> <hr></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td ><font  size="-2"><?php echo $Lang['cc_form_13'];?></font></td>
	<td align="right" ><font  size="-2"><?php echo $Lang['cc_form_14'];?></font></td>
  </tr>
    <tr>
    <td colspan="2">&nbsp;</td>
  </tr>  
      <tr>
    <td colspan="2"><font  size="-2">SS.No : <b><?php echo $rows['ssno'];?>/<?php echo date("Y");?></b> C. No .............<?php echo date("Y"); ?> </font></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
      <tr>
    <td colspan="2"><font  size="-2">Search Fees : <b>Rs. <?php echo $totfee; ?>/-</b></font></td>
  </tr>
    <tr>
    <td colspan="2"><font  size="-2">&nbsp;</font></td>
  </tr>
      <tr>
    <td colspan="2"><font  size="-2">Search made on index (......................) for ...........................years</font></td>
  </tr>
    <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
      <tr>
    <td colspan="2"><font  size="-2">Copy fees</font></td>
  </tr>
    <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
      <tr>
    <td colspan="2"><font  size="-2">Document found Read out</font></td>
  </tr>  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
      <tr>
    <td colspan="2"><font  size="-2">Book ............................Vol ............................. Page .................... Number .......................</font></td>
  </tr>
  <td colspan="2">&nbsp;</td>
  </tr>
      <tr>
    <td colspan="2"><font  size="-2">Year .......................... Stamp ................ ....... No of Pages</font></td>
  </tr> 
  <td colspan="2">&nbsp;</td>
  </tr>
      <tr>
    <td colspan="2"><font  size="-2">Search made by .........................................</font></td>
  </tr> 
  <td colspan="2">&nbsp;</td>
  </tr>
      <tr>
    <td colspan="2"><font  size="-2">Search Verified by ......................................</font></td>
  </tr> 
  <td colspan="2">&nbsp;</td>
  </tr>
      <tr>
    <td colspan="2"><font  size="-2">Copy prepared by........................................</font></td>
  </tr> 
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
      <tr>
    <td colspan="2"><font  size="-2">Book ............................Vol ............................. Page .................... Number .......................</font></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
      <tr>
    <td colspan="2"><font  size="-2">Compared by <span style="padding-left:5px; ">Reader ....................</span></font></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
      <tr>
    <td colspan="2"><font  size="-2"><span style="padding-left:85px; ">Examiner ...................</span></font></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
      <tr>
    <td colspan="2"><font  size="-2">................................... Stamp Rs ....................... and sheets of paper produced on ............................</font></td>
  </tr>
   <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
      <tr>
    <td colspan="2" align="right"><font  size="-2">Sub Registrar</font></td>
  </tr>
  
<tr>
<td colspan="2" align="center">
	<input  name="btnPrint" type="button" class="btnStyle" id="btnPrint" onClick="ClickHereToPrint();" value="Print" style="width: 100px"/>
</td>
	
</tr>
</table>

<td >
</td>
  </tr>

</table>
</div>

<?php
}
catch(Exception $e)
  {
	
	echo "Mesg:";
	echo $query;
  }
}


//******************************************************************************************************
}//end of class
?>