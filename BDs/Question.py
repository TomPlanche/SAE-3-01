
from enum import Enum


class GeneralQuestion(Enum):
    def __str__(self):
        return str(self.name).lower()


class Etat(GeneralQuestion):
    a_verifier = 1
    modifiee = 2
    acceptee = 3


class Difficulte(GeneralQuestion):
    facile = 1
    moyen = 2
    difficile = 3


class Type(GeneralQuestion):
    qcm = 1
    qcu = 2
    flashcard = 3


class Question:
    def __init__(
            self,
            id_question,
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

        self.reponses = []
        self.tags = []

    def lier_reponse(self, reponse):
        """
        Lier les réponses à la question
        :param reponss: Une Réponses
        :type reponse: dict
        """
        self.reponses.append(reponse)

    def lier_tags(self, *tags):
        """
        Lier les tags à la question
        :param tags: Une liste de tags
        :type tags: list
        """
        for tag in tags:
            self.tags.append(tag)

    def creer_question(self) -> str:
        """
        Création de la question en SQLite
        :return: Requête SQL
        :rtype: str
        """

        message = ""

        message += "INSERT INTO Question values (" \
                        f"'{self.id_question}', " \
                        f"'{self.etat_question}', " \
                        f"'{self.titre}', " \
                        f"'{self.id_typeQuestion}', " \
                        f"'{self.difficulte}', " \
                        f"'{self.id_etudiant}', " \
                        f"'{self.id_depot}'" \
                        ");\n" \

        for reponse in self.reponses:
            print(reponse)
            message += "INSERT INTO QUESTION_A_REPONSE values (" \
                            f"'{self.id_question}', " \
                            f"'{reponse['id_reponse']}'," \
                            f"{int(reponse['est_bonne'])}" \
                            ");\n"

        for tag in self.tags:
            message += "INSERT INTO TAG_LIE_A_QUESTION values (" \
                            f"'{self.id_question}', " \
                            f"'{tag.nom_tag}'" \
                            ");\n"

        with open("./scriptSQLOEOEOE.txt", "a") as f:
            f.write(message)

        print(message)
