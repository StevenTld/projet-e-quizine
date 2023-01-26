<?php
/*  
    Projet : Bloc-kuiz
    Creator : STEVEN TALBOURDET 
    Description : Ce fichier contient toutes les requêtes SQL servant à relier la base de données et le site web
    V1.0
*/

/*-----------------------------------------------------------------------*/
class Db_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }
    /*GESTION CRUD DES COMPTE*/
    public function get_all_compte()
    {
        $query = $this->db->query("SELECT usr_pseudo FROM T_UTILISATEUR_usr;");
        return $query->result_array();
    }

    /*-----------------------------------------------------------------------*/ 
    
    /*GESTION CRUD DES ACTU*/
    public function get_actualite($numero)
    {
        $query = $this->db->query("SELECT new_id,new_contenu FROM T_NEWS_new WHERE
        new_id=".$numero.";");
        return $query->row();
    }
    public function get_all_actualite()
    {
        $query = $this->db->query(" SELECT new_date, new_titre, new_contenu, usr_pseudo,new_id FROM T_NEWS_new
                                    join T_UTILISATEUR_usr using(usr_id);");
        return $query->result_array();
    }

    /*-----------------------------------------------------------------------*/ 
    
    /*NOMBRES DE COMPTES UTILISATEUR*/
    public function get_number_compte()
    {
        $query = $this->db->query("SELECT count(usr_id) as nb_compte from T_UTILISATEUR_usr;");
        return $query->row();
    }
    /*-----------------------------------------------------------------------*/ 
    
    /*TOUTES LES INFOS D'UN MATCH*/
    public function get_info_match($CODE_MAT)
    {
        $query = $this->db->query("SELECT * from T_MATCH_mat join T_QUESTION_que using(qui_id) join T_REPONSE_rep using(que_id) join T_QUIZ_qui using(qui_id) where mat_code = '".$CODE_MAT."' AND que_etat = 'A' ; ");
        return $query->result_array();
    }
    /*NOM DU MATCH ET DU QUIZ*/
    public function get_name_match($CODE_MAT)
    {
        $query = $this->db->query("SELECT * from T_MATCH_mat  join T_QUIZ_qui using(qui_id) where mat_code = '".$CODE_MAT."' ; ");
        return $query->row();
    }

    /*-----------------------------------------------------------------------*/

    public function get_compte_exist($usr_pseudo){
        $this->load->helper('url');

        $query = $this->db->query("SELECT * from T_UTILISATEUR_usr where usr_pseudo = '".$usr_pseudo."' ; ");

        if ($query->num_rows() == 0){
            return FALSE;
         }else{
            return TRUE;
         }
        


    }
    
    /*CREATION D'UN COMPTE*/
    public function set_compte()
    {
        
        $this->load->helper('url');
        //récupératioon des données du comptes
        $id=$this->input->post('id');
        $mdp=$this->input->post('mdp');
        $mdp2=$this->input->post('mdp2');
       
         
         
        
        $mdp_escaped = html_escape($this->db->escape_str(hash('sha256',$mdp)));
        $mdp_escaped2 = html_escape($this->db->escape_str($mdp2));
        $id_escaped = html_escape($this->db->escape_str($id));

        // insertion des données
            
                $req="INSERT INTO T_UTILISATEUR_usr VALUES ('".$id_escaped."','".$mdp_escaped."','F','A',NULL);";
                $query = $this->db->query($req);
                return ($query);
            
            
        
    }

     /*-----------------------------------------------------------------------*/ 
     /*VERIFIFACTION DE L'EXISTENCE D'UN MATCH*/
     public function get_match_exist()
     {
         $this->load->helper('url');

         //récupération du code du match entré par l'utilisateur
         $code_match=$this->input->post('code_match');
         $code_match_escaped=html_escape($this->db->escape_str($code_match));

         $req = "SELECT mat_code from T_MATCH_mat where mat_code = '".$code_match_escaped."';";
         $query = $this->db->query($req);
         
         if ($query->num_rows() == 0){
            return FALSE;
         }else{
            return ($query->row());
         }
         
     }
    /*-----------------------------------------------------------------------*/
    /*RECHERCHE DE L'ID D'UN MATCH POUR UN CODE DONNE*/
    public function set_joueur($CODE_MAT)
    {
        $this->load->helper('url');

        /*RECUPERATION DE L'ID D'UN MATCH*/
        $req="SELECT mat_id from T_MATCH_mat where mat_code ='".$CODE_MAT."';";
        $query = $this->db->query($req);
        return $query->row();
    }
    
    public function joueur_unique($PSEUDO,$CODE_MAT){
        $this->load->helper('url');
        $req="SELECT * from T_JOUEUR_jou where jou_pseudo = '".$PSEUDO."' and mat_id ='".$CODE_MAT."';";
        $query = $this->db->query($req);
        if ($query->num_rows() == 0){
            return FALSE;
         }else{
            return ($query->row());
         }
        
    }
     
     public function set_joueur2($CODE_MAT)
     {   

         $this->load->helper('url');
         $jou_pseudo=$this->input->post('jou_pseudo');
         $jou_pseudo_escaped = html_escape($this->db->escape_str($jou_pseudo));
         /*INSERTION DU JOUEUR DANS LA DATABASE*/
         $test = $this->set_joueur($CODE_MAT)->mat_id;
         if($this->joueur_unique($jou_pseudo_escaped,$test)==FALSE){
            $req="INSERT INTO T_JOUEUR_jou VALUES ('".$jou_pseudo_escaped."',0,NULL, '".$test."');";
            $query = $this->db->query($req);
            return ($query);
         }else{
             return FALSE;
         }
         
         
     }
 
      /*-----------------------------------------------------------------------*/



    public function connect_compte($username, $password){
        $salt = 'CeciEstLeSel6549022*';
        $hash_password = hash('SHA256',$password.$salt);
        
        $query =$this->db->query("SELECT usr_pseudo,usr_mdp,usr_role,usr_id FROM T_UTILISATEUR_usr WHERE usr_pseudo='".$username."' AND usr_mdp='".$hash_password."' AND usr_etat = 'A';");
        if($query->num_rows() > 0){
            return ($query->row());
        }
        else{
            return false;
        }
    }

    /*-----------------------------------------------------------------------*/

    

    public function change_password($username, $password, $new_password){
    
        $salt = 'CeciEstLeSel6549022*';
        $hash_password = hash('SHA256',$password.$salt);
        $hash_new_password = hash('SHA256',$new_password.$salt);
        
        $query =$this->db->query("SELECT usr_pseudo,usr_mdp,usr_role FROM T_UTILISATEUR_usr WHERE usr_pseudo='".$username."' AND usr_mdp='".$hash_password."' AND usr_etat = 'A';");
        if($query->num_rows() > 0){
            $query2 = $this->db->query("UPDATE T_UTILISATEUR_usr SET usr_mdp ='".$hash_new_password."' WHERE usr_pseudo='".$username."' ; ");
        }
        else{
            return false;
        }
    }
    
    /*-----------------------------------------------------------------------*/
    public function new_match($code_match,$quiz){
    
        $query= $this->db->query("INSERT into T_MATCH_mat VALUES (NULL, NULL, 'N', 'A','".$code_match."', NULL,'".$_SESSION['usr_id']."', '".$quiz."' );"); 
        
        return TRUE;
        
    }

    public function set_start_match($code_match){
        $query = $this->db->query("UPDATE T_MATCH_mat SET mat_date_debut = now() where mat_code = '".$code_match."'");
    }

    /*-----------------------------------------------------------------------*/

    public function get_all_quiz_formateur()
    {
        $query = $this->db->query(" SELECT * FROM T_QUIZ_qui where usr_id = '".$_SESSION['usr_id']."'; ");
        return $query->result_array();
    }

    /*-----------------------------------------------------------------------*/

    public function get_all_match_formateur()
    {
        $query = $this->db->query(" SELECT * FROM T_MATCH_mat join T_QUIZ_qui using(qui_id) where T_MATCH_mat.usr_id = '".$_SESSION['usr_id']."'; ");
        return $query->result_array();
    }

    public function get_info_compte($ID_USR){
        $query = $this->db->query(" SELECT * FROM T_PROFIL_pfl join T_UTILISATEUR_usr using(usr_id) WHERE usr_id = '".$ID_USR."'; ");
        return $query->row();
    }
}


?>