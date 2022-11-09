
-- Création des tables


-- Etudiant = (idEtudiant NUMBER(6), nom VARCHAR2(50), prenom VARCHAR2(50), formation VARCHAR2(50), td NUMBER(2), tp NUMBER(2));

create table ETUDIANT (
    idEtudiant NUMBER(6) primary key,
    nom VARCHAR2(50) not null,
    prenom VARCHAR2(50) not null,
    formation VARCHAR2(50),
    td NUMBER(2),
    tp NUMBER(2)
)

-- Enseignant = (idEnseignant VARCHAR2(50), nom VARCHAR2(50), prenom VARCHAR2(50), matiere VARCHAR2(50), nationalité VARCHAR2(50));

create table ENSEIGNANT(
    idEnseignant VARCHAR2(50) primary key,
    nom VARCHAR2(50) not null,
    prenom VARCHAR2(50) not null,
    matiere VARCHAR2(50) not null,
    nationalité VARCHAR2(50) 

)


-- Depot = (idDepot VARCHAR2(50), statut BOLEEAN, dateOuverture DATETIME, dateFermeture VARCHAR2(50), #idEnseignant);

create table DEPOT(
    idDepot VARCHAR2(50) primary key,
    statut BOLEEAN not null,
    dateOuverture DATETIME not null,
    dateFermeture DATETIME not null,
    idEnseignant VARCHAR2(50) not null,
    foreign key (idEnseignant) references ENSEIGNANT(idEnseignant)
)

-- Reponse = (label VARCHAR2(50));

create table REPONSE(
    label VARCHAR2(50) primary key
)


-- Tag = (idTag NUMBER(3), label VARCHAR2(50), #idEnseignant);

create table TAG(
    idTag NUMBER(3) primary key,
    label VARCHAR2(50) not null,
    idEnseignant VARCHAR2(50) not null,
    foreign key (idEnseignant) references ENSEIGNANT(idEnseignant)
)

QCM = (idQCM VARCHAR2(50), titre VARCHAR2(50), description VARCHAR2(50), etat BOOLEAN, #idEnseignant);

create table QCM(
    idQCM VARCHAR2(50) primary key,
    titre VARCHAR2(50) not null,
    description VARCHAR2(50) not null,
    etat BOOLEAN not null,
    idEnseignant VARCHAR2(50) not null,
    foreign key (idEnseignant) references ENSEIGNANT(idEnseignant)
)

-- difficulte = (id NUMBER(1), label VARCHAR2(50));

create table DIFFICULTE(
    id NUMBER(1) primary key,
    label VARCHAR2(50) not null
)

type = (idType NUMBER(2), label VARCHAR2(50));

create table TYPE(
    idType NUMBER(2) primary key,
    label VARCHAR2(50) not null
)

question = (idQuestion NUMBER(4), titre VARCHAR2(50), etat VARCHAR2(50), #idType, #idDifficulte, #idEtudiant, #idDepot, #idEnseignant);

create table QUESTION(
    idQuestion NUMBER(4) primary key,
    titre VARCHAR2(50) not null,
    etat VARCHAR2(50) not null,
    idType NUMBER(2) not null,
    idDifficulte NUMBER(1) not null,
    idEtudiant NUMBER(6) not null,
    idDepot VARCHAR2(50) not null,
    idEnseignant VARCHAR2(50) not null,
    foreign key (idType) references TYPE(idType),
    foreign key (idDifficulte) references DIFFICULTE(id),
    foreign key (idEtudiant) references ETUDIANT(idEtudiant),
    foreign key (idDepot) references DEPOT(idDepot),
    foreign key (idEnseignant) references ENSEIGNANT(idEnseignant)
)

-- avoir = (#idQuestion, #idReponse, etatDeVerite BOOLEAN);

create table AVOIR(
    idQuestion NUMBER(4) not null,
    idReponse VARCHAR2(50) not null,
    etatDeVerite BOOLEAN not null,
    primary key (idQuestion, idReponse),
    foreign key (idQuestion) references QUESTION(idQuestion),
    foreign key (idReponse) references REPONSE(label)
)


-- lier = (#idQuestion, #idTag);

create table LIER(
    idQuestion NUMBER(4) not null,
    idTag NUMBER(3) not null,
    primary key (idQuestion, idTag),
    foreign key (idQuestion) references QUESTION(idQuestion),
    foreign key (idTag) references TAG(idTag)
)

-- etre = (#idQuestion, #idQCM, nbTentativeTotal NUMBER(4), nbTentativeReussit NUMBER(4));

create table ETRE(
    idQuestion NUMBER(4) not null,
    idQCM VARCHAR2(50) not null,
    nbTentativeTotal NUMBER(4) not null,
    nbTentativeReussit NUMBER(4) not null,
    primary key (idQuestion, idQCM),
    foreign key (idQuestion) references QUESTION(idQuestion),
    foreign key (idQCM) references QCM(idQCM)
)

-- entrainer = (#idEtudiant, #idQCM, tempsPasse TIME, score NUMBER(4,2));

create table ENTRAINER(
    idEtudiant NUMBER(6) not null,
    idQCM VARCHAR2(50) not null,
    tempsPasse TIME not null,
    score NUMBER(4,2) not null,
    primary key (idEtudiant, idQCM),
    foreign key (idEtudiant) references ETUDIANT(idEtudiant),
    foreign key (idQCM) references QCM(idQCM)
)


-- Selection de chaque table 

select * from ETUDIANT;
select * from ENSEIGNANT;
select * from DEPOT;
select * from REPONSE;
select * from TAG;
select * from QCM;
select * from DIFFICULTE;
select * from TYPE;
select * from QUESTION;
select * from AVOIR;
select * from LIER;
select * from ETRE;
select * from ENTRAINER;
