//STATS----------------------------------------------------------------------------------------
const submit_stats = (stats_name) =>{
   
   const stat_name = ''.concat(stats_name , '_value'); 

   const stat_value = document.getElementById(stat_name).value;

   // get the URL
   const http = new XMLHttpRequest();
   const url = 'update_pc_stats.php';
   const params = ''.concat('target=',stats_name,'&',stats_name,'=',stat_value);
   http.open('POST', url, true);

   //Send the proper header information along with the request
   http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

   http.onreadystatechange = function() {//Call a function when the state changes.
    if(http.readyState == 4 && http.status == 200) {
      //alert(http.responseText);
      const element = document.getElementById('footer_blinker');
      element.classList.remove("footer_blinker_animation");
      void element.offsetWidth;
      element.classList.add("footer_blinker_animation");
    }
   }

   /*var params = new Object();
   params.myparam1 = myval1;
   params.myparam2 = myval2;

   // Turn the data object into an array of URL-encoded key/value pairs.
   let urlEncodedData = "", urlEncodedDataPairs = [], name;
   for( name in params ) {
   urlEncodedDataPairs.push(encodeURIComponent(name)+'='+encodeURIComponent(params[name]));
   }*/ 

   http.send(params);
   
   // prevent form from submitting
   return false;
};



const up_value = (stat_name) => {
   let stats = stat_name;
   let sufix = "_value";
   let max_sufix = "_max_value";

   let stat_max_value = parseInt(document.getElementById(stats.concat(max_sufix)).value);
   let stat_value = parseInt(document.getElementById(stats.concat(sufix)).value);
   
   if( stat_value < stat_max_value ){
      stat_value += 1;
   }
   
   document.getElementById(stats.concat(sufix)).value = stat_value.toString();

   submit_stats(stat_name);
};


const down_value = (stat_name) => {
   let stats = stat_name;
   let sufix = "_value";
   
   let stat_value = parseInt(document.getElementById(stats.concat(sufix)).value);
   
   if( stat_value > 0 ){
      stat_value -= 1;
   }
   
   document.getElementById(stats.concat(sufix)).value = stat_value.toString();

   submit_stats(stat_name);
};

const oninput_value = (stat_name) => {
  
   let stats = stat_name;
   let sufix = "_value";
   let max_sufix = "_max_value";

   let stat_max_value = parseInt(document.getElementById(stats.concat(max_sufix)).value);
   let stat_value = parseInt(document.getElementById(stats.concat(sufix)).value);
   
   if (!stat_value || stat_value==null ) {
      
      document.getElementById(stats.concat(sufix)).value = '';
      return;
   }else{

      if( stat_value > stat_max_value ){
         stat_value = stat_max_value;
      } else  if( stat_value < 0 ){
         stat_value = 0;
      }
   }
      
   document.getElementById(stats.concat(sufix)).value = stat_value.toString();
};

const oninput_max_value = (stat_name) => {
  
   let stats = stat_name;
   let sufix = "_value";

   let stat_value = parseInt(document.getElementById(stats.concat(sufix)).value);
   
   if (!stat_value || stat_value==null ) {
      
      document.getElementById(stats.concat(sufix)).value = '';
      return;
   }else{
      
      if( stat_value < 0 ){
         stat_value = 0;
      }
   }
      
   document.getElementById(stats.concat(sufix)).value = stat_value.toString();
};

const onblur_value = (stat_name) => {

   let stats = stat_name;
   let sufix = "_value";
   let max_sufix = "_max_value";

   let stat_max_value = parseInt(document.getElementById(stats.concat(max_sufix)).value);
   let stat_value = parseInt(document.getElementById(stats.concat(sufix)).value);
   
   submit_stats(stat_name);
};

const onblur_max_value = (stat_name) => {
   /*
      let stats = stat_name;
      let sufix = "_value";
      let max_sufix = "_max_value";
   
      let stat_max_value = parseInt(document.getElementById(stats.concat(max_sufix)).value);
      let stat_value = parseInt(document.getElementById(stats.concat(sufix)).value);
      */
      submit_stats(stat_name);
};

//SKILLS----------------------------------------------------------------

const insert = (table,column,name,value) =>{
   
   
   // get the URL
   const http = new XMLHttpRequest();
   const url = 'update_pc_sheet.php';
   const params = ''.concat('table=',table,'&','name','=',name,'&','column','=',column,'&','value','=',value);
   console.log(params)
   http.open('POST', url, true);

   //Send the proper header information along with the request
   http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

   http.onreadystatechange = function() {//Call a function when the state changes.
    if(http.readyState == 4 && http.status == 200) {
      //alert(http.responseText);
      const element = document.getElementById('footer_blinker');
      element.classList.remove("footer_blinker_animation");
      void element.offsetWidth;
      element.classList.add("footer_blinker_animation");
    }
   }

   http.send(params);
   
   // prevent form from submitting
   return false;
};

const getElementValue = (element_id) =>{
   const element = document.getElementById(element_id);
   return  element.value;
}

   
