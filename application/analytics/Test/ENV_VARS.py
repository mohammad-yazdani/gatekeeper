import unittest
import os


class MyTestCase(unittest.TestCase):
    def test_something(self):
        print(os.environ.get('JDK_HOME'))
        print(os.environ.get('JAVA_HOME'))
        print(os.environ.get('TEMP'))


if __name__ == '__main__':
    unittest.main()
