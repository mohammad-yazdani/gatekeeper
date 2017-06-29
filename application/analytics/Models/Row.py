from openpyxl import load_workbook
from Services.ExcelInstance import ExcelInstance
from Definitions import ROOT_DIR
from Models.Cell import Cell
from Services.Search import Search
import os, sys, stat


class Row:

	def __init__(self, dest_file: str, sheet: str, functions):
		dest_file = dest_file.replace(" ", "_")
		if not dest_file.find(ROOT_DIR) >= 0:
			dest_file = ROOT_DIR + "..\\files\\clientFiles\\""" + dest_file
		self.file = dest_file
		# print("Row dest file: " + self.file)
		self.wb = load_workbook(filename=self.file, read_only=False, keep_vba=True)
		self.ws = self.wb.active
		self.cells = list()
		# print("search dest file: " + self.file,)
		self.row = Search.get_empty_row(file=self.file, sheet=sheet)
		# print("Waste...", )
		self.functions = functions

	def add(self, cell: Cell):
		self.cells.insert(0, cell)

	def draw(self):
		for cell in self.cells:
			print(cell.data)

	def write(self):
		for cell in self.cells:
			cell.write(self.ws, dest_row=self.row)

		# print("Object file: " + self.file)
		# print("Output file: " + output_file)
		# filename, file_extension = os.path.splitext(self.file)
		# self.file = self.file.replace(file_extension, "temp" + file_extension)
		self.wb.save(self.file)  # Write to disk

		excel_instance = ExcelInstance(self.file)
		for method in self.functions:
			excel_instance.find_method(method)(self.row)
		self.file = excel_instance.output
		# end """
		return self.file
