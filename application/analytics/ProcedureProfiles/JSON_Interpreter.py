import json
import os

from datetime import date

from Definitions import ROOT_DIR
from Models.Cell import Cell
from Models.Row import Row
from Services.Pattern import Pattern
from Services.Search import Search


class JSONInterpreter:

	def __init__(self, file, hardcoded: str):
		if str(file).find(ROOT_DIR) < 0:
			file = ROOT_DIR + file
			file.replace("/", "\\")
		self.data = json.load(open(file))
		# print(hardcoded)
		# hardcoded = '{"T-Bill Rate": "0.6%"}'
		# print(hardcoded)
		# self.hardcoded_input = json.loads(hardcoded)
		self.hardcoded_input = json.load(open(hardcoded))
		# print(str(self.hardcoded))

		# os.remove("temp_options ")

		try:
			self.update = self.data['update']

			self.source = self.update['sources']
			self.output = self.update['destination']
			self.functions = self.source['functions']
			self.hardcoded = self.source['hardcoded']
			self.row_obj = Row(self.output['file'], self.output['sheet'], self.functions)
			self.word_export = self.output['word_export']
			self.subject = str(self.hardcoded_input['subject']).replace("_", " ")
			# print(self.subject)

		except IndexError:
			self.update = None
		try:
			self.expression = self.data['update']
		except IndexError:
			self.expression = None

	def get_update(self):

		for hardcoded_index in self.hardcoded:
			value = self.hardcoded_input[hardcoded_index]
			# print(str(value),)
			hardcoded_cell = Cell(parent=None, data=value, file=self.output['file'],
			                      sheet=self.output['sheet'],
			                      column=hardcoded_index, style=None)
			self.row_obj.add(hardcoded_cell)

		math_ops = self.source['math']
		math_cols = list(math_ops.keys())

		for math_col in math_cols:
			math_data = math_ops[math_col]
			# print(math_ops)
			# TODO : Generate expression tree
			math_data = Pattern.gen_tree(math_data)
			# print(str(math_data),)
			math_cell = Cell(parent=None, data=math_data, file=self.output['file'],
			                 sheet=self.output['sheet'],
			                 column=math_col, style=None)
			# print(math_result)
			self.row_obj.add(math_cell)

		# TODO : Handle hardcoded data

		del self.source['functions']
		del self.source['math']
		del self.source['hardcoded']

		for i in self.source:
			dest_col = i
			details = self.source[dest_col]
			if len(details) <= 0:
				continue

			"""print(details)
			print("File: " + str(type(details['file'])))
			print("Sheet: " + str(type(details['sheet'])))
			print("Column: " + str(type(details['column'])))
			print("Object: " + str(type(details['object'])))"""

			# print(str(details),)

			data_value = None
			style = None

			if details['object'] == "DateTime":
				data_value = date(2017, 7, 12)
				style = "DD-MMM-YYYY"
			else:
				data_value = Search.find(details['file'], details['sheet'],
				                         details['column'], self.subject)
				# print(str(data_value),)
				if not data_value:
					continue
				data_value = data_value[0]
				if data_value < 0:
					data_value = -1 * data_value

			cell = Cell(parent=None, data=data_value, file=self.output['file'],
			            sheet=self.output['sheet'], column=dest_col, style=style)
			self.row_obj.add(cell)
		# end here

	def construct_expression_tree(self):
		print(self.data)
		# TODO : Transform from traditional interpreter
		return None
