import unittest
from Services.Search import Search


class MyTestCase(unittest.TestCase):

    def test_something(self):
        # book = xw.Book("BF_Monthly.xlsx")
        # book = xw.Book("BFSL_NAV.xlsx")
        # self.source = book

        file = "BF_Monthly.xlsm"
        sheet = "Chart"
        # category = "Investor Name"
        category = "Black Forest LTD"
        # company = "Initial Capital Commitment"
        company = "Undrawn Capital Commitment"
        # company = "Unitholder"

        dest_file = "BF Monthly.xlsx"
        dest_sheet = "Chart"
        dest_col = 4
        dest_row = 47

        # cell = Search.find(file, sheet, category, company)
        print(Search.find(file=file, sheet=sheet,col_p=category, row_p=company))

        # cell.draw()

        # cell.write(file=dest_file, dest_column=dest_col, dest_row=dest_row, sheet=dest_sheet)

if __name__ == '__main__':
    unittest.main()
