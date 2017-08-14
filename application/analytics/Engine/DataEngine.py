import os

from Definitions import ROOT_DIR
from Services.ExcelInstance import ExcelInstance
from Models import DataTree
from Services.Pattern import Pattern
from ProcedureProfiles.JSON_Interpreter import JSONInterpreter
from ProcedureProfiles.Translate.Symbols import Symbols
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
		print("Preparing ...", )
		ExcelInstance.prepare()
		WordInstance.prepare()
		print("Connecting to knowledge base...", )
		sym_translate = Symbols()
		json_string = sym_translate.translate_string(str(open(hardcoded_json).read()))
		hardcoded_json = json.loads(json_string)
		json_interpreter = JSONInterpreter(json_profile, hardcoded_json)
		print("Writing to Excel File ...", )
		path = json_interpreter.row_obj
		output_file = path.write_functions()
		json_interpreter.get_update()
		path.write()
		print("Finalizing Excel File ...", )
		# TODO : HERE
		excel_direct = ExcelInstance(path.file)
		excel_direct.update()
		excel_direct.update_formula()
		excel_direct.save_and_quit()

		print("Exporting output ...", )
		word_instance = WordInstance(json_interpreter.word_export)
		output_file = word_instance.bf_monthly_export_word()
		return output_file

	# except Exception as e:
	# print(e)
