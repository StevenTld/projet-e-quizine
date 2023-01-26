<!--Projet : Bloc-kuiz
    Creator : STEVEN TALBOURDET 
    Description : Ce fichier contient le controller des Actualités
    V1.0
-->

<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Actualite extends CI_Controller {
        public function __construct()
        {
            //chargement des constructeurs
            parent::__construct();
            $this->load->model('db_model');
            $this->load->helper('url_helper');
        }
        public function afficher($numero =FALSE)
        {
        if ($numero==FALSE)
        { 
            $url=base_url(); header("Location:$url");
        }
        else{
            
            $data['titre'] = 'Actualité :';
            //chargement de la fonction get_actualite
            $data['actu'] = $this->db_model->get_actualite($numero);

            //Chargement de la view haut.php + menu_visiteur.php
            $this->load->view('templates/haut');
            $this->load->view('templates/menu_visiteur');

            //Chargement de la view du milieu : actualite_afficher.php
            $this->load->view('actualite_afficher',$data);

            //Chargement de la view bas.php
            $this->load->view('templates/bas');
        }
        }
    }
?>


