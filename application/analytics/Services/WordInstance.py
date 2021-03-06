import datetime
import time
import os
import shutil

import win32com.client as win32
from Definitions import ROOT_DIR


class WordInstance:

	def __init__(self, file: str):
		self.base = ROOT_DIR + "..\\files\\clientFiles\\"""

		if not file.find(ROOT_DIR) >= 0:
			file = self.base + file

		'''filename, file_extension = os.path.splitext(file)
		time_postfix = int(round(time.time() * 1000))
		# time_postfix = datetime.datetime.now()
		signature = " output_" + str(time_postfix)
		output_file = file.replace(file_extension, signature + file_extension)
		try:
			os.remove(output_file)
		except FileNotFoundError:
			pass
		shutil.copy(file, output_file)
		self.file = output_file'''

		self.file = file

		self.instance = win32.Dispatch('Word.Application')
		self.instance.DisplayAlerts = False
		self.application = self.instance.Application

		self.instance.Documents.Open(file)

	def save_and_quit(self):
		self.application.ActiveDocument.Save()
		self.application.Quit()

	def bf_monthly_export_word(self):

		template = self.base + "BF_Monthly output.xlsm"
		asset_ownership = self.base + "AssetsandOwnership.xlsx"
		charts = self.base + "BF_presentation charts.xlsx"
		bfsl_nav = self.base + "BFSL_NAV.xlsx"

		self.application.Run("ExtractData", template, asset_ownership, charts, bfsl_nav)
		self.save_and_quit()
		return self.file

	@staticmethod
	def total_quit():
		pass
		# instance = win32.Dispatch('Word.Application')
		# application = instance.Application
		# application.Quit()
