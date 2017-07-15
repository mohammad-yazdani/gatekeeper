import unittest
from shutil import copyfile
from Services.WordInstance import WordInstance
import time
import win32com.client as win32
import os


class MyTestCase(unittest.TestCase):
    def test_something(self):
        word_instance = WordInstance("BF_Template.docm")
        word_instance.bf_monthly_export_word()

if __name__ == '__main__':
    unittest.main()
