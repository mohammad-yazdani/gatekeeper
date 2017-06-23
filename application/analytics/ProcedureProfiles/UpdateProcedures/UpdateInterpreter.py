from Definitions import ROOT_DIR


class UpdateInterpreter:

    def __init__(self, profile: str):
        self.dir = "ProcedureProfiles\\UpdateProcedures\\"
        self.profile = open(ROOT_DIR + self.dir + profile)
        self.output = list()

    def interpret_profile(self):
        row_start = -1
        col_start = -1
        exp_start = False
        for line in self.profile:
            # TODO : FOR TEST
            if line.find("START_ROW") >= 0:
                row_start = int(line.split()[1])
            if line.find("START_COL") >= 0:
                col_start = int(line.split()[1])
            if line.find("EXPRESSION_START") >= 0:
                exp_start = True
                continue
            for token in line.split():
                if exp_start:
                    self.output.insert(0, token)
        coordinates = [row_start, col_start]
        self.output.insert(0, coordinates)
        return self.output
