import json

from Definitions import ROOT_DIR


class Translate:

	def __init__(self, dict_file: str):
		if not dict_file.find(ROOT_DIR) >= 0:
			dict_file = ROOT_DIR + "ProcedureProfiles\\Translate\\" + dict_file
		self.dictionary = json.load(open(dict_file))

	def translate_string(self, data: str):
		for word in self.dictionary:
			data = data.replace(word, self.dictionary[word])

		return data
