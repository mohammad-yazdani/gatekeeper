import pandas as pd


class Search:

	@staticmethod
	def find_row_in_col(file, sheet, col_p, row_p):
		xl = pd.ExcelFile(file)
		df = xl.parse(sheet)
		result_col = ""
		result_row = -1
		for col in df:
			query = ""
			for cell in df[col]:
				query += " " + str(cell)
			if query.find(col_p) >= 0:
				result_col = col
				row = 0
				for entity in df[col]:
					if str(entity).find(row_p) >= 0:
						result_row = row
						break
					else:
						row += 1

		print("Col: " + result_col + " Row: " + str(result_row))

		return {
			"col": result_col,
			"row": result_row
		}
