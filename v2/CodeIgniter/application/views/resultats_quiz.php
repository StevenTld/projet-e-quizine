
<!--Projet : Bloc-kuiz
    Creator : STEVEN TALBOURDET 
    Description : Ce fichier contient la page qui affiche le score d'un joueur et potentiellement les bonnes réponses d'un quiz
    V1.0
-->
<div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="page-content">

          

          <!-- ***** Corps de la page Start ***** -->
          <div class="most-popular" style = "color : white">
            <div class="row">
                <h2> Vous avez eu 
                    <?php echo $score_joueur->SCORE;?>% de bonnes réponses !
                </h2>
                <?php 
                    if($this->db_model->is_visualisable($code_match)==TRUE){
                        echo form_open('match/corriger');
                            echo "<input type='hidden' name='mat_code' value='".$code_match."' />";
                            echo "<input type='submit' name='submit' value='Voir le corrigé' class='btn btn-secondary button_match1'/>";
                        echo "</form>";
                    }

                
                
                ?>
            </div>
          </div>
          <!-- ***** Corps de la page End ***** -->

          
        </div>
      </div>
    </div>
  </div>