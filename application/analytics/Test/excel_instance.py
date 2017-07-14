import unittest
from Services.ExcelInstance import ExcelInstance
import os


class MyTestCase(unittest.TestCase):
	def test_something(self):

		# xl = win32com.client.Dispatch("Excel.Application")
		# xl.Application.Visible = True
		# xl.Workbooks.Open(Filename="C:\\xampp\htdocs\gatekeeper\\application\\analytics\Test\BF Monthly.xlsm")
		file_name = "C:\\xampp\htdocs\gatekeeper\\application\\analytics\Test\BF Monthly output.xlsm"
		row = 48

		xl = ExcelInstance(file_name)

		# xl.fill_down(row)
		xl.save_and_quit()

		# xl.Application.Run('Dim prev_row As Integer Dim rg As String prev_row = 48 - 1 rg = "G" & prev_row & ":" & "Q" & row Worksheets("Chart").Range(rg).FillDown')
		# xl.Application.Run('MsgBox "Macro"')
		# xl.instance.Save()
		print("Till here")
		"""
		os.replace(new_name, file_name)
	# end here """

if __name__ == '__main__':
	unittest.main()
