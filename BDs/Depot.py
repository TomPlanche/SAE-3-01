
from datetime import datetime
from dateutil.relativedelta import relativedelta


class Depot:
    """
    id_depot TEXT PRIMARY KEY,
    statut_b INTEGER NOT NULL DEFAULT 0 CHECK (statut_b IN (0, 1)),
    date_ouverture DATE NOT NULL,
    date_fermeture DATE NOT NULL,
    id_enseignant TEXT NOT NULL,

    FOREIGN KEY (id_enseignant) REFERENCES ENSEIGNANT(id_enseignant)
    """

    def __init__(self, id_depot: str, statut_b: bool, id_enseignant: str, date_ouverture: str = None, date_fermeture: str = None):
        self.id_depot = id_depot
        self.statut_b = statut_b
        self.date_ouverture = datetime.now().strftime("%d/%m/%Y %H:%M")
        # self.date_fermeture <- date dans 3 mois
        self.date_fermeture = (datetime.now() + relativedelta(months =+ 3)).strftime("%d/%m/%Y %H:%M")
        # self.date_fermeture =
        self.id_enseignant = id_enseignant

        self.qcm = None

        with open("./scriptSQLOEOEOE.txt", "a") as f:
            f.write(f"INSERT INTO DEPOT VALUES ('{self.id_depot}', {self.statut_b}, '{self.date_ouverture}', '{self.date_fermeture}', '{self.id_enseignant}');\n")

        print(f"INSERT INTO DEPOT VALUES ('{self.id_depot}', {self.statut_b}, '{self.date_ouverture}', '{self.date_fermeture}', '{self.id_enseignant}')")

    def lier_qcm(self, qcm):
        """
        Lier les qcms au depot
        :param qcm: Un qcm
        :type qcm: Qcm
        """
        self.qcm = qcm

    def __str__(self):
        return self.id_depot

    def __repr__(self):
        return self.id_depot
