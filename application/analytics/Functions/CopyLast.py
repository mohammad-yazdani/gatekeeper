from Models.DataNode import DataNode
from Functions.UnaryOperator import UnaryOperator


class CopyLast(UnaryOperator):

    def __init__(self, parent: DataNode = None, new_value: float = None):
        super().__init__(parent)
        self.left = None
        self.new_value = new_value

    def evaluate(self):\

        op1_data = self.right.evaluate()
        # print("right: " + str(op1_data))
        # print("left: " + str(op2_data))

        # TODO : GET LAST ROW
        last_row = op1_data[len(op1_data) - 2]
        # print("OP1_DATA: " + str(last_row))
        # print("OP1_DATA TYPE: " + str(type(op1_data)))

        if self.new_value:
            last_row = self.new_value

        # TODO : Operation
        op1_data.append(last_row)

        # TODO : IF new_value IS NOT NONE, APPEND IT TO LAST ROW
        # TODO : ELSE APPEND THE LAST ROW TO COLUMN

        # print(str(output))  # TODO : FOR TEST

        self.right.set_value(op1_data)

        # TODO : Make sure output is indexed
        output = op1_data

        # print("\nOUTPUT: " + str(output) + "\n")

        return output

    def add_to_catalog(self):
        return {
            "key": "COPY_LAST",
            "operator": "CopyLast"
        }
