Sub UpdateFormula()
   Dim return_range As Range
    Dim return_row As Integer
    Dim return_col As Integer
    Dim hidden_col1 As Integer
    Dim hidden_col2 As Integer
    Dim filled_row As Integer
    Dim start_row As Integer
    Dim start_cell1 As String
    Dim start_cell2 As String
    Dim formula_cell As String
    Dim total_range As Range
    Dim total_row As Integer
    Dim last_row As Integer
    Dim last_cell As String
    Dim fill_range As String

    Set return_range = ThisWorkbook.ActiveSheet.Range("A1:Z50").Find("Monthly Return")
    return_row = return_range.row
    return_col = return_range.Column
    hidden_col1 = return_col + 1
    hidden_col2 = return_col + 2

    filled_row = return_row + 1
    Do While Cells(filled_row, hidden_col2).Value = ""
        filled_row = filled_row + 1
    Loop

    start_row = filled_row + 1
    start_cell1 = ThisWorkbook.ActiveSheet.Cells(start_row, hidden_col1).Address(RowAbsolute:=False, ColumnAbsolute:=False)
    start_cell2 = ThisWorkbook.ActiveSheet.Cells(filled_row, hidden_col2).Address(RowAbsolute:=False, ColumnAbsolute:=False)
    formula_cell = ThisWorkbook.ActiveSheet.Cells(start_row, hidden_col2).Address(RowAbsolute:=False, ColumnAbsolute:=False)

    ThisWorkbook.ActiveSheet.Range(formula_cell).Value = "=" & start_cell1 & "*" & start_cell2

    Set total_range = ThisWorkbook.ActiveSheet.Range("A1:D500").Find("Total")
    total_row = total_range.row
    last_row = total_row - 1

    last_cell = ThisWorkbook.ActiveSheet.Cells(last_row, hidden_col2).Address(RowAbsolute:=False, ColumnAbsolute:=False)
    fill_range = formula_cell & ":" & last_cell
    ThisWorkbook.ActiveSheet.Range(fill_range).FillDown


End Sub
