import pandas as pd
from openpyxl import load_workbook

from Models.Cell import Cell


class Search:

	@staticmethod
	def find_col(file, sheet, col_p):
		# TODO : RETURN COL
		xl = pd.ExcelFile(file)
		df = xl.parse(sheet)
		for col in df:
			query = ""
			result_col = 1
			for cell in df[col]:
				query += " " + str(cell)
				if query.find(col_p) >= 0:
					result_col = str(col)
					# result_col = int(result_col.replace("Unnamed: ", "")) + 1
					return result_col

	@staticmethod
	def find_row(file, sheet, row_p):
		xl = pd.ExcelFile(file)
		df = xl.parse(sheet)
		for col in df:
			query = ""
			for cell in df[col]:
				query += " " + str(cell)
				if query.find(row_p) >= 0:
					count = 1
					for item in df[col]:
						# print(str(count) + " " + str(item))
						if str(item).find(row_p) >= 0:
							return count
						else:
							count += 1
					return -1

	@staticmethod
	def find(file, sheet, col_p, row_p):
		row = Search.find_row(file, sheet, row_p)
		col = Search.find_col(file, sheet, col_p)
		# print("Col: " + str(col) + " row: " + str(row))
		xl = pd.ExcelFile(file)
		df = xl.parse(sheet)
		# print(df)
		cell = Cell(data=df[col][row], file=file)
		# cell.draw()
		return cell

	@staticmethod
	def get_row(file, sheet, row_number):
		wb = load_workbook(file)
		ws = wb.active
		rows = list()
		for row_index in reversed(range(1, ws.max_row + 1)):
			row = list()
			for col_index in range(1, ws.max_column + 1):
				row.insert(0, ws.cell(row=row_index, column=col_index).value)
			rows.insert(0, row)
		return rows[row_number - 1]

	@staticmethod
	def get_empty_row(file, sheet):
		wb = load_workbook(file)
		ws = wb.active
		result = list()
		# print(ws.max_row)
		# print(Search.get_row(file=file, sheet=sheet, row_number=50))
		count = 0
		for row in reversed(range(1, ws.max_row + 1)):
			empty = True
			# print(Search.get_row(file=file, sheet=sheet, row_number=row))
			the_row = Search.get_row(file=file, sheet=sheet, row_number=row)
			for cell in the_row:
				if cell:
					empty = False
			if empty:
				# print(row)
				result.insert(0, row)
				count += 1
				if count > 1:
					return row
		# print(result)
