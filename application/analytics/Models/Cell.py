from openpyxl.worksheet import Worksheet
# from Services.Search import Search


class Cell:

    def __init__(self, data: str, file: str):
        self.data = data
        self.file = file

    def write(self, ws: Worksheet, dest_sheet: str, dest_column: int=-1, dest_row: int=-1, append=True):
        if append:
            dest_row = ws.max_row - 2

        print("Col: " + str(dest_column))
        print("Row: " + str(dest_row))

        cell = ws.cell(row=int(dest_row), column=int(dest_column), value=self.data)

        # cell.number_format = '#,##0.00€'

        # Direct cell modification
        # Add new row at bottom
        # ws.append(["1337", "NanoDano", "password1"])
        # Can use Python datetime objects

    def draw(self):
        print(str(self.data))
