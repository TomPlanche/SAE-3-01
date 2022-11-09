
from Depot import Depot
from Enseignant import Enseignant
from Etudiant import Etudiant
from Qcm import Qcm
from Question import Question, Etat, Difficulte, Type
from Reponse import Reponse
from Tag import Tag

def dropAndCreateClasses():
    # erase all things in file
    with open("./scriptSQLOEOEOE.txt", "w") as f:
        f.write("")

    message = """drop table if exists ETUDIANT;
drop table if exists ENSEIGNANT;
drop table if exists DEPOT;
drop table if exists REPONSE;
drop table if exists TAG;
drop table if exists QCM;
drop table if exists QUESTION;
drop table if exists QUESTION_A_REPONSE;
drop table if exists TAG_LIE_A_QUESTION;
drop table if exists QUESTION_LIEE_A_QCM;
drop table if exists TYPE_QUESTION;
drop table if exists SENTRAINE;

create table if not exists ETUDIANT (
    id_etudiant TEXT PRIMARY KEY,
    nom_etudiant TEXT NOT NULL,
    prenom_etudiant TEXT NOT NULL,
    td INTEGER NOT NULL,
    tp INTEGER NOT NULL
);

create table if not exists ENSEIGNANT (
    id_enseignant TEXT PRIMARY KEY,
    nom_enseignnat TEXT NOT NULL,
    prenom_enseignant TEXT NOT NULL,
    matiere TEXT NOT NULL,
    nationalite TEXT NOT NULL
);

create table if not exists DEPOT (
    id_depot TEXT PRIMARY KEY,
    statut_b INTEGER NOT NULL DEFAULT 0 CHECK (statut_b IN (0, 1)),
    date_ouverture DATE NOT NULL,
    date_fermeture DATE NOT NULL,
    id_enseignant TEXT NOT NULL,

    FOREIGN KEY (id_enseignant) REFERENCES ENSEIGNANT(id_enseignant)
);

create table if not exists REPONSE (
    label_reponse TEXT PRIMARY KEY
);

create table if not exists TAG (
    nom_tag TEXT PRIMARY KEY,
    id_enseignant TEXT NOT NULL,

    FOREIGN KEY (id_enseignant) REFERENCES ENSEIGNANT(id_enseignant)
);

create table if not exists QCM (
    id_qcm TEXT PRIMARY KEY,
    titre TEXT NOT NULL,
    description TEXT NOT NULL,
    etat_b INTEGER NOT NULL DEFAULT 0 CHECK (etat_b IN (0, 1)),
    id_enseignant TEXT NOT NULL,

    FOREIGN KEY (id_enseignant) REFERENCES ENSEIGNANT(id_enseignant)
);


create table if not exists TYPE_QUESTION (
    id_type_question TEXT PRIMARY KEY,
    nom_type_question TEXT NOT NULL
);


create table if not exists QUESTION (
    id_question TEXT primary key,
    etat_question TEXT not null check  (lower(etat_question) IN ('a_verifier', 'modifiee', 'acceptee')),
    titre_question TEXT not null,
    id_type TEXT not null,
    difficulte TEXT not null default 'facile' check ( lower(difficulte) IN ('facile', 'moyen', 'difficile')),
    id_etudiant TEXT not null,
    id_depot TEXT not null,

    foreign key (id_type) references TYPE_QUESTION(id_type_question),
    foreign key (id_etudiant) references ETUDIANT(id_etudiant) ,
    foreign key (id_depot) references DEPOT(id_depot)
);

create table if not exists QUESTION_A_REPONSE (
    id_question TEXT not null,
    id_reponse TEXT not null,
    etat_veritee INTEGER not null default 0 check (etat_veritee IN (0, 1)),

    primary key (id_question, id_reponse),
    foreign key (id_question) references QUESTION(id_question),
    foreign key (id_reponse) references REPONSE(label_reponse)
);

create table if not exists TAG_LIE_A_QUESTION (
    id_question TEXT not null,
    nom_tag TEXT not null,

    foreign key (id_question) references QUESTION(id_question),
    foreign key (nom_tag) references TAG(nom_tag)
);

create table if not exists QUESTION_LIEE_A_QCM (
    id_question TEXT not null,
    id_qcm TEXT not null,

    foreign key (id_question) references QUESTION(id_question),
    foreign key (id_qcm) references QCM(id_qcm)
);


create table if not exists SENTRAINE (
    id_etudiant TEXT not null,
    id_qcm TEXT not null,
    -- date_debut DATE - date de debut de l'entrainement
    date_debut DATE not null,
    date_fin DATE,
    note INTEGER ,

    foreign key (id_etudiant) references ETUDIANT(id_etudiant),
    foreign key (id_qcm) references QCM(id_qcm)
);\n"""
    with open("./scriptSQLOEOEOE.txt", "a") as f:
        f.write(message)
        print(message)


if __name__ == '__main__':
    dropAndCreateClasses()

    etudiant_1 = Etudiant("ET0001", "Planche", "Tom", 1, 2)
    etudiant_2 = Etudiant("ET0002", "Montbord", "Tom", 1, 2)
    etudiant_3 = Etudiant("ET0004", "Hériveau", "Mathis", 1, 2)

    enseignant_1 = Enseignant("EN0001", "Bruyère", "Marie", "Mathématiques", "Française")
    enseignant_2 = Enseignant("EN0002", "Marquesuzaà", "Christophe", "Chef de département - Gestion de projet", "Française")
    enseignant_3 = Enseignant("EN0003", "Etchevery", "Patrick", "Programmation", "Française")

    depot_1 = Depot("DEP0001", True, enseignant_1)

    reponse_vrai = Reponse("Vrai")
    reponse_faux = Reponse("Faux")

    tag_1 = Tag("Mathématiques", enseignant_1)
    tag_2 = Tag("Programmation", enseignant_3)

    qcm_1 = Qcm("QCM0001", "QCM 1", "QCM 1", True, enseignant_1)

    for i, type in enumerate(Type):
        with open("./scriptSQLOEOEOE.txt", "a") as f:
            f.write(f"INSERT INTO TYPE_QUESTION VALUES ('TQ00{i + 1}', '{type.name}');\n")
        print(f"INSERT INTO TYPE_QUESTION VALUES ('TQ00{i + 1}', '{type.name}')")

    question_1 = Question(
            "Q0001",
            Etat.a_verifier,
            "Question 1",
            Type.qcm,
            Difficulte.facile,
            etudiant_1,
            qcm_1
    )

    question_1.lier_reponse({"id_reponse": reponse_vrai, "est_bonne": True})
    question_1.lier_reponse({"id_reponse": reponse_faux, "est_bonne": False})
    question_1.lier_tags(tag_1, tag_2)

    question_1.creer_question()

