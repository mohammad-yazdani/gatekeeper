import os

from Definitions import ROOT_DIR
from Services.ExcelInstance import ExcelInstance
from Models import DataTree
from Services.Pattern import Pattern
from ProcedureProfiles.JSON_Interpreter import JSONInterpreter
from Services.WordInstance import WordInstance
import json


class DataEngine:

	def __init__(self, data: str):
		# print("Starting Data Engine ...")
		self.output = list()
		pattern = Pattern(data)
		pattern.interpret()
		exp_tree = pattern.output
		self.output.insert(0, pattern.coordinates)
		# exp_tree.draw()  # TODO : FOR TEST
		self.source = exp_tree
		self.process()

	def process(self):
		# print("Data Engine: Processing Expression Tree ...")
		self.output.insert(1, self.source.process())
		# print("Data Engine: Expression Tree Process Finished.")

	def print_output(self):
		print(str(self.output))

	@staticmethod
	def update_excel(json_profile: str, hardcoded_json: str):
		print("Connecting to knowledge base...",)
		# TODO : Handle hardcoded data

		hardcoded_json = json.load(open(hardcoded_json))
		return
		json_interpreter = JSONInterpreter(json_profile, hardcoded_json)
		print("Constructing data...",)
		print("Writing to Excel ...", )
		try:
			path = json_interpreter.row_obj
			output_file = path.write_functions()
			json_interpreter.get_update()
			path.write()
			print("Exporting output ...", )
			word_instance = WordInstance(json_interpreter.word_export)
			output_file = word_instance.bf_monthly_export_word()

			# print("Data ready!",)

			return output_file
		except Exception as e:
			print(e)

