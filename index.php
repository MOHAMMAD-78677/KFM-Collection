
<?php
header('Content-Type: text/html; charset=utf-8');


// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start(); //cela démare une nouvelle session ou reprend une session existante
//cette fonction active la mise en mémoire tampon de la sortie. 
//lorsque la mise en mémoire tampon de la sortie est activée, les données envoyées au navigateur
// sont stockées dans un tampon au lieu d'être envoyées immédiatement.
//Cela permet de contrôler quand les données sont envoyées au navigateur
// ce qui est particulièrement utile
$routesProtegees = [
    'ajouter_produit',
    'editer_produit',
    'supprimer_produit'
];
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
ob_start(); 
//le paramètre dans URL lié à la variable Aparcge : RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]

// Définir la racine du projet
define('BASE_PATH', __DIR__);

// URL de base du projet (générée dynamiquement pour éviter les espaces/casse entrées manuellement)
$baseUrl = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$baseUrl = rtrim($baseUrl, '/');
define('BASE_URL', $baseUrl === '' || $baseUrl === '.' ? '' : $baseUrl);

// Inclure le controller
require_once BASE_PATH . "/controllers/produits/ProduitsController.php";
$controller = new \controllers\produits\ProduitsController();

$url = "";
//isset détermine si une variable est définie et est différente de null
//si url existe dans la requête GET, alors on affecte sa valeur à la variable $url
if (isset($_GET["url"])){
    $url=$_GET["url"];
    //var_dump($url);
}else{
    //sinon par defaut la route d'accueil est la suivante
    $url="afficher-produit";
}if (
    in_array($url, $routesProtegees, true)
    && !isset($_SESSION['user_id'])
) {
    http_response_code(403);
    exit("Vous devez vous connecter pour effectuer cette action.");
}

// //Si le paramètre apache et la variable $url sont égaux à afficher-produit, 
// //alors on inclut le fichier afficher-produit.php
// if($url=="afficher-produit"){
//     //par défaut : http:localhost/KFM-Collection/index.php?url=afficher-produit
//     //avec la réecriture : http:localhost/KFM-Collection/views/index.php?url=afficher-produit
//     //URL finale : http:localhost/KFM-Collection/afficher-produit
//     //on appel le fichier php views/produits/afficher-produit.php
//     require_once "views/produits/afficher-produit.php";
// }

// //on  effectue une redirection si url ne correspond à aucune des routes définies via des règles de réécriture d'URL dans le fichier .htaccess
// elseif($url != '#:@&-[\w]+)#'){
//     //redirection vers la page d'accueil
//     header ("location:views/produits/afficher-produit");
//     exit;
// }

if($url=="afficher-produit"){
    $title="KFM - Nos produits";
    //par défaut : http://localhost/KFM-Collection/views/produits/afficher-produit.php
    //avec la réécriture : http://localhost/KFM-Collection/views/index.php?url=afficher-produit
    //URL finale : http://localhost/KFM-Collection/afficher-produit
    //on appel le fichier php views/produits/afficher-produit.php
    $tous_les_produits = $controller->AfficherTousLesProduits();
    require_once "views/produits/afficher-produit.php";
}elseif($url==="details_produit"){
    $title = "KFM - Détails du produit -";
    $produit = $controller->AfficherLesDetailsDuProduit();
    if ($produit === null) {
    http_response_code(404);
    exit('Produit introuvable.');
    //Cela évite les erreurs si un produit n'existe pas.
}
    require_once "views/produits/details_produit.php";
}elseif ($url === "ajouter_produit"){
    $title="KFM - Ajouter un produit-";
    //ensuite la fonction du controlleur pour le traitement
    	$controller->AjouterUnProduit();
    //on appel la vue pour charger les champs du formulaire
    require_once "views/produits/ajouter_produit.php";
    //ensuite la fonction du controlleur pour le traitement
}elseif($url === "editer_produit"){
    $title="KFM - Editer produit";
    $id_produit = isset($_GET['id_produit']) ? (int)$_GET['id_produit'] : 0;
    $produit = $controller->AfficherLesDetailsDuProduit();

if ($produit === null) {
    http_response_code(404);
    exit('Produit introuvable.');
}

$controller->EditerUnProduit();
require_once "views/produits/editer_produit.php";
} elseif ($url === "supprimer_produit"){
if ($_SERVER['REQUEST_METHOD'] !== 'POST'
    || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    exit('Action non autorisée.');
}

$controller->SupprimerProduitParID();
header("Location: ?url=afficher-produit");
exit;
} elseif ($url === "inscription") {
    header("Location: " . BASE_URL . "/inscription.php");
    exit;

} elseif ($url === "connexion") {
    header("Location: " . BASE_URL . "/connexion.php");
    exit;

} elseif ($url === "dashboard") {
    if (
        !isset($_SESSION['user_id']) ||
        (int) ($_SESSION['user_role'] ?? 0) !== 2
    ) {
        http_response_code(403);
        exit("Accès réservé à l'administrateur.");
    }

    $title = "KFM - Tableau de bord";
    require_once "views/dashboard.php";
} elseif ($url === "deconnexion") {
    header("Location: " . BASE_URL . "/deconnexion.php");
    exit;
}else {
    http_response_code(404);
    echo '<h1>404 - Page non trouvée</h1><p>La page demandée "'.htmlspecialchars($url).'" n\'existe pas.</p>';
    exit;
}


//le contenu dynamique de la page est stocké dans la variable $content, qui est ensuite affichée dans le template
//cette fonction appelle le gestionnaire de sortie 
$content=ob_get_clean();
//ob_get_clean() récupère le contenu du tampon de sortie et le nettoie, 
//ce qui signifie que le contenu est stocké dans la variable $content 
//et que le tampon de sortie est vidé pour éviter d'envoyer des données au navigateur avant que le template ne soit rendu.
require_once "Template.php";

