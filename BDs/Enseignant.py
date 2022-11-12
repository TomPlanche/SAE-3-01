"""
Fichier contenant la classe Enseignant, détaillée plus bas.
"""

from main import ecrireDansFichier


class Enseignant:
    """
    Classe représentant un enseignant.

    Code SQL de la table ENSEIGNANT:
    create table if not exists ENSEIGNANT (
        id_enseignant TEXT PRIMARY KEY,
        nom_enseignnat TEXT NOT NULL,
        prenom_enseignant TEXT NOT NULL,
        matiere TEXT NOT NULL,
        nationalite TEXT NOT NULL
    );

    Attributes:
        id_enseignant (str): Identifiant de l'enseignant
        nom_enseignant (str): Nom de l'enseignant
        prenom_enseignant (str): Prénom de l'enseignant
        matiere (str): Matière enseignée
        nationalite (str): Nationalité de l'enseignant
    """
    def __init__(
            self,
            id_enseignant: str,
            nom_enseignant: str,
            prenom_enseignant: str,
            matiere: str,
            nationalite: str
    ):
        """Constructeur de la classe Enseignant"""
        self.id_enseignant = id_enseignant
        self.nom_enseignant = nom_enseignant
        self.prenom_enseignant = prenom_enseignant
        self.matiere = matiere
        self.nationalite = nationalite

        # Code SQL pour insérer un nouvel enseignant
        message = f"-- INSERT Enseignant {self.id_enseignant} --\n" \
                  f"INSERT INTO ENSEIGNANT VALUES ('{self.id_enseignant}', '{self.nom_enseignant}', '{self.prenom_enseignant}', '{self.matiere}', '{self.nationalite}');\n"

        # Écriture du code SQL dans le fichier
        ecrireDansFichier(message)

        print(message)

    def __str__(self):
        """
        Fonction permettant d'afficher un enseignant

        Returns:
            str: id de l'enseignant
        """
        return self.id_enseignant

    def __repr__(self):
        """
        Fonction permettant d'afficher un enseignant

        Returns:
            str: id de l'enseignant
        """
        return self.id_enseignant
