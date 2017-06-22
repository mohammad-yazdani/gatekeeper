import unittest

from Services.Pattern import Pattern


class MyTestCase(unittest.TestCase):
    def test_ctor(self):
        temp = "test_profile"
        pattern_evaluator = Pattern(temp)
        # pattern_evaluator.test_new()
        # pattern_evaluator.test_update()
        # self.assertEquals(False, True)
        output = pattern_evaluator.interpret()
        output.draw()

if __name__ == '__main__':
    unittest.main()
