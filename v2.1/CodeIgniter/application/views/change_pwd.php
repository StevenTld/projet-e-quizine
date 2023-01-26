



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

                           
                           
                           <!-- ***** CHANGEMENT DE MOT DE PASSE Start ***** -->
                        <div class="row" style = "color:white;">
                            
                            <?php
                            echo '<h3>Modifiez vos données :</h3>';

                            echo validation_errors();
                            echo form_open('compte/change_password');
                            echo form_label('Mot de passe actuel',);
                            echo "<br>";
                              $champ1=array('name'=>'old_pwd', 'required'=>'required','type' => 'password');
                              echo form_input($champ1);
                              echo "<br>";
                            echo form_label('Nouveau mot de passe',);
                              echo "<br>";
                              $champ2=array('name'=>'new_pwd', 'required'=>'required','type' => 'password');
                              echo form_input($champ2);
                              echo "<br>";
                            echo form_label('Confirmation du nouveau mot de passe',);
                            echo "<br>";
                              $champ3=array('name'=>'conf_new_pwd', 'required'=>'required','type' => 'password');
                              echo form_input($champ3);
                              echo "<br>";

                            echo "<input style ='margin-top : 15px' type='submit' name='submit' value='Valider' />";
                            
                            
                        ?>
                        </form>
                          <a href ="https://obiwan.univ-brest.fr/difal3/ztalboust/dev/v2/CodeIgniter/index.php/compte/modifier_profil">
                           <input type="button" value="Annuler" class="input" id="btnHome" />
                          </a>
                        
                        
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