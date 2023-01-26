



<div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="page-content">
        <h2> Informations de votre profil !
                </h2>
          <!-- ***** corps de la page Start ***** -->
            <div class="most-popular">
                <div class="row">
                    <div class="most-popular">

                           <!-- ***** INFOS DU PROFIL Start ***** -->

                          <div class="row" style = "color:white;">
                              <br><h3>Infos de votre profil :</h3></br>
                              <?php
                              if($info_profil != NULL) {
                                echo "<table class='table table-striped table-dark  table-hover'  >";
                                    echo "<thead>";
                                        echo "<tr>";
                                        echo "<th >Nom</th>";
                                        echo"<th >Prénom</th>";
                                        echo "<th >Mail</th>";
                                        echo "<th >Pseudo</th>";
                                        echo "<th >Role</th>";
                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    
                                            echo "<td>";
                                                echo $info_profil->pfl_nom;
                                            
                                            echo "<td>";
                                                echo $info_profil->pfl_prenom;

                                            echo "<td>";
                                                if( $info_profil->pfl_mail==NULL){
                                                    echo"Vous n'avez pas renseigné de mail";
                                                }else{
                                                    echo $info_profil->pfl_mail; 
                                                } 
                                            
                                            echo "<td>";
                                                echo $info_profil->usr_pseudo; 
                                            
                                            echo "<td>";
                                                if($info_profil->usr_role=='F'){
                                                  echo "Formateur";
                                                }else{echo "Administrateur";}
                                            
                                            echo "<tr/>";
                                    
                                }
                                    else {
                                    echo "Aucune info pour le moment !";
                                }
                            ?>
                          </tbody>
                          </table>
                        </div>
                           <!-- ***** INFOS DU PROFIL End ***** -->
                           
                           <!-- ***** CHANGEMENT DE MOT DE PASSE Start ***** -->
                        <div class="row" >
                            
                            <?php
                            echo '<h3>Modifiez vos données :</h3>';

                            echo '<a  href = "'.$this->config->base_url().'index.php/compte/change_password">> Changez de mot de passe';
                            echo '<h6 style = "color : grey; font-weight : normal; font-size : 15px">Le changement de mot de passe vous déconnectera de toutes vos sessions</h6></a>';
                            
                        ?>
                        </form>
                        </div>
                           <!-- ***** CHANGEMENT MOT DE PASSE End ***** -->

                        
                    </div>
                </div>
            </div>
          
          <!-- ***** Corps de la page End ***** -->

          
        </div>
      </div>
    </div>
  </div>