<?php/* 
    Projet : Bloc-kuiz
    Creator : STEVEN TALBOURDET 
    Description : Ce fichier contient la gestion des matchs par le formateur
    V2.0
*/?>



<div class="container"  >
    <div class="row">
      <div class="col-lg-12">
        <div class="page-content"  >
        
                <br />
                <h2>Gestion des matchs :
                    
                </h2>
          <!-- ***** corps de la page Start ***** -->
            <div class="most-popular">
                <div class="row">
                    <div class="most-popular">
                        <div class="row" style = "color:white; margin-top : -80px;">
                        
                          <a href ="<?php $this->config->base_url();?>creer_match">
                           <input type="button" value="+ Créer Match" class="btn btn-outline-warning" id="btnCreerMatch" />
                          </a>
                        
                        
                        </div>
                           

                            <!-- ***** afficher Match Start ***** -->
                                    <p>
                                    <br>
                                    <h3>Tous les matchs :<br> <br> </h3>
                                    <div style="overflow-x:auto; overflow-y:auto; height: 1000px;">
                                    <?php
                                        if($all_match_formateur != NULL) {
                                        echo "<table class='table table-striped table-dark  table-hover'  >";
                                            echo "<thead>";
                                                echo "<tr>";
                                                echo"<th >Auteur Match</th>";
                                                echo"<th >Nom Match</th>";
                                                echo "<th >Date Début</th>";
                                                echo"<th >Date Fin</th>";
                                                
                                                echo "<th >Match Actif</th>";
                                                echo "<th >Match Visualisation</th>";
                                                echo "<th >Match Code</th>";
                                                
                                                echo"<th >Auteur Quiz</th>";
                                                echo "<th >Nom du quiz</th>";
                                                echo "<th >Score Moyen</th>";
                                                echo "<th ></th>";
                                                echo "</tr>";
                                            echo "</thead>";
                                            echo "<tbody>";
                                            foreach($all_match_formateur as $mat){
                                                
                                                    echo "<td>";
                                                        echo $mat["auteur_match"];
                                                    
                                                    echo "<td>";
                                                        echo $mat["mat_nom"];
                                                    
                                                    echo "<td>";
                                                        if( $mat["mat_date_debut"]==NULL){
                                                            echo"Ce match n'a pas débuté";
                                                        }else{
                                                            echo $mat["mat_date_debut"]; 
                                                        } 

                                                    echo "<td >";
                                                        if( $mat["mat_date_fin"]==NULL){
                                                            echo"Ce match n'est pas fini";
                                                        }else{
                                                            echo "<div style = 'color : #e75e8d'>";
                                                                echo $mat["mat_date_fin"]; 
                                                            echo "</div>";
                                                        } 
                                                        
                                                    
                                                    echo "<td>";
                                                        echo $mat["mat_actif"];
                                                
                                                    
                                                    echo "<td>".$mat['mat_visualisation']."</td>";

                                                    echo "<td><div style='background :white;' id='".$mat["mat_code"]."'>".$mat["mat_code"]."</div></td>";
                                                    

                                                   
                                                    echo "<td>".$mat["auteur_quiz"]."</td>";
                                                    echo "<td>".$mat["qui_nom"]."</td>";

                                                    echo "<td>";
                                                        if( $mat["mat_score"]==NULL && $mat["mat_date_fin"]==NULL ){
                                                            echo"Ce match n'est pas encore fini";
                                                        }else if($mat["mat_score"]==NULL && $mat["mat_date_fin"]!=NULL){
                                                            echo "Aucun joueur n'a participé au match";
                                                        }
                                                        else{
                                                            echo $mat["mat_score"]; 
                                                        }
                                                        
                                                    
                                                


                                                    echo "<td class = 'text-center '>";
                                                    echo form_open("match/code_afficher/".$mat["mat_code"]."");
                                                        if($mat["mat_actif"]=='A'){
                                                            echo "<input type='hidden' name='mat_code' value = '".$mat["mat_code"]."' />";
                                                            echo "<input type='submit' name='submit' value='Lancez Match' class='btn btn-secondary button_match1'/>";
                                                        }else{
                                                            echo"Match désactivivé";
                                                        }
                                                        
                                                        echo validation_errors();
                                                    echo "</form>";
                                                    if($this->db_model->is_match_formateur($mat["mat_code"],$this->session->userdata('usr_id'))){

                                                            if($this->db_model->is_match_active($mat["mat_code"])){
                                                                echo form_open('match/desactivate_match');
                                                                echo "<input type='hidden' name='mat_code_des' value = '".$mat["mat_code"]."' />";
                                                                echo "<input type='submit' name='submit' value='Désactiver' class='btn btn-secondary bg-failure button_match2'/>";
                                                                echo validation_errors();
                                                                echo "</form>";
                                                            }else{
                                                                echo form_open('match/activate_match');
                                                                echo "<input type='hidden' name='mat_code_act' value = '".$mat["mat_code"]."' />";
                                                                echo "<input type='submit' name='submit' value='Activer' class='btn btn-secondary bg-success button_match1'/>";
                                                                echo validation_errors();
                                                                echo "</form>";
                                                            }
                                                            echo form_open('match/delete_match');
                                                                echo "<input type='hidden' name='mat_code_del' value = '".$mat["mat_code"]."' />";
                                                                echo "<input type='submit' name='submit' value='Supprimer' class='btn btn-secondary bg-failure button_match2'/>";
                                                                echo validation_errors();
                                                            echo "</form>";
                                                            
                                                            

                                                            echo form_open('match/raz_match');
                                                                echo "<input type='hidden' name='mat_code_raz' value = '".$mat["mat_code"]."' />";
                                                                echo "<input type='submit' name='submit' value='RAZ' class='btn btn-secondary button_match3'/>";
                                                                echo validation_errors();
                                                            echo "</form>";
                                                    }
                                                    
                                                    
                                                    echo "<tr/>";
                                            }
                                        }
                                            else {
                                            echo "Aucun match pour le moment !";
                                        }
                                    ?>
                                </tbody>
                            </table>
                            </div>    
                            
                                        <?php 
                                            $testArray = array();
                                            foreach($all_match_formateur as $matc){
                                            
                                                array_push($testArray, $matc["mat_code"]) ;
                                                
                                               
                                            }
                                            
                                        ?>
                                        
                                        <script>
                                        
                                        var testArrayJs = <?php echo json_encode($testArray) ?>
                                        
                                        testArrayJs.forEach(function(code){
                                            var button = document.getElementById(code);
                                            button.onclick = function() {
                                                var div = document.getElementById(code);
                                                if (div.style.background !== 'white') {
                                                    div.style.background= 'white';
                                                    
                                                }
                                                else {
                                                    div.style.background= '';
                                                }
                                            
                                            };
                                        }
                                        );

                                        
                                        </script>
                                    </p>
                            </div>
                            <!-- ***** Afficher Match End ***** -->
                        </div>
                    </div>
                </div>
            </div>
          
          <!-- ***** Corps de la page End ***** -->

          
        </div>
      </div>
    </div>
  </div>

  
