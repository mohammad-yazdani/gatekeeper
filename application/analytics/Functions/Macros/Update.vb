Sub Update()
    Dim total_range As Range
    Dim total_row As Integer
    Dim total_col As Integer
    Dim prev_row As Integer
    Dim old_date As Date
    Dim tbill_range As Range
    Dim tbill_col As Integer
    Dim monthend_range As Range
    Dim monthend_row As Integer
    Dim monthend_col As Integer
 
    Set monthend_range = ThisWorkbook.ActiveSheet.Range("A1:H50").Find("Month End")
    monthend_row = monthend_range.Row
    monthend_col = monthend_range.Column + 1
    Do While ThisWorkbook.ActiveSheet.Cells(monthend_row, monthend_col).Value = “”
        monthend_col = monthend_col + 1
    Loop
    
    Set total_range = ThisWorkbook.ActiveSheet.Range("A1:D500").Find("Total")
    total_row = total_range.Row
    total_col = total_range.Column
    prev_row = total_row - 1
    old_date = ThisWorkbook.ActiveSheet.Cells(prev_row, total_col).Value
    ThisWorkbook.ActiveSheet.Cells(monthend_row, monthend_col).Value = Format(old_date, "dd-mmm-yyyy")
    ThisWorkbook.ActiveSheet.Cells(prev_row, total_col).Value = Format(old_date, "dd-mmm-yyyy") ' Changes Date format
 
 
 
    Set tbill_range = ThisWorkbook.ActiveSheet.Range("A1:Z50").Find("T-bill Rate", MatchCase:=False)
    tbill_col = tbill_range.Column
    old_tbill = ThisWorkbook.ActiveSheet.Cells(prev_row, tbill_col).Value
    ThisWorkbook.ActiveSheet.Cells(prev_row, tbill_col).Value = Format(old_tbill, "0.0000%") ' Changes T-bill Rate format
End Sub
