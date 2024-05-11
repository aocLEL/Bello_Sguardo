const sheet_key = "1XtlHtoKN6SmVQQ4j1RsPdHaMqiI6EdcMZNstMbTvnJU";
const sheet_name = "values";

// for GET requests
function doGet(e) {
  let ss = SpreadsheetApp.openById(sheet_key);
  let sheet = ss.getSheetByName(sheet_name);
  //Read data from the range sheet!B2:B4
  let values = sheet.getRange("values!B2:B4").getValues();

  //Log the data that was read
  //for debugging use
  Logger.log(JSON.stringify(values));

  //return datas in JSON format
  return ContentService.createTextOutput(JSON.stringify(values));
  
}


// for POST requests
function doPost(e) {
  try {
    const coord = e.parameter.coord;
    const value = e.parameter.value;
    let ss = SpreadsheetApp.openById(sheet_key);
    let sheet = ss.getSheetByName(sheet_name);
    let range = "";
    switch(coord) {
      case 'x':
        range = "B2";
        break;
      case 'y':
        range = "B3";
        break;
      case 'z':
        range = "B4";
        break;
      default:
        console.log("Error!!");
        return;
    }
    ss.getRange(range).setValue(value);
    return ContentService.createTextOutput('200');
  } catch(e) {
    return ContentService.createTextOutput('400');
  }
}

