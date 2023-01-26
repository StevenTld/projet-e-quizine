<!--Projet : Bloc-kuiz
    Creator : STEVEN TALBOURDET 
    Description : Ce fichier contient le formulaire de création de compte avec affichage d'une erreur car les deux mots de passe rentré ne sont pas identiques
    V1.0
-->



<!-- ***** Most Popular Start ***** -->
<div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="page-content">
            <div class="most-popular">
                <div class="row">
                    
                    <br />
                    <!-- ***** START Formulaire de création de compte ***** -->
                    <p>
                        <div class="form-group">
                            <?php echo validation_errors(); ?>
                            <?php echo form_open('compte_creer'); ?>
                                <div class="form-group">
                                    <label for="id">Identifiant</label>
                                    <input type="input" name="id" aria-describedby="emailHelp" placeholder="Pseudo"  class="form-control"/><br />
                                </div>
                                
                                <div class="form-group">
                                    <label for="mdp">Mot de passe</label>
                                    <input type="password" name="mdp" placeholder="Password"  class="form-control"/><br />
                                </div>

                                <div class="form-group">
                                    <label for="mdp">Mot de passe</label>
                                    <input type="password" name="mdp" placeholder="Confirmez Password"  class="form-control"/><br />
                                </div>
                                
                                <input type="submit" class="btn btn-primary" name="submit" value="Créer un compte" />

                                <!-- ***** MESSAGE D'ERREUR MOTS DE PASSE DIFFERENTS ***** -->
                                <p style = "color : red"> Les mots de passe ne correspondent pas, veuillez réessayer !</p>
                                
                            </form>
                                
                                
                            </form>
                        </div>
                    </p>
                    <!-- ***** END Formulaire de création de compte ***** -->
                </div>
            </div>
        </div>
    </div>

             
          <!-- ***** Most Popular End ***** -->


