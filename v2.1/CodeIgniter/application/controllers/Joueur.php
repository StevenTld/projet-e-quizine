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

        public function reponses_joueur()
        {
            //gestion du formulaire de nouveau joueur

            $this->load->helper('form');
            $this->load->library('form_validation');

            //recuperation des choix du joueur START
            $CODE_MAT = $this->input->post('mat_code'); 
            
            foreach($this->db_model->get_info_match($CODE_MAT) as $mat){
                
                $this->form_validation->set_rules($mat['que_id'], $mat['que_id'], 'required');
                $this->form_validation->set_message('required', 'Veuillez répondre à toutes les questions !');

                $this->form_validation->set_error_delimiters('<p style="color:#ef1834">', '</p>'); 
            }
            
            if ($this->form_validation->run() == FALSE )
            {   
                
                $data['all_info_match'] = $this->db_model->get_info_match($CODE_MAT);
                
                //Chargement de la view haut.php + menu_visiteur.php
                $this->load->view('templates/haut');
                $this->load->view('templates/menu_visiteur');
                //Chargement de la view du milieu afficher_match.php
                $this->load->view('afficher_match',$data);
                $this->load->view('templates/bas');
            }
            else
            {   $NB_B_REP = 0;
                
                foreach($this->db_model->get_info_match($CODE_MAT) as $mat){
                    //$ID_REP = $this->input->post($mat['rep_id']);
                    
                    if ($this->db_model->get_answer($this->input->post($mat['que_id'])) == TRUE){
                        $NB_B_REP += 1;
                    }
                }
                
                $SCORE_JOU = $this->db_model->get_score($CODE_MAT,$NB_B_REP);
                
                $PSEUDO_JOU = $_POST['joueur_pseudo'];
                
                $data['score_joueur'] =  $this->db_model->get_score($CODE_MAT,$NB_B_REP);;

                $this->db_model->set_score($data['score_joueur']->SCORE,$PSEUDO_JOU,$CODE_MAT);

                $data['code_match'] = $CODE_MAT;
                //Chargement de la view haut.php + menu_visiteur.php
                $this->load->view('templates/haut');
                $this->load->view('templates/menu_visiteur');
                //Chargement de la view du milieu afficher_match.php
                $this->load->view('resultats_quiz',$data);
                $this->load->view('templates/bas');
                

                
            }
        }
    }
        
?>