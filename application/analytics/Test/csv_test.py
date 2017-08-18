import unittest
import os


class MyTestCase(unittest.TestCase):
    def test_something(self):

        file = open('sample_csv.csv', 'w+')
        data = "N,SC,,000000000001,,,VAL051115_1551,ISIN,US300141AB43,EVERGLADES 2013-1 A ,ISO,USD,,IPB,MLLON,,B,1000,1,1000,20160808,,20160810,,,,,,,,,,USDD,,,,,,,,,,,,,,GCAS"
        file.write(data)
        file.close()


if __name__ == '__main__':
    unittest.main()
