import unittest
from ProcedureProfiles.Translate.Symbols import Symbols


class MyTestCase(unittest.TestCase):
    def test_something(self):
        data = "percent in data and plus percent in my shit"
        sym = Symbols()
        sym.translate_string(data)


if __name__ == '__main__':
    unittest.main()
