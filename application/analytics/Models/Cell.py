from openpyxl import Workbook
from openpyxl.styles import NamedStyle
from openpyxl.worksheet import Worksheet

from Models.DataNode import DataNode
from Definitions import ROOT_DIR
from Services.Search import Search


class Cell(DataNode):

	def __init__(self, parent: DataNode, data: str, file: str, sheet: str, column: str, style):
		super(Cell, self).__init__(parent)
		self.data = data
		self.file = file
		# TODO : Destination column
		self.column = Search.find_col(file=file, sheet=sheet, col_p=column)\
			.replace("Unnamed: ", "")
		self.style = style

	def write(self, wb: Workbook, ws: Worksheet, dest_row: int):
		# print("Dest row: " + str(dest_row))
		cell = ws.cell(row=int(dest_row), column=int(self.column) + 1, value=self.data)

		# test_cell = ws['A1']
		# print("TEST " + str(test_cell))

		if self.style:
			style_name = "Normal"

			if str(self.style).find("Date"):
				self.style = "dd-mmm-yyyy"

			if str(self.style).find("%"):
				self.style = "0.0000%"
			# cell.style = self.style

		return ws

	def evaluate(self):
		return self.data

	def is_leaf(self):
		return True

	def set_value(self, val):
		pass

	def append(self, new_node):
		pass

	def draw(self):
		print(str(self.data))
		print(str(self.file))
		print(str(self.column))
