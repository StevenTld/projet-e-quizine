<!--Projet : Bloc-kuiz
    Creator : STEVEN TALBOURDET 
    Description : Ce fichier contient le controller des Accueil
    V1.0
-->

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Accueil extends CI_Controller {

    public function __construct()
    {
        //chargement des constructeurs
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('db_model');
    }

    public function afficher()
    {   
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['titre'] = 'Liste des actualités :';
        $data['all_actu'] = $this->db_model->get_all_actualite();
        $data['match_exist'] = $this->db_model->get_match_exist();
        //Chargement de la view haut.php + menu_visiteur.php
        $this->load->view('templates/haut');
        $this->load->view('templates/menu_visiteur');
        //Chargement de la view du milieu : page_accueil.php
        $this->load->view('page_accueil',$data);
        //Chargement de la view bas.php
        $this->load->view('templates/bas');
    }
}
?>