<?php
    $encFile = Yii::getAlias('@app/views/invoice/converter.php'); 
    require_once($encFile);

$html = "<div style='padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;'>
            <div style='display: flex;'>
                <div style='float: left;width: 75%;margin-top: -10px;'>
                    <img width='10%' src='upload/vaneshwari80.jpg'>
                    <h1 style='text-align: center;margin-top: -50px;color: #0288ae;margin-left: 235px;'><b>Vaneshwari Holidays</b></h1>
                    <h4 style='text-align: center;margin-top: -10px;color: #0288ae;font-size: 20px;margin-left: 235px;'><b>Tour & Travel Service</b></h4>
                    <h4 style='text-align: center;color: #0288ae;font-size: 20px;margin-left: 211px;margin-top: -25px;'><b>GSTIN : 33AAZFA5022B2ZR</b></h4>
                </div>
                <div style='float: left;width: 25%;padding-left: 26px;'>
                    <p style='color: #0288ae;font-size: 16px;margin-top:-15px;'>No. 62A, Duraisamy Salai,</p>
                    <p style='color: #0288ae;font-size: 16px;margin-top:-15px;'>Rajeev Nagar, Vanagaram,</p>
                    <p style='color: #0288ae;font-size: 16px;margin-top:-15px;'>Chennai - 600 077,</p>
                    <p style='color: #0288ae;font-size: 16px;margin-top:-15px;'>Cell : 9940067085, 8122003357</p>
                    <p style='color: #0288ae;font-size: 16px;margin-top:-15px;'>Email : ambe_das@yahoo.co.in</p>
                    <p style='color: #0288ae;font-size: 16px;margin-top:-15px;'>Web : www.vaneshwariholidays.com</p>
                </div>
            </div>
        </div>

<br><br><br><br><br><br><br>
<div>
    <span style='display: inline-block; width: 70%; margin-top:10px; float:left;'>
        <label style='color: #0288ae;font-size: 16px;font-weight: bold;'>Buyer Name&nbsp;:&nbsp;</label>
        <label>" . $model->buyerName . "</label>
    </span>
    <span style='display: inline-block; width: 30%; margin-top:10px; float:left;'>
        <label style='color: #0288ae;font-size: 16px;font-weight: bold;'>Invoice Id&nbsp;:&nbsp;</label>
        <label>" . $model->invoiceId . "</label>
    </span>
    <br><br>
    <span style='display: inline-block; width: 70%; margin-top:10px; float:left;'>
        <label style='color: #0288ae;font-size: 16px;font-weight: bold;'>Address&nbsp;:&nbsp;</label>
        <label>" . $model->buyerAddress . "</label>
    </span>
    <span style='display: inline-block; width: 30%; margin-top:10px; float:left;'>
        <label style='color: #0288ae;font-size: 16px;font-weight: bold;'>Invoice Date&nbsp;:&nbsp;</label>
        <label>" . $model->date . "</label>
    </span>
</div>
";
$html .= "</br></br><table border='1' width='100%' style='border-collapse: collapse;'><thead>
<tr>
    <th>Sl. No.</th>
    <th>Description</th>
    <th>HSN</th>
    <th>Amount Rs.</th>
</tr>
</thead>";

for ($i = 0; $i < count($sections); $i++) {
    $a = $sections[$i]['name'];
    $b = $sections[$i]['hsn'];
    $c = $sections[$i]['amount'];
    $name = $a ? $a : '';
    $hsn = $b ? $b : '';
    $amount = $c ? $c : '';
    $j = $i + 1;
    $html .= "<tr><td width='10%'>" . $j . "</td><td >" . $name . "</td><td width='20%'>" . $hsn . "</td><td width='20%'>" . $amount. "</td>";
}
$html .= "<tr><td colspan='3'> CSGT 5%</td><td>". $model->cgst. "</td></tr>";
$html .= "<tr><td colspan='3'> SGST 5%</td><td>". $model->sgst. "</td></tr>";
$html .= "<tr><td colspan='3'>TOTAL(Rs.)=  "  . ucwords(getIndianCurrency($model->totalAmount))  . "</td><td>".$model->totalAmount."</td></tr>";
$html .= "</table>";

$footer = "<footer>
<div style='float: right;width: 20%;'>
    <h4 style='color: #e5411b;font-size: 18px;margin-top: 18px;'>
    <b>For Vaneshwari Holidays</b></h4>
    <img width='50%' src='upload/sign.jpg' style='margin: -18px 0px 0px 65px;text-align: right;'>
    <h4 style='color: #0288ae;text-align: center;'><b>INCHARGE</b></h4>
</div></footer>";



$html .= $footer;

// echo $html;
// die;

$filename = "invoice_".$model->invoiceId;

// reference the Dompdf namespace
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
ob_end_clean();
$dompdf->render();
$dompdf->stream($filename);
exit;
