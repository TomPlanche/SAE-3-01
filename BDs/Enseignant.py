
class Enseignant:
    """
    id_enseignant TEXT PRIMARY KEY,
    nom_enseignnat TEXT NOT NULL,
    prenom_enseignant TEXT NOT NULL,
    matiere TEXT NOT NULL,
    nationalite TEXT NOT NULL
    """
    def __init__(self, id_enseignant: str, nom_enseignant: str, prenom_enseignant: str, matiere: str, nationalite: str):
        self.id_enseignant = id_enseignant
        self.nom_enseignant = nom_enseignant
        self.prenom_enseignant = prenom_enseignant
        self.matiere = matiere
        self.nationalite = nationalite

        with open("./scriptSQLOEOEOE.txt", "a") as f:
            f.write(f"INSERT INTO ENSEIGNANT VALUES ('{self.id_enseignant}', '{self.nom_enseignant}', '{self.prenom_enseignant}', '{self.matiere}', '{self.nationalite}');\n")
        print(f"INSERT INTO ENSEIGNANT VALUES ('{self.id_enseignant}', '{self.nom_enseignant}', '{self.prenom_enseignant}', '{self.matiere}', '{self.nationalite}')")

    def __str__(self):
        return self.id_enseignant

    def __repr__(self):
        return self.id_enseignant
