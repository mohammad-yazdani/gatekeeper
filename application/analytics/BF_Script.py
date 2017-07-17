from Controller import Controller
import sys
import os.path
from Definitions import ROOT_DIR

log_dir = ROOT_DIR + "option/"

if not os.path.exists(log_dir):
	os.mkdir(log_dir)

path = log_dir + "recent_log.txt"
log = open(path, 'ab')

file = "ProcedureProfiles\\BF_Monthly.json"
ctrl = Controller.update(file, sys.argv[1])
ctrl = str(ctrl)
print(ctrl)

# if open(sys.argv[1]):
	# os.remove(sys.argv[1])

log.write(bytes(ctrl, 'utf-8'))
log.close()

if os.path.exists(ROOT_DIR + "..\\files\\clientFiles\\Drawn_Capital.xlsx"):
	os.remove(ROOT_DIR + "..\\files\\clientFiles\\Drawn_Capital.xlsx")
