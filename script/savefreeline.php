<?php

require '../config.php';
	
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
    break;
}

$product->label = $label;
$product->ref = $ref;
$product->description = $description;
$product->price = $price;
$product->tva_tx = $tva;
$product->status_buy = 1;
$product->status = 1;
$product->type = $product_type;

$product->create($user);
// Traitement des données, par exemple les enregistrer dans la base de données
// $db = new PDO(...); // Connexion à la base de données
// $stmt = $db->prepare("UPDATE products SET label = ?, qty = ?, price = ?, product_type = ?, tva = ? WHERE lineid = ?");
// $stmt->execute([$label, $qty, $price, $product_type, $tva, $lineid]);

return json_encode(["status" => "success"]);