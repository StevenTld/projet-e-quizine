<!--Projet : Bloc-kuiz
    Creator : STEVEN TALBOURDET 
    Description : Ce fichier contient le template du menu de navigation visiteur
    V1.0
-->

                    <!-- ***** Search End ***** -->
                    <div class="search-input">
                      <form id="search" action="#">
                        <input type="text" placeholder="Tapez ici" id='searchText' name="searchKeyword" onkeypress="handle" />
                        <i class="fa fa-search"></i>
                      </form>
                    </div>
                    <!-- ***** Search End ***** -->

                  <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li><a href="<?php echo $this->config->base_url(); ?>index.php/compte/accueil_connecter">Accueil</a></li>
                        <li><a href="<?php echo $this->config->base_url(); ?>index.php/match/gestion">Gestion Matchs</a></li>
                        <li><a href="<?php echo $this->config->base_url(); ?>index.php/compte/modifier_profil">Votre Profil</a></li>

                        
                        <li><a href="<?php echo $this->config->base_url(); ?>index.php/compte/log_out">Déconnexion <img src="<?php echo base_url();?>style/front_end/assets/images/profile-header.jpg" alt=""></a></li>
                    </ul>   
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->

                    