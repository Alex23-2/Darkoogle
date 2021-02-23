<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Darkoogle - Résultats exploitation</title>
	<meta charset="utf-8">
      <!--Import bootstrap.css-->
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
    <?php 
        include("connexion.php");

        $sites = array();
        $nbSites = 100;

        $Adult = 0;
        $Money = 0;
        $Market = 0;
        $Virus = 0;
        $Drug = 0;
        $Crime = 0;
        $Other = 0;

        // Choix des sites à analyser (uniquement les sites sans erreur)
        for($i=0; $i<$nbSites; $i++){
            $requete="SELECT id, cat FROM sites_analyses ORDER BY RAND() LIMIT 1";
            $reponse=$mysqli->query($requete);
            if($reponse!=NULL){
                $donnees = $reponse->fetch_assoc();
                $sites[] = array('id' => $donnees['id'], 'cat' => $donnees['cat']);
                switch ($donnees['cat']) {
                    case "Adult":
                        $Adult = $Adult + 1;
                        break;
                    case "Money":
                        $Money = $Money + 1;
                        break;
                    case "Market":
                        $Market = $Market + 1;
                        break;
                    case "Virus":
                        $Virus = $Virus + 1;
                        break;
                    case "Drug":
                        $Drug = $Drug + 1;
                        break;
                    case "Crime":
                        $Crime = $Crime + 1;
                        break;
                    case "Other":
                        $Other = $Other + 1;
                        break;

                }
            }
        }

        // affichage du tableau
        echo '<table class="table table-hover"><tbody>';
        foreach ($sites as $s){
            echo "<tr><td>".$s['id']."</td><td>".$s['cat']."</td></tr>";
        } 
        echo "</tbody></table>";

        echo '<table class="table table-hover"><tbody>';
        echo "<tr><td>Adult</td><td>".$Adult."</td></tr>";
        echo "<tr><td>Drug</td><td>".$Drug."</td></tr>";
        echo "<tr><td>Virus</td><td>".$Virus."</td></tr>";
        echo "<tr><td>Crime</td><td>".$Crime."</td></tr>";
        echo "<tr><td>Market</td><td>".$Market."</td></tr>";
        echo "<tr><td>Money</td><td>".$Money."</td></tr>";
        echo "<tr><td>Other</td><td>".$Other."</td></tr>";
        echo "</tbody></table>";

    ?>
</body>