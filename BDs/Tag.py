
class Tag:
    """
    nom_tag TEXT PRIMARY KEY,
    id_enseignant TEXT NOT NULL,
    niveau INTEGER NOT NULL CHECK (niveau IN (1, 2, 3)),

    FOREIGN KEY (id_enseignant) REFERENCES ENSEIGNANT(id_enseignant)
    """
    def __init__(self, nom_tag: str, id_enseignant: str):
        self.nom_tag = nom_tag
        self.id_enseignant = id_enseignant

        with open("./scriptSQLOEOEOE.txt", "a") as f:
            f.write(f"INSERT INTO TAG VALUES ('{self.nom_tag}', '{self.id_enseignant}');\n")
        print(f"INSERT INTO TAG VALUES ('{self.nom_tag}', '{self.id_enseignant}')")

    def __str__(self):
        return self.nom_tag

    def __repr__(self):
        return self.nom_tag
