<?php 
include('../include/database.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
	
}
include_once('cookieconnect.php');
if(isset($_POST['login'])){
$emailconnect=$_POST['emailconnect'];
$mdpconnect=md5($_POST['mdpconnect']);
if(!empty($emailconnect)AND !empty($mdpconnect)){
$requser=$db->prepare("SELECT * FROM utilisateur INNER JOIN centre ON centre.id_centre=utilisateur.id_centre  WHERE login='".$emailconnect."' AND password='".$mdpconnect."'");
$requser->execute();
$userexist=$requser->rowCount();
if($userexist==1){
if(isset($_POST['rememberme'])){
setcookie('email',$emailconnect,time()+365*24*3600,null,null,false,true);
setcookie('password',$mdpconnect,time()+365*24*3600,null,null,false,true);
}
$userinfo=$requser->fetch();
$_SESSION['id_utilisateur']= $userinfo['id_utilisateur'];
$_SESSION['nom']= $userinfo['nom'];
$_SESSION['profil']= $userinfo['profil'];
$_SESSION['id_centre']= $userinfo['id_centre'];
header("Location:../pages/dashboard.php");
exit;
}else {

echo 'Mauvais identifiant';
 $_SESSION['message_delete']="Identifiants incorrects";
 $_SESSION['msg_type_delete']="danger";
header("Location:../login.php");
exit;
}
}
}

?>