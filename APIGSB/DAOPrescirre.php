<?php
	include "cnx.php";
	$request_method = $_SERVER["REQUEST_METHOD"];
	
	function getLesPrecrires()
	{
		global $cnx;
		$reponse = array();
		$sql = $cnx->prepare("select * from prescrire order by med_depotlegal");
		$sql->execute();
		$lesPrescr = $sql->fetchAll(PDO::FETCH_NUM);
		//var_dump($lesSecteurs);
		foreach($lesSecteurs as $row)
		{
			$unPrescrire = [
				'med_depotlegal' => $row[0],
				'tin_code' => $row[1],
                'dos_code' => $row[2],
                'posologie' => $row[3],
			];
			$reponse[] = $unPrescrire;
		}
		echo json_encode($reponse);
	}
	function getLePrescrire($med_depotlegal)
	{
		global $cnx;
		$sql = $cnx->prepare("select * from prescrire where med_depotlegal = ?");
		$sql->bindValue(1,$med_depotlegal);
		$sql->execute();
		$row = $sql->fetch(PDO::FETCH_NUM);
		$lePrescrire = [
			    'med_depotlegal' => $row[0],
				'tin_code' => $row[1],
                'dos_code' => $row[2],
                'posologie' => $row[3],
		];
		echo json_encode($leSecteur);
	}

	function AddPrescrire()
	{
		global $cnx;
		$json_str = file_get_contents('php://input');
		$nom = json_decode($json_str);
		$sql = $cnx->prepare("select max(med_depotlegal) from prescrire");
		$sql->execute();
		$row = $sql->fetch(PDO::FETCH_NUM);
		$sql = $cnx->prepare("insert into prescrire values(?,?)");
		$sql->bindValue(1,intval($row[0]) + 1);
		$sql->bindValue(2,$nom->Sec);
		$sql->execute();
	}

	function UpdatePrescire()
	{
		global $cnx;
		$json_str = file_get_contents('php://input');
		$leSecteur = json_decode($json_str);
		$sql = $cnx->prepare("update prescrire set tin_code = ? where secCode = ?");
		$sql->bindValue(1,$lePrescrire->Nom);
	 	$sql->bindValue(2,$lePrescrire  ->Id);
		$sql->execute();
	}
	switch($request_method)
	{
		case 'GET':
			if(!empty($_GET["id"]))
			{
				getLePrescrire($_GET["id"]);
			}
			else
			{
				getLesPrecrires();
			}
			break;
		case 'POST':
			AddPrescrire();
			break;
		case 'PUT':
			UpdatePrescire();
			break;
		default:
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}
?>