import unittest

from openpyxl import load_workbook


class MyTestCase(unittest.TestCase):
    def test_something(self):
        wb = load_workbook("BF_Monthly.xlsm")
        wb.save("BF_Monthly.xlsm")


if __name__ == '__main__':
    unittest.main()
