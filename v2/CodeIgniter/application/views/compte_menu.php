



<div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="page-content">
        <h2><?php 
                if ($this->session->userdata('role') == 'F'){
                    echo "Bienvenue sur l'espace Formateur";
                }else{
                    echo "Bienvenue sur l'espace Administrateur";
                }
                ?>
                </h2>
                <br />
                <h2>Session ouverte ! Bienvenue
                    <?php
                        echo $this->session->userdata('username');
                                    
                    ?> !
                </h2>
          <!-- ***** corps de la page Start ***** -->
            <div class="most-popular">
                <div class="row">
                    <div class="most-popular">
                      <div class="image_admin">
                      
                  <h4><em>BLOC-KUIZ</em> <br>QUAND L'INDIVIDU  <br>SERT AU COLLECTIF !</h4>
                        <h2> </h2>
                      </div>
                     
                        
                    </div>
                </div>
            </div>
          
          <!-- ***** Corps de la page End ***** -->

          
        </div>
      </div>
    </div>
  </div>