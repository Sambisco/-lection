<?php 
session_start();
include('../includes/database.php');
?>
<?php 

?>
<?php 
 if(isset($_POST["invoice_btn"]))
  { 
   $num = $_POST["num"];
   $query="SELECT num FROM vente WHERE num=$num";
     $statement=$db->prepare($query);
	$statement->execute();
$result=$statement->fetchAll();
$total_row=$statement->rowCount();
    if ($total_row>0){
	$_SESSION['message_delete']="La vente existe déja. Veillez créér une nouvelle vente!";
 $_SESSION['msg_type_delete']="danger";
  header("location:../gs/vente.php");
	}else{
	 $nom_client = $_POST["nom_client"];
	 $adresse = $_POST["adresse"];
    $telephone = $_POST["telephone"];
	 $id_utilisateur = $_POST["id_utilisateur"];
	$statc = $db->prepare("INSERT INTO `client`( `nom_client`, `adresse`, `telephone`,`id_utilisateur`) VALUES(:nom_client, :adresse, :telephone, :id_utilisateur)");
 $statc->execute(array(
		':nom_client'=>$nom_client,
		':adresse'=>$adresse,
		':telephone'=>$telephone,
		  ':id_utilisateur'=>$id_utilisateur 
		  ));
	$statc = $db->query("SELECT LAST_INSERT_ID()");
      $id_client = $statc->fetchColumn();
	  
	 $mt_ht = $_POST["mt_ht"];
    $mt_tva = $_POST["mt_tva"];
	 $mt_ttc = $_POST["mt_ttc"];
	  $description = $_POST["description"];
	$stat = $db->prepare("INSERT INTO `tva`( `id_client`, `mt_ht`, `mt_tva`, `mt_ttc`, `description`) VALUES(:id_client, :mt_ht, :mt_tva,:mt_ttc,:description)");
 $stat->execute(array(
		':id_client'=>$id_client,
		':mt_ht'=>$mt_ht,
		 ':mt_tva'=>$mt_tva,
		 ':mt_ttc'=>$mt_ttc,
		 ':description'=>$description
		  ));

	 $zone = $_POST["zone"];
	  $tarif = $_POST["tarif"];
	 $id_utilisateur = $_POST["id_utilisateur"];
	$stat = $db->prepare("INSERT INTO `livraison`( `id_client`,`zone`, `tarif`) VALUES(:id_client,:zone, :tarif)");
 $stat->execute(array(
		':id_client'=>$id_client,
		  ':tarif'=>$tarif,
		 ':zone'=>$zone
		  ));
		  
	  $montant = $_POST["montant"];
	$stat = $db->prepare("INSERT INTO `account`( `id_client`, `montant`) VALUES(:id_client, :montant)");
 $stat->execute(array(
		':id_client'=>$id_client,
		    ':montant'=>$montant
		  ));
      for($count=0; $count<$_POST["quantite"]; $count++)
      {
      
        $num = $_POST["num"];
 $date = $_POST["date"];
  $nom_client = $_POST["nom_client"];
   $adresse = $_POST["adresse"];
    $telephone = $_POST["telephone"];
	$id_stock = $_POST["id_stock"];
	$quantite = $_POST["quantite"];
	$remise = $_POST["remise"];
	$total = $_POST["total"];
	
	 $id_utilisateur = $_POST["id_utilisateur"];
        $statement = $db->prepare("INSERT INTO `vente`(`num`, `date`,`id_client`, `id_stock`, `quantite`, `remise`, `total`) VALUES (:num, :date,:id_client, :id_stock,:quantite, :remise, :total)");

        $statement->execute(array(
		':num'=>$num,
		':date'=>$date,
		':id_client'=>$id_client,
		 ':id_stock'=>$id_stock[$count],
		 ':quantite'=>$quantite[$count],
		  ':remise'=>$remise[$count],
		 ':total'=>$total[$count]
		 
		 ));
        $statement = $db->prepare("UPDATE `stock` SET qte=qte-:quantite WHERE id_stock=:id_stock");
        $statement->execute(array(
		':id_stock'=>$id_stock[$count],
		   ':quantite'=>$quantite[$count]
		
		 
		 ));
		
		  $_SESSION['message_add']="Les données ont été enregistrées avec success ";
 $_SESSION['msg_type_add']="success";
		  header("location:../gs/vente.php");
      }
	}
	}
		
	
 if(isset($_POST["invoice_update"])){
 $id=$_POST['num'];
 $query="DELETE FROM vente WHERE num=$id";
 $statement=$db->prepare($query);
$statement->execute(array( $id));

 $nom_client = $_POST["nom_client"];
	 $adresse = $_POST["adresse"];
    $telephone = $_POST["telephone"];
	 $id_client = $_POST["id_client"];
	$statc = $db->prepare("UPDATE client SET nom_client=:nom_client,adresse=:adresse, telephone=:telephone WHERE id_client=:id_client");
 $statc->execute(array(
		':nom_client'=>$nom_client,
		':adresse'=>$adresse,
		':telephone'=>$telephone,
		  ':id_client'=>$id_client 
		  ));
  $id_tva = $_POST["id_tva"];
	 $mt_ht = $_POST["mt_ht"];
    $mt_tva = $_POST["mt_tva"];
	 $mt_ttc = $_POST["mt_ttc"];
	  $description = $_POST["description"];
	$stat = $db->prepare("UPDATE tva SET mt_ht=:mt_ht, mt_tva=:mt_tva, mt_ttc=:mt_ttc, description=:description WHERE id_tva=:id_tva");
 $stat->execute(array(
         ':id_tva'=>$id_tva,
		':mt_ht'=>$mt_ht,
		 ':mt_tva'=>$mt_tva,
		 ':mt_ttc'=>$mt_ttc,
		 ':description'=>$description,
		  ));
		 $id_livraison = $_POST["id_livraison"];
		
         $zone = $_POST["zone"];
	  $tarif = $_POST["tarif"];
	$stat = $db->prepare("UPDATE livraison SET zone=:zone, tarif=:tarif WHERE id_livraison=:id_livraison");
 $stat->execute(array(
		':id_livraison'=>$id_livraison,
		':zone'=>$zone,
		 ':tarif'=>$tarif,
		  ));
		   $id_account = $_POST["id_account"];
	  $montant = $_POST["montant"];
	 $id_utilisateur = $_POST["id_utilisateur"];
	$stat = $db->prepare("UPDATE `account` SET `montant`=:montant WHERE id_account=:id_account");
 $stat->execute(array(
		':id_account'=>$id_account,
		    ':montant'=>$montant,
		  ));
     for($count=0; $count<$_POST["quantite"]; $count++)
      {
      
        $num = $_POST["num"];
 $date = $_POST["date"];
	$id_stock = $_POST["id_stock"];
	$quantite = $_POST["quantite"];
	$remise = $_POST["remise"];
	$total = $_POST["total"];
	         $statement = $db->prepare("INSERT INTO `vente`(`num`, `date`,`id_client`, `id_stock`, `quantite`, `remise`, `total`) VALUES (:num, :date,:id_client, :id_stock,:quantite, :remise, :total)");

        $statement->execute(array(
		':num'=>$num,
		':date'=>$date,
		':id_client'=>$id_client,
		 ':id_stock'=>$id_stock[$count],
		 ':quantite'=>$quantite[$count],
		  ':remise'=>$remise[$count],
		 ':total'=>$total[$count]
		 
		 ));
		$_SESSION['message_update']="Les modifications ont été effectuées ";
 $_SESSION['msg_type_update']="warning";
		  header("location:../gs/vente.php");
      }
      }
if(isset($_POST['supdata'])){
  $id=$_POST['sup_client'];
 $query="DELETE FROM client WHERE id_client=$id";
 $statement=$db->prepare($query);
$statement->execute(array( $id));


 $_SESSION['message_delete']="Suppression effectuée avec succés";
 $_SESSION['msg_type_delete']="danger";
  header("location:../gs/vente.php");
}

?>