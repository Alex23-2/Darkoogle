<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Darkoogle</title>
	<meta charset="utf-8">
</head>
<body>
    <?php 
    include("connexion_logiciel.php");
    /*
    if(isset($_POST['id'])){

        $requete="SELECT popularite FROM moteur_recherche WHERE id=".$_POST['id'];
        $reponse=$mysqli->query($requete);
        if($reponse!=NULL){
            $donnees = $reponse->fetch_assoc();
            $new_pop = $donnees['popularite'] + 1;
        }

        $requete="UPDATE site SET pop=".$new_pop." WHERE id=".$_POST['id'];

        if ($mysqli->query($requete) === TRUE) {
            echo "ok";
        } else {
            echo "erreur";
        }

        $mysqli->close();
    }
    */
    if(isset($_GET['id']) && isset($_GET['url'])){
        $requete="SELECT popularite FROM moteur_recherche WHERE id=".$_GET['id'];
        $reponse=$mysqli->query($requete);
        if($reponse!=NULL){
            $donnees = $reponse->fetch_assoc();
            $new_pop = $donnees['popularite'] + 1;
        }

        echo "popularite =".$donnees['popularite'];
        echo "<br/>new popularite =".$new_pop;

        $requete="UPDATE site SET pop=".$new_pop." WHERE id=".$_GET['id'];

        if ($mysqli->query($requete) === TRUE) {
            header('Location: http://'.$_GET['url'].'');
        } else {
            header('Location: http://'.$_GET['url'].'');
            // Pourrait indiquer une erreur par mail ? dans un journal d'erreurs ?
        }

        $mysqli->close();
    }
    
    ?>

</body>