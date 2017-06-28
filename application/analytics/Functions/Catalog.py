from Functions.CopyLast import CopyLast
from Functions.Minus import Minus
from Functions.Addition import Addition


class Catalog:
    catalog = {
        "-": Minus,
        "+": Addition,
        "COPY_LAST": CopyLast
    }

    def __init__(self):
        # print("\nLoading knowledge base ...")
        # print(str(self.catalog.values()))
        # print("\n")
        for op in self.catalog.values():
            # print("OP: " + str(op))
            op()
