import fileinput
import os
from Definitions import ROOT_DIR


class FunctionCatalog:

    def __init__(self):
        self.raw_storage = ROOT_DIR + "\Functions\Catalog.py"
        self.temp_storage = "Catalog_temp.py"
        self.package_name = "Functions"
        with open(self.raw_storage, "r+") as catalog:
            self.storage = list(catalog)

    def save(self, key: str, operator: str):
        existing = self.get(key)
        if existing and existing.find(operator) >= 0:
            # print("Function already exists!")  # TODO : FOR TEST
            return
        else:
            storage_write = fileinput.FileInput(self.raw_storage, inplace=True)
            class_header = "    catalog = {\n        \""
            operation = class_header + key + "\": " + operator + ",\n"

            new_file = open(self.temp_storage, 'w+')
            catalog_start = False
            for line in list(storage_write):
                read_temp = line
                if read_temp.find("{") >= 0:
                    catalog_start = True
                if catalog_start and read_temp.find(",") == -1:
                    new_file.write(operation)
                    catalog_start = False
                else:
                    new_file.write(line)

            storage_write.close()
            new_file.close()
            # os.remove(self.temp_storage)

            storage_write = open(self.raw_storage, 'w+')

            new_file = fileinput.FileInput(self.temp_storage, inplace=True)

            storage_write.write("from " + self.package_name + "." +
                                operator + " import " + operator + "\n")
            for line in list(new_file):
                storage_write.write(line)

            storage_write.close()
            new_file.close()
            os.remove(self.temp_storage)

    def get(self, key: str):
        key = "\"" + key + "\""

        for line in self.storage:
            # print("Line: " + line)
            # print("Key: " + key)
            if line.find(key) >= 0:
                to_find = key + ": "
                # print("TEST " + to_find)
                if line.find(to_find) >= 0:
                    result = line.split()[1]
                    if len(result) > 0:
                        # print("Result: " + str(result))
                        return result
        return None


