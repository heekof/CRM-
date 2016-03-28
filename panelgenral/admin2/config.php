<?php

$admin_user = 'kalengula';
$admin_pass = 'kalengula2010';

// $mysql_server = '94.23.22.154';

$mysql_server = '192.168.137.25';
$mysql_user = 'root';
$mysql_password = 'kalonji';
$mysql_db = 'ktcentrex';

$upload_root = '../centrexadmin/';
$images_base = '../test/';
$max_image_size = 10240;

$admin_pages = array();
$admin_pages['clients'] = array( 'name' => 'Clients', 'path' => 'pages/clients.php' );
$admin_pages['comptes'] = array( 'name' => 'Comptes', 'path' => 'pages/comptes.php' );






$admin_pages['abonnements'] = array( 'name' => 'Abonnements', 'path' => 'pages/abonnements.php',
                        'spage' => array('listeabonnements' => array('name' => 'Liste des abonnements', 'path' => 'pages/listeabonnements.php'),
                                                'addabonnement' => array( 'name' => 'Creer un abonnement', 'path' => 'pages/addabonnement.php' )

                                )
);






$admin_pages['gestioncredits'] = array( 'name' => 'Gestion des crédits', 'path' => 'pages/gestioncredits.php',
			'spage' => array('credits' => array('name' => 'Liste', 'path' => 'pages/credits.php'),
						'historique_de_credits' => array( 'name' => 'Historique d\'ajout', 'path' => 'pages/historique_de_credits.php' ),
						'consommations_credits' => array( 'name' => 'Stats des consommations', 'path' => 'pages/historique_de_credits.php' )
				)
);

//$admin_pages['historique_de_credits'] = array( 'name' => 'Historique de credits', 'path' => 'pages/historique_de_credits.php' );
//$admin_pages['consommation'] = array( 'name' => 'Consommation', 'path' => 'pages/consommation.php' );

$admin_pages['facturation'] = array( 'name' => 'facturation', 'path' => 'pages/facturation.php' ,
		'spage' => array('newfacture' => array( 'name' => 'Nouvelle', 'path' => 'pages/newfacture.php' ),
						'factures' => array( 'name' => 'Liste', 'path' => 'pages/factures.php' ),
						'paiements' => array( 'name' => 'Payées', 'path' => 'pages/paiements.php' ),
						'impayes' => array( 'name' => 'Impayées', 'path' => 'pages/impayes.php' )
				)
);


// jaafar -----------------------------------------------------------------

$admin_pages['envoie de contrat'] = array( 'name' => 'contrat', 'path' => 'pages/nouveau_contrat.php' ,
		'spage' => array('ajout_contract' => array( 'name' => 'ajout_contrat', 'path' => 'pages/ajout_contrat.php' ),
						'sauvegarde_contrat' => array( 'name' => 'sauvegarde_contrat', 'path' => 'pages/sauvegarde_contrat.php' )
				)
);


// fin jaafar---------------------------------------------------------------------------------------------
$admin_pages['rappel'] = array( 'name' => 'rappel', 'path' => 'pages/rappel.php' );

$admin_pages['publicite'] = array( 'name' => 'Publicite', 'path' => 'pages/publicite.php',
                        'spage' => array('publicite' => array('name' => 'creer une publicite', 'path' => 'pages/publicite.php'),
                                                'listedepub' => array( 'name' => 'Liste de publicite', 'path' => 'pages/listedepub.php' )



                                )
);







$admin_pages['catalogue'] = array( 'name' => 'Catalogue', 'path' => 'pages/catalogue.php' );

$admin_pages['mailling'] = array( 'name' => 'Mailling', 'path' => 'pages/mailling.php' );

$admin_pages['tarif'] = array( 'name' => 'Les tarifs', 'path' => 'pages/tarif.php' );

$admin_pages['archiver_credits'] = array( 'name' => 'archiver les credits', 'path' => 'pages/archiver_credits.php' );
$admin_pages['support'] = array( 'name' => 'support', 'path' => 'pages/support.php' );
$admin_default_page = 'clients';

?>
