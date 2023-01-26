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
            <div class="most-popular" style = "color : white">
                
                <div class="row">
                    
                    <br />
                    <p>
                    <?php
                        echo "<h1 style = 'text-align : center'>";
                        // affichage du code d'un match en particulier Start
                        if(isset($all_info_match)) {
                            
                            foreach($all_info_match as $info){
                                if (!isset($traite[$info["qui_nom"]])){
                                    echo $info["qui_nom"];
                                }
                                $traite[$info["qui_nom"]]=1;
                            }
                            
                            
                        }
                        else {echo "problème <br />";
                            
                        }
                        echo "</h1>";
                        //affichage du code d'un match en particulier End

                        
                
                        //affichage des questions reponses d'un match en particulier Start

                        echo form_open('joueur/reponses_joueur');
                                                        
                                                          
                        
                   
                    
                        
                        // Boucle de parcours de toutes les lignes du résultat obtenu
                        foreach($all_info_match as $mat){
                            echo "<div style = 'color : white; margin-bottom :10px;'>";
                            // Affichage d’une ligne de tableau pour un pseudo non encore traité
                            if (!isset($traite[$mat["que_intitule"]])){
                                $cpt_id=$mat["que_intitule"];
                                echo "<img src= '".base_url()."style/front_end/assets/images/barre_separation_question.PNG' alt = ''>";
                                echo $mat["que_intitule"];
                                
                                // Boucle d’affichage des all_info_matchalités liées au pseudo
                                echo "<fieldset id='".$mat['que_id']."'>";
                                foreach($all_info_match as $match){
                                    //echo "<ul>";
                                    if(strcmp($cpt_id,$match["que_intitule"])==0 ){
                                        echo '<div class ="radio-item" style = "margin-bottom :3px;"">';
                                        echo "<br>";
                                        echo " -- ";
                                        echo $match['rep_intitule'];
                                        echo "<input type='radio' name='".$match['que_id']."' value=".$match['rep_id'].">";
                                        
                                        echo "</div>";
                                    }
                                        //echo "</ul>";
                                }   
                                
                                echo "</fieldset>";
                                        
                                    
                                        // Conservation du traitement du pseudo
                                        // (dans un tableau associatif dans cet exemple !)                                       
                                        $traite[$mat["que_intitule"]]=1;
                                        
                                }
                               
                                echo "</div>";
                                
                        }
                            echo validation_errors();
                            echo "<input type='hidden' name='mat_code' value='".$mat["mat_code"]."' />";
                            echo "<input type='hidden' name='joueur_pseudo' value='".$this->input->post('jou_pseudo')."' />";
                            echo "<input type='submit' name='submit' value='Soumettre vos réponses' class='btn btn-secondary button_match1'/>";
                            echo "</form>";
                            //affichage des questions reponses d'un match en particulier END
                            

                        
                    ?>
                    
                    </p>

                </div>
            </div>
        </div>
    </div>

             
          <!-- ***** Corps de la page End ***** -->
