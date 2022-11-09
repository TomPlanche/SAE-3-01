
class Reponse:
    def __init__(self, label_reponse: str):
        self.label_reponse = label_reponse

        with open("./scriptSQLOEOEOE.txt", "a") as f:
            f.write(f"INSERT INTO REPONSE VALUES ('{self.label_reponse}');\n")
        print(f"INSERT INTO REPONSE VALUES ('{self.label_reponse}')")

    def __str__(self):
        return self.label_reponse

    def __repr__(self):
        return self.label_reponse
