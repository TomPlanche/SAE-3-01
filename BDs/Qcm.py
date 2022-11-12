
class Qcm:
    """
    id_qcm TEXT PRIMARY KEY,
    titre TEXT NOT NULL,
    description TEXT NOT NULL,
    etat_b INTEGER NOT NULL DEFAULT 0 CHECK (etat_b IN (0, 1)),
    id_enseignant TEXT NOT NULL,

    FOREIGN KEY (id_enseignant) REFERENCES ENSEIGNANT(id_enseignant)
    """

    def __init__(self, id_qcm: str, titre: str, description: str, etat_b: bool, id_enseignant: str):
        self.id_qcm = id_qcm
        self.titre = titre
        self.description = description
        self.etat_b = etat_b
        self.id_enseignant = id_enseignant

        self.questions = []

        message = f"-- INSERT QCM {self.id_qcm} --\n" \
                  f"INSERT INTO QCM VALUES ('{self.id_qcm}', '{self.titre}', '{self.description}', {self.etat_b}, '{self.id_enseignant}');\n"

        with open("./scriptSQLOEOEOE.txt", "a") as f:
            f.write(message)
        print(message)

    def lier_questions(self, *questions):
        """
        Lier les questions au qcm
        :param questions: Une liste de questions
        :type questions: list
        """
        for question in questions:
            self.questions.append(question)

    def __str__(self):
        return self.id_qcm

    def __repr__(self):
        return self.id_qcm
