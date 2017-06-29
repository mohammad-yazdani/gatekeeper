import unittest
from ProcedureProfiles.JSON_Interpreter import JSONInterpreter


class MyTestCase(unittest.TestCase):
	def test_something(self):

		print(self)

		json_interpreter = JSONInterpreter("BF_Monthly.json")
		# json_interpreter.get_update().write()

		"""xl = pd.ExcelFile("BFSL_NAV.xlsx")
		print(xl.sheet_names)

		data = json.load(open("BF_Monthly.json"))
		print(data)
		print()

		source = data['update']['sources']

		output = data['update']['destination']

		row_obj = Row(output['file'], output['sheet'])

		for i in source:
			dest_col = i
			details = source[dest_col]
			if len(details) <= 0:
				continue
			# print(details['sheet'])
			data_value = Search.find(details['file'], details['sheet'], details['column'], details['object'])
			if data_value[0] < 0:
				data_value[0] = data_value[0] * (-1)
			cell = Cell(data=data_value[0], file=output['file'], sheet=output['sheet'], column=dest_col)
			row_obj.add(cell)
		print(row_obj)
		row_obj.write()
		# print(data)"""

if __name__ == '__main__':
	unittest.main()
