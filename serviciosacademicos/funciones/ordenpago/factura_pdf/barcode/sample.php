<html>
<head>
	<title>Barcode Sample</title>
</head>
<body bgcolor="#FFFFCC">
<table align='center'>
 <tr>
  <td><a href="home.php"><img src="home.png" border="0"></a></td>
  <td><img src="sample.png" border="1"></td>
  <td><a href="download.php"><img src="download.png" border="0"></a></td>
 </tr>
</table>
<br><br>
<?php 
 define (__TRACE_ENABLED__, false);
 define (__DEBUG_ENABLED__, false);
								   
 require("barcode.php");		   
 require("i25object.php");
 require("c39object.php");
 require("c128aobject.php");
 require("c128bobject.php");
 require("c128cobject.php");
 						  
/* Default value */
if (!isset($output))  $output   = "png"; 
if (!isset($barcode)) $barcode  = "0123456789";
if (!isset($type))    $type     = "I25";
if (!isset($width))   $width    = "460";
if (!isset($height))  $height   = "120";
if (!isset($xres))    $xres     = "2";
if (!isset($font))    $font     = "5";
/*********************************/ 
									
if (isset($barcode) && strlen($barcode)>0) {    
  $style  = BCS_ALIGN_CENTER;					       
  $style |= ($output  == "png" ) ? BCS_IMAGE_PNG  : 0; 
  $style |= ($output  == "jpeg") ? BCS_IMAGE_JPEG : 0; 
  $style |= ($border  == "on"  ) ? BCS_BORDER 	  : 0; 
  $style |= ($drawtext== "on"  ) ? BCS_DRAW_TEXT  : 0; 
  $style |= ($stretchtext== "on" ) ? BCS_STRETCH_TEXT  : 0; 
  $style |= ($negative== "on"  ) ? BCS_REVERSE_COLOR  : 0; 
  
  switch ($type)
  {
    case "I25":
			  $obj = new I25Object(250, 120, $style, $barcode);
			  break;
    case "C39":
			  $obj = new C39Object(250, 120, $style, $barcode);
			  break;
    case "C128A":
			  $obj = new C128AObject(250, 120, $style, $barcode);
			  break;
    case "C128B":
			  $obj = new C128BObject(250, 120, $style, $barcode);
			  break;
    case "C128C":
                          $obj = new C128CObject(250, 120, $style, $barcode);
			  break;
	default:
			$obj = false;
  }
  if ($obj) {
     if ($obj->DrawObject($xres)) {
         echo "<table align='center'><tr><td><img src='./image.php?code=".$barcode."&style=".$style."&type=".$type."&width=".$width."&height=".$height."&xres=".$xres."&font=".$font."'></td></tr></table>";
     } else echo "<table align='center'><tr><td><font color='#FF0000'>".($obj->GetError())."</font></td></tr></table>";
  }
}
?>
<br>
<form method="post" action="sample.php">
<table align="center" border="1" cellpadding="1" cellspacing="1">
 <tr>
  <td bgcolor="#EFEFEF"><b>Type</b></td>
  <td><select name="type" style="WIDTH: 260px" size="1">
  		<option value="I25" <?php if($type=="I25"){echo "selected";}?>>Interleaved 2 of 5
  		<option value="C39" <?php if($type=="C39"){ echo "selected";}?>>Code 39
  		<option value="C128A" <?php if($type=="C128A"){ echo "selected"}?>>Code 128-A
		<option value="C128B" <?php if($type=="C128B"){ echo "selected"}?>>Code 128-B
        <option value="C128C" <?php if($type=="C128C"){ echo "selected"}?>>Code 128-C</select></td>
 </tr>
 <tr>
  <td bgcolor="#EFEFEF"><b>Output</b></td>
  <td><select name="output" style="WIDTH: 260px" size="1">
   		<option value="png" <?php if($output=="png"){echo "selected"}?>>Portable Network Graphics (PNG)
   		<option value="jpeg" <?php if($output=="jpeg"){echo "selected";}?>>Joint Photographic Experts Group(JPEG)</select></td>
 </tr>
 <tr>
  <td rowspan="4" bgcolor="#EFEFEF"><b>Styles</b></td>
  <td rowspan="1"><input type="Checkbox" name="border" <?php if($border=="on"){echo "CHECKED";}?>>Draw border</td>
 </tr>
 <tr>
  <td><input type="Checkbox" name="drawtext" <?php if($drawtext=="on"){echo "CHECKED";}?>>Draw value text</td>
 </tr>
 <tr>
  <td><input type="Checkbox" name="stretchtext" <?php if($stretchtext=="on"){echo "CHECKED";}?>>Stretch text</td>
 </tr>
 <tr>
  <td><input type="Checkbox" name="negative" <?php if($negative=="on"){echo "CHECKED";}?>>Negative (White on black)</td>
 </tr>
 <tr>
  <td rowspan="2" bgcolor="#EFEFEF"><b>Size</b></td>
  <td rowspan="1">Width: <input type="text" size="6" maxlength="3" name="width" value="<?php echo $width?>"></td>
 </tr>
 <tr>
  <td>Height: <input type="text" size="6" maxlength="3" name="height" value="<?php echo $height?>"></td>
 </tr>
 <tr>
  <td bgcolor="#EFEFEF"><b>Xres</b></td>
  <td>
      <input type="Radio" name="xres" value="1" <?php if($xres=="1"){echo "CHECKED";}?>>1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="Radio" name="xres" value="2" <?php if($xres=="2"){echo "CHECKED";}?>>2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="Radio" name="xres" value="3" <?php if($xres=="3"){echo "CHECKED";}?>>3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </td>
 </tr>
 <tr>
  <td bgcolor="#EFEFEF"><b>Text Font</b></td>
  <td>
      <input type="Radio" name="font" value="1" <?php if($font=="1"){echo "CHECKED";}?>>1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="Radio" name="font" value="2" <?php if($font=="2"){echo "CHECKED";}?>>2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="Radio" name="font" value="3" <?php if($font=="3"){echo "CHECKED";}?>>3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="Radio" name="font" value="4" <?php if($font=="4"){echo "CHECKED";}?>>4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="Radio" name="font" value="5" <?php if($font=="5"){echo "CHECKED";}?>>5&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </td>
 </tr>
 <tr>
  <td bgcolor="#EFEFEF"><b>Value</b></td>
  <td><input type="Text" size="24" name="barcode" style="WIDTH: 260px" value="<?php echo $barcode?>"></td>
 </tr>
 <tr>
 </tr>
 <tr>
  <td colspan="2" align="center"><input type="Submit" name="Submit" value="Show"></td>
 </tr>
</table>
</form>
</body>
</html>
