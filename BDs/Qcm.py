"""
Fichier contenant la classe Qcm, détaillée plus bas.
"""

from main import ecrireDansFichier
from Question import Question


class Qcm:
    """
    Classe représentant un QCM.

    Code SQL de la table QCM:
    create table if not exists QCM (
        id_qcm TEXT PRIMARY KEY,
        titre TEXT NOT NULL,
        description TEXT NOT NULL,
        etat_b INTEGER NOT NULL DEFAULT 0 CHECK (etat_b IN (0, 1)),
        id_enseignant TEXT NOT NULL,

        FOREIGN KEY (id_enseignant) REFERENCES ENSEIGNANT(id_enseignant)
    );

    Attributes:
        id_qcm (str): Identifiant du QCM
        titre (str): Titre du QCM
        description (str): Description du QCM
        etat_b (bool): Etat du QCM (ouvert/fermé)
        id_enseignant (str): Identifiant de l'enseignant
    """

    def __init__(
            self,
            id_qcm: str,
            titre: str,
            description: str,
            etat_b: bool,
            id_enseignant: str
    ):
        """Constructeur de la classe Qcm"""
        self.id_qcm = id_qcm
        self.titre = titre
        self.description = description
        self.etat_b = etat_b
        self.id_enseignant = id_enseignant

        self.questions = []

        message = f"-- INSERT QCM {self.id_qcm} --\n" \
                  f"INSERT INTO QCM VALUES ('{self.id_qcm}', '{self.titre}', '{self.description}', {self.etat_b}, '{self.id_enseignant}');\n"

        ecrireDansFichier(message)
        print(message)

    def lier_questions(self, *questions):
        """
        Méthode permettant de lier une ou plusieurs questions au QCM

        Args:
            *questions (Question): Questions à lier au QCM

        Returns:

        """
        for question in questions:
            self.questions.append(question)

    def __str__(self):
        """
        Méthode permettant d'afficher les informations du QCM

        Returns:
            str: id du QCM
        """
        return self.id_qcm

    def __repr__(self):
        """
        Méthode permettant d'afficher les informations du QCM

        Returns:
            str: id du QCM
        """
        return self.id_qcm
