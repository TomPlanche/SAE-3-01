"""
Fichier contenant la classe Etudiant
"""

from main import ecrireDansFichier


class Etudiant:
    """
    Classe représentant un étudiant.

    Code SQL de la table ETUDIANT:
    create table if not exists ETUDIANT (
        id_etudiant TEXT PRIMARY KEY,
        nom_etudiant TEXT NOT NULL,
        prenom_etudiant TEXT NOT NULL,
        td INTEGER NOT NULL,
        tp INTEGER NOT NULL
    );

    Attributes:
        id_etudiant (str): Identifiant de l'étudiant
        nom_etudiant (str): Nom de l'étudiant
        prenom_etudiant (str): Prénom de l'étudiant
        td (int): Numéro du TD
        tp (int): Numéro du TP
    """

    def __init__(
            self,
            id_etudiant: str,
            nom_etudiant: str,
            prenom_etudiant: str,
            td: int,
            tp: int
    ):
        """Constructeur de la classe Etudiant"""
        self.id_etudiant = id_etudiant
        self.nom_etudiant = nom_etudiant
        self.prenom_etudiant = prenom_etudiant
        self.td = td
        self.tp = tp

        message = f"-- INSERT Étudiant {self.id_etudiant} --\n" \
                  f"INSERT INTO ETUDIANT VALUES ('{self.id_etudiant}', '{self.nom_etudiant}', '{self.prenom_etudiant}', {self.td}, {self.tp});\n"

        ecrireDansFichier(message)
        print(message)

    def __str__(self):
        """
        Fonction permettant d'afficher un étudiant

        Returns:
            str: id de l'étudiant
        """
        return self.id_etudiant

    def __repr__(self):
        """
        Fonction permettant d'afficher un étudiant

        Returns:
            str: id de l'étudiant
        """
        return self.id_etudiant


if __name__ == '__main__':
    etudiant = Etudiant("ET0001", "Dupont", "Jean", 1, 1)
    print(etudiant)

    lettre = etudiant

    print(lettre.id_etudiant)
