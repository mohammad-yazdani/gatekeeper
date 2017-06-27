from openpyxl import load_workbook
from Models.Cell import Cell
from Services.Search import Search


class Row:

	def __init__(self, dest_file: str, sheet: str):
		self.file = dest_file
		self.wb = load_workbook(self.file)
		self.ws = self.wb.active
		self.cells = list()
		self.row = Search.get_empty_row(file=dest_file, sheet=sheet)

	def add(self, cell: Cell):
		self.cells.insert(0, cell)

	def write(self):
		for cell in self.cells:
			cell.write(self.ws, dest_row=self.row)
		self.wb.save(self.file)  # Write to disk
