<?php

namespace Drupal\pedigre\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\Markup;
use Drupal\Core\Url;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\file\Entity\File;
use Drupal\webform\Entity\WebformSubmission;
use TCPDF;

/**
 * Defines a route controller for entity autocomplete form elements.
 */
//
class PedigreController extends ControllerBase {

    use StringTranslationTrait;
    
    public function downloadPdf($example_name) {
    switch ($example_name) {
      case 'simple':
       $pdf = $this->generateSimplePdf();
        break;
      default:
        return $this->t('No such example.');
    }

    // Tell the browser that this is not an HTML file to show, but a pdf file to
    // download.
    header('Content-Type: application/pdf');
    header('Content-Length: ' . strlen($pdf));
    header('Content-Disposition: attachment; filename="mydocument.pdf"');
    print $pdf;
    return [];
  }
  
  public function exampleContents() {
    $page = [];

    $page['example_pdf_link'] = [
      '#title' => $this->t('Basic pdf'),
      '#type' => 'link',
      '#url' => Url::fromRoute('pedigre.download_pdf', array('example_name' => 'simple'))
    ];

    return $page;
  }
  
  public function pedigretable($lo, Request $request)
    {
    $r_arr=array();
    //a twig-be elöállitani a tölteléket  
    $r_arr=$this->r_arr_keszit($lo);
    $r_arr[999]['999']='web';
    return array('#theme' => 'pedigre', '#items' => $r_arr, '#title' => '');
    }
    
    
    
    public function pedigretablePdf($lo, Request $request)
    {
    $r_arr=array();
    $r_arr=$this->r_arr_keszit($lo); 
    $r_arr[999]['999']='pdf';
    //print_r($r_arr);
    
 
   
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);       

    $pdf->AddPage();

//    $tbl ='';  
//    $tbl.='<div><table>';
//    $tbl.='<tr><td><img src="/sites/default/files/tcpdfpedigrehatter.jpg"></td></tr>';
//    $tbl.='</table></div>';
//    $pdf->writeHTML($tbl, true, false, true, false, '');
//    $pdf->Ln(-233);





$t='teszt';


$tbl ='';
$tbl.='<table cellspacing="0" cellpadding="2" border="1">';
//$tbl.='<tr><td></td><td></td><td></td><td></td></tr>';


//$str=$array[iconv("UTF-8","ISO-8859-1", $nev)];

$pdf->SetFont('dejavusans', '', 10, '', true);



$pdflonev=$r_arr[1]['nev'];


if($r_arr[1]['penz']==0){
    $tbl.='<tr><td colspan="4"><b><font size="18"> '.$r_arr[1]['nev'].' </font></b><font size="10">'.$r_arr[1]['ev'].'</font><font size="10"> '.$r_arr[1]['orszag'].'</font><font size="10"> '.$r_arr[1]['szine'].$r_arr[1]['neme'].'</font><font size="12"><b> '.$r_arr[1]['rekord'].'</b></font><font size="9"> '.$r_arr[1]['nevel'].'</font><br></td></tr>';      
}else{
    $tbl.='<tr><td colspan="4"><b><font size="18"> '.$r_arr[1]['nev'].' </font></b><font size="10">'.$r_arr[1]['ev'].'</font><font size="10"> '.$r_arr[1]['orszag'].'</font><font size="10"> '.$r_arr[1]['szine'].$r_arr[1]['neme'].'</font><font size="12"><b> '.$r_arr[1]['rekord'].'</b></font><font size="12"><b> - '.$r_arr[1]['penz'].' Ft. </b></font><font size="9"> '.$r_arr[1]['nevel'].'</font><br></td></tr>';      
}
$tbl.='<tr><td colspan="4">';
     for($i=100; $i<=140; $i++){
        if(isset($r_arr[$i]['lonid'])){
           $tbl.='<font size="8"><b>'.$r_arr[$i]['nev'].'</b> '.$r_arr[$i]['ev'].' '.$r_arr[$i]['orszag'].' '.$r_arr[$i]['szine'].$r_arr[$i]['neme'].' '.$r_arr[$i]['rekord'].' '.$r_arr[$i]['ap_v_any'].'</font>, ';   
        }
     }          
$tbl.='</td></tr>';



//$pdf->writeHTML($tbl, true, false, true, false, '');
//$pdf->Ln(-233);



$tbl.='<tr><td rowspan="8"><br><br><br><br><br><br><b><font size="12"> '.$r_arr[3]['nev'].' </font></b><br><font size="10"> '.$r_arr[3]['ev'].', '.$r_arr[3]['orszag'].', '.$r_arr[3]['szine'].''.$r_arr[3]['neme'].', '.$r_arr[3]['rekord'].' </font></td><td rowspan="4"><br><br><br><font size="11"><b> '.$r_arr[7]['nev'].'</b></font><br><font size="10"> '.$r_arr[7]['ev'].', '.$r_arr[7]['orszag'].', '.$r_arr[7]['szine'].''.$r_arr[7]['neme'].', '.$r_arr[7]['rekord'].'</font></td><td rowspan="2"><br><br><b><font size="10"> '.$r_arr[15]['nev'].'</font></b></td><td><img src="/sites/default/files/spacer.jpg" width="1" height="11"><b><font size="9"> '.$r_arr[31]['nev'].'</font></b></td></tr>'; 
$tbl.='<tr><td><img src="/sites/default/files/spacer.jpg" width="1" height="11"><b><font size="9"> '.$r_arr[33]['nev'].'</font></b></td></tr>'; 
$tbl.='<tr><td rowspan="2"><br><br><b><font size="10"> '.$r_arr[17]['nev'].'</font></b></td><td><img src="/sites/default/files/spacer.jpg" width="1" height="11"><b><font size="9"> '.$r_arr[35]['nev'].'</font></b></td></tr>'; 
$tbl.='<tr><td><img src="/sites/default/files/spacer.jpg" width="1" height="11"><b><font size="9"> '.$r_arr[37]['nev'].'</font></b></td></tr>';   
$tbl.='<tr><td rowspan="4"><br><br><br><b><font size="11"> '.$r_arr[9]['nev'].' </font></b><br><font size="10"> '.$r_arr[9]['ev'].', '.$r_arr[9]['orszag'].', '.$r_arr[9]['szine'].''.$r_arr[9]['neme'].', '.$r_arr[9]['rekord'].' </font></td><td rowspan="2"><b><font size="9"><br> '.$r_arr[19]['nev'].'</font></b></td><td><b><font size="9"> '.$r_arr[39]['nev'].'</font></b></td></tr>'; 
$tbl.='<tr><td><img src="/sites/default/files/spacer.jpg" width="1" height="11"><b><font size="9"> '.$r_arr[41]['nev'].'</font></b></td></tr>'; 
$tbl.='<tr><td rowspan="2"><b><br><font size="9"> '.$r_arr[21]['nev'].'</font></b></td><td><img src="/sites/default/files/spacer.jpg" width="1" height="11"><b><font size="9"> '.$r_arr[43]['nev'].'</font></b></td></tr>'; 
$tbl.='<tr><td><img src="/sites/default/files/spacer.jpg" width="1" height="11"><b><font size="9"> '.$r_arr[45]['nev'].'</font></b></td></tr>';   

$tbl.='<tr><td rowspan="8"><br><br><br><br><br><br><b><font size="12"> '.$r_arr[5]['nev'].'</font></b><br><font size="10"> '.$r_arr[5]['ev'].', '.$r_arr[5]['orszag'].' , '.$r_arr[5]['szine'].''.$r_arr[5]['neme'].' , '.$r_arr[5]['rekord'].' </font></td><td rowspan="4"><br><br><br><font size="11"><b> '.$r_arr[11]['nev'].'</b></font><br><font size="10"> '.$r_arr[11]['ev'].', '.$r_arr[11]['orszag'].', '.$r_arr[11]['szine'].''.$r_arr[11]['neme'].', '.$r_arr[11]['rekord'].'</font></td><td rowspan="2"><b><br><font size="9"> '.$r_arr[23]['nev'].'</font></b></td><td><img src="/sites/default/files/spacer.jpg" width="1" height="11"><b><font size="9"> '.$r_arr[47]['nev'].'</font></b></td></tr>'; 
$tbl.='<tr><td><img src="/sites/default/files/spacer.jpg" width="1" height="11"><b><font size="9"> '.$r_arr[49]['nev'].'</font></b></td></tr>'; 
$tbl.='<tr><td rowspan="2"><br><font size="12"><b><br><font size="9"> '.$r_arr[25]['nev'].'</font></b></font></td><td><img src="/sites/default/files/spacer.jpg" width="1" height="11"><b><font size="9"> '.$r_arr[51]['nev'].'</font></b></td></tr>'; 
$tbl.='<tr><td><img src="/sites/default/files/spacer.jpg" width="1" height="11"><b><font size="9"> '.$r_arr[53]['nev'].'</font></b></td></tr>';    
$tbl.='<tr><td rowspan="4"><br><br><br><b><font size="11"> '.$r_arr[13]['nev'].' </font></b><br><font size="10"> '.$r_arr[13]['ev'].', '.$r_arr[13]['orszag'].', '.$r_arr[13]['szine'].''.$r_arr[13]['neme'].', '.$r_arr[13]['rekord'].' </font></td><td rowspan="2"><br><b><font size="9"><br> '.$r_arr[27]['nev'].'</font></b></td><td><img src="/sites/default/files/spacer.jpg" width="1" height="11"><b><font size="9"> '.$r_arr[55]['nev'].'</font></b></td></tr>'; 
$tbl.='<tr><td><img src="/sites/default/files/spacer.jpg" width="1" height="11"><b><font size="9"> '.$r_arr[57]['nev'].'</font></b></td></tr>'; 
$tbl.='<tr><td rowspan="2"><br><b><font size="9"><br> '.$r_arr[29]['nev'].'</font></b></td><td><img src="/sites/default/files/spacer.jpg" width="1" height="11"><b><font size="9"> '.$r_arr[59]['nev'].'</font></b></td></tr>'; 
$tbl.='<tr><td><img src="/sites/default/files/spacer.jpg" width="1" height="11"><b><font size="9"> '.$r_arr[61]['nev'].'</font></b></td></tr>'; 
           
$tbl.='<tr><td>';

for($i=200; $i<=240; $i++){
    if(isset($r_arr[$i]['lonid'])){
        $tbl.='<font size="8"><b>'.$r_arr[$i]['nev'].'</b> '.$r_arr[$i]['ev'].' '.$r_arr[$i]['orszag'].' '.$r_arr[$i]['szine'].''.$r_arr[$i]['neme'].' '.$r_arr[$i]['rekord'].' '.$r_arr[$i]['apanev'].', </font><br>';
    }
}

$tbl.='</td><td>';

for($i=300; $i<=340; $i++){
    if(isset($r_arr[$i]['lonid'])){
        $tbl.='<font size="8"><b>'.$r_arr[$i]['nev'].'</b> '.$r_arr[$i]['ev'].' '.$r_arr[$i]['orszag'].' '.$r_arr[$i]['szine'].''.$r_arr[$i]['neme'].' '.$r_arr[$i]['rekord'].' '.$r_arr[$i]['apanev'].', </font><br>';
    }
}

$tbl.='</td><td>';

for($i=400; $i<=440; $i++){
    if(isset($r_arr[$i]['lonid'])){
        $tbl.='<font size="8"><b>'.$r_arr[$i]['nev'].'</b> '.$r_arr[$i]['ev'].' '.$r_arr[$i]['orszag'].' '.$r_arr[$i]['szine'].''.$r_arr[$i]['neme'].' '.$r_arr[$i]['rekord'].' '.$r_arr[$i]['apanev'].', </font><br>';
    }
}

$tbl.='</td><td>';

for($i=500; $i<=540; $i++){
    if(isset($r_arr[$i]['lonid'])){
        $tbl.='<font size="8"><b>'.$r_arr[$i]['nev'].'</b> '.$r_arr[$i]['ev'].', </font><br>';
    }
}

$tbl.='</td></tr>';



     
      
$tbl.='</table>';
$now = time();
$keszult='Készült: '.date('Y-m-d H:i',$now);

$tbl.='<font size="5"><br><br>'.$keszult.' </font><img src="/sites/default/files/pedlogo.gif" width="15">';
 


//<tr><td colspan="3"><b><font size="5">'.$r_arr[1]['nev'].'</font></b><font size="3">'.$r_arr[1]['ev'].''.$r_arr[1]['orszag'].'<font size="2">(e'.$r_arr[1]['nev'].')</font>'.$r_arr[1]['szine'].''.$r_arr[1]['neme'].'</font><b><font size="3">'.$r_arr[1]['rekord'].'-'.$r_arr[1]['penz'].'Ft.</font></b><font size="2">'.$r_arr[1]['nev'].'</td></tr>
  
     
//<tr><td colspan="3"><b><font size="15">'.$r_arr[1]['nev'].'</font></b><font size="10">'.$r_arr[1]['ev'].'</font></td></tr>

  

//  <tr><td colspan='3'><b><font size='5'> '.$r_arr[1]['nev'].'</font></b> &nbsp; <font size='3'> '.$r_arr[1]['ev'].', '.$r_arr[1]['orszag'].'<font size='2'> (e.'.$r_arr[1]['elozo'].')</font>, '.$r_arr[1]['szine'].''.$r_arr[1]['neme'].',</font> &nbsp; <b><font size='3'>'.$r_arr[1]['rekord'].' - '.$r_arr[1]['penz'].' Ft. </font></b><font size='2'> &nbsp;'.$r_arr[1]['nevel'].'</td></tr>'
                
    


//$html="<table style='width: 90%;'>";
         
           // if ($r_arr[1]['elozo'] != 0) {
           //   $html.="<tr><td colspan='3'><a href='/pedigre-loker/".$r_arr[1]['lonid']."'><b><font size='5'> ".$r_arr[1]['nev']."</font></b> &nbsp; <font size='3'> ".$r_arr[1]['ev']." ".$r_arr[1]['orszag']."<font size='2'> (e.".$r_arr[1]['elozo']. ")</font>,".$r_arr[1]['szine']." ".$r_arr[1]['neme'].",</font> &nbsp; <b><font size='3'>".$r_arr[1]['rekord']." - ".$r_arr[1]['penz']." Ft. </font></b><font size='2'> &nbsp;".$r_arr[1]['nevel']."</a>";
           // } else {
           //   $html.="<tr><td colspan='3'><a href='/pedigre-loker/".$r_arr[1]['lonid']."'><b><font size='5'> ".$r_arr[1]['nev']."</font></b> &nbsp; <font size='3'> ".$r_arr[1]['ev'].", ".$r_arr[1]['orszag'].", ".$r_arr[1]['szine']."".$r_arr['neme'].",</font> &nbsp; <b><font size='3'>".$r_arr['rekord']." - ".$r_arr['penz']." Ft. </font></b><font size='2'> &nbsp;".$r_arr['nevel']."</a>";
           // }  
             
             //$html.="<tr><td colspan='3'><b>qqq<font size='5'> ".$r_arr[1]['nev']."</font></b> &nbsp; <font size='3'> ".$r_arr[1]['ev']." ".$r_arr[1]['orszag']."<font size='2'> (e.".$r_arr[1]['elozo']. ")</font>,".$r_arr[1]['szine']." ".$r_arr[1]['neme'].",</font> &nbsp; <b><font size='3'>".$r_arr[1]['rekord']." - ".$r_arr[1]['penz']." Ft. </font></b><font size='2'> &nbsp;".$r_arr[1]['nevel']."";
           
//         $html.="<tr><td colspan='3'><b><font size='5'>".$r_arr[1]['nev']."</font></b>";
           
           
//            $html.="</td></tr>"; 
       
//$html.="</table>"; 
    
    
       
    
    
    //aztán bele kell találni a rubrikákba
//    $pdf->SetCreator('My Creator');
//    $pdf->SetAuthor('My Author');
//    $pdf->SetTitle('My Title');
//    $pdf->SetSubject('My Subject');

    // Add a new page.
   






    $pdf->writeHTML($tbl, true, false, true, false, '');
    // Set the font and size.
//    $pdf->SetFont('times', '', 12);
//    $pdf->Ln(-233);
    // Write some text.
//    $str=$r_arr[1]['nev'];
    
    
    
//    $pdf->SetFont('dejavusans', 'b', 11, '', true);
//    $pdf->Cell(7, 0, '', 0, 0, 'L', 0);
//    $pdf->Cell(7, 0, $str, 0, 0, 'L', 0);
    
    
    
    
    // Insert the content. Note that DrupalInitialize automatically adds the first
    // page to the pdf document.
    //print $html;
    //$pdf->Write(0, $this->t('My PDF content'));

    // Output the PDF as a download.
     $pdf->Output($pdflonev.'.pdf', 'I');


    // PDF fájl kimenet.
  //$output = $pdf->Output('', 'S');

  // PDF fájl visszaadása.
  //return $output;
    return;
    }       
    
    
    // a twigbe való tölteléket, (lóadatokat) elöállítani
    protected function r_arr_keszit($lo){
      
    //drupal_add_http_header('X-Frame-Options', 'ALLOW-FROM 82.206.66.162');
         
    //$response = $event--->getResponse();
    //$response->headers->remove('X-Frame-Options');
    //// Set the header, use FALSE to not replace it if it's set already.
    //$response->headers->set('Content-Security-Policy', "frame-ancestors 'self' ugeto.com *.ugeto.com", FALSE);
      
     // $matches[] = ['value' => $lo];
      
      //LOAZON_LONG-ból kifejteni a $lo_nid -et. Egyébként elfogadja közvetlenül a nid -et is.
      //print $lo;
      if($lo>1 && $lo<999999){
          $lo_nid=$lo;
      }else{
        $loazon_long=$lo;
        $query = \Drupal::entityQuery('node')->accessCheck(TRUE);
        $query->condition('type', 'lovak');
        $query->condition('field_loazon_long', $loazon_long);
        $lo_entity_ids = $query->execute();
        foreach($lo_entity_ids as $key => $value){
          $lo_nid=$value;
          //print "<br>nid:".$lo_nid;
        }
      }
      //print "<br>lo_nid:".$lo_nid;
      /////////////////////////////////////////
      // pedigré tábla felépítése 4 remo -ig //
      // $lo_nid a kiindulás //////////////////
      /////////////////////////////////////////
      
      $r_arr=array();
      
     
      //1-4 remo
      for ($i=0; $i<=40; $i++) {
        //print "<br>".$i;
        if($i==0){$r_arr[0]['nid']=$lo_nid;} // Csak a loop indulásánál kell az értékadás, utána már automatikusan töltödik
        if(isset($r_arr[$i]['nid'])){
          $lo_param_array[0]=$r_arr[$i]['nid']; // Ez a lo nid értéke
          $r_arr[2*$i+1]['lonid']=$lo_param_array[0]; //lonid
          if($i==2){$lonid_remo1=$lo_param_array[0];}// REMO 1 ivadékok miatt átmenteni a lonid -ot
          if($i==6){$lonid_remo2=$lo_param_array[0];}// REMO 2 ivadékok miatt átmenteni a lonid -ot
          if($i==14){$lonid_remo3=$lo_param_array[0];}// REMO 3 ivadékok miatt átmenteni a lonid -ot
          if($i==30){$lonid_remo4=$lo_param_array[0];}// REMO 4 ivadékok miatt átmenteni a lonid -ot
        }else{
          $lo_param_array[0]=22318;
        }
        if(isset($r_arr[$i]['nev'])){
          $lo_param_array[1]=$r_arr[$i]['nev'];
        }else{
          $lo_param_array[1]='';
        }
        if($lo_param_array[0]!=22318){
          $this->lo_param($lo_param_array);// ide érkezik a 22318 nid, ha n.a.
          //print_r($lo_param_array);
          $r_arr[2*$i+1]['nev']=$lo_param_array[1]; //nev
          $r_arr[2*$i+1]['ev']=$lo_param_array[2]; //ev
          $r_arr[2*$i+1]['szine']=$lo_param_array[3]; //szine
          $r_arr[2*$i+1]['neme']=$lo_param_array[4]; //neme
          if($i==0){// átmenteni a nemet, az ivadékok lekérdezéséhez
             $lonid_neme=$lo_param_array[4];
          }
          $r_arr[2*$i+1]['rekord']=$lo_param_array[6]; //rekord
          $r_arr[2*$i+1]['penz']=$lo_param_array[7]; //ev
          $r_arr[2*$i+1]['nid']=$lo_param_array[8]; //apja nid
          $r_arr[2*$i+2]['nid']=$lo_param_array[9]; //anyja nid
          $r_arr[2*$i+1]['apanev']=$lo_param_array[10]; //apanev
          $r_arr[2*$i+1]['anyanev']=$lo_param_array[11]; //anyanev
          $r_arr[2*$i+1]['orszag']=$lo_param_array[12]; //orszag
          $r_arr[2*$i+2]['apanev']=$lo_param_array[10]; //apanev továbbadása stringesen, hogyha nincs nid esetére
          $r_arr[2*$i+2]['anyanev']=$lo_param_array[11]; //anyanev továbbadása stringesen, hogyha nincs nid esetére
          $r_arr[2*$i+1]['nlkft_iloid']=$lo_param_array[13];
          $r_arr[2*$i+1]['nevel']=$lo_param_array[14];
          $r_arr[2*$i+1]['elozo']=$lo_param_array[15];
        }
        unset($lo_param_array);
      }
      
      $this->lo_ivadekai_folo($r_arr, $lo_nid, $lonid_neme);
            
      if(isset($lonid_remo1) && $lonid_remo1!='22318'){$this->lo_ivadekai_remo($r_arr, $lonid_remo1, 1);}
      if(isset($lonid_remo2) && $lonid_remo2!='22318'){$this->lo_ivadekai_remo($r_arr, $lonid_remo2, 2);}
      if(isset($lonid_remo3) && $lonid_remo3!='22318'){$this->lo_ivadekai_remo($r_arr, $lonid_remo3, 3);}
      if(isset($lonid_remo4) && $lonid_remo4!='22318'){$this->lo_ivadekai_remo($r_arr, $lonid_remo4, 4);}
      
     //print_r($r_arr);
    return $r_arr;  
    }
    
    
    
    
    //tetszőleges ló paraméterei azaz (év, szin, nem, ország, rekord, pénz) kifejtése
    protected function lo_param(&$lo_param_array)
    //LO_param
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 0-ló_nid, 1-neve, 2-év, 3-szine, 4-neme, 5-orszag, 6-rekord, 7-pénz, 8-apja_nid, 9 anyja_nid, 10-apja_nev, 11-anyja_nev //  
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    {
      $lo_nid=$lo_param_array[0];
     
      //elenörizni, hogy létezik-e a nid a node ban.
      //$values_lo = \Drupal::entityQuery('node')->condition('nid', $lo_nid)->execute();
      //$node_exists_lo = !empty($values_lo);
      
      //print "<br>lonid".$lo_nid;
      $node_storage = \Drupal::entityTypeManager()->getStorage('node');
      $node = $node_storage->load($lo_nid);
      $loazon_long = $node->get('field_loazon_long')->value;
      //print "<br>".$loazon_long;
      $loneve = preg_replace('/(--.*)/', '', $loazon_long);
      //print "<br>".$loneve;
      //print "<br>lopraamarray1"; print_r($lo_param_array);
      //if(empty($lo_param_array[1])){
         $lo_param_array[1] = $loneve;
      //}  
      //print "<br>loneve:".$loneve;
      
      if($loneve=='n.a.'){
        $lo_param_array[2]='n.a.';
        $lo_param_array[3]='n.a.';
        $lo_param_array[4]='n.a.';
        $lo_param_array[6]='n.a.';
        $lo_param_array[7]='n.a.';
        $lo_param_array[8]='n.a.';
        $lo_param_array[9]='n.a.';
        $lo_param_array[10]='n.a.';
        $lo_param_array[11]='n.a.';
        return;
        
      }
      $lo_param_array[2] = $node->get('field_ev')->value;
      
      
      $term_szine = \Drupal\taxonomy\Entity\Term::load($node->get('field_szine')->target_id);
      if ($term_szine) {$term_name = $term_szine->get('name')->value;$lo_param_array[3]=$term_name;}else{$lo_param_array[3]='';}
      
      $term_neme = \Drupal\taxonomy\Entity\Term::load($node->get('field_neme')->target_id);
      if ($term_neme) {$term_name = $term_neme->get('name')->value;$lo_param_array[4]=$term_name;}else{$lo_param_array[4]='';}
      
      $term_orsz = \Drupal\taxonomy\Entity\Term::load($node->get('field_orszag')->target_id);
      if ($term_orsz) {$term_name = $term_orsz->get('name')->value;$lo_param_array[5]=$term_name;}else{$lo_param_array[5]='';}
            
      $lo_param_array[6] = $node->get('field_rekord')->value;
      $folo_penz=$node->get('field_penz')->value;
      $lo_param_array[7] = number_format($folo_penz);
      $lo_param_array[8] = $node->get('field_apa')->target_id;
      $lo_param_array[9] = $node->get('field_anya')->target_id;
      $lo_param_array[10] = $node->get('field_apanev')->value;
      $lo_param_array[11] = $node->get('field_anyanev')->value;
      $lo_param_array[12] = $lo_param_array[5];
      $lo_param_array[13] = $node->get('field_nlkft_iloid')->value;
      $lo_param_array[14] = $node->get('field_nevel_tenyeszt')->value;
      $lo_param_array[15] = $node->get('field_elozo')->value;
      //print $lo_param_array[14];
          
   }
    
   //ivadékai FÖLÓ
   public function lo_ivadekai_folo(&$r_arr, $lonid, $neme){
    $query = \Drupal::entityQuery('node')->accessCheck(TRUE);
    //$query->condition('status', 1);
    $query->condition('type', 'lovak');
    if($neme!='k'){
      $query->condition('field_apa', $lonid);
      $query->condition('field_orszag.entity:taxonomy_term.name', 'HU', '=');
      $query->condition('field_rekord', 0 , '!=');
     // $query->condition('field_orszag', array('HU'));
      $query->sort('field_rekord');
      $query->range(0,5);
    }else{
      $query->condition('field_anya', $lonid);
      //$query->condition('field_lo_vagy_fed', 'LO');
      $query->sort('field_ev','desc');
    }
    $ap_entity_ids = $query->execute(); 
    $ii=100;
    foreach($ap_entity_ids as $key => $value){
      $lo_param_array[0]=$value;
      $this->lo_param($lo_param_array);
      $r_arr[$ii]['lonid']=$lo_param_array[0]; //nev
      $r_arr[$ii]['nev']=$lo_param_array[1]; //nev
      $r_arr[$ii]['ev']=$lo_param_array[2]; //ev
      $r_arr[$ii]['szine']=$lo_param_array[3]; //szine
      $r_arr[$ii]['neme']=$lo_param_array[4]; //szine
      $r_arr[$ii]['rekord']=$lo_param_array[6]; //rekord
      $r_arr[$ii]['penz']=$lo_param_array[7]; //ev
      $r_arr[$ii]['nid']=$lo_param_array[8]; //apja nid
      $r_arr[$ii]['nid']=$lo_param_array[9]; //anyja nid
      if($neme!='k'){
        $r_arr[$ii]['ap_v_any']=$lo_param_array[11]; // attól függően, hogy mén vagy kanca, értelemszerűen az ősnek a nemét változtatni kell
      }else{
        $r_arr[$ii]['ap_v_any']=$lo_param_array[10]; // attól függően, hogy mén vagy kanca, értelemszerűen az ősnek a nemét változtatni kell
      }  
      $r_arr[$ii]['orszag']=$lo_param_array[12]; //orszag
      $r_arr[$ii]['apanev']=$lo_param_array[10]; //apanev továbbadása stringesen, hogyha nincs nid esetére
      $r_arr[$ii]['anyanev']=$lo_param_array[11]; //anyanev továbbadása stringesen, hogyha nincs nid esetére
      $r_arr[$ii]['nlkft_iloid']=$lo_param_array[13]; //ILOID
      $r_arr[$ii]['nevel']=$lo_param_array[14]; //nevel
      $r_arr[$ii]['elozo']=$lo_param_array[15]; //elozoneve
      unset($lo_param_array);
      $ii++;
    }
   }
  //ivadékai REMO1
   protected function lo_ivadekai_remo(&$r_arr, $lonid_remo, $remo_number){
    //print "<br>remo1:".$lonid_remo1;
    
    //print "<br> lonid_remo: ". $lonid_remo;
    $query = \Drupal::entityQuery('node')->accessCheck(TRUE);
    //$query->condition('status', 1);
    $query->condition('type', 'lovak');
    $query->condition('field_anya', $lonid_remo);
    $query->condition('field_anya', 1,'!='); //JZ
    //$query->condition('field_lo_vagy_fed', 'LO');
    //$query->condition('field_rekord', 0 , '!=');
    $query->sort('field_ev', 'desc');
    //$query->range(0,5);
    $ap_entity_ids = $query->execute(); 
    $ii=$remo_number*100+100;
    foreach($ap_entity_ids as $key => $value){
      $lo_param_array[0]=$value;
      $this->lo_param($lo_param_array);
      $r_arr[$ii]['lonid']=$lo_param_array[0]; //nev
      $r_arr[$ii]['nev']=$lo_param_array[1]; //nev
      $r_arr[$ii]['ev']=$lo_param_array[2]; //ev
      $r_arr[$ii]['szine']=$lo_param_array[3]; //szine
      $r_arr[$ii]['neme']=$lo_param_array[4]; //szine
      $r_arr[$ii]['rekord']=$lo_param_array[6]; //rekord
      $r_arr[$ii]['penz']=$lo_param_array[7]; //ev
      $r_arr[$ii]['nid']=$lo_param_array[8]; //apja nid
      $r_arr[$ii]['nid']=$lo_param_array[9]; //anyja nid
      $r_arr[$ii]['apanev']=$lo_param_array[10]; //apanev
      $r_arr[$ii]['anyanev']=$lo_param_array[11]; //anyanev
      $r_arr[$ii]['orszag']=$lo_param_array[12]; //orszag
      $r_arr[$ii]['apanev']=$lo_param_array[10]; //apanev továbbadása stringesen, hogyha nincs nid esetére
      $r_arr[$ii]['anyanev']=$lo_param_array[11]; //anyanev továbbadása stringesen, hogyha nincs nid esetére
      unset($lo_param_array);
      $ii++;
    }
   }
  
  public function csikojelPdf($sid, Request $request)
    {
        
    // adatok lekérése a submissionból
    $submission = WebformSubmission::load($sid);
    // Ellenőrizzük, hogy létezik-e a submission.
    if ($submission) {
    // A submission adatai.
      $data = $submission->getData();
 
      //print_r($data);
      //anyakanca_neve
      //csiko_ivara
      //csiko_neve
      //csiko_szine
      //fedezomen
      //szul_datum
      //tenyeszto_cime
      //tenyeszto_neve
      //tulajdonos_cime
      //tulajdonos_emailcime
      //tulajdonos_neve
      //tulajdonos_telefonszama
     
    }else{
      print "<br>Nincs ".$sid." submission!"; 
      return;  
    }
     
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);       
    
    $pdf->setPrintHeader(false);
    $pdf->AddPage();

    $pdf->SetFont('dejavusans', '', 10, '', true);
    
    $pdf->Ln(50);
    $str=$data['fedezomen'];
    $pdf->SetFont('dejavusans', 'b', 9, '', true);
    $pdf->Cell(73, 0, '', 0, 0, 'L', 0);
    $pdf->Cell(50, 0, $str, 0, 0, 'L', 0);
    
    $pdf->Ln(10);
    $str=$data['anyakanca_neve'];
    $pdf->SetFont('dejavusans', 'b', 9, '', true);
    $pdf->Cell(118, 0, '', 0, 0, 'L', 0);
    $pdf->Cell(50, 0, $str, 0, 0, 'L', 0);
    
    
    $pdf->Ln(30);
    $str=$data['tulajdonos_neve'];
    $pdf->SetFont('dejavusans', 'b', 8, '', true);
    $pdf->Cell(21, 0, '', 0, 0, 'L', 0);
    $pdf->Cell(50, 0, $str, 0, 0, 'L', 0);
    
    $pdf->Ln(11);
    $str=$data['tulajdonos_cime'];
    $pdf->SetFont('dejavusans', 'b', 8, '', true);
    $pdf->Cell(58, 0, '', 0, 0, 'L', 0);
    $pdf->Cell(50, 0, $str, 0, 0, 'L', 0);
    
    $pdf->Ln(14);
    $str=$data['tenyeszto_neve'];
    $pdf->SetFont('dejavusans', 'b', 8, '', true);
    $pdf->Cell(21, 0, '', 0, 0, 'L', 0);
    $pdf->Cell(50, 0, $str, 0, 0, 'L', 0);
    
    $pdf->Ln(10);
    $str=$data['tenyeszto_cime'];
    $pdf->SetFont('dejavusans', 'b', 8, '', true);
    $pdf->Cell(58, 0, '', 0, 0, 'L', 0);
    $pdf->Cell(50, 0, $str, 0, 0, 'L', 0);
    
    $pdf->Ln(15);
    $str=$data['csiko_neve'];
    $pdf->SetFont('dejavusans', 'b', 8, '', true);
    $pdf->Cell(21, 0, '', 0, 0, 'L', 0);
    $pdf->Cell(50, 0, $str, 0, 0, 'L', 0);
    
    $str='U G';
    $pdf->SetFont('dejavusans', 'b', 9, '', true);
    $pdf->Cell(55, 0, '', 0, 0, 'L', 0);
    $pdf->Cell(50, 0, $str, 0, 0, 'L', 0);
    
    $pdf->Ln(9);
    $str=$data['csiko_szine'];
    $pdf->SetFont('dejavusans', 'b', 8, '', true);
    $pdf->Cell(91, 0, '', 0, 0, 'L', 0);
    $pdf->Cell(50, 0, $str, 0, 0, 'L', 0);
    
    $str=$data['csiko_ivara'];
    $pdf->SetFont('dejavusans', 'b', 8, '', true);
    $pdf->Cell(14, 0, '', 0, 0, 'L', 0);
    $pdf->Cell(54, 0, $str, 0, 0, 'L', 0);
    
    $pdf->Ln(10);
    $strd=$data['szul_datum'];
    
    
  //                  2                     0                     2                     4                    -                     1                       1                     -                                                           
  $str=substr($strd,0,1).' '.substr($strd,1,1).' '.substr($strd,2,1).' '.substr($strd,3,1).'    '.substr($strd,5,1).' '.substr($strd,6,1).'    '.substr($strd,8,1).' '.substr($strd,9,1);
   
    $pdf->SetFont('dejavusans', 'b', 12, '', true);
    $pdf->Cell(38, 0, '', 0, 0, 'L', 0);
    $pdf->Cell(50, 0, $str, 0, 0, 'L', 0);
    
    $str='H U N 1 U G';
    $pdf->SetFont('dejavusans', 'b', 11, '', true);
    $pdf->Cell(20, 0, '', 0, 0, 'L', 0);
    $pdf->Cell(50, 0, $str, 0, 0, 'L', 0);
    
    

   // $pdf->writeHTML($tbl, true, false, true, false, '');
   
    $pdf->Output('jelentes'.'.pdf', 'I');


    return;
    }       
 
  
  
  
    
}