
<script src="./jsvalidate.js" ></script>
<script>
	//window.onload = function()	{checkDisplay();	}	
	function getCheckedValue(radioObj) {
		if(!radioObj)
			return "";
		var radioLength = radioObj.length;
		if(radioLength == undefined)
			if(radioObj.checked)
				return radioObj.value;
			else
				return "";
		for(var i = 0; i < radioLength; i++) {
			if(radioObj[i].checked) {
				return radioObj[i].value;
			}
		}
		return "";
	}

	function checkDisplay(){
		var eplQ = getCheckedValue(document.f1.EPLQuestion);
		 if (eplQ != "")
		 {
			if (eplQ =="Yes"){
				document.getElementById("EPLBarcode").style.display='Block';
				document.getElementById("NewUser").style.display='none';
				document.f1.newEplPin.value = "";
				document.f1.confirmEplPin.value = "";
			}else if (eplQ =="No"){
				document.getElementById("EPLBarcode").style.display='none';
				document.getElementById("NewUser").style.display='Block';
				document.f1.eplBarCode.value = "";
				document.f1.currentEplPin.value = "";
				
			}
		 }
	}
	window.onload = function()	{checkDisplay();	}	
</script>
<?php
set_default($_POST['gender']); 
set_default($_POST['birthdate']); 

foreach($_SESSION['userInfo'] as $key=>$value){
	$userInfo[$key][0]=$_SESSION['userInfo'][$key][0];
	if ( is_null($userInfo[$key][0]) ){
		$userInfo[$key][0]="";
	}
}
?>
<form name="f1" method="post" onsubmit="return ValidateForm();">
					<?php
						if ($messaging->getErrorString()!=""){ ?>
							<br>
							<font color="Red"><?php echo $messaging->getErrorString(); ?></font><br>
					<?php } ?>
					
						<table width="60%">
							<tr class="entrydata"><td align="">Barcode:</td><td><?php echo $userInfo['ID'][0]; ?></td></tr>
							<tr class="entrydata"><td align="">Name:</td>
							<td><?php echo "{$userInfo['FIRST_NAME'][0]} {$userInfo['MIDDLE_NAME'][0]} {$userInfo['LAST_NAME'][0]}";?> </td></tr>
							<tr class="entrydata"><td width="22%" align="">Phone:</td><td><?php echo $userInfo['PHONE'][0]; ?> 		</td></tr>
							<tr class="entrydata"><td align="">Address:</td><td><?php echo $userInfo['ADDRESS'][0]; ?> 	</td></tr>
							<?php if ($userInfo['LINE2'][0] != ""){ ?>
							<tr class="entrydata"><td align="">Line 2:</td>
									<td><?php echo $userInfo['LINE2'][0]; ?></td></tr>
							<?php } ?>
							<tr class="entrydata"><td align="">City, Prov: </td>
									<td><?php echo $userInfo['CITYPROV'][0]; ?></td></tr>
							<tr class="entrydata"><td align="">Postal Code:</td><td><?php echo $userInfo['POSTALCODE'][0]; ?></td></tr>
							<tr class="entrydata"><td align="">Country:</td><td><?php echo $userInfo['COUNTRY'][0]; ?> 	</td></tr>
							<tr class="entrydata"><td align="">Email:</td><td><?php echo $userInfo['EMAIL'][0]; ?> </td></tr>
						</table>
						
						
						<br>
						<table cellpadding="2">
						<tr><td>Do you currently have an Edmonton Public Library (EPL) account?</td></tr>
						<tr><td>
						<Label style="padding-bottom:0.0em;" for="Yes">Yes </LABEL>
						<input type="Radio" name="EPLQuestion" onclick="checkDisplay(this)" value="Yes" id="Yes">
						<br>
						<Label style="padding-bottom:0.0em; padding-right: 3px;" for="No">No</LABEL>
						<input type="Radio" name="EPLQuestion" onclick="checkDisplay(this)" value="No" id="No">

						</td></tr>
						</table>
						<hr style="width:75%;text-align:left;margin-left:0" />

						<div id="EPLBarcode" style="display:none">
						<table width="70%" cellpadding="2">
							<tr><td><br></td></tr>
							<tr class="entrydata"><td colspan="2"  >
							<b> Please enter in your EPL or L-PASS barcode  &amp; PIN  below.</b></td></tr>
							<tr><td><br></td><td></td></tr>
							<tr class="entrydata"><td width="45%" align="top"> BarCode (No Spaces 21221XXXXXXXXX or 132XXXXXXXXXX):</td><td><input type="text" value="" name="eplBarCode" SIZE="22" MAXLENGTH="20"></td></tr>
							<tr class="entrydata"><td align="">Pin (1-10 characters):</td><td><input type="password" value="" name="currentEplPin" SIZE="22" MAXLENGTH="20"></td></tr>
							<tr><td><br></td></tr>
						</table>
						<hr style="width:75%;text-align:left;margin-left:0" />
						</div>


						<div id="NewUser" style="display: none">
						<table cellpadding="2">
							<tr class="entrydata"><td colspan="2"  >
							<!--- If you do NOT have an Edmonton Public Library (EPL) card ---> Please enter in a PIN number you would like to use below (1-10 characters):</td></tr>
							<tr><td>&nbsp;</td></tr>
							<tr class="entrydata"><td width="20%" align="">New PIN:</td><td>
							<input type="password" value="" name="newEplPin" SIZE="22" MAXLENGTH="20"></td></tr>
							<tr class="entrydata"><td align="">Confirm PIN:</td>
							<td>
							<input type="password" value="" name="confirmEplPin" SIZE="22" MAXLENGTH="20"></td></tr>
							<tr><td><br></td></tr>
						</table>
						<hr style="width:75%;text-align:left;margin-left:0" />
						</div>

						<table width=80% cellpadding="2">
							<tr class="entrydata"><td colspan="2" bgcolor="" >
							Please select the library branch you want to use for picking up material placed on hold
							<!--- Note: If you have entered in a valid EPL Barcode and pin above your EPL record will be updated to the library branch you select below.
							If no EPL Barcode or an invalid EPL Barcode/pin has been entered above a new record will be created. --->
							</td></tr>
							<tr><td>&nbsp;</td></tr>
							<tr class="entrydata"><td>Home EPL Branch:

							</td>
					<td>
						<select name="homelibrary">
							<option value=""></option>
							<option value="EPLABB">Abbottsfield-Penny Mckee Branch</option>
							<option value="EPLCAL">Calder Branch</option>
							<option value="EPLCPL">Capilano Branch </option>
							<option value="EPLCSD">Castle Downs Branch</option>
							<option value="EPLHIG">Highlands Branch</option>
							<option value="EPLIDY">Idylwylde Branch</option>
							<option value="EPLJPL">Jasper Place Branch</option>

							<option value="EPLLHL">Lois Hole Library</option>
							<option value="EPLLON">Londonderry Branch</option>
							<option value="EPLMLW">Mill Woods Branch</option>
							<option value="EPLMNA">Stanley A. Milner Library</option>
							<option value="EPLRIV">Riverbend Branch</option>
							<option value="EPLSPW">Sprucewood Branch</option>
							<option value="EPLSTR">Strathcona Branch</option>
							<option value="EPLWMC">Whitemud Crossing Branch</option>
							<option value="EPLWOO">Woodcroft Branch</option>
						</select>							<a target=_blank href="http://www.epl.ca/about-epl/branches-and-hours/">EPL Branches</a>
					</td></tr>

							<tr class="entrydata"><td align="">Gender: </td>
								<td>
								<label style="padding-bottom: 0px;" for="m">Male:</label><input type="radio" id="m" name="gender" value="Male"><br>
								<label for="f">Female:</label><input type="radio" id="f" name="gender" value="Female"></td></tr>
							<tr class="entrydata"><td align=""><font color="Red"></font>Birthdate: </td><td><input type="text" name="birthdate" size="10"> (mm/dd/yyyy)</td></tr>
							<tr class="entrydata"><td colspan="2" align="center">
							<br>
										<div align="left">
												To qualify for this EPL service, you must allow MacEwan to send the above information to the Edmonton Public Library.
												By clicking on the "I Agree" button below, you are giving permission to MacEwan University to give your personal data displayed on this page to the Edmonton Public Library to create your account in its system
												Your personal information will not be used for other purposes unless requested.
												<br><br>

												The information you submit is collected under the authority of Section 33(c) of the Freedom of Information and Protection of Privacy Act (Alberta) by MacEwan University under agreement with Edmonton Public Library.
												It will not be used for any other purpose.
												If you have a question about the collection of this information, please contact <a target="_blank" href="http://library.macewan.ca/staff_directory">Debbie McGugan, Associate Dean, Libraries</a>.

												<br><br>

												The Edmonton Public Library collects customer information under the authority of the Alberta Libraries Act and the Freedom of Information and Protection of Privacy Act.
												<br><br>
											


										</div>
										<br>
							<div align="left"><br>
								<input type="submit" style='width: 100px; height: 30px;' value="I Agree"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input style='width: 100px; height: 30px;' type="button" onclick="javascript:document.location.href='agreementcancel.php'" value="Cancel">
							</div>
							</td></tr>

						</table>
		</form>