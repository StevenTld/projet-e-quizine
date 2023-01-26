<!--Projet : Bloc-kuiz
    Creator : STEVEN TALBOURDET 
    Description : Ce fichier contient la page d'accueil si le code du match rentré est invalide
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
                  <h6>Bienvenue sur Bloc-kuiz</h6>
                  <h4><em>Apprendre l'avenir</em> <br>avec nos quiz sur <br>la Blockchain</h4>
                  
                    <div class="tm-main-content tm-gallery-container">
                      <p>
                        <?php
                            // START formulaire de recherche de match
                            
                            echo form_open('match_exister',array('class' => 'test'   ));
                            echo "<h5 style = 'margin-bottom :-10px'>";
                            echo form_label('Entrez le code d\'un match :',);
                            echo "</h5>";
                            echo "<br>";
                            echo "<div class='test2'>";
                              echo "<input type='submit' name='submit' value='' class='input_button' />";
                              $champ1=array('name'=>'code_match', 'required'=>'required','class'=>'input_style', 'maxlength' => '8','minlength' => '8');
                              echo form_input($champ1);
                            // END formulaire de recherche de match
                           
                        ?>
                        
                        
                          
                              
                            </div>
                            
                            <p style =" color : #ef1834;margin-top:7px">Aucun Match associé à ce code !</p>
                            <?php echo validation_errors();?>
                        </form>
                      </p>
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