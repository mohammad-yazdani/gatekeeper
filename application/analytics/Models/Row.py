from datetime import datetime

from openpyxl import load_workbook

from Definitions import ROOT_DIR
from Models.Cell import Cell
from Services.Search import Search


class Row:

	def __init__(self, dest_file: str, sheet: str):
		dest_file = dest_file.replace(" ", "_")
		if not dest_file.find(ROOT_DIR) >= 0:
			dest_file = ROOT_DIR + "..\\files\\clientFiles\\""" + dest_file
		self.file = dest_file
		# print("Row dest file: " + self.file)
		self.wb = load_workbook(self.file)
		self.ws = self.wb.active
		self.cells = list()
		# print("search dest file: " + self.file)
		self.row = Search.get_empty_row(file=self.file, sheet=sheet)

	def add(self, cell: Cell):
		self.cells.insert(0, cell)

	def draw(self):
		for cell in self.cells:
			print(cell.data)

	def write(self):
		for cell in self.cells:
			cell.write(self.ws, dest_row=self.row)
		output_file = self.file.replace(".xlsx", "") + "_output.xlsx"
		# print("Object file: " + self.file)
		# print("Output file: " + output_file)
		self.wb.save(output_file)  # Write to disk
		return output_file
