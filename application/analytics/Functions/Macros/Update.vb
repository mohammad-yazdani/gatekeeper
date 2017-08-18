Sub Update()
    Dim total_range As Range
    Dim total_row As Integer
    Dim total_col As Integer
    Dim prev_row As Integer
    Dim old_date As Date
    Dim old_tbill As Double
    Dim monthend_range As Range
    Dim monthend_row As Integer
    Dim monthend_col As Integer
    Dim monthend_value As Date

    Set monthend_range = ThisWorkbook.ActiveSheet.Range("A1:H50").Find("Month End")
    monthend_row = monthend_range.row
    monthend_col = monthend_range.Column + 1
    Do While ThisWorkbook.ActiveSheet.Cells(monthend_row, monthend_col).Value = “”
        monthend_col = monthend_col + 1
    Loop
    monthend_value = DateSerial(Year(Date), Month(Date), 0)
    ThisWorkbook.ActiveSheet.Cells(monthend_row, monthend_col).Value = Format(monthend_value, "dd-mmm-yyyy")


    Set total_range = ThisWorkbook.ActiveSheet.Range("A1:D500").Find("Total")
    total_row = total_range.row
    total_col = total_range.Column
    prev_row = total_row - 1

    old_date = ThisWorkbook.ActiveSheet.Cells(prev_row, total_col).Value
    old_tbill = ThisWorkbook.ActiveSheet.Cells(prev_row, total_col + 11).Value
    ThisWorkbook.ActiveSheet.Cells(prev_row, total_col).Value = Format(old_date, "dd-mmm-yyyy") ' Changes Date format
    ThisWorkbook.ActiveSheet.Cells(prev_row, total_col + 11).Value = Format(old_tbill, "0.0000%") ' Changes T-bill Rate format
End Sub

