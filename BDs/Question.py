"""
Fichier contenant la classe Question
"""


from enum import Enum
from Reponse import Reponse
from Tag import Tag
from main import ecrireDansFichier


class GeneralEnum(Enum):
    """
    Classe représentant une question Générale.
    Utilisée afin de regrouper les questions pour la méthode 'str'.
    """
    def __str__(self):
        """
        Méthode permettant d'afficher le nom du type énuméré
        Returns:
            str: Nom du type énuméré
        """
        return str(self.name).lower()


class Etat(GeneralEnum):
    """
    Classe représentant l'état d'une question.
    """
    a_verifier = 1
    modifiee = 2
    acceptee = 3


class Difficulte(GeneralEnum):
    """
    Classe représentant la difficulté d'une question.
    """
    facile = 1
    moyen = 2
    difficile = 3


class Type(GeneralEnum):
    """
    Classe représentant le type d'une question.
    """
    qcm = 1
    qcu = 2
    flashcard = 3


class Question:
    """
    Classe représentant une question QCM.

    Code SQL de la table QUESTION:
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

    Attributes:
        id_question (str): Identifiant de la question
        etat_question (Etat): Etat de la question
        titre (str): Titre de la question
        id_typeQuestion (str): Identifiant du type de question
        difficulte (Difficulte): Difficulté de la question
        id_etudiant (str): Identifiant de l'étudiant
        id_depot (str): Identifiant du dépôt
    """
    def __init__(
            self,
            id_question: str,
            etat_question: Etat,
            titre: str,
            id_typeQuestion: str,
            difficulte: Difficulte,
            id_etudiant: str,
            id_depot: str
    ):
        self.id_question = id_question
        self.etat_question = etat_question
        self.titre = titre
        self.id_typeQuestion = id_typeQuestion
        self.difficulte = difficulte
        self.id_etudiant = id_etudiant
        self.id_depot = id_depot

        # Liste des réponses
        self.reponses = []
        # Liste des tags
        self.tags = []

    def lier_reponse(self, reponse: Reponse) -> None:
        """
        Lier une réponse à la question

        Args:
            reponse (Reponse): Réponse à lier

        Returns:
            None
        """
        self.reponses.append(reponse)

    def lier_tags(self, *tags: Tag) -> None:
        """
        Lier des tags à la question

        Args:
            *tags (Tag): Tags à lier

        Returns:
            None
        """
        for tag in tags:
            self.tags.append(tag)

    def creer_question(self) -> None:
        """
        Créer la question dans la base de données

        Returns:
            None
        """

        message = f"-- INSERT QUESTION {self.id_question} --\n"

        message += "INSERT INTO QUESTION values ("\
                   f"'{self.id_question}', "\
                   f"'{self.etat_question}', "\
                   f"'{self.titre}', "\
                   f"'{self.id_typeQuestion}', "\
                   f"'{self.difficulte}', "\
                   f"'{self.id_etudiant}', "\
                   f"'{self.id_depot}'"\
                   ");\n"

        for reponse in self.reponses:
            print(reponse)
            message += "-- INSERT QUESTION_A_REPONSE\n"\
                       "INSERT INTO QUESTION_A_REPONSE values ("\
                       f"'{self.id_question}', "\
                       f"'{reponse['id_reponse']}',"\
                       f"{int(reponse['est_bonne'])}"\
                       ");\n"

        for tag in self.tags:
            message += "-- INSERT TAG_LIE_A_QUESTION\n"\
                       "INSERT INTO TAG_LIE_A_QUESTION values ("\
                       f"'{self.id_question}', "\
                       f"'{tag.nom_tag}'"\
                       ");\n"

        ecrireDansFichier(message)
        print(message)
