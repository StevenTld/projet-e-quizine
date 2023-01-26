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
                    <?php 
                    echo "<h1 style = 'text-align : center'>";
                    // affichage du code d'un match en particulier Start
                    if(isset($all_info_match)) {
                        echo(" CODE DU MATCH : <br> ");
                        foreach($all_info_match as $info){
                            if (!isset($traite[$info["mat_code"]])){
                                echo $info["mat_code"];
                            }
                            $traite[$info["mat_code"]]=1;
                        }
                        
                        
                    }
                    else {echo "problème <br />";
                        
                    }
                    echo "</h1>";
                ?>
            <div class="most-popular">
                
                <div class="row">
                    
                    <br />
                    <p>
                    <?php
                        echo "<h1 style = 'text-align : center'>";
                        // affichage du code d'un match en particulier Start
                        if(isset($all_info_match)) {
                            
                            foreach($all_info_match as $info){
                                if (!isset($traite[$info["mat_nom"]])){
                                    echo $info["mat_nom"];
                                }
                                $traite[$info["mat_nom"]]=1;
                            }
                            
                            
                        }
                        else {echo "problème <br />";
                            
                        }
                        echo "</h1>";
                        //affichage du code d'un match en particulier End

                        
                        //affichage des questions reponses d'un match en particulier Start
                        // Boucle de parcours de toutes les lignes du résultat obtenu
                        foreach($all_info_match as $mat){
                            echo "<p style = 'color : white'>";
                            // Affichage d’une ligne de tableau 
                            if (!isset($traite[$mat["que_intitule"]])){
                                $cpt_id=$mat["que_intitule"];
                                echo "<img src= '".$this->config->base_url()."style/front_end/assets/images/barre_separation_question.PNG' alt = ''>";
                                echo $mat["que_intitule"];
                                
                                // Boucle d’affichage des all_info_match lié à un match
                                foreach($all_info_match as $match){
                                    //echo "<ul>";
                                    if(strcmp($cpt_id,$match["que_intitule"])==0){
                                        echo "<br>";
                                        echo " -- ";
                                        echo $match["rep_intitule"];
                                    }
                                        //echo "</ul>";
                                    }
                                        
                                        // Conservation du traitement du pseudo
                                        // (dans un tableau associatif dans cet exemple !)
                                        echo "<br>";
                                        $traite[$mat["que_intitule"]]=1;
                                        
                                }
                            }
                            //affichage des questions reponses d'un match en particulier END
                            
                            //affichage du formulaire/boutton "terminer match" START
                            if(isset($all_info_match)) {
                                foreach($all_info_match as $info){
                                    if (!isset($traite2[$info["mat_code"]])){
                                        if($this->db_model->get_match_date_fin_null($info["mat_code"])){
                                            echo form_open('match/terminer');
                                                echo "<input type='hidden' name='mat_code_terminer' value = '".$mat["mat_code"]."' />";
                                                echo "<input type='submit' name='submit' value='Terminer le match' class='btn btn-secondary button_match2'/>";
                                                
                                            echo "</form>";
                                        }else{
                                            echo "<p style ='color:#e75e8d; text-align : center;font-size:20px;'>Le match est terminé<br>";
                                            echo "Score global : ".$info["mat_score"]."</p>";
                                            
                                        }
                                            
                                        
                                    }
                                    $traite2[$info["mat_code"]]=1;
                                }
                            }
                            //affichage du formulaire/boutton "terminer match" END
                                
                                
                            
                            
                         
                    ?></p>

                    
                </div>
            </div>
        </div>
    </div>

             
          <!-- ***** Corps de la page End ***** -->
