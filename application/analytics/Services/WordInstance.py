import win32com.client as win32
from Definitions import ROOT_DIR


class WordInstance:

	def __init__(self, file: str):
		self.file = file
		self.instance = win32.Dispatch('Word.Application')
		self.application = self.instance.Application
		self.base = ROOT_DIR + "..\\files\\clientFiles\\"""

		if not file.find(ROOT_DIR) >= 0:
			file = self.base + file

		self.instance.Documents.Open(file)

	def save_and_quit(self):
		self.application.Quit()

	def bf_monthly_export_word(self):

		template = self.base + "BF_Monthly output.xlsm"
		asset_ownership = self.base + "Asset Ownership & Deal Exposure.xlsx"
		charts = self.base + "BF_presentation charts.xlsx"
		bfsl_nav = self.base + "BFSL_NAV.xlsx"

		self.application.Run("ExtractData", template, asset_ownership, charts, bfsl_nav)
		self.save_and_quit()
		return self.base + self.file
