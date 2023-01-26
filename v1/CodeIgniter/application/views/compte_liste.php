<!--Projet : Bloc-kuiz
    Creator : STEVEN TALBOURDET 
    Description : Ce fichier contient la page des comptes listés
    V1.0
-->

<!-- ***** Corps de la page Start ***** -->
<div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="page-content">
            <div class="most-popular">
                <div class="row">
                    <h1><?php echo $titre;?></h1>
                    <br />
                    <p>
                    <?php
                        // START Affiche de la liste des comptes présent dans la base de données
                        if(isset($nb)) {
                            echo $nb->nb_compte;
                            echo "<br />";
                        }
                        else {echo "<br />";}
                        if($pseudos != NULL) {
                            foreach($pseudos as $login){
                                echo "<br />";
                                echo " -- ";
                                echo $login["usr_pseudo"];
                                echo " -- ";
                                echo "<br />";
                            }
                        }
                            else {echo "<br />";
                            echo "Aucun compte !";
                        }
                        // END Affiche de la liste des comptes présent dans la base de données
                    ?></p>
                </div>
            </div>
        </div>
    </div>

             
          <!-- ***** Corps de la page End ***** -->
