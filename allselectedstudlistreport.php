<?php
require("./fpdf/fpdf.php");
class PDF extends FPDF
{
    /* Page header */
    function Header()
    {

        $this->SetFont('Arial', 'B', 15);
        $this->Cell(50, 10, 'CPMS');
        $this->Ln(7);


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

session_start();
$id = $_SESSION['userid'];
$count = 0;
$conn1 = new mysqli("localhost", "root", "", "minor_project");
$query1 = "SELECT company.c_name FROM company  where c_id=$id ";
$record1 = $conn1->query($query1);
$row1 = $record1->fetch_array();
$dt = date("d/m/Y");

/* Instanciation of inherited class */
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 10, 'Company Name : ');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, $row1['c_name']);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 10, 'Print Date : ');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, $dt);
$pdf->Ln(15);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(43);
$pdf->Cell(100, 10, 'ALL SELECTED STUDENT LIST', 1, 0, 'C');
$pdf->Ln(20);

$pdf->SetFont('Times', '', 12);
$pdf->SetFillColor(193, 229, 252);
$pdf->Cell(20, 10, 'Index No', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Student Name', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Job Title', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Job type', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Skill', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Salary', 1, 1, 'C', true);



$count = 0;
$conn = new mysqli("localhost", "root", "", "minor_project");
$query = "SELECT student.s_name,jobdetails.j_title,j_type,sal,skill FROM student INNER JOIN apply on apply.student_id=student.s_id  INNER JOIN jobdetails on jobdetails.j_id=apply.jobdetail_id where apply.status=2 and jobdetails.userid=$id";
$record = $conn->query($query);
while (($row = $record->fetch_array()) == true) {
    $pdf->Cell(20, 10, ++$count, 1, 0, 'C');
    $pdf->Cell(30, 10, $row['s_name'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['j_title'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['j_type'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['skill'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['sal'], 1, 1, 'C');
}
$pdf->Output();

?>