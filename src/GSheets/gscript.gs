var sheet_key = "---SHEET-KEY---";


function doGet(e) {
  var ss = SpreadsheetApp.openById(sheet_key);
  var sheet_name = "values";
  var sheet = ss.getSheetByName(sheet_name);
  //Read data from the range sheet!B2:B4
  var values = sheet.getRange("values!B2:B4").getValues();
  Logger.log(JSON.stringify(values));
  return ContentService.createTextOutput(JSON.stringify(values));
  
}