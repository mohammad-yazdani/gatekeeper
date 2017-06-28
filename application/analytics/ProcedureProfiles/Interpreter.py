from Definitions import ROOT_DIR


class Interpreter:

    def __init__(self, profile: str):
        self.dir = "ProcedureProfiles\\"
        # print("Interpreter opening: " + ROOT_DIR + self.dir + profile)
        self.profile = open(ROOT_DIR + self.dir + profile)
        self.output = list()
        self.row_start = -1
        self.col_start = -1
        self.input_dir = ""

    def read_profile(self):
        exp_start = False
        for line in self.profile:
            # TODO : FOR TEST
            if line.find("DIR") >= 0:
                self.input_dir = str(line.split()[1])
            if line.find("START_ROW") >= 0:
                self.row_start = int(line.split()[1])
            if line.find("START_COL") >= 0:
                self.col_start = int(line.split()[1])
            if line.find("EXPRESSION_START") >= 0:
                exp_start = True
                continue
            for token in line.split():
                if exp_start:
                    self.output.insert(0, token)

    @staticmethod
    def static_read(profile: str):
        profile = profile.replace(".", " ")
        output = list()
        for token in profile.split():
            output.insert(0, token)
        return output

    def interpret_profile(self):
        coordinates = [self.row_start, self.col_start]
        self.output.insert(0, coordinates)
        self.output.insert(0, self.input_dir)
        return self.output
