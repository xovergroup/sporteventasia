function getDataFromLocalStorage(key) {
    
    var array;
    
    if(localStorage.getItem(key) === null) {
        array = [];
    } else {
        array = JSON.parse(localStorage.getItem(key));
    }
    return array;
}

function addDataToLocalStorage(key, value){
    
    var array =  getDataFromLocalStorage(key);
    
    array.push(value);
    
    localStorage.setItem(key, JSON.stringify(array));
     
}

function addArrayToLocalStorage(key, array){
    localStorage.setItem(key, JSON.stringify(array));
}

function addOneValueToLocalStorage(key, value){
    localStorage.setItem(key, JSON.stringify(value));
}

function getOneValueToLocalStorage(key){
    
    var value = JSON.parse(localStorage.getItem(key));
    
    return value;
}

function removeFromLocalStorage(key){
    localStorage.removeItem(key);
}
