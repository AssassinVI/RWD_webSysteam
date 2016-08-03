<?php
  require_once '../tcpdf/tcpdf.php';

  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false); //不要頁首
$pdf->setPrintFooter(false); //不要頁尾
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);  //設定自動分頁

$pdf->setFontSubsetting(true); //產生字型子集（有用到的字才放到文件中）
$pdf->SetFont('mingliu', '', 12, '', true); //設定字型 新細明體
$pdf->AddPage(); //新增頁面

$html='<h1>你好嗎??</h1>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('contact.pdf', 'I');
?>