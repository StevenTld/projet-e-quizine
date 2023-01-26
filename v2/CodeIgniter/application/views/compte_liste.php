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
                        if($info_compte != NULL) {
                            echo "<table class='table table-striped table-dark  table-hover'  >";
                                echo "<thead>";
                                    echo "<tr>";
                                    echo"<th >Nom</th>";
                                    echo"<th >Prénom</th>";
                                    echo "<th >Pseudo</th>";
                                    echo"<th >Mail</th>";
                                   
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                
                                foreach($info_compte as $info){
                                    echo "<tr>";
                                    echo "<td>";
                                        echo $info["pfl_nom"];
                                
                                    echo "<td>";
                                        echo $info["pfl_prenom"]; 

                                    echo "<td>";
                                        echo $info["usr_pseudo"];
                                        
                                    echo "<td>";
                                        if( $info["pfl_mail"]==NULL){
                                            echo"Vous n'avez pas renseigné de mail";
                                        }else{
                                            echo $info["pfl_mail"]; 
                                        } 

                                } echo "<tr/>";
                            }
                        
                            else {
                            echo "Aucun compte pour le moment !";
                        }
                        // END Affiche de la liste des comptes présent dans la base de données
                    ?>
                </tbody>
            </table>
                        
                    </p>
                </div>
            </div>
        </div>
    </div>

             
          <!-- ***** Corps de la page End ***** -->
