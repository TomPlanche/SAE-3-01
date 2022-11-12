"""
Fichier contenant la classe Tag
"""

from main import ecrireDansFichier


class Tag:
    """
    Classe représentant un tag d'une question.

    Code SQL de la table TAG:
    create table if not exists TAG (
        nom_tag TEXT PRIMARY KEY,
        id_enseignant TEXT NOT NULL,

        FOREIGN KEY (id_enseignant) REFERENCES ENSEIGNANT(id_enseignant)
    );

    Attributes:
        nom_tag (str): Nom du tag
        id_enseignant (str): Identifiant de l'enseignant
    """
    def __init__(self, nom_tag: str, id_enseignant: str):
        self.nom_tag = nom_tag
        self.id_enseignant = id_enseignant

        message = f"-- INSERT Tag {self.nom_tag} --\n" \
                  f"INSERT INTO TAG VALUES ('{self.nom_tag}', '{self.id_enseignant}');\n"

        ecrireDansFichier(message)
        print(message)

    def __str__(self):
        """
        Méthode permettant d'afficher les informations du tag

        Returns:
            str: nom du tag
        """
        return self.nom_tag

    def __repr__(self):
        """
        Méthode permettant d'afficher les informations du tag

        Returns:
            str: nom du tag
        """
