
<!--Projet : Bloc-kuiz
    Creator : STEVEN TALBOURDET 
    Description : Ce fichier contient la page d'affichage d'une actualite en particulier dont l'id peut etre passé en paramètre
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
                        // affichage d'une actualite en particulier Start
                        if(isset($actu)) {
                            echo $actu->new_id;
                            echo(" -- ");
                            echo $actu->new_contenu;
                        }
                        else {echo "<br />";
                            
                        }
                        //affichage d'une actualite en particulier End
                    ?></p>
                </div>
            </div>
        </div>
    </div>

             
          <!-- ***** Corps de la pageEnd ***** -->