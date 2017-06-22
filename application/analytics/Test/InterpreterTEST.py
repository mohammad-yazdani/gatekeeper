import unittest
from ProcedureProfiles.Interpreter import Interpreter


class MyTestCase(unittest.TestCase):
    def test_something(self):
        interpreter = Interpreter("test_profile")
        print(interpreter.interpret_profile())


if __name__ == '__main__':
    unittest.main()
