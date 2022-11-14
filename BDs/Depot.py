"""
Fichier contenant la classe Depot, détaillée plus bas.
"""

from datetime import datetime
from dateutil.relativedelta import relativedelta
from Qcm import Qcm
from main import ecrireDansFichier

FORMAT_DATE = "%d/%m/%Y %H:%M"  # Format de date utilisé dans le programme - jour/mois/année heure:minute


class Depot:
    """
    Classe représentant un dépôt de questions.

    Code SQL de la table DEPOT:
    create table if not exists DEPOT (
        id_depot TEXT PRIMARY KEY,
        statut_b INTEGER NOT NULL DEFAULT 0 CHECK (statut_b IN (0, 1)),
        date_ouverture DATE NOT NULL,
        date_fermeture DATE NOT NULL,
        id_enseignant TEXT NOT NULL,

        FOREIGN KEY (id_enseignant) REFERENCES ENSEIGNANT(id_enseignant)
    );

    Attributes:
        id_depot (str): Identifiant du dépôt
        statut_b (bool): Statut du dépôt (ouvert/fermé)
        id_enseignant (str): Identifiant de l'enseignant
        date_ouverture (str, optional): Date d'ouverture du dépôt. Defaults to None.
        date_fermeture (str, optional): Date de fermeture du dépôt. Defaults to None.
    """

    def __init__(
            self,
            id_depot: str,
            statut_b: bool,
            id_enseignant: str,
            date_ouverture: str = None,
            date_fermeture: str = None
    ):
        """Constructeur de la classe Depot"""
        self.id_depot = id_depot
        self.statut_b = statut_b
        # Si aucune date n'est précisée, on prend la date du jour
        self.date_ouverture = date_ouverture if date_ouverture else datetime.now().strftime(FORMAT_DATE)
        # Si aucune date de fermeture n'est précisée, on prend la date du jour
        self.date_fermeture = date_fermeture if date_fermeture else\
            (self.date_ouverture + relativedelta(months =+ 3)).strftime(FORMAT_DATE)
        self.id_enseignant = id_enseignant

        self.qcm = None  # Qcm lié au dépôt

        # Code SQL pour insérer un nouveau dépôt
        message = f"-- INSERT Depôt {self.id_depot} --\n" \
                  f"INSERT INTO DEPOT VALUES ('" \
                  f"{self.id_depot}', " \
                  f"{self.statut_b}, " \
                  f"'{self.date_ouverture}', " \
                  f"'{self.date_fermeture}', " \
                  f"'{self.id_enseignant}'" \
                  f");\n"

        # Écriture du code SQL dans le fichier
        ecrireDansFichier(message)

        # Code SQL pour insérer un nouveau dépôt
        print(message)

    def lier_qcm(self, qcm: Qcm) -> None:
        """
        Méthode permettant de lier un Qcm à un dépôt

        Args:
            qcm (Qcm): Qcm à lier

        Returns:
            None
        """
        self.qcm = qcm

    def __str__(self) -> str:
        """
        Réécriture de la méthode __str__ pour afficher les informations du dépôt

        Returns:
            str -- Informations du dépôt
        """
        return self.id_depot  # Par choix, on renvoie l'identifiant du dépôt

    def __repr__(self) -> str:
        """
        Réécriture de la méthode __repr__ pour afficher les informations du dépôt

        Returns:
            str -- Informations du dépôt
        """
        return self.id_depot
