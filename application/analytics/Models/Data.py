import xlwings as xw
import pandas as pd
from Definitions import ROOT_DIR
from Models.DataNode import DataNode


class Data(DataNode):

    def __init__(self, parent: DataNode, file: str, sheet: str, column: int, row: int = None):
        super(Data, self).__init__(parent)
        self.right = False
        # self.right = True
        self.left = False
        self.column = column
        # self.left = True
        # print("File: " + file + " Sheet: " + sheet + " Column: " + str(column))
        self.path = ROOT_DIR + "..\\files\\clientFiles\\""" + file + ".xlsx"
        # print("File path: " + self.path)  # TODO : FOR TEST
        self.book = xw.Book(self.path)
        self.source = self.book.sheets

        if row:
            self.row = row

        xl = pd.ExcelFile(self.path)
        df1 = xl.parse(sheet)
        data = df1['Unnamed: ' + str(column)]
        self.data = list()
        index = 0
        for cell in data:
            try:
                if not (str(float(cell)) == "nan"):
                    self.data.insert(index, float(cell))
            except ValueError:
                continue
            index += 1

    def evaluate(self):
        return self.data

    def set_value(self, val: list):

        """index = 0
        for item in range(1, self.source.max_row + 1):
            self.source.cell(row=item, column=self.column, value=self.data[index])
            # print("Row: " + str(item) + " Col: " + str(column) + " Data: " + str(cell_data))  # TODO : FOR TEST
            index += 1

        # self.book.save(self.path)"""

    def append(self, new_node):
        return False

    def draw(self):
        print(str(self.data))
