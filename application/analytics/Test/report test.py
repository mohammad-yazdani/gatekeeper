import unittest

import os
import shutil

import win32com.client as win32
from Definitions import ROOT_DIR


class MyTestCase(unittest.TestCase):
    def test_something(self):
        self.base = ROOT_DIR + "..\\files\\clientFiles\\"""
        file = "BF_Template.docm"
        if not file.find(ROOT_DIR) >= 0:
            file = self.base + file

        filename, file_extension = os.path.splitext(file)
        # milli = int(round(time.time() * 1000))
        signature = " output"
        output_file = file.replace(file_extension, signature + file_extension)
        shutil.copy(file, output_file)
        self.file = output_file

        self.instance = win32.Dispatch('Word.Application')
        self.application = self.instance.Application

        self.instance.Documents.Open(file)

        template = self.base + "BF_Monthly output.xlsm"
        asset_ownership = self.base + "Asset Ownership & Deal Exposure.xlsx"
        charts = self.base + "BF_presentation charts.xlsx"
        bfsl_nav = self.base + "BFSL_NAV.xlsx"

        self.application.Run("ExtractData", template, asset_ownership, charts, bfsl_nav)
        self.application.Quit()
        print(self.file)

if __name__ == '__main__':
    unittest.main()
