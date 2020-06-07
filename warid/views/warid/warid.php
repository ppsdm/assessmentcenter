<?php


require __DIR__ . '/../../../vendor/reno/tcpdf/tcpdf.php';;

//============================================================+
// File name   : example_048.php
// Begin       : 2009-03-20
// Last Update : 2013-05-14
//
// Description : Example 048 for TCPDF class
//               HTML tables and table headers
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: HTML tables and table headers
 * @author Nicola Asuni
 * @since 2009-03-20
 */
// Dummy Variable Data Diri
$nama           = $result['biodata']['nama'];
$no             = '5454';
$jabatanlamar   = 'dada';

$ttl            = $result['biodata']['tanggal_lahir'];
$tujuan         = 'sadada';
$pendidikan     = $result['biodata']['pendidikan'];
$tgltes         = 'Juni 2020';
$tempattes      = 'Jakarta';
$ttd            = "Drs. Budiman Sanusi, MPsi.";
$himpsi         = "0111891963";

$namaaspek = "GENERAL INTELLIGENCE";
$judul     = "PSIKOGRAM HASIL ASSESSMENT / PEMERIKSAAN PSIKOLOGIS";

$bobot1 = 19; // General Intelligence

$bobot3 = 9; // Interpersonal Understanding
$bobot4 = 9; // Stabilitas Emosi
$bobot6 = 9; // Kepercayaan diri
$bobot10 = 9; // Kemandirian bobot

$bobot2 = 9; // Achievement motivation
$bobot5 = 9; // Pengambilan resiko
$bobot7 = 9; // Inisiatif
$bobot8 = 9; // Kerjasama
$bobot9 = 9; // Ketekunan

$total_bobot =  $bobot1 + $bobot2 + $bobot3+ $bobot4+ $bobot5+ $bobot6+ $bobot7+ $bobot8+ $bobot9+ $bobot10;

$total_min = 0;
$total_pribadi = 0;
$total_max = 0;

$min1 = 1 * $bobot1;$min2 = 1 * $bobot2;$min3 = 1 * $bobot3;$min4 = 1 * $bobot4;$min5 = 1 * $bobot5;$min6 = 1 * $bobot6;$min7 = 1 * $bobot7;$min8 = 1 * $bobot8;$min9 = 1 * $bobot9;$min10 = 1 * $bobot10;
$max1 = 7 * $bobot1;$max2 = 7 * $bobot2;$max3 = 7 * $bobot3;$max4 = 7 * $bobot4;$max5 = 7 * $bobot5;$max6 = 7 * $bobot6;$max7 = 7 * $bobot7;$max8 = 7 * $bobot8;$max9 = 7 * $bobot9;$max10 = 7 * $bobot10;

$total_min = $min1 + $min2 + $min3 + $min4 + $min5 + $min6 + $min7 + $min8 + $min9 + $min10;
$total_max = $max1 + $max2 + $max3 + $max4 + $max5 + $max6 + $max7 + $max8 + $max9 + $max10;

$riasec = strtoupper($result['riasec']);


$rating1 = $result['aspek']['inteligensi_umum'];
$rating2 = $result['aspek']['daya_analisa_sintesa'];
$rating3 = $result['aspek']['konseptual'];
$rating4 = $result['aspek']['pengetahuan_umum'];
$rating5 = $result['aspek']['kemampuan_numerik'];
$rating6 = $result['aspek']['klasifikasi_diferensiasi'];
$rating7 = $result['aspek']['kemampuan_dasar_keteknikan'];
$rating8 = $result['aspek']['orientasi_pandang_ruang'];
$rating9 = $result['aspek']['kecepatan_kerja'];
$rating10 = $result['aspek']['ketelitian_kerja'];
$rating11 = $result['aspek']['konsentrasi'];
$rating12 = $result['aspek']['stabilitas_emosi'];
$rating13 = $result['aspek']['penyesuaian_diri'];
$rating14 = $result['aspek']['hubungan_interpersonal'];



$pribadi1 = $rating1 * $bobot1 ;
$pribadi2 =  $rating2 * $bobot2;
$pribadi3 =  $rating3 * $bobot3;$pribadi4 =  $rating4 * $bobot4;$pribadi5 =  $rating5 * $bobot5;$pribadi6 =  $rating6 * $bobot6;$pribadi7 =  $rating7 * $bobot7;$pribadi8 =  $rating8 * $bobot8;$pribadi9 =  $rating9 * $bobot9;$pribadi10 =  $rating10 * $bobot10;
$total_pribadi = $pribadi1 + $pribadi2 + $pribadi3 + $pribadi4 + $pribadi5 + $pribadi6 + $pribadi7 + $pribadi8 + $pribadi9 + $pribadi10;
if ($rating1 == 1 ){ $rat11 = "grey";} else { $rat11 = "";}
if ($rating1 == 2 ){ $rat12 = "grey";} else { $rat12 = "";}
if ($rating1 == 3 ){ $rat13 = "grey";} else { $rat13 = "";}
if ($rating1 == 4 ){ $rat14 = "grey";} else { $rat14 = "";}
if ($rating1 == 5 ){ $rat15 = "grey";} else { $rat15 = "";}
if ($rating1 == 6 ){ $rat16 = "grey";} else { $rat16 = "";}
if ($rating1 == 7 ){ $rat17 = "grey";} else { $rat17 = "";}

if ($rating2 == 1 ){ $rat21 = "grey";} else { $rat21 = "";}
if ($rating2 == 2 ){ $rat22 = "grey";} else { $rat22 = "";}
if ($rating2 == 3 ){ $rat23 = "grey";} else { $rat23 = "";}
if ($rating2 == 4 ){ $rat24 = "grey";} else { $rat24 = "";}
if ($rating2 == 5 ){ $rat25 = "grey";} else { $rat25 = "";}
if ($rating2 == 6 ){ $rat26 = "grey";} else { $rat26 = "";}
if ($rating2 == 7 ){ $rat27 = "grey";} else { $rat27 = "";}

if ($rating3 == 1 ){ $rat31 = "grey";} else { $rat31 = "";}
if ($rating3 == 2 ){ $rat32 = "grey";} else { $rat32 = "";}
if ($rating3 == 3 ){ $rat33 = "grey";} else { $rat33 = "";}
if ($rating3 == 4 ){ $rat34 = "grey";} else { $rat34 = "";}
if ($rating3 == 5 ){ $rat35 = "grey";} else { $rat35 = "";}
if ($rating3 == 6 ){ $rat36 = "grey";} else { $rat36 = "";}
if ($rating3 == 7 ){ $rat37 = "grey";} else { $rat37 = "";}

if ($rating4 == 1 ){ $rat41 = "grey";} else { $rat41 = "";}
if ($rating4 == 2 ){ $rat42 = "grey";} else { $rat42 = "";}
if ($rating4 == 3 ){ $rat43 = "grey";} else { $rat43 = "";}
if ($rating4 == 4 ){ $rat44 = "grey";} else { $rat44 = "";}
if ($rating4 == 5 ){ $rat45 = "grey";} else { $rat45 = "";}
if ($rating4 == 6 ){ $rat46 = "grey";} else { $rat46 = "";}
if ($rating4 == 7 ){ $rat47 = "grey";} else { $rat47 = "";}

if ($rating5 == 1 ){ $rat51 = "grey";} else { $rat51 = "";}
if ($rating5 == 2 ){ $rat52 = "grey";} else { $rat52 = "";}
if ($rating5 == 3 ){ $rat53 = "grey";} else { $rat53 = "";}
if ($rating5 == 4 ){ $rat54 = "grey";} else { $rat54 = "";}
if ($rating5 == 5 ){ $rat55 = "grey";} else { $rat55 = "";}
if ($rating5 == 6 ){ $rat56 = "grey";} else { $rat56 = "";}
if ($rating5 == 7 ){ $rat57 = "grey";} else { $rat57 = "";}

if ($rating6 == 1 ){ $rat61 = "grey";} else { $rat61 = "";}
if ($rating6 == 2 ){ $rat62 = "grey";} else { $rat62 = "";}
if ($rating6 == 3 ){ $rat63 = "grey";} else { $rat63 = "";}
if ($rating6 == 4 ){ $rat64 = "grey";} else { $rat64 = "";}
if ($rating6 == 5 ){ $rat65 = "grey";} else { $rat65 = "";}
if ($rating6 == 6 ){ $rat66 = "grey";} else { $rat66 = "";}
if ($rating6 == 7 ){ $rat67 = "grey";} else { $rat67 = "";}

if ($rating7 == 1 ){ $rat71 = "grey";} else { $rat71 = "";}
if ($rating7 == 2 ){ $rat72 = "grey";} else { $rat72 = "";}
if ($rating7 == 3 ){ $rat73 = "grey";} else { $rat73 = "";}
if ($rating7 == 4 ){ $rat74 = "grey";} else { $rat74 = "";}
if ($rating7 == 5 ){ $rat75 = "grey";} else { $rat75 = "";}
if ($rating7 == 6 ){ $rat76 = "grey";} else { $rat76 = "";}
if ($rating7 == 7 ){ $rat77 = "grey";} else { $rat77 = "";}

if ($rating8 == 1 ){ $rat81 = "grey";} else { $rat81 = "";}
if ($rating8 == 2 ){ $rat82 = "grey";} else { $rat82 = "";}
if ($rating8 == 3 ){ $rat83 = "grey";} else { $rat83 = "";}
if ($rating8 == 4 ){ $rat84 = "grey";} else { $rat84 = "";}
if ($rating8 == 5 ){ $rat85 = "grey";} else { $rat85 = "";}
if ($rating8 == 6 ){ $rat86 = "grey";} else { $rat86 = "";}
if ($rating8 == 7 ){ $rat87 = "grey";} else { $rat87 = "";}

if ($rating9 == 1 ){ $rat91 = "grey";} else { $rat91 = "";}
if ($rating9 == 2 ){ $rat92 = "grey";} else { $rat92 = "";}
if ($rating9 == 3 ){ $rat93 = "grey";} else { $rat93 = "";}
if ($rating9 == 4 ){ $rat94 = "grey";} else { $rat94 = "";}
if ($rating9 == 5 ){ $rat95 = "grey";} else { $rat95 = "";}
if ($rating9 == 6 ){ $rat96 = "grey";} else { $rat96 = "";}
if ($rating9 == 7 ){ $rat97 = "grey";} else { $rat97 = "";}

if ($rating10 == 1 ){ $rat101 = "grey";} else { $rat101 = "";}
if ($rating10 == 2 ){ $rat102 = "grey";} else { $rat102 = "";}
if ($rating10 == 3 ){ $rat103 = "grey";} else { $rat103 = "";}
if ($rating10 == 4 ){ $rat104 = "grey";} else { $rat104 = "";}
if ($rating10 == 5 ){ $rat105 = "grey";} else { $rat105 = "";}
if ($rating10 == 6 ){ $rat106 = "grey";} else { $rat106 = "";}
if ($rating10 == 7 ){ $rat107 = "grey";} else { $rat107 = "";}

if ($rating11 == 1 ){ $rat111 = "grey";} else { $rat111 = "";}
if ($rating11 == 2 ){ $rat112 = "grey";} else { $rat112 = "";}
if ($rating11 == 3 ){ $rat113 = "grey";} else { $rat113 = "";}
if ($rating11 == 4 ){ $rat114 = "grey";} else { $rat114 = "";}
if ($rating11 == 5 ){ $rat115 = "grey";} else { $rat115 = "";}
if ($rating11 == 6 ){ $rat116 = "grey";} else { $rat116 = "";}
if ($rating11 == 7 ){ $rat117 = "grey";} else { $rat117 = "";}

if ($rating12 == 1 ){ $rat121 = "grey";} else { $rat121 = "";}
if ($rating12 == 2 ){ $rat122 = "grey";} else { $rat122 = "";}
if ($rating12 == 3 ){ $rat123 = "grey";} else { $rat123 = "";}
if ($rating12 == 4 ){ $rat124 = "grey";} else { $rat124 = "";}
if ($rating12 == 5 ){ $rat125 = "grey";} else { $rat125 = "";}
if ($rating12 == 6 ){ $rat126 = "grey";} else { $rat126 = "";}
if ($rating12 == 7 ){ $rat127 = "grey";} else { $rat127 = "";}

if ($rating13 == 1 ){ $rat131 = "grey";} else { $rat131 = "";}
if ($rating13 == 2 ){ $rat132 = "grey";} else { $rat132 = "";}
if ($rating13 == 3 ){ $rat133 = "grey";} else { $rat133 = "";}
if ($rating13 == 4 ){ $rat134 = "grey";} else { $rat134 = "";}
if ($rating13 == 5 ){ $rat135 = "grey";} else { $rat135 = "";}
if ($rating13 == 6 ){ $rat136 = "grey";} else { $rat136 = "";}
if ($rating13 == 7 ){ $rat137 = "grey";} else { $rat137 = "";}

if ($rating14 == 1 ){ $rat141 = "grey";} else { $rat141 = "";}
if ($rating14 == 2 ){ $rat142 = "grey";} else { $rat142 = "";}
if ($rating14 == 3 ){ $rat143 = "grey";} else { $rat143 = "";}
if ($rating14 == 4 ){ $rat144 = "grey";} else { $rat144 = "";}
if ($rating14 == 5 ){ $rat145 = "grey";} else { $rat145 = "";}
if ($rating14 == 6 ){ $rat146 = "grey";} else { $rat146 = "";}
if ($rating14 == 7 ){ $rat147 = "grey";} else { $rat147 = "";}


if ($total_pribadi > 449 ){ $bcg1 = "yellow";} else { $bcg1 = "";}
if ($total_pribadi > 399 && $total_pribadi < 450 ){ $bcg2 = "yellow";} else { $bcg2 = "";}
if ($total_pribadi > 349 && $total_pribadi < 400 ){ $bcg3 = "yellow";} else { $bcg3 = "";}
if ($total_pribadi < 350 ){ $bcg4 = "yellow";} else { $bcg4 = "";}


$namaaspek1 = "<B>INTELIGENSI UMUM</B><BR>Gabungan keseluruhan potensi kecerdasan sebagai perpaduan dari aspek-aspek pembentukan intelektualitas.";
$namaaspek2 = "<B>KEMAMPUAN BERPIKIR ANALITIS SINTETIS</B><BR>Kemampuan membedakan hal-hal penting dan kurang penting sehingga mampu menguraikan masalah secara mendalam.";
$namaaspek3 = "<B>KEMAMPUAN BERPIKIR KONSEPTUAL</B><BR>Kemampuan individu untuk melakukan pertimbangan yang logis dan mengorganisir data dalam pemikiran.";
$namaaspek4 = "<B>PENGETAHUAN UMUM</B><BR>Keluasan pengetahuan dan informasi yang menunjang kemampuannya memecahkan masalah.";
$namaaspek5 = "<B>KEMAMPUAN NUMERIK</B><BR>Kemampuan memahami dan mengungkapkan pikiran dengan menggunakan simbol angka dan grafik,";
$namaaspek6 = "<B>KLASIFIKASI DAN DIFERENSIASI</B><BR>Kemampuan untuk melakukan pengelompokan dan pembedaan data secara tekun dan teliti.";
$namaaspek7 = "<B>KEMAMPUAN DASAR TEKNIK</B><BR>Kemampuan dasar untuk memahami dan mengolah konsep-konsep keteknikan.";
$namaaspek8 = "<B>ORIENTASI PANDANG RUANG</B><BR>Kemampuan memahami konsep-konsep jarak, arah dan ruang tiga dimensi.";

$namaaspek9 = "<B>KECEPATAN KERJA</B><BR>Kecepatan dan kecekatan kerja, yang menunjukkan kemampuan menyelesaikan sejumlah tugas dalam batas waktu tertentu.";
$namaaspek10 = "<B>KETELITIAN KERJA</B><BR>Kemampuan untuk bekerja dengan sesedikit mungkin melakukan kesalahan/kekeliruan.";
$namaaspek11 = "<B>KONSENTRASI</B><BR>Kemampuan untuk mempertahankan perhatian dan fokus terhadap pelaksanaan tugas.";
$namaaspek12 = "<B>STABILITAS EMOSI</B><BR>Menunjukkan kematangan pribadi, mampu mengendalikan emosi,  serta mampu menyesuaikan emosi dengan situasi.";
$namaaspek13 = "<B>PENYESUAIAN DIRI</B><BR>Mampu menyesuaikan diri dengan perbagai situasi,  berbagai tugas, tanggung jawab dan orang-orang disekitarnya.";
$namaaspek14 = "<B>HUBUNGAN INTERPERSONAL</B><BR>Kemampuan menghadapi bermacam macam orang secara efektif dalam berbagai situasi.";

    $rekomendasi = "Penjelasan lebih detail tentang arah minat dan penjabarannya dapat dipelajari pada halaman belakang laporan";
// Include the main TCPDF library (search for installation path).

ob_end_clean();

//require_once('tcpdf_include.php');


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information

// set header and footer fonts

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP - 15, PDF_MARGIN_RIGHT);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM-15);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}


$pdf->AddPage();


$pdf->SetFont('helvetica', '', 9);

// -----------------------------------------------------------------------------

$tbl = <<<EOD
<style>

    table.first {

        border: 3px solid #000000;

    }
    td.black {
        border: 2px solid #000000;
    }
</style>

<table cellspacing="1" cellpadding="1" class="first">
<tr>
<td bgcolor="#FFFF00" width="66%" align="center" class="black"><H1><B>PSIKOGRAM</B></H1></td>
<td bgcolor="#00AFEF" width="34%" align="center" class="black"><H1><B><font>RAHASIA</font></B></H1></td>
</tr>
<tr>
<td bgcolor="#FFFF00" width="66%" align="center" class="black"><H4><B>HASIL ASSESSMENT/PEMERIKSAAN PSIKOLOGIS</B></H4></td>
<td bgcolor="#FFFF00" width="34%" align="center" class="black"><H4><B><font>LEVEL STAFF</font></B></H4></td>
</tr>
</table>

<BR>
<BR>
<table cellspacing="0" cellpadding="1" class="first">

    <tr>
        <td bgcolor="#FFFF00" width="66%" align="center" class="black"><H3><B>IDENTITAS PESERTA</B></H3></td>
        <td bgcolor="#FFFF00" width="34%" align="center" class="black"><H3><B>KETERANGAN</B></H3></td>
    </tr>
    <tr>

       <td>
       <table cellspacing="0" cellpadding="1" border="0">
            <tr>
                <td width="30%">No. Tes</td>
                <td width="3%">:</td>
                <td width="67%">$no</td>
            </tr>
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td>$nama</td>
            </tr><tr>
                <td>Tempat / Tgl. Lahir</td>
                <td>:</td>
                <td>$ttl</td>
            </tr><tr>
                <td>Pendidikan Terakhir</td>
                <td>:</td>
                <td>$pendidikan</td>
            </tr>
            <tr>
                <td>Tujuan Pemeriksaan</td>
                <td>:</td>
                <td>$tujuan</td>
            </tr>
            <tr>
                <td>Tempat / Tgl. Test</td>
                <td>:</td>
                <td>$tempattes / $tgltes</td>
            </tr>
       </table>
       </td>
        <td class="black">
           <ol>
                <li>Jauh di bawah rata-rata</li>
                <li>Di bawah rata-rata</li>
                <li>Rata-rata batas bawah</li>
                <li>Rata-rata</li>
                <li>Rata-rata batas atas</li>
                <li>Di atas rata-rata</li>
                <li>Jauh di atas rata-rata</li>
            </ol>
        </td>

    </tr>

</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->SetFont('helvetica', '', 7);

$tbl = <<<EOD
<style>

    table.first {

        border: 3px solid #000000;

    }
    td {
        border: 2px solid #000000;

    }
    td.put {
        border: 2px solid black;

    }
</style>
</BR>

<table>
<tr>
<td width="100%" >

<table cellspacing="0" cellpadding="1"  class="first">
    <tr>
        <td bgcolor="#FFFF00"  class="black" rowspan="2" align="CENTER" width="72%"><h3><B>ASPEK - ASPEK PENILAIAN</B></h3></td>
  
        <td bgcolor="#FFFF00" class="black" rowspan="2" align="center" width="28%"><h3><B>RATING</B></h3></td>
      
    </tr>

</table>

<table class="first">
    <tr>
        <td  bgcolor="#48e70a" rowspan="4" align="left" width="100%"><h3><B>A. ASPEK KECERDASAN</B></h3></td>

    </tr>
</table>

<table cellspacing="0" cellpadding="1" class="first">
    <tr>
        <td rowspan="3" align="center" width="5%"><BR><BR>1</td>
        <td rowspan="3" align="left" width="67%">$namaaspek1</td>
       
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">1</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">2</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">3</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">4</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">5</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">6</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">7</td>

    </tr>
    <tr>
   <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat11"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat12"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat13"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat14"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat15"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat16"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat17"></td>
    </tr>
    <tr>
    <td colspan="7" align="left" align="center"></td>
    </tr>
</table>

<table cellspacing="0" cellpadding="1" class="first">
    <tr>
        <td rowspan="3" align="center" width="5%"><BR><BR>2</td>
        <td rowspan="3" align="left" width="67%">$namaaspek2</td>
       
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">1</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">2</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">3</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">4</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">5</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">6</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">7</td>

    </tr>
    <tr>
   <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat21"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat22"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat23"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat24"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat25"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat26"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat27"></td>
    </tr>
    <tr>
    <td colspan="7" align="left" align="center"></td>
    </tr>
</table>
<table cellspacing="0" cellpadding="1" class="first">
    <tr>
        <td rowspan="3" align="center" width="5%"><BR><BR>3</td>
        <td rowspan="3" align="left" width="67%">$namaaspek3</td>
       
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">1</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">2</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">3</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">4</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">5</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">6</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">7</td>

    </tr>
    <tr>
   <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat31"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat32"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat33"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat34"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat35"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat36"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat37"></td>
    </tr>
    <tr>
    <td colspan="7" align="left" align="center"></td>
    </tr>
</table>
<table cellspacing="0" cellpadding="1" class="first">
    <tr>
        <td rowspan="3" align="center" width="5%"><BR><BR>4</td>
        <td rowspan="3" align="left" width="67%">$namaaspek4</td>
       
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">1</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">2</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">3</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">4</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">5</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">6</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">7</td>

    </tr>
    <tr>
   <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat41"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat42"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat43"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat44"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat45"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat46"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat47"></td>
    </tr>
    <tr>
    <td colspan="7" align="left" align="center"></td>
    </tr>
</table>
<table cellspacing="0" cellpadding="1" class="first">
    <tr>
        <td rowspan="3" align="center" width="5%"><BR><BR>5</td>
        <td rowspan="3" align="left" width="67%">$namaaspek5</td>
       
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">1</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">2</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">3</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">4</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">5</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">6</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">7</td>

    </tr>
    <tr>
   <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat51"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat52"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat53"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat54"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat55"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat56"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat57"></td>
    </tr>
    <tr>
    <td colspan="7" align="left" align="center"></td>
    </tr>
</table>
<table cellspacing="0" cellpadding="1" class="first">
    <tr>
        <td rowspan="3" align="center" width="5%"><BR><BR>6</td>
        <td rowspan="3" align="left" width="67%">$namaaspek6</td>
       
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">1</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">2</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">3</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">4</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">5</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">6</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">7</td>

    </tr>
    <tr>
   <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat61"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat62"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat63"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat64"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat65"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat66"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat67"></td>
    </tr>
    <tr>
    <td colspan="7" align="left" align="center"></td>
    </tr>
</table>
<table cellspacing="0" cellpadding="1" class="first">
    <tr>
        <td rowspan="3" align="center" width="5%"><BR><BR>7</td>
        <td rowspan="3" align="left" width="67%">$namaaspek7</td>
       
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">1</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">2</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">3</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">4</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">5</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">6</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">7</td>

    </tr>
    <tr>
   <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat71"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat72"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat73"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat74"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat75"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat76"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat77"></td>
    </tr>
    <tr>
    <td colspan="7" align="left" align="center"></td>
    </tr>
</table>
<table cellspacing="0" cellpadding="1" class="first">
    <tr>
        <td rowspan="3" align="center" width="5%"><BR><BR>8</td>
        <td rowspan="3" align="left" width="67%">$namaaspek8</td>
       
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">1</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">2</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">3</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">4</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">5</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">6</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">7</td>

    </tr>
    <tr>
   <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat81"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat82"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat83"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat84"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat85"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat86"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat87"></td>
    </tr>
    <tr>
    <td colspan="7" align="left" align="center"></td>
    </tr>
</table>
<table class="first">
    <tr>
        <td  bgcolor="#48e70a" rowspan="4" align="left" width="100%"><h3><B>B. ASPEK SIKAP KERJA</B></h3></td>

    </tr>
</table>

<table cellspacing="0" cellpadding="1" class="first">
    <tr>
        <td rowspan="3" align="center" width="5%"><BR><BR>1</td>
        <td rowspan="3" align="left" width="67%">$namaaspek9</td>
   
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">1</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">2</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">3</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">4</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">5</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">6</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">7</td>

    </tr>
    <tr>
   <td rowspan="2"  align="left" width="4%" align="center" bgcolor="$rat91"></td>
        <td  rowspan="2" align="left" width="4%" align="center" bgcolor="$rat92"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat93"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat94"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat95"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat96"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat97"></td>
    </tr>
    <tr>
    <td colspan="7" align="left" align="center"></td>


    </tr>
</table>

<table cellspacing="0" cellpadding="1" class="first">
    <tr>
        <td rowspan="3" align="center" width="5%"><BR><BR>2</td>
        <td rowspan="3" align="left" width="67%">$namaaspek10</td>

        <td bgcolor="#bebebe"  align="left" width="4%" align="center">1</td>
        <td  bgcolor="#bebebe" align="left" width="4%" align="center">2</td>
        <td  bgcolor="#bebebe" align="left" width="4%" align="center">3</td>
        <td  bgcolor="#bebebe" align="left" width="4%" align="center">4</td>
        <td  bgcolor="#bebebe" align="left" width="4%" align="center">5</td>
        <td  bgcolor="#bebebe" align="left" width="4%" align="center">6</td>
        <td  bgcolor="#bebebe" align="left" width="4%" align="center">7</td>

    </tr>
    <tr>
    <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat101"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat102"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat103"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat104"></td>
        <td rowspan="2"  align="left" width="4%" align="center" bgcolor="$rat105"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat106"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat107"></td>
    </tr>
    <tr>
    <td colspan="7" align="left" align="center"></td>


    </tr>
</table>

<table cellspacing="0" cellpadding="1" class="first">
    <tr>
        <td rowspan="3" align="center" width="5%"><BR><BR>3</td>
        <td rowspan="3" align="left" width="67%">$namaaspek11</td>
 
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">1</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">2</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">3</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">4</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">5</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">6</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">7</td>

    </tr>
    <tr>
    <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat111"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat112"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat113"></td>
        <td rowspan="2"  align="left" width="4%" align="center" bgcolor="$rat114"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat115"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat116"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat117"></td>
    </tr>
    <tr>
    <td colspan="7" align="left" align="center"></td>


    </tr>
</table>

<table class="first">
    <tr>
        <td  bgcolor="#48e70a" rowspan="4" align="left" width="100%"><h3><B>C. ASPEK KEPRIBADIAN</B></h3></td>
    </tr>
</table>

<table cellspacing="0" cellpadding="1" class="first">
    <tr>
        <td rowspan="3" align="center" width="5%"><BR><BR>1</td>
        <td rowspan="3" align="left" width="67%">$namaaspek12</td>
 
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">1</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">2</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">3</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">4</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">5</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">6</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">7</td>

    </tr>
    <tr>
    <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat121"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat122"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat123"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat124"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat125"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat126"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat127"></td>
    </tr>
    <tr>
    <td colspan="7" align="left" align="center"></td>
    </tr>
</table>
<table cellspacing="0" cellpadding="1" class="first">
    <tr>
        <td rowspan="3" align="center" width="5%"><BR><BR>2</td>
        <td rowspan="3" align="left" width="67%">$namaaspek13</td>
 
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">1</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">2</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">3</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">4</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">5</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">6</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">7</td>

    </tr>
    <tr>
    <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat131"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat132"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat133"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat134"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat135"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat136"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat137"></td>
    </tr>
    <tr>
    <td colspan="7" align="left" align="center"></td>
    </tr>
</table>
<table cellspacing="0" cellpadding="1" class="first">
    <tr>
        <td rowspan="3" align="center" width="5%"><BR><BR>3</td>
        <td rowspan="3" align="left" width="67%">$namaaspek14</td>
 
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">1</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">2</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">3</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">4</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">5</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">6</td>
        <td bgcolor="#bebebe"  align="left" width="4%" align="center">7</td>

    </tr>
    <tr>
    <td rowspan="2"  align="left" width="4%" align="center" bgcolor="$rat141"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat142"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat143"></td>
        <td rowspan="2"  align="left" width="4%" align="center" bgcolor="$rat144"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat145"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat146"></td>
        <td rowspan="2" align="left" width="4%" align="center" bgcolor="$rat147"></td>
    </tr>
    <tr>
    <td colspan="7" align="left" align="center"></td>
    </tr>
</table>

</td>

</tr>
</table>



EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->SetFont('helvetica', '', 9);

// -----------------------------------------------------------------------------

$tbl = <<<EOD
<style>

    table.first {

        border: 3px solid #000000;

    }
    td.black {
        border: 2px solid #000000;

    }
    td.put {
        border: 2px solid white;

    }
</style>
<table cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td colspan="3" align="center" height="15px"><B></B></td>
    </tr>
    <tr>
       <td width="71%">

       <table class="first">

            <tr>
                <td class="black" bgcolor="#bebebe" colspan="2" align="center" width="30%"><B>ARAH MINAT</B></td>
                <td  class="black"   align="center" width="50%"><B>$riasec</B></td>
   
            </tr>
            <tr>
                <td class="black" colspan="3" align="left"><B>CATATAN :</B>$rekomendasi</td>
            </tr>
       </table>

       <br><br>



       </td>

       <td width="2%"></td>

       <td width="27%">

            <table>
            <tr>
            <td align="center">$tempattes, $tgltes</td>
            </tr>
            <tr>
            <td align="center">A.n. Psikolog Pemeriksa</td>
            </tr>
            <tr>
            <td align="center"><img src="http://mbss.report.ppsdm.com/images/ttd_budiman.jpg" width="150px"></td>
            </tr>
            <tr>
            <td align="center">$ttd</td>
            </tr>
            <tr>
            <td align="center">$himpsi</td>
            </tr>
            </table>
       </td>

    </tr>

</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->AddPage();


$tbl = <<<EOD
<style>
  table td {
    /*border: 1px solid black; */
    text-align: right;
  }

  td.bold { 
      font-weight: 700;
  }
</style>
<p>
    <strong>URAIAN ASPEK SIKAP KERJA</strong>
</p>
<p>
    <strong></strong>
</p>
<p>
    Dalam melaksanakan penugasannya, $nama memiliki kecepatan
    kerja yang baik, sehingga ia mampu untuk mengerjakan tugas-tugasnya dalam
    waktu yang relatif cepat. Aliefia Hidayati Y juga bisa memfokuskan
    perhatiannya pada setiap tugas yang dilakukannya. Perhatiannya tidak mudah
    teralihkan. Sementara, kehati-hatiannya dalam bekerja tergolong cukup
    memadai. Untuk meningkatkan kualitas dan akurasi hasil kerjanya, sekaligus
    meminimalisir peluang terjadinya kesalahan kerja, maka Aliefia Hidayati Y
    perlu memeriksa kembali setiap tugas belajarnya, sebelum diserahkan pada
    pihak guru / sekolah.
</p>
<p>
    <strong>URAIAN ASPEK KEPRIBADIAN</strong>
</p>
<p>
    <strong></strong>
</p>
<p>
    Sikap $nama yang senantiasa tenang dan terkendali menunjukkan
    adanya upaya untuk mempertahankan keadaan emosi agar tidak mudah bergejolak
    pada kondisi tertentu. Meski terkadang masih terlihat belum konsisten,
    upaya ini menunjukkan adanya proses kematangan yang cukup positif pada
    perkembangan dirinya. Hal ini juga didukung oleh pemahaman yang cukup
    mendalam terhadap kebutuhan maupun kondisi sesama. Ia selalu berupaya
    menjaga perasaan orang lain dan terlibat pada kegiatan sosial yang
    produktif dengan teman-temannya. Sementara, aspek yang masih perlu
    ditingkatkan adalah rasa percaya dirinya, manakala menghadapi situasi baru
    yang berbeda.
</p>
<p>
    <strong></strong>
</p>
<p>
    <strong>REKOMENDASI</strong>
</p>
<p>
    <strong></strong>
</p>
<p>
    $nama, memiliki orientasi minat pada bidang (SI), yaitu Sosial
    dan Investigatif. Berdasarkan hasil pemeriksaan psikologik yang mencakup
    aspek kecerdasan, sikap kerja, kepribadian, dan minat, maka Aliefia
    Hidayati Y lebih disarankan untuk melanjutkan pendidikan pada jenjang
    sarjana atau jenjang diploma. Beberapa alternatif pilihan jurusan yang
    dapat direkomendasikan antara lain: biologi, pendidikan, ekonomi dan
    bisnis, antropologi, hukum, teknik, kesehatan masyarakat, psikologi,
    kedokteran, keperawatan, atau administrasi
</p>



            <table>
            <tr><td width="100%"></td></tr>
            <tr>
              <td width="65%"></td>
              <td align="center">$tempattes, $tgltes</td>
            </tr>
            <tr>
            <td width="65%"></td>
            <td align="center">A.n. Psikolog Pemeriksa</td>
            </tr>
            <tr>
            <td width="65%"></td>
            <td align="center"><img src="http://mbss.report.ppsdm.com/images/ttd_budiman.jpg" width="150px"></td>
            </tr>
            <tr>
            <td width="65%"></td>
            <td align="center">$ttd</td>
            </tr>
            <tr>
            <td width="65%"></td>
            <td align="center">$himpsi</td>
            </tr>
            </table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');


//Close and output PDF document
$pdf->Output('psikotes.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
