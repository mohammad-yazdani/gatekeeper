import unittest
from Services.Search import Search


class MyTestCase(unittest.TestCase):

    def test_something(self):
        # book = xw.Book("BF_Monthly.xlsx")
        # book = xw.Book("BFSL_NAV.xlsx")
        # self.source = book

        file = "BFSL_NAV.xlsx"
        sheet = "Capital Allocation Ltd"
        category = "Investor Name"
        company = "The J. Paul Getty Trust"

        search_tool = Search(file, sheet, category, company)
        search_tool.find_row_in_col()

if __name__ == '__main__':
    unittest.main()
