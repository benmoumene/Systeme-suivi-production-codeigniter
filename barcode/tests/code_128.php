<?php
    
    //Include the barcode script
    
    include_once '../barcode.php';
    
    //Handle if text posted
	
	if($_POST['text']) {
		
        //Create the barcode
        
		$img			=	code128BarCode($_POST['text'], 1);
		$text1			=	$_POST['text1'];
        $text2			=	$_POST['text2'];
        $text3			=	$_POST['text3'];

        //Start output buffer to capture the image
        //Output PNG image
        
		ob_start();
		imagepng($img);
		
        //Get the image from the output buffer
        
		$output_img		=	ob_get_clean();
		
	}
?>

<!DOCTYPE html>

<html lang="en-US">
	
	<head>
		
		<title>Barcode Generator</title>
		
	</head>
	
<body>
	
	<form action="" method="post">
		
		PO No: <input type="text" style="width:200px;" name="text3" id="text3" autofocus required onkeyup="tabToSize();"/>
		Size: <input type="text" style="width:200px;" name="text2" id="text2" autofocus required onkeyup="tabToGmt();"/>
		Garments No.: <input type="text" style="width:200px;" name="text" id="text" autofocus required onkeyup="saveDataAndReload();"/>
		<input type="submit" id="submit" value="Create Barcode >" />
		
	</form>
	
	<br /><br /><br /><br />

    <div id="printableArea">
    	<?php if($_POST['text']) echo '<b> Size: '. $text2 .'</b><br /><b> PO No.: '. $text3 .'</b>'.'<br /><b> Gmt:'.$_POST['text'].' </b><br />'.'<img src="data:image/png;base64,' . base64_encode($output_img) . '" />'; ?>
<!--        <br />-->
<!--        --><?php //if(!empty($output_img)){ ?>
<!--        ------------------------>
<!--        <p style="color: rgba(30,54,255,0.8); margin-left: 50px;">X</p>-->
<!--        --><?php //} ?>
<!--    	--><?php //if($_POST['text']) echo '<b> Size: '. $text2 .'</b><br /><b> PO No.: '. $text3 .'</b>'.'<br /><b> Gmt:'.$_POST['text'].' </b><br />'.'<img src="data:image/png;base64,' . base64_encode($output_img) . '" />'; ?>
<!---->
<!--        --><?php //if(!empty($output_img)){ ?>
<!--           <br />-->
<!--           <br />-->
<!--           <br />-->
<!---->
<!--        --><?php //}?>
<!---->
    </div>
    <?php if(!empty($output_img)){ ?>
        <br /><a href="#" target="_blank" onclick="printDiv('printableArea')">Print</a>
    <?php }?>

</body>
	
</html>

<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

    function tabToSize() {
        var text3 = document.getElementById("text3").value;
        if(text3 != ''){
            document.getElementById("text2").focus();
        }
    }

    function tabToGmt() {
        var text2 = document.getElementById("text2").value;
        if(text2 != ''){
            document.getElementById("text").focus();
        }
    }


    function saveDataAndReload() {
        var text = document.getElementById("text").value;
        if(text != ''){
            //window.location.reload(true);
            document.getElementById("submit").click();
        }
    }
</script>