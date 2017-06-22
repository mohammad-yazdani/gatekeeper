from Models import DataTree
from Services.Pattern import Pattern


class DataEngine:

    def __init__(self, data: str):
        print("Starting Data Engine ...")
        self.output = list()
        pattern = Pattern(data)
        pattern.interpret()
        exp_tree = pattern.output
        self.output.insert(0, pattern.coordinates)
        # exp_tree.draw()  # TODO : FOR TEST
        self.source = exp_tree
        self.process()

    def process(self):
        # print("Data Engine: Processing Expression Tree ...")
        self.output.insert(1, self.source.process())
        print("Data Engine: Expression Tree Process Finished.")

    def print_output(self):
        print(str(self.output))
