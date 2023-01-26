<!--Projet : Bloc-kuiz
    Creator : STEVEN TALBOURDET 
    Description : Ce fichier contient le controller des Matchs
    V2.0
-->

<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Match extends CI_Controller {
        public function __construct()
        {
            //chargement des constructeurs
            parent::__construct();
            $this->load->model('db_model');
            $this->load->helper('url_helper');
        }

        public function afficher($code,$pseudo)
        {
            if ($code==FALSE || $pseudo == FALSE)
            { 
                $url=base_url(); header("Location:$url");
            }
            else{  

                
                $data['all_info_match'] = $this->db_model->get_info_match($code);
                
                //Chargement de la view haut.php + menu_visiteur.php
                $this->load->view('templates/haut');
                $this->load->view('templates/menu_visiteur');
                //Chargement de la view du milieu afficher_match.php
                $this->load->view('afficher_match',$data);
                $this->load->view('templates/bas');
            }
        }
        public function exister()
        {       
            $this->load->helper('form');
            $this->load->library('form_validation');

            //gestion des erreurs
            $this->form_validation->set_rules('code_match', 'code_match', array('required','alpha_numeric'));
            $this->form_validation->set_message('min_length', 'Le code contient obligatoirement 8 caractères.');
            $this->form_validation->set_message('alpha_numeric', 'Le code ne contient que des lettres et/ou des chiffres !');
            $this->form_validation->set_error_delimiters('<p style="color:#ef1834">', '</p>'); 
            
            $data['titre'] = 'Liste des actualités :';


            $data['all_actu'] = $this->db_model->get_all_actualite();
            $data['code_match'] = $this->db_model->get_match_exist();
            if ($this->form_validation->run() == FALSE  || $this->db_model->get_match_exist() == FALSE)
            {
                //Chargement de la view haut.php + menu_visiteur.php
                $this->load->view('templates/haut');
                $this->load->view('templates/menu_visiteur');
                
                //Chargement de la view du milieu page_accueil_no_match.php
                $this->load->view('page_accueil_no_match',$data);

                //Chargement de la view bas.php
                $this->load->view('templates/bas');
            }
            else
            {
                //Chargement de la view haut.php + menu_visiteur.php
                $this->load->view('templates/haut_wo_loader');
                $this->load->view('templates/menu_visiteur');
                //Chargement de la view du milieu nouveau_joueur.php
                $this->load->view('nouveau_joueur',$data);
                //Chargement de la view bas.php
                $this->load->view('templates/bas');
            }
            }



            public function gestion()
        {       
            
            $this->load->helper('form');
            $this->load->library('form_validation');
            
             //gestion des erreurs
             $this->form_validation->set_rules('qui_id', 'qui_id', 'required');
             
             $this->form_validation->set_error_delimiters('<p style="color:#ef1834">', '</p>'); 
             
             $data['all_match_formateur'] = $this->db_model->get_all_match_formateur();

            if($_SESSION['role']== 'A' || $_SESSION['role']!= 'F'){
                redirect(base_url()."index.php/compte/connecter");
                
            }else {
                if ($this->form_validation->run() == FALSE)
                {
                    $this->load->view('templates/haut');
                    $this->load->view('templates/menu_formateur');
                    $this->load->view('gestion_match',$data);
                    $this->load->view('templates/bas');
                }else{

                    

                    
                    redirect(base_url()."index.php/match/gestion");
                }

                
            }
       
        }
    /************************************************************** */
        

        public function creer_match()
        {       
            $this->load->helper('form');
            $this->load->library('form_validation');
            //gestion des erreurs
            $this->form_validation->set_rules('qui_id', 'qui_id', 'required');
            $this->form_validation->set_rules('name_match', 'name_match', 'required');
            $this->form_validation->set_rules('mat_visualisation', 'mat_visualisation', 'required');
            $this->form_validation->set_message('required', 'Veuillez compléter tous les champs !');
            
            $this->form_validation->set_error_delimiters('<p style="color:#ef1834">', '</p>'); 
            $data['all_quiz'] = $this->db_model->get_all_quiz_formateur();
            if($_SESSION['role']== 'A' || $_SESSION['role']!= 'F'){
                redirect(base_url()."index.php/compte/connecter");
                
            }else {
                if ($this->form_validation->run() == FALSE)
                {
                    $this->load->view('templates/haut');
                    $this->load->view('templates/menu_formateur');
                    $this->load->view('creer_match',$data);
                    $this->load->view('templates/bas');
                }else{
                    $code_match = $this->input->post('qui_id');
                    $date_debut = $this->input->post('start_match');
                    $name_match = $this->input->post('name_match');
                    $visualisation_match = $this->input->post('mat_visualisation');
                    $this->db_model->new_match($code_match,$date_debut,$name_match,$visualisation_match);
                    redirect(base_url()."index.php/match/gestion");
                    
                }

                
            }
        }
       

    /*************************************************************** */



        public function code_afficher()
        {       
            
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('mat_code', 'mat_code', 'required');

            
            $ID_MAT = $this->input->post('mat_code');
             
            $data['all_quiz'] = $this->db_model->get_all_quiz_formateur();
            $data['all_match_formateur'] = $this->db_model->get_all_match_formateur();
            $data['all_info_match']=$this->db_model->get_info_match($ID_MAT);
            if($_SESSION['role']== 'A' || $_SESSION['role']!= 'F'){
                redirect(base_url()."index.php/compte/connecter");
                
            }
            if ($this->form_validation->run() == FALSE)
                {
                    redirect(base_url()."index.php/match/gestion");
                }else {
                

                    
                    //Chargement de la view haut.php + menu_visiteur.php
                    $this->load->view('templates/haut');
                    $this->load->view('templates/menu_formateur');
                    //Chargement de la view du milieu gestion_match.php
                    $this->load->view('afficher_code',$data);
                    //Chargement de la view bas.php
                    $this->load->view('templates/bas');
                }

                
            
       
        }
        /*************************************************************** */
        public function delete_match()
        {       
            
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('mat_code_del', 'mat_code_del', 'required');

            
            $code_match = $this->input->post('mat_code_del');
             
            if($_SESSION['role']== 'A' || $_SESSION['role']!= 'F'){
                redirect(base_url()."index.php/compte/connecter");
                
            }
            if ($this->form_validation->run() == FALSE)
                {
                    redirect(base_url()."index.php/match/gestion");
                }else {
                    $this->db_model->del_match($code_match);
                    redirect(base_url()."index.php/match/gestion");
                }
                   

                
            
       
        }
        /*************************************************************** */
        public function raz_match()
        {       
            
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('mat_code_raz', 'mat_code_raz', 'required');

            
            $code_match = $this->input->post('mat_code_raz');
             
            if($_SESSION['role']== 'A' || $_SESSION['role']!= 'F'){
                redirect(base_url()."index.php/compte/connecter");
                
            }
            if ($this->form_validation->run() == FALSE)
                {
                    redirect(base_url()."index.php/match/gestion");
                }else {
                    $this->db_model->raz_match($code_match);
                    
                    redirect(base_url()."index.php/match/gestion");
                }
        }
        /*************************************************************** */
        public function desactivate_match()
        {       
            
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('mat_code_des', 'mat_code_des', 'required');

            
            $code_match = $this->input->post('mat_code_des');
             
            if($_SESSION['role']== 'A' || $_SESSION['role']!= 'F'){
                redirect(base_url()."index.php/compte/connecter");
                
            }
            if ($this->form_validation->run() == FALSE)
                {
                    redirect(base_url()."index.php/match/gestion");
                }else {
                    $this->db_model->desactiver_match($code_match);
                    
                    redirect(base_url()."index.php/match/gestion");
                }
        }
        /*************************************************************** */
        public function activate_match()
        {       
            
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('mat_code_act', 'mat_code_act', 'required');

            
            $code_match = $this->input->post('mat_code_act');
             
            if($_SESSION['role']== 'A' || $_SESSION['role']!= 'F'){
                redirect(base_url()."index.php/compte/connecter");
                
            }
            if ($this->form_validation->run() == FALSE)
                {
                    redirect(base_url()."index.php/match/gestion");
                }else {
                    $this->db_model->activer_match($code_match);
                    redirect(base_url()."index.php/match/gestion");
                }
        }
        /*************************************************************** */
        public function corriger()
        {       
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('mat_code', 'mat_code', 'required');
            $code = $_POST['mat_code'] ;
            $data['all_info_match'] = $this->db_model->get_info_match($code);

            if ($this->form_validation->run() == FALSE)
            {
                redirect(base_url()."index.php");
            }else{

            //Chargement de la view haut.php + menu_visiteur.php
            $this->load->view('templates/haut');
            $this->load->view('templates/menu_visiteur');
            //Chargement de la view du milieu corriger_question.php
            $this->load->view('corriger_question',$data);
            //Chargement de la view bas.php
            $this->load->view('templates/bas');
                }
            
            
                    
                
        }

        public function terminer()
        {       
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('mat_code_terminer', 'mat_code_terminer', 'required');

            
            $code_match = $this->input->post('mat_code_terminer');
             
            if($_SESSION['role']== 'A' || $_SESSION['role']!= 'F'){
                redirect(base_url()."index.php/compte/connecter");
                
            }
            if ($this->form_validation->run() == FALSE)
                {
                    redirect(base_url()."index.php/match/gestion");
                }else {
                    $this->db_model->set_match_fin($code_match);
                    $this->db_model->set_score_total($code_match);
           
                redirect(base_url()."index.php/match/gestion");
                    
                }
            
           
           //Chargement de la view haut.php + menu_visiteur.php
           
           
                
        }


    }
?>




<!-- https://obiwan.univ-brest.fr/difal3/ztalboust/dev/CodeIgniter/index.php/match/afficher/1 -->