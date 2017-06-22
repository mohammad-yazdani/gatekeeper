from openpyxl import Workbook
from openpyxl import load_workbook
import json
from Models.DataTree import DataTree
from Models.Data import Data
from Functions.FunctionCatalog import FunctionCatalog
from Functions.Catalog import Catalog
from ProcedureProfiles.Interpreter import Interpreter


class Pattern:

    def __init__(self, file: str):
        self.procedure_profile = Interpreter(file).interpret_profile()
        self.finder = FunctionCatalog()
        self.output = None
        self.coordinates = None

    def interpret(self):
        self.output = DataTree()
        # TODO : Handle parent
        parent = None
        # print("Profile: " + str(self.procedure_profile))  # TODO : FOR TEST
        count = 0
        self.coordinates = self.procedure_profile.pop(0)
        for token in self.procedure_profile:
            # print("Token: " + token)
            is_function = self.finder.get(token)
            if is_function:
                token = Catalog.catalog[token](parent)
            else:
                # TODO : What if NOT a function?
                # TODO : Token TO Sheet and Column
                temp = ""
                output = list()
                index = 0
                for character in token:
                    if character == ".":
                        output.insert(index, temp)
                        index += 1
                        temp = ""
                    else:
                        temp += character
                output.insert(0, temp)

                # print("Output for interpreter: " + str(output))

                file = output[1]
                # print("File: " + file)
                sheet = output[2]
                # print("Sheet: " + sheet)
                column = int(output[0])
                # print("Col: " + str(column))

                token = Data(parent, file, sheet, column)

            # print("New Token: " + str(token))
            self.output.add(token)
            parent = token
            # self.output.draw()
            count += 1

        return self.output

    @staticmethod
    def test_new(path="void.xls"):
        wb = Workbook()
        wb.active["A1"] = 25
        wb.save(path)

    @staticmethod
    def test_update(path="void.xls"):
        wb = load_workbook(path)
        wb.active["A1"] = 45
        wb.active["B1"] = 45
        wb.save(path)

    @staticmethod
    def test_json():
        temp = json.dumps(['foo', {'bar': ('baz', None, 1.0, 2)}])
        print(temp)
