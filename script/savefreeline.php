<?php

if(is_file('../main.inc.php'))$dir = '../';
else  if(is_file('../../../main.inc.php'))$dir = '../../../';
else $dir = '../../';


if(!defined('INC_FROM_DOLIBARR') && defined('INC_FROM_CRON_SCRIPT')) {
    include($dir."master.inc.php");
}
elseif(!defined('INC_FROM_DOLIBARR')) {
    include($dir."main.inc.php");
} else {
    global $dolibarr_main_db_host, $dolibarr_main_db_name, $dolibarr_main_db_user, $dolibarr_main_db_pass;
}

if(!defined('DB_HOST')) {
    define('DB_HOST',$dolibarr_main_db_host);
    define('DB_NAME',$dolibarr_main_db_name);
    define('DB_USER',$dolibarr_main_db_user);
    define('DB_PASS',$dolibarr_main_db_pass);
}

dol_include_once('/product/class/product.class.php');

global $user, $langs;

$lineid=GETPOST('lineid');
$label = GETPOST('label');
$price = GETPOST('price');
$description = GETPOST('description');
$element = GETPOST('element');
$ref = GETPOST('ref');
$product_type = GETPOST('product_type');
$tva = GETPOST('tva');

$product = new Product($db);
if($product->fetch('', $ref) > 0) {
    setEventMessage('Cette référence existe déjà pour un produit', 'errors');
}

if (empty($lineid) && empty($label)) {
    setEventMessage('Une erreur est survenue (label manquant ou autre)', 'errors');
} else {
    $product->label = $label;
    $product->ref = $ref;
    $product->description = $description;
    $product->price = $price;
    $product->tva_tx = $tva;
    $product->status_buy = 1;
    $product->status = 1;
    $product->type = $product_type;
    $prd = $product->create($user);

    if ($prd > 0) {
        if($element == 'propal')$table='propaldet';
        else if($element == 'commande')$table='commandedet';

        $sql = "UPDATE ".MAIN_DB_PREFIX.$table." SET fk_product=".$prd.",description='".$description."',label='".$label."',tva_tx=".$tva.",price=".$price.",product_type='".$product_type."'";
        $sql .= " WHERE rowid=".$lineid;
        var_dump($sql);
        if($res = $db->query($sql)) {
            setEventMessage('Produit créer', 'mesgs');
        } else {
            setEventMessage('Une erreur est survenu lors de la création du produit', 'errors');
        }
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'description' => $description,
            'price' => $price,
            'tva' => $tva
        ]
    ]);
}