<?php
	require_once("./pearllogin_template.php");
	require_once("./classes/class.generaltransactions.php");
	$viewObj = new view();
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Power Attestation</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
$viewObj->commonCSSLinks();
$viewObj->commonJavaScriptFiles();
?>
<style>
.curvedd {
 -moz-border-radius:10px;
 -webkit-border-radius:10px;
  behavior:url(border-radius.htc);
   background-color: #f2f6f6;
   padding-left: 10px;
   padding-top: 10px;
   padding-right: 10px;
   padding-bottom: 10px;
   xmargin-top: 40px;
   xmargin-left:50px;
   border-style:solid;
   border-width:2px;
   border-color:#518AE1;
   }
</style>
<link rel="stylesheet" type="text/css" href="css/report_style.css">
<script type="text/javascript">
var utf8="<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
var printresult=null;
//function validateEntryForm(obj_form)
//{
	// if(!_isEmpty(obj_form.txt_desc,"Description")) return false;	 
//	 if(!_isEmpty(obj_form.refno,"Reference No.")) return false;	 
//	 if(!_isSelected(obj_form.sro,'SRO'))   return false;
//	 if(!_isDate(obj_form.date,"Date","M")) return false;	
//	 if(!_isSelected(obj_form.transcode,'Transaction Code'))   return false;
//     if(!_isEmpty(obj_form.amount,"Amount")) return false;
//	 if(!_isEmpty(obj_form.rmrk,"Remark")) return false;
	// return true;
//}

//===================================================


function submitFrm()
{

var type=0;
var radios = document.getElementsByName("select_type");
 for (var i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                type=radios[i].value;
            }
        }
		
		 pwrAttestRes(type);
       
}

function alertMesg(results,divID)
{
    if(_isTrim(results)!="")
        {
           
        
     if(_isTrim(results).substring(0,4)=="Mesg")
    {
        alert(_isTrim(results).substring(5,_isTrim(results).length));
        return false;
    }
    
    else if(_isTrim(results).search("Message")!=-1)
    {
        //alert(results);
        window.location.href="index.php";
        return false;
    }
    else
    {
        document.getElementById(divID).innerHTML='';

    document.getElementById(divID).innerHTML=utf8+results;

    return true;
    }
        }
}


function pwrAttestRes(type)
{
//alert(type);
var aTok = document.getElementById('frmpwrAttestation').tok.value; 


callPhp_get('xml/xmlgeneraltransactions.php?option=2&tok='+escape(document.frmpwrAttestation.tok.value)+'&type='+type ,handle_powerAttestation);
}

function handle_powerAttestation()
{
//alert("nic");
 if(http.readyState==4 && http.status==200)
    {
       results=http.responseText;
	   //alert(_isTrim(results));
	   alertMesg(results, "divcontent");
    }
}

function showFee(obj_form)
{
	if(!_isSelected(obj_form.transcode,'Transcode'))   return false;
	 //var trcode=document.getElementById('transcode').value

 if(!_isDecimal(obj_form.amount,"Amount","M")) return false;
 
  getFees(obj_form);
       
}
function getFees(obj_form)
{
     
         callphp(obj_form,'xml/xmlgeneraltransactions.php?option=6&tok='+obj_form.tok.value+'&tcode='+obj_form.transcode.value,handle_getFees);
}
function handle_getFees()
{
    if(http.readyState==4 && http.status==200)
    {
       results=http.responseText;
	   alertMesg(results, "div_fee_dtls");
    }
}

function nextData(obj_form)
{
// if(!_isEmpty(obj_form.txt_desc,"Description")) return false;	 
//	 if(!_isEmpty(obj_form.refno,"Reference No.")) return false;	 
//	 if(!_isSelected(obj_form.sro,'SRO'))   return false;
//	 if(!_isDate(obj_form.date,"Date","M")) return false;	
//	 if(!_isSelected(obj_form.transcode,'Transaction Code'))   return false;
	  if(!_isEmpty(obj_form.amount,"Amount")) return false;
	 if(!_isEmpty(obj_form.rmrk,"Remark")) return false;
   		callphp(obj_form,'xml/xmlgeneraltransactions.php?option=7&tok='+obj_form.tok.value,handle_nextData);
	 
}
function handle_nextData()
{			
    if(http.readyState==4 && http.status==200)
    {
      	  results=http.responseText; 
	  	  //alertMesg(results, "grid");

		  var slno = document.getElementById('slno').value;
		  var one = 1;
		  nxtVal = parseInt(slno) + parseInt(one) ;
		 
		  document.getElementById('slno').value = nxtVal;
	
		  //document.getElementById('div_fee_dtls').innerHTML='';
		  document.getElementById('amount').value="";
		  alertMesg(results, "div_fee_dtls1");
		   document.getElementById('amount').value="";
	  	  document.getElementById('fee').value="";
		  document.getElementById('sd').value="";
		  document.getElementById('sc').value="";
		  document.getElementById('rmrk').value="";
		   document.getElementById('account').value="";
    }
}


function saveData(obj_form)
{
var type=0;
var radios = document.getElementsByName("select_type");
 for (var i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                type=radios[i].value;
            }
        }
	//alert(type);	
		
//var type1="power_attestation";	
callphp(obj_form,'xml/xmlgeneraltransactions.php?option=5&tok='+obj_form.tok.value+'&type='+type,handle_saveData);

}

function handle_saveData()
{

  if(http.readyState==4 && http.status==200)
		 {
		   results=http.responseText;
                    //alertMesg(results, 'divDeclaration');
		
			if(results!="")
			 {  
				 if(_isTrim(results).substring(0,4)=='Mesg')
                                 {
                                    alert(_isTrim(results).substring(5,_isTrim(results).length));
                                 }
                                  else if(_isTrim(results).search('Message')!=-1)
                                 {
                                     window.location.href='index.php';
                                 }
                                 else
                                     {
									document.getElementById('divcontent').innerHTML = '';
									document.getElementById('divcontent').innerHTML=utf8+results;
									printresult=results;
									}
			 }
		  }//readystste==4
		   else
                            {
                                var loadingImg = "<br /><br /><br /><div align=\"center\"><img src=\"images/loading_img.gif\" align=\"top\" alt=\"Loading..\"></div>";
								
                              document.getElementById('divcontent').innerHTML='';
                              document.getElementById('divcontent').innerHTML=loadingImg;
								
                            }
                           
}

function ClickHereToPrint()
		{
		
		var oIframe = document.getElementById('ifrmPrint');
		var asdf=printresult.split('btnPrint');
		var res=printresult.replace('value="Print"','style="display:none"');
        var res=res.replace('value="Close"','style="display:none"');
		var oContent = res;
		var oDoc = (oIframe.contentWindow || oIframe.contentDocument);
		if (oDoc.document) oDoc = oDoc.document;
		oDoc.write("</head><body onload='this.focus(); this.print();'>");
		oDoc.write(oContent + "</body>");
		oDoc.close();
	
		}
		
		
function Slno(obj_form)
{
	serialno(obj_form);
	
}
function fillgrid(obj_form)
{
//alert("ddddd");
	callphp(obj_form,'xml/xmlgeneraltransactions.php?option=4&tok='+obj_form.tok.value,handle_Grid);
}

function handle_Grid()
{

 if(http.readyState==4 && http.status==200)
    {
      	  results=http.responseText; 
		  alertMesg(results, "div_fee_dtls1");
		  
		
	}
}



function serialno(obj_form)
{
	if(!_isDate(obj_form.recvd_date,"Date","M")) return false;	
	if(!_isDateBeforeToday(obj_form.recvd_date," Date","M")) return false;
	callphp(obj_form,'xml/xmlgeneraltransactions.php?option=3&tok='+obj_form.tok.value,handle_Slno);
	
}



function handle_Slno()
{

 if(http.readyState==4 && http.status==200)
    {
      	  results=http.responseText; 
		  alertMesg(results, "divslno");
		  
		  var obj_form=document.getElementById('frmpwrAttestation');		  
		  fillgrid(obj_form);
		  //alert(_isTrim(results));
		// document.getElementById('divslno').innerHTML=results;
		// document.getElementById('slno1').value=results;
		  
	}
}

function saveAcc_C(obj_form)
{


	  
  if(!_isDate(obj_form.recvd_date,"Date","M")) return false;		  
  if(!_isEmpty(obj_form.rcvd,"Recieved From")) return false;	 
  if(!_isEmpty(obj_form.onacc,"On Account of")) return false;
  if(!_isNumber(obj_form.amt,"Amount","M")) return false;	 
  if(!_isEmpty(obj_form.rfc,"Ref $ Cross ref to Disbursed")) return false;
  if(!_isEmpty(obj_form.det,"Details of Disbursement ")) return false;
  //if(!_isEmpty(obj_form.amtd,"Amount Disbursed ")) return false;
  if(!_isNumber(obj_form.amtd,"Amount Disbursed","M")) return false;	
  if(!_isEmpty(obj_form.disb_reference,"Ref $ Cross ref with reciept no")) return false;
   
//	 if(!_isSelected(obj_form.sro,'SRO'))   return false;
//	 if(!_isDate(obj_form.date,"Date","M")) return false;	
//	 if(!_isSelected(obj_form.transcode,'Transaction Code'))   return false;
//     if(!_isEmpty(obj_form.amount,"Amount")) return false;
	  
callphp(obj_form,'xml/xmlgeneraltransactions.php?option=8&tok='+obj_form.tok.value,handle_saveDataC);

}

function handle_saveDataC()
{

 if(http.readyState==4 && http.status==200)
    {
      	  results=http.responseText; 
		  //alertMesg(results, "acc_C");
		 // document.getElementById('acc_C').innerHTML='';
		  document.getElementById('rcvd').value="";
	  	  document.getElementById('onacc').value="";
		  document.getElementById('amt').value="";
		  document.getElementById('rfc').value="";
		  document.getElementById('det').value="";
		   document.getElementById('amtd').value="";
		   document.getElementById('disb_reference').value="";
		   var obj_form=document.getElementById('frmpwrAttestation');		  
		  fillgrid(obj_form);
		  serialno(obj_form);
		  
	}
}






function nextData_C(obj_form)
{

callphp(obj_form,'xml/xmlgeneraltransactions.php?option=4&tok='+obj_form.tok.value,handle_nextData_C);
	 
}
function handle_nextData_C()
{
    if(http.readyState==4 && http.status==200)
    {
      	  results=http.responseText; 
	  	  //alertMesg(results, "grid");

		  var slno = document.getElementById('slno').value;
		  var one = 1;
		  nxtVal = parseInt(slno) + parseInt(one);
		 
		  document.getElementById('slno').value = nxtVal;
	
		  
		  document.getElementById('amount').value="";
		  alertMesg(results, "div_fee_dtls1");
		   document.getElementById('amount').value="";
	  	  document.getElementById('fee').value="";
		  document.getElementById('sd').value="";
		  document.getElementById('sc').value="";
		  document.getElementById('rmrk').value="";
		   document.getElementById('account').value="";
    }
}


function close1()
    {
	var str='generaltransactions.php?tok='+escape(document.frmpwrAttestation.tok.value)+'&flogin=f';
        window.location.href=str;
    }
	
</script>
<style type="text/css">
.note_table
{
    border-collapse:collapse;
    background-color:#EEEEDD;
    border-color:#DBDBCC;
    /*padding:20px;*/
    font-size:13px;
    padding-bottom:10px;
    padding-left:10px;
    padding-right:10px;
    padding-top:10px;
}
</style>
</head>

<body>
<?php

$viewObj->headerview();
$viewObj->Logintoken();

?>

<form method="post" id="frmpwrAttestation" name="frmpwrAttestation" enctype="multipart/form-data"  >
<input AUTOCOMPLETE=OFF name="tok" id="tok" type="hidden" value="<?php echo htmlentities($strToken,ENT_QUOTES);?>" >

			
			<div id="divdisplay">
			<?php
			
			$objpwrAttest= new GeneralTransaction();
			$objpwrAttest->gnTransactionFrm();
			?>
			</div>
			<div id="divcontent1" align="center">
			 
			</div>




<iframe id="ifrmPrint" src="#" style="width:0px; height:0px; display:list-item"></iframe>
</form>
<?php //view::footerview();
$viewObj->footerview();
 ?>

</body>
</html>
