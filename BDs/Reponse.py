
class Reponse:
    def __init__(self, label_reponse: str):
        self.label_reponse = label_reponse

        message = f"-- INSERT Réponse {self.label_reponse} --\n" \
                  f"INSERT INTO REPONSE VALUES ('{self.label_reponse}');\n"

        with open("./scriptSQLOEOEOE.txt", "a") as f:
            f.write(message)
        print(message)

    def __str__(self):
        return self.label_reponse

    def __repr__(self):
        return self.label_reponse
