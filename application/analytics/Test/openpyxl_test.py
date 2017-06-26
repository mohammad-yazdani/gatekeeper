import unittest
from openpyxl import *
import datetime


class MyTestCase(unittest.TestCase):
    def test_something(self):

        wb = load_workbook("BF Monthly.xlsx")

        ws = wb.active  # Use default/active sheet
        # Or create a new named sheet and set it to active using index
        # ws = wb.create_sheet(title="User Information")
        # wb.active = 1  # Default sheet was 0, this new sheet is 1

        # cell = ws.cell(row=48, column=3, value=5000)

        rd = ws.row_dimensions[3]  # get dimension for row 3
        rd.height = 25

        # cell.number_format = '#,##0.00€'

        # Direct cell modification
        # Add new row at bottom
        # ws.append(["1337", "NanoDano", "password1"])
        # Can use Python datetime objects

        wb.save("BF Monthly.xlsx")  # Write to disk


if __name__ == '__main__':
    unittest.main()
