<!--Projet : Bloc-kuiz
    Creator : STEVEN TALBOURDET 
    Description : Ce fichier contient le formulaire de création de compte
    V1.0
-->



<!-- ***** Most Popular Start ***** -->
<div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="page-content">
            <h3 style = "text-align : center; color :#e75e8d">Inscrivez vous dès maintenant !</h3>
            <div class="most-popular">
                
                <div class="row">
                    
                    <br />
                    <!-- ***** START Formulaire de création de compte ***** -->
                    <p> 
                        
                        <div class="form-group">
                            
                            <?php echo form_open('compte_creer'); ?>
                                <div class="form-group">
                                    <label for="id"></label>
                                    <input type="input" name="id" aria-describedby="emailHelp" placeholder="Pseudo"  class="form-control"/><br />
                                </div>
                                
                                <div class="form-group">
                                    <label for="mdp"></label>
                                    <input type="password" name="mdp" placeholder="Mot de passe"  class="form-control"/><br />
                                </div>

                                <div class="form-group">
                                    <label for="mdp2"></label>
                                    <input type="password" name="mdp2" placeholder="Confirmez votre mot de passe"  class="form-control"/><br />
                                </div>
                                
                                <?php echo validation_errors(); ?>
                                <input type="submit" class="btn btn-primary" name="submit" value="Créer un compte" />
                                
                            </form>
                                
                                
                            
                        </div>
                    </p>
                    <!-- ***** END Formulaire de création de compte ***** -->
                </div>
            </div>
        </div>
    </div>

             
          <!-- ***** Most Popular End ***** -->


