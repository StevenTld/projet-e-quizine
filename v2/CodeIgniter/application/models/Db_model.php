<?php
/*  
    Projet : Bloc-kuiz
    Creator : STEVEN TALBOURDET 
    Description : Ce fichier contient toutes les requêtes SQL servant à relier la base de données et le site web
    V2.0
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
        $query = $this->db->query("SELECT  * FROM T_UTILISATEUR_usr join T_PROFIL_pfl using(usr_id);");
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
                                    join T_UTILISATEUR_usr using(usr_id) ORDER BY new_date DESC;");
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
        
        $query = $this->db->query("SELECT * from T_MATCH_mat join T_QUESTION_que using(qui_id) join T_REPONSE_rep using(que_id) join T_QUIZ_qui using(qui_id) where mat_code = '".$CODE_MAT."' AND que_etat = 'A' AND  mat_actif = 'A' ; ");
        
        return $query->result_array();
    }
    /*VERIFIE SI UN QUIZ A DES QUESTIONS*/
    public function get_if_quiz_has_question($CODE_QUIZ)
    {
        $query = $this->db->query("SELECT * from T_QUIZ_qui join T_QUESTION_que using (qui_id) where qui_id = '".$CODE_QUIZ."'; ");
        if ($query->num_rows() == 0){
            return FALSE;
         }else{
            return TRUE;
         }
    
    }

    /*-----------------------------------------------------------------------*/

    

     /*-----------------------------------------------------------------------*/ 
     /*VERIFIFACTION DE L'EXISTENCE D'UN MATCH*/
     public function get_match_exist()
     {
         $this->load->helper('url');

         //récupération du code du match entré par l'utilisateur
         $code_match=$this->input->post('code_match');
         $code_match_escaped=html_escape($this->db->escape_str($code_match));

         $req = "SELECT mat_code from T_MATCH_mat where mat_code = '".$code_match_escaped."' AND mat_actif = 'A';";
         $query = $this->db->query($req);
         
         if ($query->num_rows() == 0){
            return FALSE;
         }else{
            return ($query->row());
         }
         
     }


    /*-------------------------------------------------------------------------------------------------------*/
    //CREATION D'UN JOUEUR
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
         //récupération et gestion des erreurs du pseudo du joueur
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
     /*-------------------------------------------------------------------------------------------------------*/

    
     /*-------------------------------------------------------------------------------------------------------*/
    //START GESTION D'UN COMPTE 
    /*-----------------------------------------------------------------------*/
     // test si un compte existe
    public function get_compte_exist($usr_pseudo){
        $this->load->helper('url');

        $query = $this->db->query("SELECT * from T_UTILISATEUR_usr where usr_pseudo = '".$usr_pseudo."' ; ");

        if ($query->num_rows() == 0){
            return FALSE;
         }else{
            return TRUE;
         }
        


    }
    /*-----------------------------------------------------------------------*/
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
    
        // hash en sha 256 des mots de passe + salage = SECURTITE ++
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
    //END GESTION D'UN COMPTE
    /*-------------------------------------------------------------------------------------------------------*/



    public function new_match($quiz,$date_debut,$name_match,$mat_visualisation){
        
        //gestion des caractères non voulus dans un nom de match
        $name_match_escaped = html_escape($this->db->escape_str($name_match));
        $query= $this->db->query("INSERT into T_MATCH_mat VALUES ('".$name_match_escaped."','".$date_debut."', NULL, 'A','".$mat_visualisation."' ,NULL,'".SUBSTR(MD5(RAND()), 1, 8)."', NULL,'".$_SESSION['usr_id']."', '".$quiz."' );"); 
        
        return TRUE;
        
    }

    public function set_start_match($code_match){
        $query = $this->db->query("UPDATE T_MATCH_mat SET mat_date_debut = now() where mat_code = '".$code_match."'");
    }

    /*-----------------------------------------------------------------------*/

    public function get_all_quiz_formateur()
    {
        $query = $this->db->query(" SELECT * FROM T_QUIZ_qui  ; ");
        return $query->result_array();
    }

    /*-----------------------------------------------------------------------*/

    public function get_all_match_formateur()
    {
        $query = $this->db->query(" SELECT * ,usr.usr_pseudo as auteur_match, usr2.usr_pseudo as auteur_quiz
                                    from T_QUIZ_qui as qui
                                    inner join T_MATCH_mat as mat on mat.qui_id = qui.qui_id
                                    inner join T_UTILISATEUR_usr as usr on usr.usr_id = mat.usr_id
                                    inner join T_UTILISATEUR_usr as usr2 on usr2.usr_id = qui.usr_id
                                    ORDER by mat_id DESC;");
        return $query->result_array();
    }
    /*-----------------------------------------------------------------------*/

    public function get_info_compte($ID_USR){
        $query = $this->db->query(" SELECT * FROM T_PROFIL_pfl join T_UTILISATEUR_usr using(usr_id) WHERE usr_id = '".$ID_USR."'; ");
        return $query->row();
    }

    /*-------------------------------------------------------------------------------------------------------*/
    //START tableau de gestion des matchs dans la partie formateur
    /*-----------------------------------------------------------------------*/

    //test si tel match appartient à tel formateur
    public function is_match_formateur($CODE_MATCH,$ID_USR){
        $query = $this->db->query("SELECT * FROM T_MATCH_mat WHERE mat_code = '".$CODE_MATCH."' and usr_id = '".$ID_USR."'; ");
        if($query->num_rows() > 0){
            return TRUE;
        }else{return FALSE;}
    }
    //test si un match est activé
    public function is_match_active($CODE_MATCH){
        $query = $this->db->query("SELECT * FROM T_MATCH_mat WHERE mat_code = '".$CODE_MATCH."' and mat_actif= 'A'; ");
        if($query->num_rows() > 0){
            return TRUE;
        }else{return FALSE;}
    }

    //suppression d'un match
    public function del_match($CODE_MATCH){
        $query = $this->db->query("DELETE FROM T_MATCH_mat WHERE mat_code = '".$CODE_MATCH."'; ");
        return TRUE;
    }

    //remise à 0 d'un match
    public function raz_match($CODE_MATCH){
        $query = $this->db->query("UPDATE T_MATCH_mat set mat_date_debut = NOW() + INTERVAL 1 DAY, mat_date_fin = 
        NULL, mat_visualisation = 'A', mat_score = NULL where mat_code = '".$CODE_MATCH."'; ");
        return TRUE;
    }
    //Désactive un match
    public function desactiver_match($CODE_MATCH){
        $query = $this->db->query("UPDATE T_MATCH_mat set mat_actif = 'D' where mat_code = '".$CODE_MATCH."'; ");
        return TRUE;
    }

    //Active un match
    public function activer_match($CODE_MATCH){
        $query = $this->db->query("UPDATE T_MATCH_mat set mat_actif = 'A' where mat_code = '".$CODE_MATCH."'; ");
        return TRUE;
    }
     /*-----------------------------------------------------------------------*/
     //END tableau de gestion des matchs dans la partie formateur
     /*-------------------------------------------------------------------------------------------------------*/



    /*-------------------------------------------------------------------------------------------------------*/
    //START Gestion des resultats d'un joueur pour un match
    /*-----------------------------------------------------------------------*/
    public function get_answer($rep_id){
        $query = $this->db->query("SELECT * from T_REPONSE_rep where rep_id = '".$rep_id."' and rep_bonne_reponse = 1 ;");
        if($query->num_rows() > 0){
            return TRUE;
        }else{return FALSE;}
    }
    public function get_score($CODE_MATCH,$NB_B_REP){
        $this->db->query("CALL Score_joueur(".$NB_B_REP.", '".$CODE_MATCH."', @p2);  ");
        $query = $this->db->query("SELECT @p2 AS 'SCORE';");
        return $query->row();
        
        
    }

    public function is_visualisable($CODE_MATCH){
        $query = $this->db->query("SELECT * from T_MATCH_mat where mat_code = '".$CODE_MATCH."' and mat_visualisation = 'A';");
        if($query->num_rows() > 0){
            return TRUE;
        }else{return FALSE;}

    }

    public function set_score($score,$pseudo,$match){
        $query = $this->db->query("UPDATE T_JOUEUR_jou join T_MATCH_mat using(mat_id) set jou_score = '".$score."'  where jou_pseudo = '".$pseudo."'  and mat_code = '".$match."';");
        
        return TRUE;

    }
    /*-----------------------------------------------------------------------*/
    //END Gestion des resultats d'un joueur pour un match
     /*-------------------------------------------------------------------------------------------------------*/


     /*-------------------------------------------------------------------------------------------------------*/
    //START MATCH affichage score total
    /*-----------------------------------------------------------------------*/
        //test si un match n'est pas terminé
     public function get_match_date_fin_null($CODE_MATCH){
        
        $query = $this->db->query("SELECT * from T_MATCH_mat where mat_code = '".$CODE_MATCH."' and mat_date_fin is NULL;");
        if($query->num_rows() > 0){
            return TRUE;
        }else{return FALSE;}
    }
        //Initialise la fin d'un match
    public function set_match_fin($CODE_MATCH){

        $query = $this->db->query("UPDATE T_MATCH_mat set mat_date_fin = NOW() WHERE mat_code = '".$CODE_MATCH."';");
        return TRUE;
    }
        //Initialise le score total d'un match
    public function set_score_total($CODE_MATCH){

        $query = $this->db->query("CALL set_score_match('".$CODE_MATCH."'); ");
        return TRUE;
    }

    /*-------------------------------------------------------------------------------------------------------*/
    //END MATCH affichage score total
    /*-----------------------------------------------------------------------*/
}


?>