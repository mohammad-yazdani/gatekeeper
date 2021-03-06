from Models.DataNode import DataNode
from abc import abstractmethod
from Functions.FunctionCatalog import FunctionCatalog


class UnaryOperator(DataNode):

    def __init__(self, parent: DataNode = None):
        super(UnaryOperator, self).__init__(parent)
        f_ctrl = FunctionCatalog()
        f_ctrl.save(self.add_to_catalog()['key'], self.add_to_catalog()['operator'])
        self.left = None

    @abstractmethod
    def evaluate(self):
        pass

    @abstractmethod
    def add_to_catalog(self):
        pass

    def set_value(self, val):
        return None

    def draw(self):
        print(str(self.add_to_catalog()['key']))
        if self.right:
            self.right.draw()

