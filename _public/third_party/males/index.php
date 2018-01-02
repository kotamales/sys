<?php
$file = array_values(glob('*.xlsx'));

require 'php-excel-reader/excel_reader2.php';
require 'SpreadsheetReader.php';
require 'core.php';

$xls = isset($_GET['f']) ? $_GET['f'] : '1.xlsx';

if (file_exists($xls) && in_array($xls, $file)) {
	$xls = $xls;
} else {
	$xls = '1.xlsx';
}

echo "<h3>Data xlsx yang tersedia</h3>";
echo "<ul>";
foreach ($file as $key => $value) {
	echo '<li>';
	echo $value;
	echo '</li>';
}
echo "<ul>";
echo "silahkan masukkan query string 'f' contoh http://xls.primasoft.co.id/index.php?f=2.xlsx";
echo "<br/>";
echo "download sourcenya di : http://xls.primasoft.co.id/source.tgz";
echo "<br/>";
echo "<h3>DATA YANG DI PROSES " . $xls ."</h3>";
echo "<br/>";

$Reader = new SpreadsheetReader($xls);
$data = [];
foreach ($Reader as $Row)
{
	$data[]= $Row;
}

$core = new Males($data);
// echo "<pre>";
// print_r($core->render('header'));
// echo "</pre>";

// die;
?>
<table border="1">
<?php echo($core->render('table')); ?>
</table>
