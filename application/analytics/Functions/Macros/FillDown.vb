Sub FillDown(row As Integer)
    Dim prev_row As Integer
    Dim rg As String
    Dim SR_address As String
    Dim SR_col As String
    SR_address = Worksheets("Chart").Range("A1", "Z50").Find("Sharpe Ratio").Address(True, False)
    SR_col = Left(SR_address, 1)
    prev_row = row - 1
    rg = "G" & prev_row & ":" & SR_col & row
    Worksheets("Chart").Range(rg).FillDown
    Worksheets("Chart").Rows(row).RowHeight = 15 
End Sub