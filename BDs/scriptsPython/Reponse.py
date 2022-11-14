"""
Fichier contenant la classe Reponse
"""

from main import ecrireDansFichier


class Reponse:
    """
    Classe représentant une réponse à une question.

    Code SQL de la table REPONSE:
    create table if not exists REPONSE (
        label_reponse TEXT PRIMARY KEY
    );

    Nous avons choisi de mettre le label de la réponse en clé primaire car il est unique afin d'éviter les doublons.

    Attributes:
        label_reponse (str): Label de la réponse
    """
    def __init__(self, label_reponse: str):
        self.label_reponse = label_reponse

        message = f"-- INSERT Réponse {self.label_reponse} --\n" \
                  f"INSERT INTO REPONSE VALUES ('{self.label_reponse}');\n"

        ecrireDansFichier(message)
        print(message)

    def __str__(self):
        """
        Méthode permettant d'afficher les informations de la réponse

        Returns:
            str: label de la réponse
        """
        return self.label_reponse

    def __repr__(self):
        """
        Méthode permettant d'afficher les informations de la réponse

        Returns:
            str: label de la réponse
        """
        return self.label_reponse
