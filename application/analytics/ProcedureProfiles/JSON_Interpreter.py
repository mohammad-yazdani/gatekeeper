import json
import os

from datetime import date

from Definitions import ROOT_DIR
from Models.Cell import Cell
from Models.Row import Row
from Services.Pattern import Pattern
from Services.Search import Search
from shutil import copyfile


class JSONInterpreter:

	def __init__(self, file, hardcoded: dict):
		if str(file).find(ROOT_DIR) < 0:
			file = ROOT_DIR + file
			file.replace("/", "\\")
		self.data = json.load(open(file))
		# print(hardcoded)
		# hardcoded = '{"T-Bill Rate": "0.6%"}'
		# print(hardcoded)
		# self.hardcoded_input = json.loads(hardcoded)
		self.hardcoded_input = hardcoded
		# print(str(self.hardcoded))
		self.company_dict = json.load(open(ROOT_DIR + 'ProcedureProfiles/company_dict.json'))
		# os.remove("temp_options ")

		try:
			self.update = self.data['update']
			self.source = self.update['sources']
			self.output = self.update['destination']
			self.subject = str(self.hardcoded_input['subject']).replace("_", " ")
			specific_file = str(self.company_dict[self.subject][1]).replace('/', '') + "_" + self.output['file']
			try:
				os.remove(self.output['file'])
			except FileNotFoundError:
				temp = None
			if not specific_file.find(ROOT_DIR) >= 0:
				specific_file = ROOT_DIR + "..\\files\\clientFiles\\""" + specific_file
			if not self.output['file'].find(ROOT_DIR) >= 0:
				self.output['file'] = ROOT_DIR + "..\\files\\clientFiles\\""" + self.output['file']
			# print(specific_file)
			# print(self.output['file'])
			copyfile(specific_file, self.output['file'])

			self.functions = self.source['functions']
			self.hardcoded = self.source['hardcoded']
			self.row_obj = Row(self.output['file'], self.output['sheet'], self.functions)
			self.word_export = self.output['word_export']

		except IndexError:
			self.update = None
		try:
			self.expression = self.data['update']
		except IndexError:
			self.expression = None

	def get_update(self):

		for hardcoded_index in self.hardcoded:
			value = self.hardcoded_input[hardcoded_index]
			value = str(value).replace("percent", "%")
			hardcoded_cell = Cell(parent=None, data=value, file=self.output['file'],
			                      sheet=self.output['sheet'],
			                      column=hardcoded_index, style=None)
			self.row_obj.add(hardcoded_cell)

		math_ops = self.source['math']
		math_cols = list(math_ops.keys())

		for math_col in math_cols:
			details = math_ops[math_col]
			# print(math_ops)

			for section in details:
				if str(self.company_dict[self.subject][0]).find("LLC") >= 0:
					if not (str(type(section)).find('dict') >= 0):
						continue
					if str(section['sheet']).find('LTD') >= 0:
						section['sheet'] = str(section['sheet']).replace('LTD',
						                                                 str(self.company_dict[self.subject][0]))
					if str(section['column']).find('LTD') >= 0:
						section['column'] = str(section['column']).replace('LTD', str(
							self.company_dict[self.subject][0]))

			# print(str(details),)
			# TODO : Generate expression tree
			math_data = Pattern.gen_tree(details)
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
				temp_subject = self.subject
				# if str(details['sheet']).find('Capital Allocation') >= 0:
				# 	details['sheet'] = 'Capital Allocation ' + self.company_dict[self.subject][0]

				if str(self.company_dict[self.subject][0]).find("LLC") >= 0:
					details['sheet'] = str(details['sheet']).replace('Ltd', self.company_dict[self.subject][0])
					details['column'] = str(details['column']).replace('Ltd', self.company_dict[self.subject][0])

				if str(details['file']).find('Drawn_Capital') >= 0:
					temp_subject = self.company_dict[self.subject][1]

				# print(str(company_dict[self.subject]))
				# print(str(details['file'] + " " + details['sheet'] + " " + details['column'] + " " + self.subject))

				data_value = Search.find(details['file'], details['sheet'],
				                         details['column'], temp_subject)

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
