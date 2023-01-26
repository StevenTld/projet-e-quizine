
<!--Projet : Bloc-kuiz
    Creator : STEVEN TALBOURDET 
    Description : Ce fichier contient la page avec le formulaire de nouveau joueur
    V1.0
-->
<div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="page-content">

          <!-- ***** Banner Start ***** -->
          <div class="main-banner">
            <div class="row">
              <div >
                <div class="header-text">
                  <h6>Bloc-kuiz</h6>
                
                  <h4><em>Disclaimer : </em> <br>ce match pourrait<br>T'INSTRUIRE</h4>
                  
                    <div class="tm-main-content tm-gallery-container">
                        <div class=" new_joueur">
                            <p>
                                <h5>Vous allez entrez dans le match : <?php  if(validation_errors()==FALSE){echo $code_match->mat_code;}?></h5>
                                <?php
                                  // START formulaire de création de joueur
                                    
                                    echo"<div class = 'test_new_joueur'>";
                                        if(validation_errors()==FALSE){
                                        $match_code=array('id'=>$code_match->mat_code);
                                        echo form_open('new_player' ,'', $match_code);

                                        echo "<h6 style='margin-top :2%'>";
                                        echo form_label('Veuillez choisir un pseudo :');
                                        echo "</h6>";
                                        echo "<div class='test2_new_joueur'>";
                                            $champ1=array('name'=>'jou_pseudo', 'required'=>'required','class'=>'input_style_new_joueur');
                                            echo form_input($champ1);
                                        echo "</div>";
                                    echo "</div>";
                                    echo "</p>";
                                        }
                                        else{
                                          
                                          echo"<div class = 'test_new_joueur'>";
                                        if(validation_errors()==TRUE){
                                                $match_code=array('id'=>$test);
                                                echo form_open('new_player' ,'', $match_code);
                                                
                                                echo "<h6 style='margin-top :2%'>";
                                                echo form_label('Veuillez choisir un pseudo :');
                                                echo "</h6>";
                                                echo "<div class='test2_new_joueur'>";
                                                $champ1=array('name'=>'jou_pseudo', 'required'=>'required','class'=>'input_style_new_joueur');
                                                echo form_input($champ1);
                                                echo validation_errors();
                                                echo "</div>";
                                              echo "</div>";
                                            echo "</div>";
                                            echo "</p>";
                                        }
                                      }
                                    // END formulaire de création de joueur
                                ?>
                            
                            
                            
                                
                                
                                </form>
                            </p>
                        </div>
                    </div>
                                             
                </div>
              </div>
            </div>
          </div>
          <!-- ***** Banner End ***** -->

          <!-- ***** Corps de la page Start ***** -->
          <div class="most-popular">
            <div class="row">
            <h3>Actualités</h3>
            <h5>Vous trouverez ici toutes les nouvelles actus en rapport avec Bloc-kuiz ! </h5>

            <!-- ***** AFFICHAGE DES ACTUALITES SUR LA PAGE D'ACCUEIL ***** -->
            <p>
            
                    <?php
                        if($all_actu != NULL) {
                          echo "<table class='table table-striped table-dark  table-hover'  >";
                              echo "<thead>";
                                echo "<tr>";
                                  echo "<th >Date</th>";
                                  echo"<th ></th>";
                                  echo "<th >Titre</th>";
                                  echo "<th ></th>";
                                  echo "<th >Contenu</th>";
                                  echo "<th ></th>";
                                  echo "<th >Auteur</th>";
                                  echo "<th ></th>";
                                echo "</tr>";
                              echo "</thead>";
                            echo "<tbody>";
                            foreach($all_actu as $info){
                              
                                echo "";
                                echo '<tr onclick="window.location=\'/index.php/actualite/afficher/'.$info["new_id"].'\'" style="cursor: pointer">';
                                
                                
                                  echo "<td>";
                                    
                                      echo $info["new_date"]; 
                                    
                                  echo "<td/>";
                                  
                                  echo "<td/>";
                                    
                                    echo $info["new_titre"] ;
                                    
                                  echo "<td/>";
                                  
                                  echo "<td/>";
                                    echo $info["new_contenu"];
                                  echo "<td/>";

                                  echo "<td/>";
                                    echo $info["usr_pseudo"]; 
                                  echo "<td/>";

                                echo "<tr/>";
                            }
                        }
                            else {
                            echo "Aucune actu !";
                        }
                    ?>
                </tbody>
              </table>
                    </p>
            </div>
          </div>
          <!-- ***** Corps de la page End ***** -->

          
        </div>
      </div>
    </div>
  </div>