<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Darkoogle</title>
	<meta charset="utf-8">
      <!--Import bootstrap.css-->
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      <!-- Ancien script "OnClick()"
      <script>
            $(function() {
                  $('a').click(function(){
                        var identifiant = $(this).attr('id');
                        $.post('popularite.php',{ id : identifiant}, function(data) {
                        }); 
                  });
            });
      </script>
      -->
</head>
<body>
      <section id="cover" class="min-vh-100">
            <div id="cover-caption">
                  <div class="container">
                        <div class="row">
                        <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto text-center form p-4">
                              <h1 class="display-4 py-2 text-truncate"><a class="text-dark" href="index.php">Darkoogle</a></h1>
                              <div class="px-2">
                                    <form action="" class="justify-content-center">
                                    <div class="form-group">
                                          <input type="text" class="form-control" placeholder='<?php if(!isset($_GET['search'])) echo "Votre recherche sur le Darkweb";?>' name="search" value="<?php if(isset($_GET['search'])) echo $_GET['search'];?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-2">Rechercher</button>
                                    </form>
                              </div>
                        </div>     
                  </div>
                        <?php if(isset($_GET['search']) && !is_null($_GET['search'])){
                              include("connexion.php");
                              echo "Résultat de la recherche pour ".$_GET['search']." :<br/>";
                              $recherche = $_GET['search']."%";
                              $res = array();
                              // On recherche d'abord dans les titres de page
                              $requete="SELECT * FROM moteur_recherche WHERE titre LIKE '$recherche'";
                              $reponse=$mysqli->query($requete);
                              if($reponse!=NULL){
                                    while($donnees = $reponse->fetch_assoc()){
                                          // ajout des résultats de la recherche au tableau
                                          $res[] = array ("id" => $donnees['id'], "date" => $donnees['date'], "url" => $donnees['url'], "titre" => $donnees['titre'], "mc" => $_GET['search'], "pop" =>$donnees['popularite']);
                                    }
                              }
                              for ($i=1; $i<6; $i++){ // boucle de recherche des mc
                                    $champ = "mc".$i;
                                    $requete="SELECT * FROM moteur_recherche WHERE $champ LIKE '$recherche'";
                                    $reponse=$mysqli->query($requete);
                                    if($reponse!=NULL){
                                          while($donnees = $reponse->fetch_assoc()){
                                                // ajout des résultats de la recherche au tableau
                                                $res[] = array ("id" => $donnees['id'], "date" => $donnees['date'], "url" => $donnees['url'], "titre" => $donnees['titre'], "mc" => $donnees[$champ], "pop" =>$donnees['popularite']);
                                          }
                                    }
                              }
                              $taille = count($res);
                              // tri du tableau par popularité :
                              $popularite  = array_column($res, 'pop');
                              array_multisort($popularite, SORT_DESC, $res);
                              if($taille > 0)
                              { 
                                    $nb_res_max = 5;
                                    $nb_page = $taille / $nb_res_max;
                                    $deb = 0;
                                    if($taille < $nb_res_max)
                                          $fin = $taille;
                                    else{
                                          if(isset($_GET['page'])){
                                                $deb = ($_GET['page'] - 1)*$nb_res_max + 1;
                                                $fin = $deb+$nb_res_max;
                                          }
                                          else {
                                                //Si on est sur la première page
                                                $fin = $nb_res_max;
                                          }
                                    }
                                    // affichage du tableau
                                    echo '<table class="table table-hover"><tbody>';
                                    while($deb < $fin){
                                          $date = new DateTime($res[$deb]['date']);
                                          echo "<tr><td><a class='text-dark' id='".$res[$deb]['id']."' href='popularite.php/?id=".$res[$deb]['id']."&url=".$res[$deb]['url']."'>".$res[$deb]['url']."</a></td><td>".$res[$deb]['titre']."</td><td>actif le : ".$date->format('d/m/Y')."</td><td><i>Mot clé : ".$res[$deb]['mc']."</i></td></tr>";
                                          $deb++;
                                    }
                                    echo "</tbody></table>";
                                    // affichage des numéros de pages
                                    echo '<nav aria-label="pages"><ul class="pagination justify-content-end">';
                                    if(isset($_GET['page']) && $_GET['page']!=0){
                                          $prec = $_GET['page']-1;
                                          $suiv = $_GET['page']+1;
                                          echo '<li class="page-item"><a class="page-link" href="?search='.$_GET['search'].'&page='.$prec.'">Précédente</a></li>';
                                          echo liste_pages($nb_page, $_GET['page'], $_GET['search']);
                                          if ($suiv>=$nb_page)//dernière page
                                                echo '<li class="page-item disabled"><a class="page-link" href="#">Suivante</a></li>';
                                          else
                                                echo '<li class="page-item"><a class="page-link" href="?search='.$_GET['search'].'&page='.$suiv.'">Suivante</a></li>';
                                    }else{ // première page
                                          echo '<li class="page-item disabled">
                                          <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Précédente</a>
                                          </li>';
                                          echo liste_pages($nb_page, 0, $_GET['search']);
                                          if($nb_page>1)
                                                echo '<li class="page-item"><a class="page-link" href="?search='.$_GET['search'].'&page=1">Suivante</a></li>';
                                          else
                                                echo '<li class="page-item disabled"><a class="page-link" href="#">Suivante</a></li>';
                                    }
                                    echo '</ul></nav>';
                              }
                        }
                        ?>
                  </div>
            </div>
      </section>
</body>
</html>
<?php
      function liste_pages($nb, $active, $recherche){
            $res = '';
            for($i = 0; $i < $nb; $i++){
                  if($i == $active)
                        $res.='<li class="page-item active"><a class="page-link" href="?search='.$recherche.'&page='.$i.'">'.$i.'</a></li>';
                  else
                        $res.='<li class="page-item"><a class="page-link" href="?search='.$recherche.'&page='.$i.'">'.$i.'</a></li>';
            }
            return $res;
      }
?>
