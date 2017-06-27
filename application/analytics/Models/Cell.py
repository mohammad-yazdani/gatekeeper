from openpyxl.worksheet import Worksheet
from Services.Search import Search


class Cell:

    def __init__(self, data: str, file: str, sheet: str, column: str):
        self.data = data
        self.file = file
        self.column = Search.find_col(file=file, sheet=sheet, col_p=column)

    def write(self, ws: Worksheet, dest_row: int=-1, append=True):
        if append:
            dest_row = ws.max_row - 2

        print("Col: " + str(self.column))
        print("Row: " + str(dest_row))

        cell = ws.cell(row=int(dest_row), column=int(self.column), value=self.data)

        # cell.number_format = '#,##0.00€'

        # Direct cell modification
        # Add new row at bottom
        # ws.append(["1337", "NanoDano", "password1"])
        # Can use Python datetime objects

    def draw(self):
        print(str(self.data))
