import unittest
from Services.Search import Search


class MyTestCase(unittest.TestCase):

    def test_something(self):
        # book = xw.Book("BF_Monthly.xlsx")
        # book = xw.Book("BFSL_NAV.xlsx")
        # self.source = book

        file = "BFSL_NAV04302017.xlsx"
        sheet = "Capital Allocation Ltd"
        # category = "Investor Name"
        category = "Ending NAV Balance"
        company = "The J. Paul Getty Trust"

        dest_file = "BF Monthly.xlsx"
        dest_sheet = "Chart"
        dest_col = 4
        dest_row = 47

        # cell = Search.find(file, sheet, category, company)
        Search.find_empty_row(dest_file, dest_sheet)

        # cell.draw()

        # cell.write(file=dest_file, dest_column=dest_col, dest_row=dest_row, sheet=dest_sheet)

if __name__ == '__main__':
    unittest.main()
