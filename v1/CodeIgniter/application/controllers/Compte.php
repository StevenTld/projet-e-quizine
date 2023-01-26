<!--Projet : Bloc-kuiz
    Creator : STEVEN TALBOURDET 
    Description : Ce fichier contient le controller des Compte
    V1.0
-->

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Compte extends CI_Controller {
    public function __construct()
    {   
        //chargement des constructeurs
        parent::__construct();
        $this->load->model('db_model');
        $this->load->helper('url_helper');
    }
 /*---------------------------------------------------------------------------------------------------------------------------- */
    public function creer()
    {
        //gestion du formulaire de création de compte
        $this->load->helper('form');

        //gestion des erreurs START
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'id', 'required|alpha_numeric|is_unique[T_UTILISATEUR_usr.usr_pseudo]');
        $this->form_validation->set_rules('mdp', 'mdp', 'required');
        $this->form_validation->set_rules('mdp2', 'mdp2', 'required|matches[mdp]');
        $this->form_validation->set_message('matches', 'Les deux mots de passe ne correspondent pas, veuillez réessayer.');
        $this->form_validation->set_message('alpha_numeric', 'Le pseudo ne peut contenir que des lettres et/ou des chiffres !');
        $this->form_validation->set_message('is_unique', 'Ce pseudo n\'est pas disponible !');
        $this->form_validation->set_error_delimiters('<div style="color:red">', '</div>'); 
        //gestion des erreurs END

        if ($this->form_validation->run() == FALSE )
        {   
            //Chargement de la view haut.php + menu_visiteur.php
            $this->load->view('templates/haut');
            $this->load->view('templates/menu_visiteur');

            //Chargement de la view du milieu : creer_creer.php
            $this->load->view('compte_creer');

            //Chargement de la view bas.php
            $this->load->view('templates/bas');
        }
        else
        {   
                 $this->db_model->set_compte();
                //Chargement de la view haut.php + menu_visiteur.php
                $this->load->view('templates/haut');
                $this->load->view('templates/menu_visiteur');

                //Chargement de la view du milieu : compte_succes.php
                $this->load->view('compte_succes');

                //Chargement de la view bas.php
                $this->load->view('templates/bas');
            }
    }
    

    
 /*---------------------------------------------------------------------------------------------------------------------------- */
    public function lister()
    {
        //chargement des fonctions get_all_compte et get_number_compte
        $data['titre'] = 'Liste des pseudos :';
        $data['pseudos'] = $this->db_model->get_all_compte();
        $data['nb'] = $this->db_model->get_number_compte();

        if($_SESSION['role']== 'F' || $_SESSION['role']!= 'A'){
            redirect(base_url()."index.php/compte/connecter");
            
        }else{
            //Chargement de la view haut.php + menu_visiteur.php
            $this->load->view('templates/haut');
            $this->load->view('templates/menu_administrateur');

            //Chargement de la view du milieu compte_liste.php
            $this->load->view('compte_liste',$data);

            //Chargement de la view bas.php
            $this->load->view('templates/bas');
        }
        
    }
 /*---------------------------------------------------------------------------------------------------------------------------- */
   
    public function check_info_usr($username,$password){
        if($this->db_model->connect_compte($username,$password)){
            return TRUE;
        }else{
            $this->form_validation->set_message('check_info_usr', 'Les informations n\'ont pas permis de vous identifier');
            return FALSE;
        }
    }
 
    public function connecter()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pseudo', 'pseudo', 'required|callback_check_info_usr['.$this->input->post('mdp').']');
        $this->form_validation->set_rules('mdp', 'mdp', 'required');
        $this->form_validation->set_message('required', 'Saisissez un pseudo et un mot de passe.');
        $this->form_validation->set_error_delimiters('<div style="color:red">', '</div>'); 

        
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('templates/haut');
            $this->load->view('templates/menu_visiteur');
            $this->load->view('compte_connecter');
            $this->load->view('templates/bas');
        }
        else
        {   
            $username = $this->input->post('pseudo');
            $password = $this->input->post('mdp');
            $role = $this->db_model->connect_compte($username,$password)->usr_role;
            $ID_USR = $this->db_model->connect_compte($username,$password)->usr_id;
            $data['info_profil']=$this->db_model->get_info_compte($ID_USR);


            if($this->db_model->connect_compte($username,$password) && $role == 'F')
            {   
                $session_data = array('username' => $username,'role' => $role, 'usr_id'=>$ID_USR );
                $this->session->set_userdata($session_data);
                
                $this->load->view('templates/haut');
                $this->load->view('templates/menu_formateur');
                $this->load->view('compte_menu',$data);
                $this->load->view('templates/bas');
            }
            else if($this->db_model->connect_compte($username,$password) && $role == 'A')
            {   
                $session_data = array('username' => $username,'role' => $role, 'usr_id'=>$ID_USR );
                $this->session->set_userdata($session_data);
                $this->load->view('templates/haut');
                $this->load->view('templates/menu_administrateur');
                $this->load->view('compte_menu',$data);
                $this->load->view('templates/bas');

            }else if(!$this->db_model->connect_compte($username,$password)){
                $this->load->view('templates/haut');
                $this->load->view('templates/menu_visiteur');
                $this->load->view('compte_connecter');
                $this->load->view('templates/bas');
            }
            
        }
        if($this->session->userdata('usr_id')){
            redirect(base_url()."index.php/compte/accueil_connecter");
        }

    }

    public function accueil_connecter()
    {
    
        
        if($_SESSION['role']=='F')
        {   
            
            $this->load->view('templates/haut');
            $this->load->view('templates/menu_formateur');
            $this->load->view('compte_menu');
            $this->load->view('templates/bas');
        }
        else if($_SESSION['role']=='A')
        {   
            
            $this->load->view('templates/haut');
            $this->load->view('templates/menu_administrateur');
            $this->load->view('compte_menu');
            $this->load->view('templates/bas');
        }else if($_SESSION['role']!='A' && $_SESSION['role']!='F'){
            $this->load->view('templates/haut');
            $this->load->view('templates/menu_visiteur');
            $this->load->view('compte_connecter');
            $this->load->view('templates/bas');
        }
    }

    
 /*---------------------------------------------------------------------------------------------------------------------------- */
    public function modifier_profil(){
        $data['info_profil']=$this->db_model->get_info_compte($this->session->userdata('usr_id'));

        if($this->session->userdata('role')== 'F')
            {   
                
                
                $this->load->view('templates/haut');
                $this->load->view('templates/menu_formateur');
                $this->load->view('gestion_profil',$data);
                $this->load->view('templates/bas');
            }
            else if( $this->session->userdata('role') == 'A')
            {   
              
                $this->load->view('templates/haut');
                $this->load->view('templates/menu_administrateur');
                $this->load->view('gestion_profil',$data);
                $this->load->view('templates/bas');

            }else if($this->session->userdata('role') != 'A' && $this->session->userdata('role') != 'F') {
                redirect(base_url()."index.php/compte/connecter");

            }

    }
  /*---------------------------------------------------------------------------------------------------------------------------- */

    public function old_pwd_check($str){
        if($this->db_model->connect_compte($_SESSION['username'],$str) == FALSE){
            $this->form_validation->set_message('old_pwd_check', 'Le mot de passe ne correspond pas !');
            return FALSE;
        }
        else{return TRUE;}
    }
    /*------------------------------------------------------------------------------------------------- */
    public function change_password(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('old_pwd', 'old_pwd', 'required|callback_old_pwd_check');
        $this->form_validation->set_rules('new_pwd', 'new_pwd', 'required');
        $this->form_validation->set_rules('conf_new_pwd', 'new_pwd', 'required|matches[new_pwd]');
        $this->form_validation->set_message('matches', 'Confirmation du mot de passe erronée, veuillez réessayer !');
        $this->form_validation->set_error_delimiters('<div style="color:red">', '</div>'); 
        
        if($this->session->userdata('role')!= 'A' && $this->session->userdata('role')!= 'F'){
            redirect(base_url()."index.php/compte/connecter");
            
        }
        if ($this->form_validation->run() == FALSE && $this->session->userdata('role') == 'F')
        {
            $this->load->view('templates/haut');
            $this->load->view('templates/menu_formateur');
            $this->load->view('change_pwd');
            $this->load->view('templates/bas');

        }else if($this->form_validation->run() == FALSE && $this->session->userdata('role') == 'A'){
            $this->load->view('templates/haut');
            $this->load->view('templates/menu_administrateur');
            $this->load->view('change_pwd');
            $this->load->view('templates/bas');

        }
        
        else{
            $old_password = $this->input->post('old_pwd');
            $new_password = $this->input->post('new_pwd');
            if($_SESSION['role'] == 'F'){
                $this->db_model->change_password($this->session->userdata('username'),$old_password,$new_password);
                $this->load->view('templates/haut');
                $this->load->view('templates/menu_formateur');
                $this->load->view('compte_menu');
                $this->load->view('templates/bas');

            }else if($_SESSION['role'] == 'A'){
                $this->db_model->change_password($this->session->userdata('username'),$old_password,$new_password);
                $this->load->view('templates/haut');
                $this->load->view('templates/menu_administrateur');
                $this->load->view('compte_menu');
                $this->load->view('templates/bas');
         }

        } 


    }
     /*------------------------------------------------------------------------------------------------- */
 /*---------------------------------------------------------------------------------------------------------------------------- */
    
 /*---------------------------------------------------------------------------------------------------------------------------- */

    public function log_out(){
        if($this->session->userdata('role')!= 'A' && $this->session->userdata('role')!= 'F'){
            redirect(base_url()."index.php/compte/connecter");
            
        }else{
            session_destroy();
            unset($_SESSION['role']);
            unset($_SESSION['username']);
            redirect(base_url()."index.php/compte/connecter");
        }
        
    }

}


?>