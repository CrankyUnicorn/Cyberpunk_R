
//ENTRY POINT------------------------------------------------------------------
const create_html = () =>{
   if (document.getElementById("sheet_page_div")) {
      
      request_character_sheet_info("stats");
   }
   
}


//BASIC ACTIONS----------------------------------------------------------------
const write_html = (html) =>{
   
   main_div = document.getElementById("sheet_page_div");

   if(html!=null && main_div!=null){
      
      main_div.innerHTML = html;
   }
}

const getElementValue = (element_id) =>{
   const element = document.getElementById(element_id);
   return  element.value;
}

const removeAllChildren = (element_id) =>{
   const element = document.getElementById("element_id");
   while(element.firstChild) { 
      element.removeChild(element.firstChild); 
  } 
}


//ESTHETICS--------------------------------------------------------------------
const blinker = () =>{

   const element = document.getElementById('footer_blinker');
   element.classList.remove("footer_blinker_animation");
   void element.offsetWidth;
   element.classList.add("footer_blinker_animation");
}

//INSERT-----------------------------------------------------------------------
const insert_character_sheet_info = (table,name,column,value) =>{
   
   // get the URL
   const http = new XMLHttpRequest();
   const url = 'pc_sheet_operations.php';
   const params = ''.concat('insert','&','table=',table,'&','name','=',name,'&','column','=',column,'&','value','=',value);
   
   http.open('POST', url, true);

   //Send the proper header information along with the request
   http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

   http.onreadystatechange = function() {//Call a function when the state changes.
    if(http.readyState == 4 && http.status == 200) {
      
      if (http.responseText) {
         
         alert(http.responseText);
      }

      blinker();
    }
   }

   http.send(params);
   
   // prevent form from submitting
   return false;
};

//UPDATE-----------------------------------------------------------------------
const update_character_sheet_info = (table,name,column,value) =>{
   
   // get the URL
   const http = new XMLHttpRequest();
   const url = 'pc_sheet_operations.php';
   const params = ''.concat('update','&','table=',table,'&','name','=',name,'&','column','=',column,'&','value','=',value);
   
   http.open('POST', url, true);

   //Send the proper header information along with the request
   http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

   http.onreadystatechange = function() {//Call a function when the state changes.
    if(http.readyState == 4 && http.status == 200) {
      
      if (http.responseText) {
         
         alert(http.responseText);
      }
      
      blinker();
    }
   }

   http.send(params);
   
   // prevent form from submitting
   return false;
};


//VIEW-------------------------------------------------------------------------
const request_character_sheet_info = (table_request) =>{
   //table_request defines the type of data requested from the Database

   // get the URL
   const http = new XMLHttpRequest();
   const url = "pc_sheet_operations.php";
   const params = ''.concat('view','&','table=',table_request);
   
   http.open('POST', url, true);

   //Send the proper header information along with the request
   http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

   http.onreadystatechange = function() {//Call a function when the state changes.
    if(http.readyState == 4 && http.status == 200) {
          
      blinker();
    }
   }

   http.onload = function() {
      const str = JSON.parse(http.responseText);
      //const strstart = str.search("<!--skillstart-->");
      //const strend = str.search("<!--skillend-->")+15;
      //const substr = str.substring(strstart,strend);
      
      console.log(str);

      build_ui(str);
   }

   http.send(params);
   
   // prevent form from submitting
   return false;
};


//STATS RELATED OPERATIONS-----------------------------------------------------
const up_stats_value = (stat_name) => {
   let stats = stat_name;
   const sufix = "_value";
   const max_sufix = "_max_value";
   let stat_max_value = parseInt(document.getElementById(stats.concat(max_sufix)).value);
   let stat_value = parseInt(document.getElementById(stats.concat(sufix)).value);
   
   if( stat_value < stat_max_value ){
      stat_value += 1;
   }
   
   document.getElementById(stats.concat(sufix)).value = stat_value.toString();

   update_character_sheet_info("stats",stats,"value",stat_value);
};


const down_stats_value = (stat_name) => {
   let stats = stat_name;
   const sufix = "_value";
   
   let stat_value = parseInt(document.getElementById(stats.concat(sufix)).value);
   
   if( stat_value > 0 ){
      stat_value -= 1;
   }
   
   document.getElementById(stats.concat(sufix)).value = stat_value.toString();

   update_character_sheet_info("stats",stats,"value",stat_value);
};

const oninput_stats_value = (stat_name) => {
  
   let stats = stat_name;
   const sufix = "_value";
   const max_sufix = "_max_value";

   
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

   //doesn't require to send since it will do at element blur
};

const oninput_stats_max_value = (stat_name) => {
  
   let stats = stat_name;
   const sufix = "_value";
  

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

   //doesn't require to send since it will do at element blur
};


const onblur_stats_value = (stat_name) => {
   const stats = stat_name;
   const sufix = "_value";
   
   let stat_value = parseInt(document.getElementById(stats.concat(sufix)).value);
   
   update_character_sheet_info("stats",stats,"value",stat_value);
};

const onblur_stats_max_value = (stat_name) => {
   const stats = stat_name;
   const max_sufix = "_max_value";

   let stat_max_value = parseInt(document.getElementById(stats.concat(max_sufix)).value);
   
   update_character_sheet_info("stats",stats,"max_value",stat_max_value);
};


//BUILD SHEET UI
const build_ui = (status) =>{

   const panel = document.getElementById("sheet_page_div");

   const sheet = document.createElement("div");
   sheet.className = "pc_intro_panel";
   panel.appendChild(sheet);

   const sheet_title = document.createElement("h3");
   sheet_title.style.textAlign = "center";
   for (let index = 0; index < status.length; index++) {
      if (status[index]["character_name"]) {
         sheet_title.textContent = status[index]["character_name"];
      }
   }
   sheet.appendChild(sheet_title);

   const sub_title = document.createElement("h4");
   sub_title.className = "pc_forms_text";
   sub_title.textContent = "Stats";
   sheet.appendChild(sub_title);
   
   const stats_form = document.createElement("form");
   stats_form.setAttribute("method", "post"); 
   stats_form.setAttribute("action", ""); 
   stats_form.id = "stats_form";
   sheet.appendChild(stats_form);
  
   
   const form_inner_div = document.createElement("div");
   form_inner_div.className = "pc_stats_panel";
   stats_form.appendChild(form_inner_div);

   for (let index = 0; index < status.length; index++) {
      if (status[index]["value"]==null ) {
         continue;
      }
      
      const stat_block = document.createElement("div");
      stat_block.className = "pc_stats_block";
      if (status[index]["name"]=="HUM" || status[index]["name"]=="HP") {
         stat_block.style.width = "175px";   
      }
      form_inner_div.appendChild(stat_block);

      const stat_header = document.createElement("div");
      stat_header.className = "pc_stats_block_header";
      stat_header.textContent = status[index]["name"];
      stat_block.appendChild(stat_header);

      const stat_inner_div = document.createElement("div");
      stat_inner_div.style.marginTop = "4px";
      stat_block.appendChild(stat_inner_div);


      const max_value_div = document.createElement("div");
      max_value_div.style.height = "16px";
      max_value_div.style.width = "auto";
      if (status[index]["max_value"]) { //used to hide max value div
         //max_value_div.style.display = "none";  
      }
      stat_inner_div.appendChild(max_value_div);
      
      const  max_label = document.createElement("label");
      max_label.className = "pc_stats_block_label";
      max_label.textContent = "|"
      max_value_div.appendChild(max_label);

      const  max_value = document.createElement("input");
      max_value.type = "text";
      max_value.className = "pc_stats_block_value_max";
      max_value.id = "".concat(status[index]["name"],"_max_value");
      max_value.name = "".concat(status[index]["name"],"_max_value");
      max_value.value = status[index]["max_value"];
      max_value.addEventListener("input",function(){ oninput_stats_max_value(status[index]["name"] ) },false);
      max_value.addEventListener("change",function(){ onblur_stats_max_value(status[index]["name"] ) },false);
      max_value_div.appendChild(max_value);


      const current_value_div = document.createElement("div");
      current_value_div.className = "pc_stats_block_value_max";
      current_value_div.style.height = "auto";
      current_value_div.style.width = "auto";
      stat_inner_div.appendChild(current_value_div);
   
      const current_value = document.createElement("input");
      current_value.type = "text";
      current_value.className = "pc_stats_block_value";
      current_value.id = "".concat(status[index]["name"],"_value");
      current_value.name = "".concat(status[index]["name"],"_value");
      current_value.value = status[index]["value"];
      current_value.addEventListener("input",function(){ oninput_stats_value(status[index]["name"] ) },false);
      current_value.addEventListener("change",function(){ onblur_stats_value(status[index]["name"] ) },false);
      current_value_div.appendChild(current_value);
     
      const up_button = document.createElement("div");
      up_button.className = "pc_stats_corner_up";
      up_button.addEventListener("click",function(){ up_stats_value( status[index]["name"] ) },false)
      stat_block.appendChild(up_button);
      
      const down_button = document.createElement("div");
      down_button.className = "pc_stats_corner_down";
      down_button.addEventListener("click",function(){ down_stats_value( status[index]["name"] ) },false)
      stat_block.appendChild(down_button);
   }

   
}



   
