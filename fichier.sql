Etudiant = (idEtudiant VARCHAR(50), nom VARCHAR(50), prenom VARCHAR(50), formation VARCHAR(50), td VARCHAR(50), tp VARCHAR(50));
Enseignant = (idEnseignant VARCHAR(50), nom VARCHAR(50), prenom VARCHAR(50), matiere VARCHAR(50), formation VARCHAR(50), nationalité VARCHAR(50));
Depot = (idDepot VARCHAR(50), status LOGICAL, dateOuverture DATETIME, dateFermeture VARCHAR(50), #idEnseignant);
Reponse = (label VARCHAR(50));
Tag = (idTag VARCHAR(50), label VARCHAR(50));
QCM = (idQCM VARCHAR(50), titre VARCHAR(50), description VARCHAR(50), etat VARCHAR(50), #idEnseignant);
difficulte = (id INT, label VARCHAR(50));
type = (idType INT, label VARCHAR(50));
question = (idQuestion VARCHAR(50), titre VARCHAR(50), etat VARCHAR(50), #idType, #id, #idEtudiant, #idDepot, #idEnseignant);
avoir = (#idQuestion, #label, etatDeVerite LOGICAL);
lier = (#idQuestion, #idTag);
etre = (#idQuestion, #idQCM, nbTentativeTotal INT, nbTentativeReussit INT);
s_entrainer = (#idEtudiant, #idQCM, tempsPasse VARCHAR(50), score VARCHAR(50));
creer = (#idEnseignant, #idTag);

-- 3.7.	Script SQL des tables

CREATE TABLE Etudiant(
   idEtudiant VARCHAR(50),
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50),
   formation VARCHAR(50) NOT NULL,
   td VARCHAR(50),
   tp VARCHAR(50),
   PRIMARY KEY(idEtudiant)
);

CREATE TABLE Enseignant(
   idEnseignant VARCHAR(50),
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   matiere VARCHAR(50) NOT NULL,
   formation VARCHAR(50) NOT NULL,
   nationalité VARCHAR(50) NOT NULL,
   PRIMARY KEY(idEnseignant)
);

CREATE TABLE Depot(
   idDepot VARCHAR(50),
   status LOGICAL NOT NULL,
   dateOuverture DATETIME NOT NULL,
   dateFermeture VARCHAR(50) NOT NULL,
   idEnseignant VARCHAR(50) NOT NULL,
   PRIMARY KEY(idDepot),
   FOREIGN KEY(idEnseignant) REFERENCES Enseignant(idEnseignant)
);

CREATE TABLE Reponse(
   label VARCHAR(50),
   PRIMARY KEY(label)
);

CREATE TABLE Tag(
   idTag VARCHAR(50),
   label VARCHAR(50) NOT NULL,
   PRIMARY KEY(idTag)
);

CREATE TABLE QCM(
   idQCM VARCHAR(50),
   titre VARCHAR(50) NOT NULL,
   description VARCHAR(50) NOT NULL,
   etat VARCHAR(50) NOT NULL,
   idEnseignant VARCHAR(50) NOT NULL,
   PRIMARY KEY(idQCM),
   FOREIGN KEY(idEnseignant) REFERENCES Enseignant(idEnseignant)
);

CREATE TABLE difficulte(
   id INT,
   label VARCHAR(50) NOT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE type(
   idType INT,
   label VARCHAR(50) NOT NULL,
   PRIMARY KEY(idType)
);

CREATE TABLE question(
   idQuestion VARCHAR(50),
   titre VARCHAR(50) NOT NULL,
   etat VARCHAR(50) NOT NULL,
   idType INT NOT NULL,
   id INT NOT NULL,
   idEtudiant VARCHAR(50) NOT NULL,
   idDepot VARCHAR(50) NOT NULL,
   idEnseignant VARCHAR(50) NOT NULL,
   PRIMARY KEY(idQuestion),
   FOREIGN KEY(idType) REFERENCES type(idType),
   FOREIGN KEY(id) REFERENCES difficulte(id),
   FOREIGN KEY(idEtudiant) REFERENCES Etudiant(idEtudiant),
   FOREIGN KEY(idDepot) REFERENCES Depot(idDepot),
   FOREIGN KEY(idEnseignant) REFERENCES Enseignant(idEnseignant)
);

CREATE TABLE avoir(
   idQuestion VARCHAR(50),
   label VARCHAR(50),
   etatDeVerite LOGICAL NOT NULL,
   PRIMARY KEY(idQuestion, label),
   FOREIGN KEY(idQuestion) REFERENCES question(idQuestion),
   FOREIGN KEY(label) REFERENCES Reponse(label)
);

CREATE TABLE lier(
   idQuestion VARCHAR(50),
   idTag VARCHAR(50),
   PRIMARY KEY(idQuestion, idTag),
   FOREIGN KEY(idQuestion) REFERENCES question(idQuestion),
   FOREIGN KEY(idTag) REFERENCES Tag(idTag)
);

CREATE TABLE etre(
   idQuestion VARCHAR(50),
   idQCM VARCHAR(50),
   nbTentativeTotal INT NOT NULL,
   nbTentativeReussit INT NOT NULL,
   PRIMARY KEY(idQuestion, idQCM),
   FOREIGN KEY(idQuestion) REFERENCES question(idQuestion),
   FOREIGN KEY(idQCM) REFERENCES QCM(idQCM)
);

CREATE TABLE s_entrainer(
   idEtudiant VARCHAR(50),
   idQCM VARCHAR(50),
   tempsPasse VARCHAR(50),
   score VARCHAR(50),
   PRIMARY KEY(idEtudiant, idQCM),
   FOREIGN KEY(idEtudiant) REFERENCES Etudiant(idEtudiant),
   FOREIGN KEY(idQCM) REFERENCES QCM(idQCM)
);

CREATE TABLE creer(
   idEnseignant VARCHAR(50),
   idTag VARCHAR(50),
   PRIMARY KEY(idEnseignant, idTag),
   FOREIGN KEY(idEnseignant) REFERENCES Enseignant(idEnseignant),
   FOREIGN KEY(idTag) REFERENCES Tag(idTag)
);


-- Un étudiant devra pouvoir :
-- -	Voir tous les QCM d’un enseignant.
select * from QCM where idEnseignant = 'idEnseignant';
-- -	Ajouter une question (à un dépôt (étudiant), à un/des QCM(s)). 
insert into question values ('idQuestion', 'titre', 'etat', 'idType', 'id', 'idEtudiant', 'idDepot', 'idEnseignant');
-- Un enseignant devra pouvoir :
-- -	Supprimer une question.
delete from question where idQuestion = 'idQuestion';
-- -	Modifier une question (tags / contenu / état (proposée, refusée)).
update question set titre = 'titre', etat = 'etat', idType = 'idType', id = 'id', idEtudiant = 'idEtudiant', idDepot = 'idDepot', idEnseignant = 'idEnseignant' where idQuestion = 'idQuestion';
-- -	Ajouter un nouveau tag
insert into Tag values ('idTag', 'label');
-- -	Modifier un tag mal formulé
update Tag set label = 'label' where idTag = 'idTag';
-- -	Supprimer un tag obsolète 
delete from Tag where idTag = 'idTag';
-- -	Créer un dépôt pour les étudiants
insert into Depot values ('idDepot', 'status', 'dateOuverture', 'dateFermeture', 'idEnseignant');

-- Pour récupérer des statistiques il faudra :
-- -	Voir le nombre d’étudiants qui ont répondu à un QCM précis.
select count(*) from s_entrainer where idQCM = 'idQCM';
-- -	Voir qui n’a pas répondu / qui a le + de tentatives.
select * from s_entrainer where idQCM = 'idQCM' order by nbTentativeTotal desc;
-- -	Voir la question-là plus/moins réussie.
select * from s_entrainer where idQCM = 'idQCM' order by score desc;
