import sys

from Functions.Catalog import Catalog
from Engine.DataEngine import DataEngine
from Services.Export import Export


class Controller:

	def __init__(self, destination: str, procedures: list=None):
		Catalog()
		self.procedures = procedures
		# print("Procedures: " + str(self.procedures))
		self.destination = destination
		print("Destination: " + self.destination)
		self.output = list()
		self.coordinates = list()

	def process(self):
		# print("Processing in controller ...")
		ctrl = 0
		for index in range(0, len(self.procedures)):
			# print(str(ctrl))
			ctrl += 1
			input_arg = self.procedures[index]

			# print("Engine args: " + str(input_arg))

			engine = DataEngine(input_arg)

			temp = engine.output
			self.coordinates = temp.pop(0)
			temp.insert(0, input_arg)

			self.output.insert(0, temp)
			# print(input_arg)  # TODO : FOR TEST
			# engine.print_output()  # TODO : FOR TEST
			# print("\n")  # TODO : FOR TEST

	@staticmethod
	def update(json: str):
		return DataEngine.update_excel(json)

	def export(self):
		export = Export(self.output, sys.argv[len(sys.argv) - 1], self.coordinates)
		return export
