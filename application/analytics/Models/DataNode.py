from abc import abstractmethod


class DataNode:

    def __init__(self, parent=None, left=None, right=None, func=False):
        self.left = left
        self.right = right
        self.parent = parent
        self.func = func

    def is_leaf(self):
        return (not self.left) and (not self.right)

    def append(self, new_node):
        # print("left: " + str(self.left))  # TODO : FOR TEST
        # print("right: " + str(self.right))   # TODO : FOR TEST
        if not self.right:
            # print("Appending " + str(new_node) + " to right of " + str(self))  # TODO : FOR TEST
            self.right = new_node
            return True
        if not self.left:
            # print("Appending " + str(new_node) + " to left of " + str(self))  # TODO : FOR TEST
            self.left = new_node
            return True
        elif self.parent:
            # print("Appending " + str(new_node) + " to parent of " + str(self))  # TODO : FOR TEST
            self.parent.append(new_node)
        else:
            # print("Could not append " + str(new_node) + " to " + str(self))  # TODO : FOR TEST
            return False

    @abstractmethod
    def draw(self):
        pass

    @abstractmethod
    def evaluate(self):
        pass

    @abstractmethod
    def set_value(self, val):
        pass


