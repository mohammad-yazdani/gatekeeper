from Functions.BinaryOperator import BinaryOperator
from Models.DataNode import DataNode


class Minus(BinaryOperator):

    def __init__(self, parent: DataNode = None):
        super().__init__(parent)

    def evaluate(self):
        op1_data = self.right.evaluate()
        op2_data = self.left.evaluate()
        # print("right: " + str(op1_data))
        # print("left: " + str(op2_data))

        """length = len(self.right.evaluate())

        # TODO : Handle non-equal length of operands
        output = []

        ctrl = 0
        for i in range(length):
            output.insert(ctrl, op1_data[i] - op2_data[i])
            ctrl += 1                            

        # print(str(output))  # TODO : FOR TEST

        self.right.set_value(op1_data)
        self.left.set_value(op2_data)

        # TODO : Make sure output is indexed
        return output"""
        return op1_data - op2_data

    def add_to_catalog(self):
        return {
            "key": "-",
            "operator": "Minus"
        }
