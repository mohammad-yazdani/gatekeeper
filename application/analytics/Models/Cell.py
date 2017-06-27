from openpyxl.worksheet import Worksheet
from Definitions import ROOT_DIR
from Services.Search import Search


class Cell:

    def __init__(self, data: str, file: str, sheet: str, column: str):
        self.data = data
        self.file = ROOT_DIR + "..\\files\\clientFiles\\""" + file + ".xlsx"
        # TODO : Destination column
        self.column = Search.find_col(file=file, sheet=sheet, col_p=column).replace("Unnamed: ", "")

    def write(self, ws: Worksheet, dest_row: int):
        print(self.data)
        cell = ws.cell(row=int(dest_row), column=int(self.column) + 1, value=self.data)
        return ws

    def draw(self):
        print(str(self.data))
