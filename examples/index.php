<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/1145e9fad2.js" crossorigin="anonymous"></script>
<style>
	body{
		background:#f1f1f1;
	}
	h1{
		color:#3d3d3d;
	}
	h2{
		color:#3d3d3d;

	}
	table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
	input[type="file"] {
  cursor: pointer !Important;
  font: 300 14px sans-serif;
  color:#9e9e9e;
}
input[type="file"]::-webkit-file-upload-button
{
  font: 300 14px  sans-serif;
  background: #009688;
  border: 0;
  padding: 12px 25px;
  cursor: pointer;
  color: #fff;
  text-transform: uppercase;
}
 
input[type="file"]::-ms-browse {
  font: 300 14px 'Roboto', sans-serif;
  background: #009688;
  border: 0;
  padding: 12px 25px;
  cursor: pointer;
  color: #fff;
  text-transform: uppercase;
}

</style>

<?php
date_default_timezone_set('Europe/Istanbul');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

require_once __DIR__.'/../src/SimpleXLSX.php';
echo '<center><div class="shadow" style="background:white;padding:50px;width:95%;margin-top:60px;">';
echo '<h1 style="text-align:center;">XLSX FORMATINI İNCELEME</h1><hr/>';


echo '


<form method="post" id="excel" enctype="multipart/form-data" style="text-align:center;width:60%;">
<br><br><h2 style="text-align:center;">Excel Dönüştür</h2><br><br>
<input type="file" name="file"  />	
<button class="btn btn-outline-danger" type="submit" >Dönüştür</button>
</form>';
$sayi=0;
if (isset($_FILES['file'])) {
	
	if ( $xlsx = SimpleXLSX::parse( $_FILES['file']['tmp_name'] ) ) {

	
		echo '<center><table table-sm class="table table-dark" id="table">';

		$dim = $xlsx->dimension();
		$cols = $dim[0];
		foreach ( $xlsx->rows() as $k => $r ) {
			//		if ($k == 0) continue; // skip first row
			
			
			echo '<tr class="secim'.$k.'" id="secim'.$k.'" scope="row" onclick="myData('.$k.')">';
		
			for ( $i = 0; $i < $cols; $i ++ ) {
				
				echo '<td >' . ( isset( $r[ $i ] ) ? $r[ $i ] : '&nbsp;' ) . '</td>';
			}
			echo '</tr>';
		}
		echo '</table></center>';
	} else {
		echo '<br><div style="width:40%;" class="alert alert-secondary" role="alert">
		'.SimpleXLSX::parseError().'
	  </div>';
	}
}
echo '</div></center>';
?>
<script>
	var degisken = "<?php echo $sayi; ?>";
	function myData($k){
		x = document.getElementById("table").rows.length;
			var tr = document.getElementsByTagName("tr")[$k];
			var tdl = tr.getElementsByTagName("td").length;
			var excel = new Array();
			for(j=0;j<tdl;j++){
				var td = tr.getElementsByTagName("td")[j];
				excel[j]=td.innerHTML;
			}
			document.getElementById('table').style.display="none";
			document.getElementById('sonuc').style.display="none";
			document.getElementById('excel').style.display="none";
			document.getElementById('tebligat').style.display="block";
			console.log(excel)
			var res = excel[2].split(" ");
			document.getElementById('soyadi').innerHTML='&nbsp'+res[1];
			document.getElementById('adi').innerHTML='&nbsp'+res[0];
			window.adi=res[0];
			window.soyadi=res[1];
	}
	function PrintDiv() {    
       var divToPrint = document.getElementById('tebligat');
       var popupWin = window.open('', '_blank', 'width=700,height=700');
       popupWin.document.open();
       popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
        popupWin.document.close();
    }
	function PrintWord(){
		var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
            "xmlns:w='urn:schemas-microsoft-com:office:word' "+
            "xmlns='http://www.w3.org/TR/REC-html40'>"+
            "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
       var footer = "</body></html>";
       var sourceHTML = header+document.getElementById("tebligat").innerHTML+footer;
       var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
       var fileDownload = document.createElement("a");
       document.body.appendChild(fileDownload);
       fileDownload.href = source;
       fileDownload.download = window.adi+'_'+window.soyadi+'_'+'Tebligat_Pusulası'+'.doc';
       fileDownload.click();
       document.body.removeChild(fileDownload);
	}
		
	function deneme($k){
		var deneme = $("#secim"+$k).text();
		console.log(deneme);

	}
	<?php

	?>
</script>
