import unittest

from Search import Search


class MyTestCase(unittest.TestCase):
    def test_something(self):
        print(str(Search.get_empty_row('BF Monthly output.xlsm', 'Chart')))


if __name__ == '__main__':
    unittest.main()
