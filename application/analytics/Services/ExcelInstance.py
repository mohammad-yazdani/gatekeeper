import os
import win32com.client as win32
from Definitions import ROOT_DIR
import time


class ExcelInstance:

	def __init__(self, file: str):

		if not file.find(ROOT_DIR) >= 0:
			file = ROOT_DIR + "..\\files\\clientFiles\\""" + file

		self.file = file

		self.macros_path = ROOT_DIR + "Functions\\Macros\\"""
		self.instance = win32.Dispatch('Excel.Application')
		self.application = self.instance.Application
		self.instance.DisplayAlerts = False
		self.instance.Visible = False

		# self.application = self.instance
		self.workbook = self.instance.Workbooks.Open(Filename=self.file)

		self.catalog = {
			"FillDown": self.fill_down,
			"ToggleAlert": self.display_alert,
			"Update": self.update,
			"UpdateFormula": self.update_formula
		}

	def save_and_quit(self):
		self.application.ActiveWorkbook.SaveAs(self.file)
		self.application.Quit()

	def fill_down(self, row: int):
		try:
			self.application.Run("FillDown", str(row))
		except Exception as e:
			no_macro = (str(e).
						find("The macro may not be available in this workbook or "
							 "all macros may be disabled.")
						>= 0)
			if no_macro:
				macro = "FillDown"
				macro_path = self.macros_path + macro + ".vb"
				excel_module = self.workbook.VBProject.VBComponents.Add(1)
				excel_module.CodeModule.AddFromString(str(open(macro_path, encoding='utf8').read()))

				self.fill_down(row)
			else:
				self.save_and_quit()
				return False

	def add_empty_below(self, row: int):
		self.application.Run("InsertRowBelow", str(row + 1))

	def find_cell(self, row: int, col: int):
		self.application.Run("GetValue", row, col)

	def find_method(self, name):
		return self.catalog[name]

	def display_alert(self, switch: bool):
		macro = "ToggleAlert"
		try:
			self.application.Run(macro, switch)
		except Exception as e:
			no_macro = (str(e).
						find("The macro may not be available in this workbook or "
							 "all macros may be disabled.")
						>= 0)
			if no_macro:
				macro_path = self.macros_path + macro + ".vb"
				excel_module = self.workbook.VBProject.VBComponents.Add(1)
				excel_module.CodeModule.AddFromString(str(open(macro_path, encoding='utf8').read()))

				# self.display_alert(switch)
			else:
				self.save_and_quit()
				return False

	def update(self):
		try:
			self.application.Run("Update")
		except Exception as e:
			no_macro = (str(e).
			            find("The macro may not be available in this workbook or "
			                 "all macros may be disabled.")
			            >= 0)
			if no_macro:
				macro = "Update"
				macro_path = self.macros_path + macro + ".vb"
				excel_module = self.workbook.VBProject.VBComponents.Add(1)
				excel_module.CodeModule.AddFromString(str(open(macro_path, encoding='utf8').read()))

				self.update()
			else:
				self.save_and_quit()
				return False

	def update_formula(self):
		try:
			self.application.Run("UpdateFormula")
		except Exception as e:
			no_macro = (str(e).
			            find("The macro may not be available in this workbook or "
			                 "all macros may be disabled.")
			            >= 0)
			if no_macro:
				macro = "UpdateFormula"
				macro_path = self.macros_path + macro + ".vb"
				excel_module = self.workbook.VBProject.VBComponents.Add(1)
				excel_module.CodeModule.AddFromString(str(open(macro_path, encoding='utf8').read()))

				self.update_formula()
			else:
				self.save_and_quit()
				return False

	def add_to_catalog(self, name: str):
		# TODO : Fix later
		self.catalog[name] = None

	@staticmethod
	def prepare():
		instance = win32.Dispatch('Excel.Application')
		application = instance.Application
		application.Quit()
