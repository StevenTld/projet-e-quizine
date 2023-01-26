# BLOC-KUIZ - Projet e-quizine



Auteur : Steven Talbourdet

Version présenté : V2

Date de présentation : 06/12/2022

Lien de l'application : [https://obiwan.univ-brest.fr/difal3/ztalboust/dev/v2/CodeIgniter/](https://obiwan.univ-brest.fr/difal3/ztalboust/dev/v2/CodeIgniter/)


## Site construit avec 

- Bootstrap 
    * Templates Bootstrap utilisé : https://bootstrapmade.com/techie-free-skin-bootstrap-3/
- CodeIgniter 3

## Compte de démo

#### Identifiants :
##### administrateur :   
- pseudo : responsable
- mot de passe : resp22_ZUIQ
##### formateur :       
- pseudo : StevenT
- mot de passe : L3IFA3_form_mdp



## Allons-y !                   
### lien pour se connecter : [https://obiwan.univ-brest.fr/difal3/ztalboust/dev/v2/CodeIgniter/index.php/compte/connecter](https://obiwan.univ-brest.fr/difal3/ztalboust/dev/v2/CodeIgniter/index.php/compte/connecter)

La version présenté est la version 2.

Elle comprend :

* Une page d'accueil avec affichage des actualités, champ de saisie pour un code de match, bouton de connexion pour les formateurs/administrateurs
* Une page avec un champ de saisie de pseudo inventé par une visiteur après avoir rentré un code de match valide
* Une page d'affichage des questions d'un match avec choix des réponses
* Une page d'affiche du score d'un joueur avec bouton d'affichage des bonnes réponses du quiz
* Une page de connexion pour les formateurs/administrateurs
* Pour les formateurs une Page de gestion des matchs : 
    - lancez un match, 
    - supprimer ses matchs, 
    - remise à zéro de ses matchs, 
    - activation/désactivation de ses matchs.
* Pour les administrateurs :
    - une page d'affichage de tous les profils et compte associés existant dans la base de données.
* Pour les formateurs/administrateurs :
    - une page d'affichage des données de leur profil et un formulaire de changement de mot de passe.


### Base de données
La base de données avec un jeu de données professionnels est disponible à l'adresse suivante : https://gitlab-deptinfo.univ-brest.fr/e22006308/projet_e_quizine/-/blob/main/zal3-ztalboust_1.sql
Nom de la base : zal3-ztalboust_1.sql
***
#### Fonctions/procédures/triggers ajouter à la base de données : 
#### Fonctions
* COMPTER_NB_QUIZ : Compte le nombre de quiz
* Liste_joueur_mat : Liste tous les joueurs d'un match
#### Procédures 
* NOUVEAU_VETERANT : Ajoute une actualité ayant comme un intitulé : "Nouveau Vétérant ! < nom de formateur > vient d'atteindre les 20 quiz créés."
* insert_actualite : Lorsque qu'un match se termine, une actualité est créé pour dire que le match numéro < id d'un match > est terminé.
* nombre_match : compte le nombre de match
* Score_joueur : determine le score d'un joueur en fonction du nombre de question d'un match et de son nombre de bonnes réponses
* set_score_match : insert le score moyen de tous les joueurs d'un match dans la colonne mat_score de la table T_MATCH_mat
#### Triggers
* AjoutActuVeterant : Lorsque qu'un formateur atteint les 20 quiz créés, la procédure NOUVEAU_VETERANT est déclenché
* HASH_MDP : Lorsque qu'un mot de passe est entré dans la base il est hashé en SHA256 puis salé 
* TRIGGER1 : Lorsque qu'un quiz est modifier (question supprimé) une nouvelle actualité est créé en fonction du nombre de questions restantes dans le quiz.
* TRIGGER2 : Trigger de remise à zéro d'un match. Lorsque que la date de début d'un match est postérieur à la date actuelle et qu'il n'y a pas de date de fin, tous les joueurs du match sont supprimés.
* trigger_insert_news : Lorsque qu'un match se termine, la procédure insert_actualite est appelé 

### Amélioration de l'application

* Pour la V2 en elle même, il serait judicieux d'ouvrir une session pour un joueur pour éviter tout problèmes de sécurité. Et également rendre l'utilisation de l'application plus user friendly :
    - possibilité de quitter la page et de revenir dans son match
    - si le match à déjà débuté le joueur avec une session pourra tout de même rentrer dans le match
* Pour une futur V3 
    - Implémenter la gestion CRUD des formateurs par les administrateurs 
    - Gestion CRUD des actualités par les formateurs et les administrateur 
    - Meilleur interface de jeu pour les joueur
    - Potentiel système d'éxpérience pour un joueur avec création de compte de joueur

### Procédure d'installation de l'application Web 

1. Vous avez réçu le dossier V2.zip, à l'intérieur se trouve votre application web BLOK-QUIZ.
2. Après avoir dézippé le dossier, importer le fichier : zal3-ztalboust_1.sql, correpondant à la base de données, dans votre propre base de données.
3. Ensuite dans le fichier se trouvant à l'adresse v2\CodeIgniter\application\config\database.php, remplacez les données
    - 'hostname' => '',
	- 'username' => '',
	- 'password' => '',
 par vos propres données.
4. Puis dans le fichier v2\CodeIgniter\application\config\config.php remplacez "$config[' base_url '] = https://obiwan.univ-brest.fr/difal3/ztalboust/dev/v2/CodeIgniter/';" par votre url


