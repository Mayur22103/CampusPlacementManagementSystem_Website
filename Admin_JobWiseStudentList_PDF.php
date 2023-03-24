<?php
require("./fpdf/fpdf.php");
class PDF extends FPDF
{
    /* Page header */
    function Header()
    {

        $this->SetFont('Arial', 'B', 15);
        /* Move to the right */
        $this->Cell(40);

        $this->Cell(100, 10, 'Job Wise Selected Student', 1, 0, 'C');
        $this->Ln(20);

    }
    /* Page footer */
    function Footer()
    {
        /* Position at 1.5 cm from bottom */
        $this->SetY(-15);
        /* Arial italic 8 */
        $this->SetFont('Arial', 'I', 8);
        /* Page number */
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

/* Instanciation of inherited class */
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);
$pdf->SetLeftMargin(30);
$pdf->SetFillColor(193, 229, 252);
$pdf->Cell(20, 10, 'No', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'student name', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Degree Name', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Company name', 1, 1, 'C', true);

$id = $_POST['jt'];
$count = 0;
$conn = new mysqli("localhost", "root", "", "minor_project");
$query = "SELECT company.c_name,company.c_id,jobdetails.userid,jobdetails.j_title,jobdetails.skill,jobdetails.j_type,student.s_name,student.s_degname,student.selected_status FROM jobdetails INNER JOIN company  ON jobdetails.userid=company.c_id INNER JOIN student ON student.s_degname=jobdetails.j_type WHERE student.selected_status=2 and jobdetails.j_title='$id'";
$record = $conn->query($query);
while (($row = $record->fetch_array()) == true) {
    $pdf->Cell(20, 10, ++$count, 1, 0, 'C');
    $pdf->Cell(40, 10, $row['s_name'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['s_degname'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['c_name'], 1, 1, 'C');

}
$pdf->Output();

?>