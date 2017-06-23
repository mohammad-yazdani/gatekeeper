import unittest
import json
import pandas as pd
from Services.Search import Search
from ProcedureProfiles.Interpreter import Interpreter


class MyTestCase(unittest.TestCase):
    def test_something(self):
        data = open("json_test.json").read()
        data = json.loads(data)
        # print(data['dependencies'])
        dependency_name = data['dependencies']
        dependencies = list()
        for file in dependency_name:
            dependencies.insert(0, pd.ExcelFile(file))
        # print(dependencies)
        template = pd.ExcelFile(data['template'])
        # print(template)
        columns = data['columns']
        # print(columns)
        company = "The J. Paul Getty Trust"
        cells = list()

        for index in columns:
            expression = Interpreter.static_read(columns[index])
            # print(expression)
            file = expression.pop() + ".xlsx"
            sheet = expression.pop().replace("_", " ")
            category = expression.pop().replace("_", " ")
            result = Search.find_row_in_col(file, sheet, category, company)
            cells.insert(0, result)

        print(cells)

if __name__ == '__main__':
    unittest.main()
