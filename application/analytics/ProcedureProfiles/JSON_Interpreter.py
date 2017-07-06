import json

from Definitions import ROOT_DIR
from Models.Cell import Cell
from Models.Row import Row
from Pattern import Pattern
from Services.Search import Search


class JSONInterpreter:

	def __init__(self, file):
		if str(file).find(ROOT_DIR) < 0:
			file = ROOT_DIR + file
			file.replace("/", "\\")
		self.data = json.load(open(file))
		try:
			self.update = self.data['update']
		except IndexError:
			self.update = None
		try:
			self.expression = self.data['update']
		except IndexError:
			self.expression = None

	def get_update(self):
		source = self.update['sources']
		output = self.update['destination']
		functions = source['functions']

		math_ops = source['math']
		math_col = list(math_ops.keys())[0]
		math_ops = math_ops[math_col]
		# print(math_ops)
		# TODO : Generate expression tree
		math_result = Pattern.gen_tree(math_ops)
		# print(math_result)

		row_obj = Row(output['file'], output['sheet'], functions)
		del source['functions']
		for i in source:
			dest_col = i
			details = source[dest_col]
			if len(details) <= 0:
				continue

			"""print(details)
			print("File: " + str(type(details['file'])))
			print("Sheet: " + str(type(details['sheet'])))
			print("Column: " + str(type(details['column'])))
			print("Object: " + str(type(details['object'])))"""

			data_value = Search.find(details['file'], details['sheet'], details['column'], details['object'])
			data_value = data_value[0]
			if data_value < 0:
				data_value = -1 * data_value
			cell = Cell(data=data_value, file=output['file'], sheet=output['sheet'], column=dest_col)
			row_obj.add(cell)
		# end here
		return row_obj

	def construct_expression_tree(self):
		print(self.data)
		# TODO : Transform from traditional interpreter
		return None
