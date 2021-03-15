<?php
include "cnx.php";
$request_method = $_SERVER["REQUEST_METHOD"];

function getLesMedicaments()
{
    global $cnx;
    $reponse = array();
    $sql = $cnx->prepare("select * from medicament order by med_nomcommercial;");
    $sql->execute();
    $lesMedicaments = $sql->fetchAll(PDO::FETCH_NUM);
    //var_dump($lesMedicaments);
    foreach($lesMedicaments as $row)
    {
        $unMedicament = [
            'id' => $row[0],
            'nom_commercial' => $row[1],
            'composition' => $row[2],
            'effets' => $row[3],
            'contreindic' => $row[4],
            'prix_echantillon' => $row[5],
            'family_code' => $row[6],
        ];
        $reponse[] = $unMedicament;
    }
    echo json_encode($reponse);
}

function getLeMedicament($id)
{
    global $cnx;
    $sql = $cnx->prepare("select * from medicament order by med_nomcommercial where med_nomcommercial = ?");
    $sql->bindValue(1,$id);
    $sql->execute();
    $row = $sql->fetch(PDO::FETCH_NUM);
    $leMedicament = [
        'id' => $row[0],
        'nom_commercial' => $row[1],
        'composition' => $row[2],
        'effets' => $row[3],
        'contreindic' => $row[4],
        'prix_echantillon' => $row[5],
    ];
    echo json_encode($leMedicament);
}

function UpdateMedicament()
	{
		global $cnx;
		$json_str = file_get_contents('php://input');
		$leSecteur = json_decode($json_str);
		$sql = $cnx->prepare("update secteur set secLibelle = ? where secCode = ?");
		$sql->bindValue(1,$leSecteur->Nom);
	 	$sql->bindValue(2,$leSecteur->Id);
		$sql->execute();
	}

function UpdateMedicament()
{
    global $cnx;
    $json_str = file_get_contents('php://input');
    $leSecteur = json_decode($json_str);
    $sql = $cnx->prepare("update medicament set 'nom_commercial = ?, 'composition' = ?, effets = ? 'contreindic' = ? 'prix_echantillon' = ? where id = ?");
    $sql->bindValue(1,$leMedicament->Nom);
    $sql->bindValue(2,$leMedicament->composition);
    $sql->bindValue(3,$leMedicament->effets);
    $sql->bindValue(4,$leMedicament->contreindic);
    $sql->bindValue(5,$leMedicament->prix_echantillon);
    $sql->bindValue(6,$leMedicament->id);
    $sql->execute();
}
switch($request_method)
{
    case 'GET':
        if(!empty($_GET["id"]))
        {
            getLeMedicament($_GET["id"]);
        }
        else
        {
            getLesMedicaments();
        }
        break;
    case 'POST':
        AddMedicament();
        break;
    case 'PUT':
        UpdateMedicament();
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
?>