<?php

set_time_limit(300);

include_once "class.writeexcel_workbookbig.inc.php";
include_once "class.writeexcel_worksheet.inc.php";

$fname = tempnam("/tmp", "bigfile.xls");
$workbook = &new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$worksheet->set_column(0, 50, 18);

for ($col=0;$col<50;$col++) {
    for ($row=0;$row<6000;$row++) {
        $worksheet->write($row, $col, "ROW:$row COL:$col");
    }
}

$workbook->close();

header("Content-Type: application/x-msexcel");
$fh=fopen($fname, "rb");
fpassthru($fh);
unlink($fname);

?>
