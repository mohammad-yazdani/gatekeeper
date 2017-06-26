from openpyxl import load_workbook
from Models.Cell import Cell


class Row:

	def __init__(self, dest_file: str):
		self.file = dest_file
		self.wb = load_workbook(self.file)
		self.ws = self.wb.active
		self.cells = list()

	def add(self, cell: Cell):
		self.cells.insert(0, cell)

	def write(self):
		for cell in self.cells:
			cell.write(self.ws)
		self.wb.save(self.file)  # Write to disk
