from Controller import Controller
import sys

# ctrl = Controller.update("ProcedureProfiles\\BF_Monthly_011.json")
file = "ProcedureProfiles\\BF_Monthly_" + str(sys.argv[1]) + ".json"
ctrl = Controller.update(file, sys.argv[2])
print(ctrl)
