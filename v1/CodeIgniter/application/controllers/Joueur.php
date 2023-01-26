<!--Projet : Bloc-kuiz
    Creator : STEVEN TALBOURDET 
    Description : Ce fichier contient le controller des Joueurs
    V1.0
-->

<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Joueur extends CI_Controller {
        public function __construct()
        {
            //chargement des constructeurs
            parent::__construct();
            $this->load->model('db_model');
            $this->load->helper('url_helper');
        }

        public function joueur_check($str){
            if($this->db_model->set_joueur2($_POST['id'])==FALSE){
                $this->form_validation->set_message('joueur_check', 'Ce pseudo est déjà choisi');
                return FALSE;
            }
            else{return TRUE;}
        }
        public function creer()
        {
            //gestion du formulaire de nouveau joueur

            $this->load->helper('form');

            //gestion des erreurs
            $this->load->library('form_validation');
            $this->form_validation->set_rules('jou_pseudo', 'jou_pseudo', 'required|alpha_numeric|callback_joueur_check');
            $this->form_validation->set_message('alpha_numeric', 'Votre pseudo ne peut contenir que des chiffres et/ou des lettres !');
            $this->form_validation->set_error_delimiters('<p style="color:#ef1834">', '</p>'); 
            
            //chargement des fonctions get_all_actualite et get_info_match
            $data['all_actu'] = $this->db_model->get_all_actualite();
            $data['nom_match'] = $this->db_model->get_info_match($_POST['id']);
            $data['all_info_match'] = $this->db_model->get_info_match($_POST['id']);
            $data['name_match'] = $this->db_model->get_name_match($_POST['id']);
            $data_test['all_actu'] = $this->db_model->get_all_actualite();
            $data_test['code_match'] = $this->db_model->get_match_exist();

            
            
           

            if ($this->form_validation->run() == FALSE )
            {   
                $data_test['test']= $_POST['id'];
                //Chargement de la view haut.php + menu_visiteur.php
                $this->load->view('templates/haut');
                $this->load->view('templates/menu_visiteur');

                //Chargement de la view du milieu nouveau_joueur.php si il y a une erreur
                $this->load->view('nouveau_joueur',$data_test);

                //Chargement de la view bas.php
                $this->load->view('templates/bas');
            }
            else
            {
                //appelle de la fonction set_joueur2 présente dans Db_model.php
                $this->db_model->set_joueur2($_POST['id']);

                //Chargement de la view haut.php + menu_visiteur.php
                $this->load->view('templates/haut_wo_loader');
                $this->load->view('templates/menu_visiteur');

                //Chargement de la view du milieu afficher_match.php
                $this->load->view('afficher_match',$data);

                //Chargement de la view bas.php
                $this->load->view('templates/bas');
            }
        }
    }
        
?>