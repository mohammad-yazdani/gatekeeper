import unittest
import xlwings as xw
import pandas as pd


class MyTestCase(unittest.TestCase):

    def test_something(self):

        file = "BF_Monthly.xlsx"
        wb = xw.Book(file)
        sheet = wb.sheets

        print(str(sheet))
        sheet = sheet[0]
        print(str(sheet))

        column = 1

        xl = pd.ExcelFile(file)

        df1 = xl.parse('Chart')

        self.data = df1['Unnamed: ' + str(column)]

        print(xl.sheet_names)

        print("#################################################################################################")
        # print(str(df1))
        print("#################################################################################################")

        print(str(type(df1['Unnamed: 1'])))
        print(df1['Unnamed: ' + str(3)][31])
        print(float(df1['Unnamed: ' + str(3)][31]))
        print(str(type(df1['Unnamed: ' + str(1)][31])))

        # print(str(type(df1)))

        """
        row_count = sheet.max_row
        column_count = sheet.max_column
        print("Row count: " + str(row_count))
        print("Column count: " + str(column_count))
        """

if __name__ == '__main__':
    unittest.main()
