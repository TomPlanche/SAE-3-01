
class Etudiant:
    """
    id_etudiant TEXT PRIMARY KEY,
    nom_etudiant TEXT NOT NULL,
    prenom_etudiant TEXT NOT NULL,
    td INTEGER NOT NULL,
    tp INTEGER NOT NULL
    """

    def __init__(self, id_etudiant: str, nom_etudiant: str, prenom_etudiant: str, td: int, tp: int):
        self.id_etudiant = id_etudiant
        self.nom_etudiant = nom_etudiant
        self.prenom_etudiant = prenom_etudiant
        self.td = td
        self.tp = tp

        message = f"-- INSERT Étudiant {self.id_etudiant} --\n" \
                  f"INSERT INTO ETUDIANT VALUES ('{self.id_etudiant}', '{self.nom_etudiant}', '{self.prenom_etudiant}', {self.td}, {self.tp});\n"

        with open("./scriptSQLOEOEOE.txt", "a") as f:
            f.write(message)
        print(message)

    def __str__(self):
        return self.id_etudiant

    def __repr__(self):
        return self.id_etudiant


if __name__ == '__main__':
    etudiant = Etudiant("ET0001", "Dupont", "Jean", 1, 1)
    print(etudiant)
    
    lettre = etudiant
    
    print(lettre.id_etudiant)
