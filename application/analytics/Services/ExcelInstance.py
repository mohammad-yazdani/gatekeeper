import os
import win32com.client
from Definitions import ROOT_DIR
import time


class ExcelInstance:

	def __init__(self, file: str):
		self.file = file
		self.instance = win32com.client.Dispatch('Excel.Application')

		self.application = self.instance.Application
		if not file.find(ROOT_DIR) >= 0:
			file = ROOT_DIR + "..\\files\\clientFiles\\""" + file
		self.instance.Workbooks.Open(Filename=file)

		self.catalog = {
			"FillDown": self.fill_down,
			"AddEmptyBelow": self.add_empty_below
		}

	def save_and_quit(self):
		self.application.ActiveWorkbook.SaveAs(self.file)
		self.application.Quit()

	def fill_down(self, row: int):
		self.application.Run("FillDown", str(row))

	def add_empty_below(self, row: int):
		self.application.Run("InsertRowBelow", str(row + 1))

	def find_cell(self, row: int, col: int):
		self.application.Run("GetValue", row, col)

	def find_method(self, method: str):
		return self.catalog[method]
