



<div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="page-content">
        
                <br />
                <h2>Gestion des matchs :
                    
                </h2>
          <!-- ***** corps de la page Start ***** -->
            <div class="most-popular">
                <div class="row">
                    <div class="most-popular">
                        <div class="row" style = "color:white;">
                            
                            <?php
                            echo '<h3>Creer un match</h3>';

                            echo validation_errors();
                            echo form_open('match/gestion');
                            echo form_label('Code du match :');
                            echo "<br>";
                            echo "<p style = 'text-transform: uppercase;'>";
                              $champ1=array('name'=>'code', 'required'=>'required','minlength' => '8','maxlength' => '8');
                              echo form_input($champ1);
                              echo "<br>";
                            echo "</p>";
                            echo form_label('Quel quiz voulez vous lancer ?',);
                              echo "<br>";
                              
                              
                              
                              
                            echo '<select name="qui_id">';
                                if($all_quiz != NULL) {
                                    foreach($all_quiz as $quiz){
                                        echo '<option value="'.$quiz["qui_id"].'">'.$quiz['qui_nom'].'</option>';
                                    }
                                }   
                            echo '</select>';
                               
                                    
                              
                        
                                
                                echo "<br> <br>";
                                

                            echo "<input type='submit' name='submit' value='Créer Match' />";
                            
                        ?>
                        </form>

                            <!-- ***** afficher Match Start ***** -->
                                    <p>
                                    <br>
                                    <h3>Tous vos matchs :<br> <br> </h3>
                                    
                                    <?php
                                        if($all_match_formateur != NULL) {
                                        echo "<table class='table table-striped table-dark  table-hover'  >";
                                            echo "<thead>";
                                                echo "<tr>";
                                                echo "<th >Date Début</th>";
                                                echo"<th >Date Fin</th>";
                                                echo "<th >Match Actif</th>";
                                                echo "<th >Match Visualisation</th>";
                                                echo "<th >Match Code</th>";
                                                echo "<th >Match ID</th>";
                                                echo "<th >Nom du quiz</th>";
                                                echo "<th ></th>";
                                                echo "</tr>";
                                            echo "</thead>";
                                            echo "<tbody>";
                                            foreach($all_match_formateur as $mat){
                                                
                                                    
                                                    
                                                    
                                                    echo "<td>";
                                                        if( $mat["mat_date_debut"]==NULL){
                                                            echo"Ce match n'a pas débuté";
                                                        }else{
                                                            echo $mat["mat_date_debut"]; 
                                                        } 

                                                    echo "<td>";
                                                        if( $mat["mat_date_fin"]==NULL){
                                                            echo"Ce match n'est pas fini";
                                                        }else{
                                                            echo $mat["mat_date_fin"]; 
                                                        } 
                                                        

                                                    echo "<td>";
                                                        echo $mat["mat_actif"];
                                                    
                                                    echo "<td>";
                                                        echo $mat["mat_visualisation"]; 
                                                    
                                                    echo "<td>";
                                                        echo $mat["mat_code"]; 
                                                    
                                                    echo "<td>";
                                                        echo $mat["mat_id"]; 
                                                    
                                                    echo "<td>";
                                                        echo $mat["qui_nom"]; 

                                                    echo "<td>";
                                                    echo form_open('match/code_afficher');
                                                        echo "<input type='hidden' name='mat_code' value = '".$mat["mat_code"]."' />";
                                                        echo "<input type='submit' name='submit' value='Lancez Match' />";
                                                        echo validation_errors();
                                                    echo "</form>";
                                                    echo "<tr/>";
                                            }
                                        }
                                            else {
                                            echo "Aucun match pour le moment !";
                                        }
                                    ?>
                                </tbody>
                            </table>
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