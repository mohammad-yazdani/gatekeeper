from Controller import Controller
import sys


if __name__ == '__main__':
    print("Script running...")

    procedures = list()
    for i in range(1, len(sys.argv) - 1):
        procedures.insert(0, sys.argv[i])
    destination = sys.argv[len(sys.argv) - 1]
    ctrl = Controller(procedures, destination)
    ctrl.process()
    # print(str(ctrl.output))
    ctrl.export()

else:
    print("main not running")
