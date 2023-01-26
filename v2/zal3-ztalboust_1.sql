-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 05 déc. 2022 à 20:01
-- Version du serveur : 10.5.12-MariaDB-0+deb11u1
-- Version de PHP : 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `zal3-ztalboust_1`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`ztalboust`@`%` PROCEDURE `insert_actualite` (`ID_MAT` INT)   BEGIN
SET @intitule_match = (select qui_nom from T_QUIZ_qui 
join T_MATCH_mat using(qui_id)
where mat_id = ID_MAT);
SET @date_debut_match = (SELECT mat_date_debut from T_MATCH_mat where mat_id =ID_MAT);
SET @date_fin_match = (SELECT mat_date_fin from T_MATCH_mat where mat_id =ID_MAT);
INSERT INTO T_NEWS_new VALUES(CONCAT("Match numéro ",ID_MAT," finis !"),CONCAT('Nom du match : ',@intitule_match,'. Date de début : ', @date_debut_match,' Date de fin : ',@date_fin_match),CURRENT_DATE(),null,1);

END$$

CREATE DEFINER=`ztalboust`@`%` PROCEDURE `nombre_match` (OUT `NB_MAT_FINIS` INT, OUT `NB_MAT_EN_COURS` INT, OUT `NB_MAT_A_VENIR` INT)   BEGIN
	SET NB_MAT_FINIS = (SELECT COUNT(mat_id) from T_MATCH_mat where mat_date_fin is not null and mat_date_fin<NOW());
    SET NB_MAT_EN_COURS = (SELECT COUNT(mat_id) from T_MATCH_mat where mat_date_fin is null and mat_date_debut <NOW());
    SET NB_MAT_A_VENIR = (SELECT COUNT(mat_id) from T_MATCH_mat where mat_date_debut is null and mat_date_fin is null  );
END$$

CREATE DEFINER=`ztalboust`@`%` PROCEDURE `NOUVEAU_VETERANT` (IN `ID_USR` INT)   BEGIN
	SET @prenom_usr = (SELECT pfl_prenom from T_PROFIL_pfl where usr_id = ID_USR);
    SET @nom_usr = (SELECT pfl_nom from T_PROFIL_pfl where usr_id = ID_USR);
	SET @nb_actu = (SELECT COMPTER_NB_ACTU(ID_USR));
	IF @nb_actu=20 THEN
    	INSERT INTO T_NEWS_new VALUES('Nouveau Vétérant',CONCAT(@prenom_usr,' ',@nom_usr,' vient d\'atteindre les 20 quiz créés, c\'est désormais un véterant de BLOCQUIZ'),CURRENT_DATE(),null,1);
	END IF;
END$$

CREATE DEFINER=`ztalboust`@`%` PROCEDURE `Score_joueur` (IN `NB_BONNE_REP` INT, IN `CODE_MATCH` CHAR(8), OUT `SCORE` INT)   BEGIN
SET @nb_question = (SELECT count(qui_id) from T_QUESTION_que join T_QUIZ_qui using(qui_id) join T_MATCH_mat using(qui_id) where mat_code = CODE_MATCH);
SET SCORE = (((NB_BONNE_REP/@nb_question)*100)/4);

END$$

CREATE DEFINER=`ztalboust`@`%` PROCEDURE `set_score_match` (IN `CODE_MAT` CHAR(8))   BEGIN
SET @score_total = (SELECT AVG(jou_score) from T_JOUEUR_jou join T_MATCH_mat using(mat_id) where mat_code = CODE_MAT);
UPDATE T_MATCH_mat set mat_score = @score_total where mat_code = CODE_MAT;
END$$

--
-- Fonctions
--
CREATE DEFINER=`ztalboust`@`%` FUNCTION `COMPTER_NB_QUIZ` (`ID_USR` INT) RETURNS INT(11)  BEGIN
	DECLARE nb INT;
	SELECT COUNT(qui_id) into nb from T_QUIZ_qui where usr_id = ID_USR;
    RETURN nb;
END$$

CREATE DEFINER=`ztalboust`@`%` FUNCTION `Liste_joueur_mat` (`ID_MAT` INT) RETURNS TEXT CHARSET utf8mb4  BEGIN
	DECLARE test TEXT;
	SELECT GROUP_CONCAT(jou_pseudo) INTO test FROM T_JOUEUR_jou where mat_id = ID_MAT; 
    return test;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `LISTE_MAIL_PSEUDO`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `LISTE_MAIL_PSEUDO` (
`usr_pseudo` varchar(45)
,`pfl_mail` varchar(100)
);

-- --------------------------------------------------------

--
-- Structure de la table `T_JOUEUR_jou`
--

CREATE TABLE `T_JOUEUR_jou` (
  `jou_pseudo` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `jou_score` decimal(5,2) NOT NULL,
  `jou_id` int(11) NOT NULL,
  `mat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `T_JOUEUR_jou`
--

INSERT INTO `T_JOUEUR_jou` (`jou_pseudo`, `jou_score`, `jou_id`, `mat_id`) VALUES
('Steven', '10.00', 1, 1),
('Lucas', '0.00', 2, 1),
('Lea', '0.00', 3, 1),
('Lea', '0.00', 4, 4),
('LEa', '0.00', 5, 2),
('Benoit', '0.00', 6, 3),
('Chargzii', '0.00', 7, 2),
('Boubou', '0.00', 8, 3),
('xX-Alexis-Xx', '0.00', 9, 4),
('Boubou', '0.00', 10, 5),
('test', '0.00', 40, 5),
('caroline', '45.00', 54, 5),
('Gaby', '0.00', 142, 41),
('kf', '60.00', 143, 41),
('CACTUS', '0.00', 145, 4);

-- --------------------------------------------------------

--
-- Structure de la table `T_MATCH_mat`
--

CREATE TABLE `T_MATCH_mat` (
  `mat_nom` varchar(64) NOT NULL,
  `mat_date_debut` datetime DEFAULT NULL,
  `mat_date_fin` datetime DEFAULT NULL,
  `mat_actif` char(1) NOT NULL,
  `mat_visualisation` char(1) NOT NULL,
  `mat_score` decimal(5,2) DEFAULT NULL,
  `mat_code` char(8) DEFAULT NULL,
  `mat_id` int(11) NOT NULL,
  `usr_id` int(11) NOT NULL,
  `qui_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `T_MATCH_mat`
--

INSERT INTO `T_MATCH_mat` (`mat_nom`, `mat_date_debut`, `mat_date_fin`, `mat_actif`, `mat_visualisation`, `mat_score`, `mat_code`, `mat_id`, `usr_id`, `qui_id`) VALUES
('C\'est le match 1', '2022-10-10 16:12:47', '2022-10-26 16:12:47', 'A', 'A', '0.00', 'TESTTEST', 1, 3, 1),
('C\'est le 2eme match', '2022-10-16 18:58:01', '2022-10-16 18:58:01', 'A', 'A', '0.00', 'BLABLABA', 2, 5, 4),
('3eme match', '2022-10-16 19:00:51', '2022-10-16 19:00:51', 'D', 'A', '0.00', 'MATCHCOD', 3, 8, 3),
('Vous etes chaud ou paS ?', '2022-10-16 19:00:51', '2022-10-16 19:00:51', 'A', 'A', '0.00', 'CCCCCCCC', 4, 7, 2),
('Nom du match', '2022-10-16 19:01:58', '2022-10-16 19:01:58', 'A', 'A', '10.00', 'BBBBBBBB', 5, 5, 4),
('Vous allez y arriver', '2022-12-01 12:08:25', NULL, 'D', 'D', NULL, 'bbd08742', 32, 15, 1),
('Match 120000', '2022-12-08 00:00:00', NULL, 'A', 'A', NULL, '7ccfe98f', 41, 15, 1),
('Match des L3 IFA 3', '2022-12-06 19:17:47', NULL, 'A', 'N', NULL, 'cef9e652', 43, 15, 3);

--
-- Déclencheurs `T_MATCH_mat`
--
DELIMITER $$
CREATE TRIGGER `TRIGGER2` AFTER UPDATE ON `T_MATCH_mat` FOR EACH ROW BEGIN
IF NEW.mat_date_debut>CURRENT_DATE() and NEW.mat_date_fin is NULL THEN
DELETE FROM T_JOUEUR_jou where mat_id = NEW.mat_id;
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trigger_insert_news` AFTER UPDATE ON `T_MATCH_mat` FOR EACH ROW BEGIN
IF NEW.mat_date_fin is not null and OLD.mat_date_fin is null then 
	CALL insert_actualite(NEW.mat_id);
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `T_NEWS_new`
--

CREATE TABLE `T_NEWS_new` (
  `new_titre` varchar(200) NOT NULL,
  `new_contenu` varchar(500) NOT NULL,
  `new_date` date NOT NULL,
  `new_id` int(11) NOT NULL,
  `usr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `T_NEWS_new`
--

INSERT INTO `T_NEWS_new` (`new_titre`, `new_contenu`, `new_date`, `new_id`, `usr_id`) VALUES
('Nouveau Quiz le 12 Octobre !', 'Un nouveau quiz sur la mise à jour The Merge d\'Ethereum sera publié le 12 octobre', '2022-10-10', 1, 3),
('Nouveau Formateur', 'Le très renommé Docteur Talbourdet arrive sur le plateforme le 12 novembre pour proposé ses quiz les plus difficiles !', '2022-10-16', 2, 2),
('Maintenance !', 'Votre site de quiz en ligne préféré sera en maintenance du lundi 17 octobre au lundi 16 décembre. De toutes nouvelles fonctionnalités seront implémentées durant cette maintenance.', '2022-10-16', 3, 4),
('Le match numéro 1 est terminé !', 'Intitulé du match :The Merge; Début du match :2022-10-10 16:12:47 Fin du match :2022-10-27 16:12:47', '2022-10-26', 25, 1),
('Le match numéro 1 est terminé !', 'Intitulé du match :The Merge; Début du match :2022-10-10 16:12:47 Fin du match :2022-10-26 16:12:47 Liste des joueurs : Steven,Lucas,Lea', '2022-10-26', 26, 1),
('Modification du quiz\r\n: test_match', 'QUIZ VIDE ! ID des match de ce quiz : 7,8.\nFormateur(s) concerné(s) : Lucie23,Jason', '2022-11-09', 34, 1),
('Match numéro 6 finis !', 'Nom du match : The Merge. Date de début : 2022-11-02 13:44:49 Date de fin : 2022-11-18 14:06:39', '2022-11-14', 42, 1),
('Match numéro 5 finis !', 'Nom du match : Les \"Wallets\", les nouveaux sauveurs de notre sécurité en ligne.. Date de début : 2022-10-16 19:01:58 Date de fin : 2022-10-16 19:01:58', '2022-12-03', 64, 1),
('Match numéro 43 finis !', 'Nom du match : Mieux connaître le Bitcoin.. Date de début : 2022-12-06 12:09:00 Date de fin : 2022-12-05 19:00:20', '2022-12-05', 65, 1),
('Match numéro 43 finis !', 'Nom du match : Mieux connaître le Bitcoin.. Date de début : 2022-12-06 19:08:58 Date de fin : 2022-12-05 19:09:01', '2022-12-05', 66, 1),
('Match numéro 43 finis !', 'Nom du match : Mieux connaître le Bitcoin.. Date de début : 2022-12-06 19:16:01 Date de fin : 2022-12-05 19:16:42', '2022-12-05', 67, 1);

-- --------------------------------------------------------

--
-- Structure de la table `T_PROFIL_pfl`
--

CREATE TABLE `T_PROFIL_pfl` (
  `pfl_nom` varchar(60) NOT NULL,
  `pfl_prenom` varchar(60) NOT NULL,
  `pfl_mail` varchar(100) DEFAULT NULL,
  `pfl_id` int(10) NOT NULL,
  `usr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `T_PROFIL_pfl`
--

INSERT INTO `T_PROFIL_pfl` (`pfl_nom`, `pfl_prenom`, `pfl_mail`, `pfl_id`, `usr_id`) VALUES
('Talbourdet', 'Steven', NULL, 1, 1),
('Dupont', 'Paul', 'dupont.paul@univ-brest.fr', 2, 2),
('Duval', 'Lucie', NULL, 3, 3),
('Pierre', 'Valérie', 'valerie.pierre@orange.fr', 4, 4),
('Stone', 'Jason', 'Jason_Stone@gmail.com', 6, 5),
('Pratt', 'Casey', NULL, 7, 6),
('Moyer', 'Debbie', 'Debbie45Moyer@wanadoo.fr', 8, 7),
(' Austin', 'Robin', 'roro22mail@sfr.fr', 9, 8),
('Talbourdet', 'Steven', 'stevenemail@gmail.com', 13, 15);

-- --------------------------------------------------------

--
-- Structure de la table `T_QUESTION_que`
--

CREATE TABLE `T_QUESTION_que` (
  `que_intitule` varchar(200) NOT NULL,
  `que_img` varchar(200) NOT NULL,
  `que_etat` char(1) NOT NULL,
  `que_id` int(11) NOT NULL,
  `qui_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `T_QUESTION_que`
--

INSERT INTO `T_QUESTION_que` (`que_intitule`, `que_img`, `que_etat`, `que_id`, `qui_id`) VALUES
('Que signifie \"The Merge\" ?', 'image1', 'A', 1, 1),
('Quand a eu lieu la mise à jour intitulé \"The Merge\" ?', 'que_image2', 'A', 2, 1),
('De combien de % cette mise à jour à réduit la consommation d\'énergie d\'Ethereum ?', 'que_image2', 'A', 3, 1),
('Qu\'a changé la mise à jour sur le réseau Ethereum ?', 'que_image3', 'A', 4, 1),
('Quelle est la prochain mise à jour après The Merge ?', 'que_image5', 'A', 5, 1),
('Qu\'est-ce que la blockchain ?', 'image', 'A', 6, 2),
('Les données dans une base blockchain sont :', 'image', 'A', 7, 2),
('Complète la phrase: «Le cryptage de la technologie blockchain…', 'image', 'A', 8, 2),
('Parmi les termes suivants quel est celui qui ne fait pas partie de la famille de Blockchain ?', 'image', 'A', 9, 2),
('Laquelle de ces affirmations est fausse ?', 'image', 'A', 10, 2),
('Quelle abréviation est utilisée pour le bitcoin ?', 'image', 'A', 11, 3),
('Quel est le pseudonyme utilisé par le concepteur du bitcoin ?', 'image', 'A', 12, 3),
(' La plateforme d\'échange de Bitcoin Mt Gox basée à Tokyo :', 'image', 'A', 13, 3),
('Le nombre maximal possible de bitcoins en circulation dans le monde est de ?', 'image', 'A', 14, 3),
('Quel algorithme de hashage est à la base du bitcoin ?', 'image', 'A', 15, 3),
('Qu\'est est la différence entre un wallet hardware et software ?', 'image', 'A', 16, 4),
('Complétez la phrase suivante : \"Un wallet est ... \"', 'image', 'A', 17, 4),
('Laquelle de ces propositions n\'est pas un wallet hardware ?', 'image', 'A', 18, 4),
('Quelle est la traduction française de \"wallet\" ?', 'image', 'A', 19, 4),
('A quoi sert un wallet ?', 'image', 'A', 20, 4);

--
-- Déclencheurs `T_QUESTION_que`
--
DELIMITER $$
CREATE TRIGGER `TRIGGER1` AFTER DELETE ON `T_QUESTION_que` FOR EACH ROW BEGIN
        SET @liste_mat_id = (SELECT GROUP_CONCAT(mat_id) from T_MATCH_mat
        where qui_id = OLD.qui_id);
        SET @liste_formateur =(SELECT GROUP_CONCAT(usr_pseudo) from
        T_UTILISATEUR_usr join T_MATCH_mat USING(usr_id) where qui_id = OLD.qui_id);
        DELETE from T_NEWS_new where new_titre LIKE 'Modification du quiz%' and
        usr_id = 1;
        SET @nom_qui =(SELECT qui_nom from T_QUIZ_qui where qui_id = OLD.qui_id);
        SET @nb_question =(SELECT count(que_id) from T_QUESTION_que where qui_id =
        OLD.qui_id);
        IF @nb_question > 1 THEN
            INSERT INTO T_NEWS_new VALUES(CONCAT('Modification du quiz :\r\n            ',@nom_qui),CONCAT('Suppression d’une question, il reste ',@nb_question,'\r\n            questions',' ID des match de ce quiz : ',@liste_mat_id,'.\r\n                Formateur(s) concerné(s) : ',@liste_formateur),CURRENT_DATE(),null,1);
        END IF;
        IF @nb_question = 1 THEN
            INSERT INTO T_NEWS_new VALUES(CONCAT('Modification du quiz :\r\n            ',@nom_qui),CONCAT('ATTENTION, plus qu’une question ! ID des match de ce quiz : ',@liste_mat_id,'.\r\n                Formateur(s) concerné(s) : ',@liste_formateur),CURRENT_DATE(),null,1);
        END IF;
        IF @nb_question = 0 THEN

            IF @liste_mat_id is not null THEN
                INSERT INTO T_NEWS_new VALUES(CONCAT('Modification du quiz\r\n                : ',@nom_qui),CONCAT('QUIZ VIDE ! ID des match de ce quiz : ',@liste_mat_id,'.\r\n                Formateur(s) concerné(s) : ',@liste_formateur),CURRENT_DATE(),null,1);
            ELSE
                INSERT INTO T_NEWS_new VALUES(CONCAT('Modification du quiz :\r\n                ',@nom_qui),'QUIZ VIDE ! Aucun match associé à ce quiz pour\r\n                l’instant !',CURRENT_DATE(),null,1);
            END IF;
        END IF;
	END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `T_QUIZ_qui`
--

CREATE TABLE `T_QUIZ_qui` (
  `qui_nom` varchar(200) NOT NULL,
  `qui_image` varchar(200) NOT NULL,
  `qui_etat` char(1) NOT NULL,
  `qui_id` int(11) NOT NULL,
  `usr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `T_QUIZ_qui`
--

INSERT INTO `T_QUIZ_qui` (`qui_nom`, `qui_image`, `qui_etat`, `qui_id`, `usr_id`) VALUES
('The Merge', '280px-Shakhovite-81870.jpg', 'A', 1, 3),
('La technologie Blockchain !', 'image2', 'A', 2, 6),
('Mieux connaître le Bitcoin.', 'image', 'A', 3, 8),
('Les \"Wallets\", les nouveaux sauveurs de notre sécurité en ligne.', 'image', 'A', 4, 5),
('Smart Contract ?', 'test_quiz_image', 'A', 5, 8);

--
-- Déclencheurs `T_QUIZ_qui`
--
DELIMITER $$
CREATE TRIGGER `AjoutActuVeterant` AFTER INSERT ON `T_QUIZ_qui` FOR EACH ROW BEGIN
	CALL NOUVEAU_VETERANT(NEW.usr_id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `T_REPONSE_rep`
--

CREATE TABLE `T_REPONSE_rep` (
  `rep_intitule` varchar(200) NOT NULL,
  `rep_bonne_reponse` char(1) NOT NULL,
  `rep_id` int(11) NOT NULL,
  `que_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `T_REPONSE_rep`
--

INSERT INTO `T_REPONSE_rep` (`rep_intitule`, `rep_bonne_reponse`, `rep_id`, `que_id`) VALUES
('La fusion', '1', 1, 1),
('L\'ascension', '0', 2, 1),
('La Destruction', '0', 3, 1),
('La mise à jour', '0', 4, 1),
('12 octobre 2021', '0', 5, 2),
('12 octobre 2022', '0', 6, 2),
('15 septembre 2022', '1', 7, 2),
('23 juillet 2022', '0', 8, 2),
('50%', '0', 9, 3),
('Elle n\'a pas réduit sa consommation d\'énergie', '0', 10, 3),
('99%', '1', 11, 3),
('38,9%', '0', 12, 3),
('Le changement de consensus. PoW -> PoS', '1', 13, 4),
('L\'interface d\'Ethereum ', '0', 14, 4),
('Le nom de la blockchain.', '0', 15, 4),
('L\'historique des transactions effectués sur le réseau Ethereum', '0', 16, 4),
('The Surge', '1', 17, 5),
('The Verge', '0', 18, 5),
('The Purge', '0', 19, 5),
('The Splurge', '0', 20, 5),
('Une base de données distribuée', '1', 21, 6),
('Une base de données centralisée', '0', 22, 6),
('Une plateforme de E-commerce', '0', 23, 6),
('Un réseau social ', '0', 24, 6),
('Infalsifiables', '1', 25, 7),
('Falsifiables', '0', 26, 7),
('Supprimables', '0', 27, 7),
('altérable', '0', 28, 7),
('Smart Contract', '0', 29, 9),
('Proof of Work', '0', 30, 9),
('Backlog', '1', 31, 9),
('NFT', '0', 32, 9),
('Les informations ne peuvent plus être modifiées a posteriori.', '0', 33, 10),
('Les informations sont enregistrées de manière centralisée auprès de l’administrateur de la blockchain.', '1', 34, 10),
('Les informations ne peuvent plus être effacées a posteriori.', '0', 35, 10),
('Les informations sont enregistrées dans l’ordre chronologique.', '0', 36, 10),
('garantit qu’aucune information ne puisse être modifiée a posteriori.»', '1', 37, 8),
('est déficient car il a, par le passé, souvent été hacké.»', '0', 38, 8),
('devient plus simple si un nombre important de gens l’utilise.»', '0', 39, 8),
('sera inutile dans le futur.»', '0', 40, 8),
('BTC', '1', 41, 11),
('BTN', '0', 42, 11),
('BNC', '0', 43, 11),
('BTCN', '0', 44, 11),
('John Mac Coin', '0', 49, 12),
('Ross Ulbricht', '0', 50, 12),
('Satoshi Nakamoto', '1', 51, 12),
('Donald Fitz', '0', 52, 12),
('est le leader mondial', '0', 53, 13),
('a fermé suite à un piratage', '1', 54, 13),
('a été rachetée par Amazon', '0', 55, 13),
('est la seul a proposé du Bitcoin', '0', 56, 13),
('illimité', '0', 57, 14),
('21 millions', '1', 58, 14),
('réévalué tous les 12 janvier de chaque année', '0', 59, 14),
('45 millions', '0', 60, 14),
('MD4', '0', 61, 15),
('SHA-256', '1', 62, 15),
('TIGER', '0', 63, 15),
('HAVAR', '0', 64, 15),
('Le support utilisé pour stocker les informations', '1', 73, 16),
('L\'encodage des données', '0', 74, 16),
('Les données stockées', '0', 75, 16),
('Un wallet hardware stock seulement une clé privée', '0', 76, 16),
('un procédé de stockage supposément sécurisé, physique ou numérique, de cryptomonnaies.\"', '1', 77, 17),
('utilisé depuis des années dans la vie quotidienne des consommateurs.\"', '0', 78, 17),
('capable de se faire passer pour un clavier d\'ordinateur pour pirater une machine\"', '0', 79, 17),
('une clé usb\"', '0', 80, 17),
('Coinbase Wallet', '1', 81, 18),
('Ledger', '0', 82, 18),
('Trezor', '0', 83, 18),
('Coldcard', '0', 84, 18),
('Porte-feuille', '1', 85, 19),
('Carte Froide', '0', 86, 19),
('Enveloppe', '0', 87, 19),
('Classeur', '0', 88, 19),
('Stocker seulement des cryptomonnaies ', '0', 89, 20),
('Stocker seulement des cryptomonnaies et des NFT', '0', 90, 20),
('Stocker des clés permettant l\'authentification', '1', 91, 20),
('Stocker de l\'argent', '0', 92, 20);

-- --------------------------------------------------------

--
-- Structure de la table `T_UTILISATEUR_usr`
--

CREATE TABLE `T_UTILISATEUR_usr` (
  `usr_pseudo` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usr_mdp` char(64) NOT NULL,
  `usr_role` char(1) NOT NULL,
  `usr_etat` char(1) NOT NULL,
  `usr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `T_UTILISATEUR_usr`
--

INSERT INTO `T_UTILISATEUR_usr` (`usr_pseudo`, `usr_mdp`, `usr_role`, `usr_etat`, `usr_id`) VALUES
('responsable', '23b571434effc6f08fa2d1ad48bbe882ab53ec5bc6a8e5b5e7cc89a9fe5e2506', 'A', 'A', 1),
('Dupont', 'qbgdqd', 'A', 'A', 2),
('Lucie23', 'testqzdq', 'F', 'A', 3),
('Valerie12', 'test', 'A', 'A', 4),
('Jason', 'test', 'F', 'A', 5),
('Casey ', 'test', 'F', 'A', 6),
('Debbie', 'test', 'F', 'A', 7),
('Robin', 'test', 'F', 'A', 8),
('StevenT', '87f974589838fa2e1b0354653e999987c3300c633138f7b1e7b91c4bbf883cba', 'F', 'A', 15);

--
-- Déclencheurs `T_UTILISATEUR_usr`
--
DELIMITER $$
CREATE TRIGGER `HASH_MDP` BEFORE INSERT ON `T_UTILISATEUR_usr` FOR EACH ROW BEGIN
	SET NEW.usr_mdp = SHA2(CONCAT(NEW.usr_mdp,'CeciEstLeSel6549022*'),256);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la vue `LISTE_MAIL_PSEUDO`
--
DROP TABLE IF EXISTS `LISTE_MAIL_PSEUDO`;

CREATE ALGORITHM=UNDEFINED DEFINER=`ztalboust`@`%` SQL SECURITY DEFINER VIEW `LISTE_MAIL_PSEUDO`  AS SELECT `T_UTILISATEUR_usr`.`usr_pseudo` AS `usr_pseudo`, `T_PROFIL_pfl`.`pfl_mail` AS `pfl_mail` FROM (`T_UTILISATEUR_usr` join `T_PROFIL_pfl` on(`T_UTILISATEUR_usr`.`usr_id` = `T_PROFIL_pfl`.`usr_id`))  ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `T_JOUEUR_jou`
--
ALTER TABLE `T_JOUEUR_jou`
  ADD PRIMARY KEY (`jou_id`),
  ADD KEY `fk_T_JOUEUR_jou_T_MATCH_mat1_idx` (`mat_id`);

--
-- Index pour la table `T_MATCH_mat`
--
ALTER TABLE `T_MATCH_mat`
  ADD PRIMARY KEY (`mat_id`),
  ADD UNIQUE KEY `mat_code` (`mat_code`),
  ADD KEY `fk_T_MATCH_mat_T_UTILISATEUR_usr1_idx` (`usr_id`),
  ADD KEY `fk_T_MATCH_mat_T_QUIZ_qui1_idx` (`qui_id`);

--
-- Index pour la table `T_NEWS_new`
--
ALTER TABLE `T_NEWS_new`
  ADD PRIMARY KEY (`new_id`),
  ADD KEY `fk_T_NEWS_new_T_UTILISATEUR_usr1_idx` (`usr_id`);

--
-- Index pour la table `T_PROFIL_pfl`
--
ALTER TABLE `T_PROFIL_pfl`
  ADD PRIMARY KEY (`pfl_id`),
  ADD UNIQUE KEY `usr_id` (`usr_id`),
  ADD KEY `fk_T_PROFIL_pfl_T_UTILISATEUR_usr1_idx` (`usr_id`);

--
-- Index pour la table `T_QUESTION_que`
--
ALTER TABLE `T_QUESTION_que`
  ADD PRIMARY KEY (`que_id`),
  ADD KEY `fk_T_QUESTION_que_T_QUIZ_qui1_idx` (`qui_id`);

--
-- Index pour la table `T_QUIZ_qui`
--
ALTER TABLE `T_QUIZ_qui`
  ADD PRIMARY KEY (`qui_id`),
  ADD KEY `fk_T_QUIZ_qui_T_UTILISATEUR_usr1_idx` (`usr_id`);

--
-- Index pour la table `T_REPONSE_rep`
--
ALTER TABLE `T_REPONSE_rep`
  ADD PRIMARY KEY (`rep_id`),
  ADD KEY `fk_T_REPONSE_rep_T_QUESTION_que1_idx` (`que_id`);

--
-- Index pour la table `T_UTILISATEUR_usr`
--
ALTER TABLE `T_UTILISATEUR_usr`
  ADD PRIMARY KEY (`usr_id`),
  ADD UNIQUE KEY `usr_id_UNIQUE` (`usr_id`),
  ADD UNIQUE KEY `usr_pseudo` (`usr_pseudo`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `T_JOUEUR_jou`
--
ALTER TABLE `T_JOUEUR_jou`
  MODIFY `jou_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT pour la table `T_MATCH_mat`
--
ALTER TABLE `T_MATCH_mat`
  MODIFY `mat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `T_NEWS_new`
--
ALTER TABLE `T_NEWS_new`
  MODIFY `new_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT pour la table `T_PROFIL_pfl`
--
ALTER TABLE `T_PROFIL_pfl`
  MODIFY `pfl_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `T_QUESTION_que`
--
ALTER TABLE `T_QUESTION_que`
  MODIFY `que_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `T_QUIZ_qui`
--
ALTER TABLE `T_QUIZ_qui`
  MODIFY `qui_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `T_REPONSE_rep`
--
ALTER TABLE `T_REPONSE_rep`
  MODIFY `rep_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT pour la table `T_UTILISATEUR_usr`
--
ALTER TABLE `T_UTILISATEUR_usr`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `T_JOUEUR_jou`
--
ALTER TABLE `T_JOUEUR_jou`
  ADD CONSTRAINT `fk_T_JOUEUR_jou_T_MATCH_mat1` FOREIGN KEY (`mat_id`) REFERENCES `T_MATCH_mat` (`mat_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `T_MATCH_mat`
--
ALTER TABLE `T_MATCH_mat`
  ADD CONSTRAINT `fk_T_MATCH_mat_T_QUIZ_qui1` FOREIGN KEY (`qui_id`) REFERENCES `T_QUIZ_qui` (`qui_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_T_MATCH_mat_T_UTILISATEUR_usr1` FOREIGN KEY (`usr_id`) REFERENCES `T_UTILISATEUR_usr` (`usr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `T_NEWS_new`
--
ALTER TABLE `T_NEWS_new`
  ADD CONSTRAINT `fk_T_NEWS_new_T_UTILISATEUR_usr1` FOREIGN KEY (`usr_id`) REFERENCES `T_UTILISATEUR_usr` (`usr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `T_PROFIL_pfl`
--
ALTER TABLE `T_PROFIL_pfl`
  ADD CONSTRAINT `fk_T_PROFIL_pfl_T_UTILISATEUR_usr1` FOREIGN KEY (`usr_id`) REFERENCES `T_UTILISATEUR_usr` (`usr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `T_QUESTION_que`
--
ALTER TABLE `T_QUESTION_que`
  ADD CONSTRAINT `fk_T_QUESTION_que_T_QUIZ_qui1` FOREIGN KEY (`qui_id`) REFERENCES `T_QUIZ_qui` (`qui_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `T_QUIZ_qui`
--
ALTER TABLE `T_QUIZ_qui`
  ADD CONSTRAINT `fk_T_QUIZ_qui_T_UTILISATEUR_usr1` FOREIGN KEY (`usr_id`) REFERENCES `T_UTILISATEUR_usr` (`usr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `T_REPONSE_rep`
--
ALTER TABLE `T_REPONSE_rep`
  ADD CONSTRAINT `fk_T_REPONSE_rep_T_QUESTION_que1` FOREIGN KEY (`que_id`) REFERENCES `T_QUESTION_que` (`que_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
