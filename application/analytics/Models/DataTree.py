from Models.DataNode import DataNode


class DataTree:

    def __init__(self, root: DataNode = None):
        self.root = root
        self.id = "Data tree"
        self.current = root

    def process(self):
        return self.root.evaluate()

    def add(self, item: DataNode):
        # print("\n")
        # print("CURRENT IS: " + str(self.current))
        if not self.root:
            # print("Adding " + str(item) + " as root")  # TODO : FOR TEST
            self.root = item
            self.current = item
            return True

        print("OPS " + str(item) + " appended to " + str(self.current))
        current_add = self.current.append(item)

        # print("Root add: " + str(current_add))  # TODO : FOR TEST

        if current_add:
            self.current = item
        else:
            # print("Could not append " + str(item) + " to " + str(self.current) + "\nAppending to parent...")
            # print("Parent: " + str(self.current.parent))
            if not self.current.parent:
                self.root = item
                temp = self.current
                self.current = item
                self.current.append(temp)

            parent_add = self.current.parent.append(item)
            if not parent_add:
                # print("ERROR: Not added to tree: " + str(item))  # TODO : FOR TEST
                return False
            else:
                self.current = item

    def draw(self):
        print("DRAWING OF EXPRESSION TREE BEGIN:")
        print(self.root.draw())
        print("DRAWING OF EXPRESSION TREE END!")
