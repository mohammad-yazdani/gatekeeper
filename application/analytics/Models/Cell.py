from openpyxl.worksheet import Worksheet

from Models.DataNode import DataNode
from Definitions import ROOT_DIR
from Services.Search import Search


class Cell(DataNode):

    def __init__(self, parent: DataNode, data: str, file: str, sheet: str, column: str, style):
        super(Cell, self).__init__(parent)
        self.data = data
        self.file = ROOT_DIR + "..\\files\\clientFiles\\""" + file + ".xlsx"
        # TODO : Destination column
        self.column = Search.find_col(file=file, sheet=sheet, col_p=column)\
            .replace("Unnamed: ", "")
        self.style = style

    def write(self, ws: Worksheet, dest_row: int):
        cell = ws.cell(row=int(dest_row), column=int(self.column) + 1, value=self.data)
        if self.style:
            cell.number_format = self.style
        return ws

    def evaluate(self):
        return self.data

    def is_leaf(self):
        return True

    def set_value(self, val):
        pass

    def append(self, new_node):
        pass

    def draw(self):
        print(str(self.data))
