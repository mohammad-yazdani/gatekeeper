import pandas as pd
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
	def find_empty_row(file, sheet):
		xl = pd.ExcelFile(file)
		df = xl.parse(sheet)
		print(str(len(df['Unnamed: 0'])))
		'''for col in df:
			print(col)
			for cell in df[col]:
				print(cell)'''
		return [0, 0]
