<div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="page-content">
            <div class="page-content-create-match">
                <br />
                <h2>Gestion des matchs :
                    
                </h2>
                    <?php
                            
                            echo form_open('match/creer_match');
                            echo "<br>";
                            echo "<div style = 'color : white'>";
                            echo form_label('Quel quiz voulez vous lancer ?',);
                              echo "<br>"; 
                            echo "</div>";
                            echo '<select name="qui_id">';
                                echo '<option disabled selected value="">Nom du quiz</option>';
                            
                                if($all_quiz != NULL) {
                                    
                                    foreach($all_quiz as $quiz){
                                        if($this->db_model->get_if_quiz_has_question($quiz["qui_id"])==TRUE){
                                            echo '<option value="'.$quiz["qui_id"].'">'.$quiz['qui_nom'].'</option>';
                                        }else{
                                            echo '<option style = "color : red" disabled value="'.$quiz["qui_id"].'">'.$quiz['qui_nom'].' : quiz sans question</option>';
                                        }
                                    }
                                }   
                            echo '</select>';
                            echo "<input type='text' name='name_match' placeholder ='Nom du match' required>";
                            echo '<select name="mat_visualisation">';
                                echo '<option disabled selected value="">Visualisation du corrigé</option>';
                                echo '<option value="A">Activer</option>';
                                echo '<option value="D">Désactiver</option>';
                            echo '</select>';
                            echo "<input type='datetime-local' min='2018-06-07T00:00' name='start_match' required>";
                            echo "<label style ='color :white'>Utilisez les flèches du clavier</label>";
                            echo "<br> <br>";
                            echo validation_errors();
                            echo "<input type='submit' name='submit' value='Créer Match' /> ";
                            
                            
                        ?>
                        </form>
                <div>
            </div>
        </div>
    </div>
</div>