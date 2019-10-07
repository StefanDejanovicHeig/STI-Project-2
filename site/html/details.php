<?php
session_start();
include_once('includes/header.inc.php');

if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false){
    header("location: login.php");
    exit;
}

require_once "connection.php";
try {
    $sql = "SELECT Message.date, Utilisateur.login, Message.sujet, Message.corps FROM Message INNER JOIN Utilisateur
            ON Message.expediteur = Utilisateur.id_login WHERE Message.id_message = " . $_GET["id"];

    $stmt = $pdo->query($sql);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    header("Location: 404.php");
    die("ERREUR: " . $e->getMessage());
}

echo '<div class="container-fluid" >';

if(isset($result)) {
    $rowArray = array("Date de réception:","Expéditeur:","Sujet:","Message:");
    $sqlRow = array("date", "login", "sujet", "corps");

    $valueArray = array();
    $cpt = 0;
    for ($i = 0; $i < count($sqlRow); $i++){
        array_push($valueArray, $result->$sqlRow[$cpt++]);
    }

    for ($i = 0; $i < count($rowArray); $i++) {
        $sizeOfBloc = $i > 1 ? 9 : 3;
                echo'<div class="col-lg-' . $sizeOfBloc .'">
                    <div class="card shadow mb-4" >
                        <div class="card-header py-3" >
                            <h6 class="m-0 font-weight-bold text-primary" >' . $rowArray[$i] . '</h6 >
                        </div >
                    <div class="card-body" >' . nl2br($valueArray[$i]) . '</div >
                </div>
              </div >';
    }
}
else{
            echo'<div class="col-lg-3" >
                <div class="card shadow mb-4" >
                    <div class="card-header py-3" >
                        <h6 class="m-0 font-weight-bold text-primary" > Erreur:</h6 >
                    </div >
                    <div class="card-body" >Aucun mail à afficher</div >
                </div >
            </div >';
}


echo '<a href="index.php" class="btn btn-primary btn-user btn-block">Retour</a>';
echo '</div >';

include_once('includes/footer.inc.php');
?>