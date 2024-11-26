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
dol_include_once('/commande/class/orderline.class.php');
dol_include_once('/comm/propal/class/propaleligne.class.php');

global $user, $langs;

$lineid=GETPOST('lineid');
$label = GETPOST('label');
$price = GETPOST('price');
$description = GETPOST('description');
$weight = GETPOST('height');
$weight = GETPOST('weight');
$weight = GETPOST('cost_price');
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
    $product->weight = $weight;
    $product->height = $height;
    $product->cost_price = $cost_price;
    $product->price = price2num($price);
    $product->tva_tx = $tva;
    $product->status_buy = 1;
    $product->status = 1;
    $product->type = $product_type;
    $prd = $product->create($user);
    
    if ($prd > 0) {
        if($element == 'propal'){
            $table='propaldet';
            $classligne = 'PropaleLigne';
        }
        else if($element == 'commande') {
            $table='commandedet';
            $classligne = 'OrderLine';
        }
    
        $object = new $classligne($db);
        $object->fetch($lineid);
        $totalttc = price2num($price) + (price2num($price) * $tva / 100);
        // Save fk_product
        $object->fk_product = $prd;
        $sql = "UPDATE ".MAIN_DB_PREFIX.$table;
        $sql .= " SET fk_product=".$prd;
        $sql .= " WHERE rowid=".$lineid;
        $db->query($sql);
        $object->total_ttc = strval($totalttc);
        $object->total_ht = strval($price * $object->qty);
        $object->desc = $description;
        $object->weight = $weight;
        $object->height = $height;
        $object->cost_price = $cost_price;
        $object->label = $label;
        $object->tva_tx = $tva;
        $object->price = strval($price);
        $object->subprice = strval($price);
        $object->product_type = $product_type;
        $res = $object->update($user, true);
        $object->update_total();
        if ($res) {
            setEventMessage('Produit créer', 'mesgs');
            echo json_encode([
                'success' => true,
                'data' => [
                    'description' => $description,
                    'price' => $price,
                    'tva' => $tva
                ]
            ]);
        } else {
            setEventMessage('Une erreur est survenu lors de la création du produit', 'errors');
        }

        // $totalttc = price2num($price) + (price2num($price) * $tva / 100);
        // $sql = "UPDATE ".MAIN_DB_PREFIX.$table;
        // $sql .= " SET fk_product=".$prd;
        // $sql .= " ,description='".$description;
        // $sql .= "' ,label='".$label;
        // $sql .= "' ,tva_tx=".$tva;
        // $sql .= " ,price=".$price;
        // $sql .= " ,subprice=".$price;
        // $sql .= " ,total_ht=".$object->total_ht;
        // $sql .= " ,total_ttc=".$totalttc;
        // $sql .= " ,product_type='".$product_type."'";
        // $sql .= " WHERE rowid=".$lineid;
        // if($res = $db->query($sql)) {
        //     setEventMessage('Produit créer', 'mesgs');
        // } else {
        //     setEventMessage('Une erreur est survenu lors de la création du produit', 'errors');
        // }
    }
}