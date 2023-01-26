<!--Projet : Bloc-kuiz
    Creator : STEVEN TALBOURDET 
    Description : Ce fichier contient le controller des Matchs
    V1.0
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

        public function afficher($code =FALSE)
        {
            if ($code==FALSE || $code == TRUE)
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
             $this->form_validation->set_rules('code', 'code', 'required|alpha_numeric');
             $this->form_validation->set_message('alpha_numeric', 'Le code ne contient que des lettres et/ou des chiffres !');
             $this->form_validation->set_error_delimiters('<p style="color:#ef1834">', '</p>'); 
             $data['all_quiz'] = $this->db_model->get_all_quiz_formateur();
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

                    $code_match = $this->input->post('code');
                    $quiz = $this->input->post('qui_id');

                    $this->db_model->new_match($code_match,$quiz);
                    //Chargement de la view haut.php + menu_visiteur.php
                    $this->load->view('templates/haut');
                    $this->load->view('templates/menu_formateur');
                    //Chargement de la view du milieu gestion_match.php
                    $this->load->view('gestion_match',$data);
                    //Chargement de la view bas.php
                    $this->load->view('templates/bas');
                }

                
            }
       
        }



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



    }
?>




<!-- https://obiwan.univ-brest.fr/difal3/ztalboust/dev/CodeIgniter/index.php/match/afficher/1 -->