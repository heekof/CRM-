<?php
include("phpToPDF/phpToPDF.php");

$PDF=new phpToPDF();

$PDF->AddPage();
$PDF->startPageNums();
$PDF->SetFont('Arial','B',14);
$PDF->Image("./images/logoktis.jpg", 10, 10);

//Cadre Adresse Ktis
//*****************************

$PDF->SetFont('Arial','B',16);
// Définition des propriétés du tableau.
$ptesTableau = array(
'TB_ALIGN' => 'R',
'R_MARGIN' => 15,
'BRD_COLOR' => array(0,92,177),
'BRD_SIZE' => '0.3',
);
// Définition des propriétés du header du tableau.
$pteHeader = array(
'T_COLOR' => array(150,10,10),
'T_SIZE' => 12,
'T_FONT' => 'Arial',
'T_ALIGN' => 'C',
'V_ALIGN' => 'T',
'T_TYPE' => 'B',
'LN_SIZE' => 7,
'BG_COLOR_COL0' => array(239, 241, 241),
'BG_COLOR' => array(170, 240, 230),
'BRD_COLOR' => array(0,92,177),
'BRD_SIZE' => 0.2,
'BRD_TYPE' => '1',
'BRD_TYPE_NEW_PAGE' => '',
);
// Contenu du header du tableau.
$ctnuHeader = array(
85,
"          http://www.ktis-fr.com",
);
// Définition des propriétés du reste du contenu du tableau.
$pteContenu = array(
'T_COLOR' => array(0,0,0),
'T_SIZE' => 10,
'T_FONT' => 'Arial',
'T_ALIGN_COL0' => 'L',
'T_ALIGN' => 'C',
'V_ALIGN' => 'M',
'T_TYPE' => '',
'LN_SIZE' => 6,
'BG_COLOR_COL0' => array(239, 241, 241),
'BG_COLOR' => array(239, 241, 241),
'BRD_COLOR' => array(239, 241, 241),
'BRD_SIZE' => 0.1,
'BRD_TYPE' => '1',
'BRD_TYPE_NEW_PAGE' => '',
);
// Contenu du tableau.
$ctnuTableau = array(
"ktis - Siret 479 811 754 00015 - Ape 723 Z\n68 rue de musselburg – 94500 champigny sur Marne Tél : 0170819329 - Email : info@kt-centrex.com",
);
// D'abord le PDF, puis les propriétés globales du tableau.
// Ensuite, le header du tableau (propriétés et données) puis le contenu (propriétés et données)
$PDF->drawTableau($PDF, $ptesTableau, $pteHeader, $ctnuHeader, $pteContenu,$ctnuTableau);

//*****************************
$PDF->SetFont('Arial','B',14);
//$PDF->Cell(0, 10, "http://www.ktis-fr.com", 0, 2, "C","","http://www.ktis-fr.com");/*Lien du site*/
//DATE
$PDF->Text(115,45,"Champigny sur marne, le ".date('d/m/Y',time()));
//Numero de facture
$PDF->Write(10,"\n\nDEVIS N° : ".$f."\n");

//Recapitulatif du devis
$PDF->SetFont('Arial','B',12);$PDF->Write(10,"\nNom du client : ");$PDF->SetFont('Arial','',12);$PDF->Write(10,$prenom.' '.$nom);
$PDF->SetFont('Arial','B',12);$PDF->Write(10,"\nNom de la Société : ");$PDF->SetFont('Arial','',12);$PDF->Write(10,$societe);
$PDF->SetFont('Arial','B',12);$PDF->Write(10,"\nAdresse : ");$PDF->SetFont('Arial','',12);$PDF->Write(10,$adresse." - ".$liv_codepostal." ".$liv_ville.' ; '.$liv_pays);
$PDF->SetFont('Arial','B',12);$PDF->Write(10,"\nTél(s) : ");$PDF->SetFont('Arial','',12);
$tel = "";
if($telephonep) $tel .= 'Cel : '.$telephonep;
if($telephonef && $tel) $tel .= ' ; fixe : '.$telephonef; elseif($telephonef) $tel .= 'fixe : '.$telephonep;
if($telephoneb && $tel) $tel .= ' ; bureau : '.$telephoneb; elseif($telephoneb) $tel .= 'bureau : '.$telephoneb;

$PDF->Write(10,$tel);
$PDF->SetFont('Arial','B',12);$PDF->Write(10,"\nE-mail : ");$PDF->SetFont('Arial','',12);$PDF->Write(10,$email);

//On récupère les details de la facture
$query = " SELECT * FROM elementfacture WHERE idfacture='".$f."' ;";
	$rDetails = mysql_query($query) or die ("Erreur : ".mysql_error());
	
$PDF->Write(10,"\nDETAILS DU DEVIS : \n");
$totalHT = 0;
$totalTTC = 0;
$desc = '';
while($details = mysql_fetch_array($rDetails))
{
	$query = " SELECT * FROM element WHERE id='".$details['idelement']."' ;";
	$rElt = mysql_query($query) or die ("Erreur : ".mysql_error());
	$elt = mysql_fetch_array($rElt);
	$desc .= $elt['ref'].'-';
	$contenuTableau[] = $elt['ref'];
	$contenuTableau[] = $details['prix'];
	$contenuTableau[] = $details['quantite'];
	$contenuTableau[] = number_format($details['prix']*$details['quantite'],3);
	$totalHT += $details['prix']*$details['quantite'];
}
//**************************************************************************************************

$PDF->SetFont('Arial','B',16);
// Définition des propriétés du tableau.
$proprietesTableau = array(
'TB_ALIGN' => 'L',
'L_MARGIN' => 15,
'BRD_COLOR' => array(0,92,177),
'BRD_SIZE' => '0.3',
);
// Définition des propriétés du header du tableau.
$proprieteHeader = array(
'T_COLOR' => array(150,10,10),
'T_SIZE' => 12,
'T_FONT' => 'Arial',
'T_ALIGN' => 'C',
'V_ALIGN' => 'T',
'T_TYPE' => 'B',
'LN_SIZE' => 7,
'BG_COLOR_COL0' => array(170, 240, 230),
'BG_COLOR' => array(170, 240, 230),
'BRD_COLOR' => array(0,92,177),
'BRD_SIZE' => 0.2,
'BRD_TYPE' => '1',
'BRD_TYPE_NEW_PAGE' => '',
);
// Contenu du header du tableau.
$contenuHeader = array(
75, 25, 20, 30,
"Description", "P.U. (en €)", "Quantité", "Montant (en €)",
);
// Définition des propriétés du reste du contenu du tableau.
$proprieteContenu = array(
'T_COLOR' => array(0,0,0),
'T_SIZE' => 10,
'T_FONT' => 'Arial',
'T_ALIGN_COL0' => 'L',
'T_ALIGN' => 'R',
'V_ALIGN' => 'M',
'T_TYPE' => '',
'LN_SIZE' => 6,
'BG_COLOR_COL0' => array(245, 245, 150),
'BG_COLOR' => array(255,255,255),
'BRD_COLOR' => array(0,92,177),
'BRD_SIZE' => 0.1,
'BRD_TYPE' => '1',
'BRD_TYPE_NEW_PAGE' => '',
);
// Contenu du tableau.
/*$contenuTableau = array(
"champ 1", 1, 2,2,
"champ 2", 3, 4,2,
"champ 3", 5, 6,2,
"champ 4", 7, 8,2,
);*/
// D'abord le PDF, puis les propriétés globales du tableau.
// Ensuite, le header du tableau (propriétés et données) puis le contenu (propriétés et données)
$PDF->drawTableau($PDF, $proprietesTableau, $proprieteHeader, $contenuHeader, $proprieteContenu,$contenuTableau);

//les totaux
$PDF->SetFont('Arial','',12);$PDF->Write(10,"Montant total H.T. : ");$PDF->SetFont('Arial','B',12);$PDF->Write(10,$totalHT.' €');

$PDF->SetFont('Arial','',12);$PDF->Write(10,"\nTVA(".$tva."%) : ");$PDF->SetFont('Arial','B',12);$PDF->Write(10,($totalHT*($tva/100)).' €');

$PDF->SetFont('Arial','',12);$PDF->Write(10,"\nMontant total T.T.C. : ");$PDF->SetFont('Arial','B',12);$PDF->Write(10,($totalHT*(1+$tva/100)).' €');

//**************************************************************************************************
$PDF->AddPage();
$PDF->stopPageNums();

//Une nouvelle page pour notre  RELEVE D'IDENTITE BANCAIRE
$PDF->SetFont('Arial','B',16);
$PDF->Cell(0, 10, "RELEVE D'IDENTITE BANCAIRE", 0, 2, "C");
$PDF->SetFont('Times','',16);
$PDF->Write(10,"Titulaire du compte : KTIS \nDomiciliation : BNP PARISBAS CHAMPIGNY REPUBLIQUE \n\n");
$PDF->Write(10,"Code Banque : 30004 \nCode Guichet : 01601 \nNuméro de Compte : 00010022727 \nClé Rib : 71\n\n");
$PDF->Write(10,"Numéro de compte bancaire International (IBAN) \nFR76 3000 4016 0100 0100 2272 771\n\n");
$PDF->Write(10,"CODE BIC : BNPAFRPPMDT");


//Donne un nom au devis

//Enregistre le devis dans le dossioer des devis
$PDF->Output("les_devis/".$nomDuDevis.".pdf", "F");
?>