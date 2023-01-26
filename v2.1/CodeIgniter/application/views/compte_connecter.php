





<div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="page-content">

          <!-- ***** Banner Start ***** -->
          <div class="main-banner">
            <div class="row">
              <div >
                <div class="header-text">
                  <h6>Bienvenue sur Bloc-kuiz</h6>
                  <h4><em>Apprendre l'avenir</em> <br>avec nos quiz sur <br>la Blockchain</h4>
                  
                    <div class="tm-main-content tm-gallery-container">
                      <p>
                        <div class="most-popular">
                            <div class="row">
                                
                                <?php echo form_open('compte/connecter'); ?>
                                    <label style ="color :white">Saisissez vos identifiants ici :</label><br>
                                    <input type="text" name="pseudo" placeholder = "Pseudo" required />
                                    <input type="password" name="mdp" placeholder = "Mot de passe" required/>
                                    <input type="submit" value="Connexion"/>
                                    <?php echo validation_errors(); ?>
                                </form>

                        </div>
                      </p>
                    </div>

                </div>
              </div>
            </div>
          </div>
          <!-- ***** Banner End ***** -->

        

          
        </div>
      </div>
    </div>
  </div>