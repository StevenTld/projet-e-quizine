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
                            echo "<p style = 'color : white; margin-top:15px;'>";
                            // Affichage d’une ligne de tableau 
                            if (!isset($traite[$mat["que_intitule"]])){
                                $cpt_id=$mat["que_intitule"];
                                
                                echo $mat["que_intitule"];
                                
                                // Boucle d’affichage des all_info_match lié à un match
                                foreach($all_info_match as $match){
                                    //echo "<ul>";
                                    if(strcmp($cpt_id,$match["que_intitule"])==0){
                                        if($this->db_model->get_answer($match["rep_id"])){
                                            echo "<div style = 'color:green'>";
                                            echo "<br>";
                                            echo " -- ";
                                            echo $match["rep_intitule"];
                                            echo "</div>";
                                        }else{
                                            echo "<div style = 'color:red'>";
                                            echo "<br>";
                                            echo " -- ";
                                            echo $match["rep_intitule"];
                                            echo "</div>";
                                        }
                                        
                                    }
                                        //echo "</ul>";
                                    }
                                        
                                        // Conservation du traitement du pseudo
                                        // (dans un tableau associatif dans cet exemple !)
                                        echo "<br>";
                                        $traite[$mat["que_intitule"]]=1;
                                        
                                }
                            }
                            //affichage des questions reponses d'un match en particulier Start

                        
                    ?></p>
                </div>
            </div>
        </div>
    </div>

             
          <!-- ***** Corps de la page End ***** -->
