
//ENTRY POINT------------------------------------------------------------------
const create_html = () =>{
   if (document.getElementById("sheet_page_div")) {
      
      request_character_sheet_info( build_ui );//build_ui is a callback
      
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

const json_counter = (status) =>{
   let count = 0;
   for(let line in status){
      count++;
   }
   return count;
}

const show_message = (message_text, type) =>{
   const html_body = document.getElementsByTagName('body');
   
   const old_message_panel = document.getElementById('message_panel');
   
   if ( old_message_panel != null ) {
      old_message_panel.remove();
   }
   
   const message_panel = document.createElement('div');
   message_panel.id = 'message_panel';
   if (type == 'error') {
      
      message_panel.className = 'pc_message_panel pc_message_panel_error'; 
   }else{

      message_panel.className = 'pc_message_panel'; 
   }
   message_panel.textContent =  message_text;
   html_body[0].appendChild(message_panel);
   
   const close_icon = document.createElement('i');
   //close_icon.className = 'pc_message_close_button fa fa-times pc_message_panel_exit_icon';
   message_panel.appendChild(close_icon);

}

//ESTHETICS--------------------------------------------------------------------
const blinker = () =>{

   const element = document.getElementById('footer_blinker');
   element.classList.remove("footer_blinker_animation");
   void element.offsetWidth;
   element.classList.add("footer_blinker_animation");
}

//INSERT-----------------------------------------------------------------------
const insert_character_sheet_info = (table,name,column,value, callback) =>{
   
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

      if (callback) {
         callback();   
      }

      blinker();
    }
   }

   http.send(params);
   
   // prevent form from submitting
   return false;
};

//DELETE-----------------------------------------------------------------------
const delete_character_sheet_info = (table,name,column,value, callback) =>{
   
   // get the URL
   const http = new XMLHttpRequest();
   const url = 'pc_sheet_operations.php';
   const params = ''.concat('delete','&','table=',table,'&','name','=',name,'&','column','=',column,'&','value','=',value);
   
   http.open('POST', url, true);

   //Send the proper header information along with the request
   http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

   http.onreadystatechange = function() {//Call a function when the state changes.
    if(http.readyState == 4 && http.status == 200) {
      
      if (http.responseText) {
         
         alert(http.responseText);
      }

      if (callback) {
         callback();   
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

//SELECT-------------------------------------------------------------------------
const select_character_sheet_info = (table_request, callback) =>{
   //table_request defines the type of data requested from the Database

   // get the URL
   const http = new XMLHttpRequest();
   const url = "pc_sheet_operations.php";
   const params = ''.concat('select','&','table=',table_request);
   
   http.open('POST', url, true);

   //Send the proper header information along with the request
   http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

   http.onreadystatechange = function() {//Call a function when the state changes.
    if(http.readyState == 4 && http.status == 200) {
          
      blinker();
    }
   }

   http.onload = function() {
      const json_array = JSON.parse(http.responseText);
            
      if (callback) {
         callback(json_array);
      }
   }

   http.send(params);
   
   // prevent form from submitting
   return false;
};

//VIEW-------------------------------------------------------------------------
const request_character_sheet_info = ( callback ) =>{
   //table_request defines the type of data requested from the Database

   // get the URL
   const http = new XMLHttpRequest();
   const url = "pc_sheet_operations.php";
   const params = ''.concat('view');
   
   http.open('POST', url, true);

   //Send the proper header information along with the request
   http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

   http.onreadystatechange = function() {//Call a function when the state changes.
    if(http.readyState == 4 && http.status == 200) {
          
      blinker();
   }
}

   http.onload = () => {
      const json_array = JSON.parse(http.responseText);
      
      if (callback) {
         callback(json_array);
      }
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
   
   const string_stat_value = stat_value == 0 ? "".concat( "0", stat_value.toString() ): stat_value.toString();
      
   document.getElementById(stats.concat(sufix)).value = string_stat_value;
   

   //doesn't require to send since it will do at element blur
};

const oninput_stats_max_value = (stat_name) => {
  
   let stats = stat_name;
   const sufix = "_value";
   const max_sufix = "_max_value";

   let stat_value = parseInt(document.getElementById(stats.concat(sufix)).value);
   let stat_max_value = parseInt(document.getElementById(stats.concat(max_sufix)).value);
   
   if (!stat_max_value || stat_max_value==null ) {
      
      document.getElementById(stats.concat(max_sufix)).value = '';
      return;
   }else{
      
      if( stat_max_value < 0 ){
         stat_max_value = 0;
      }
   }
      
   const string_stat_value = stat_max_value == 0 ? "".concat( "0", stat_max_value.toString() ): stat_max_value.toString();

   document.getElementById(stats.concat(max_sufix)).value = stat_max_value.toString();

   //doesn't require to send since it will do at element blur
};


const onblur_stats_value = (stat_name) => {
   const stats = stat_name;
   const sufix = "_value";
   
   let stat_value = parseInt(document.getElementById(stats.concat(sufix)).value);
   
   if ( !stat_value || stat_value == null) {
      stat_value = 0;
   }

   document.getElementById(stats.concat(sufix)).value = stat_value.toString();

   update_character_sheet_info("stats",stats,"value",stat_value);
};

const onblur_stats_max_value = (stat_name) => {
   const stats = stat_name;
   const sufix = "_value";
   const max_sufix = "_max_value";

   let stat_value = parseInt(document.getElementById(stats.concat(sufix)).value);
   let stat_max_value = parseInt(document.getElementById(stats.concat(max_sufix)).value);
   
   if ( stat_value > stat_max_value ) {
      
      stat_value = stat_max_value;

      document.getElementById(stats.concat(sufix)).value = stat_value.toString();
   }

   
   if ( !stat_value || stat_value == null ) {
      stat_value = 0;
   }

   if ( !stat_max_value || stat_max_value == null ) {
      stat_max_value = 0;
   }
     
   document.getElementById(stats.concat(sufix)).value = stat_value.toString();
   document.getElementById(stats.concat(max_sufix)).value = stat_max_value.toString();

   update_character_sheet_info("stats",stats,"value",stat_value);
   update_character_sheet_info("stats",stats,"max_value",stat_max_value);
};


const calculate_stats_max_value = (stat_name) => {
   const stats = stat_name;
   const sufix = "_value";
   const max_sufix = "_max_value";

   let stat_max_value = parseInt(document.getElementById(stats.concat(max_sufix)).value);;

   if ( stats == "HUM" ) {

      const emp_value = parseInt(document.getElementById("EMP".concat(max_sufix)).value);
      stat_max_value = 10 * emp_value;
      
      document.getElementById(stats.concat(max_sufix)).value = stat_max_value.toString();
   
   }else if ( stats == "HP" ) {
   
      const will_value = parseInt(document.getElementById("WILL".concat(sufix)).value);
      const body_value = parseInt(document.getElementById("BODY".concat(sufix)).value);
      stat_max_value = 10+( 5 * Math.ceil(( will_value + body_value ) / 2 ) ); 

      document.getElementById(stats.concat(max_sufix)).value = stat_max_value.toString();
   }
   
   update_character_sheet_info("stats",stats,"max_value",stat_max_value);
}

const reset_stats_value = (stat_name) => {
   const stats = stat_name;
   const sufix = "_value";
   const max_sufix = "_max_value";

      const max_value = parseInt(document.getElementById(stats.concat(max_sufix)).value);
      const stat_value = max_value;
      
      document.getElementById(stats.concat(sufix)).value = stat_value.toString();

      update_character_sheet_info("stats",stats,"value",stat_value);
}

const roll_skill_value = (skill_name) => {

   const base_value = parseInt(document.getElementById("".concat(skill_name,"_base")).value);
   const result = base_value + Math.floor( Math.random() * 11) ;
   
   //roll panel must be created to display this results
   //a roll log also would be nice
   console.log("skill roll: ".concat(skill_name,":",result));
}

const up_skill_value = (skill_name) => {

   const skill_id_name = "".concat(skill_name,"_value");
   let skill_value = parseInt(document.getElementById(skill_id_name).value);
   
   skill_value += 1;
   
   document.getElementById(skill_id_name).value = skill_value.toString();

   update_character_sheet_info("skill",skill_name,"value",skill_value);
}

const down_skill_value = (skill_name) => {
   
   const skill_id_name = "".concat(skill_name,"_value");
   let skill_value = parseInt(document.getElementById(skill_id_name).value);
   
   if (skill_value > 0) {
      
      skill_value -= 1;
   }

   document.getElementById(skill_id_name).value = skill_value.toString();

   update_character_sheet_info("skill",skill_name,"value",skill_value);
}

const skill_add = (select_skill_element, status, skills_panel_div ) => {

   const skill_value = "1";
   const select = document.getElementById(select_skill_element);
   const selected_skill_name = select.value;
   const selected_skill_block = document.getElementById( "".concat( selected_skill_name, "_block" ) );
   //find the correct skill index in the "stats" matrix/json
   
   let flag_is_skill = false;
   let flag_skill_exists = false;
   let skill_index = 0; 
   let index = 0; 
   while( index < json_counter(status) ) { 
      
      if (status[index]["topic"] == "all_skills") { //check if skill is in the all_skill list
         
         if (status[index]["name"] == selected_skill_name) {
            flag_is_skill = true;
            skill_index = index;
         }
      }

      if (status[index]["topic"] == "skills") { //check if the skill already exists in the character sheet
         
         if (status[index]["name"] == selected_skill_name) {
            flag_skill_exists = true;
         }
      }
      
      index++;
   }
   
   if (flag_is_skill == true && flag_skill_exists == false) {
      
      insert_character_sheet_info("skill",selected_skill_name,"value",skill_value, () =>{
      
         request_character_sheet_info( (new_status) => {

            //console.log(new_status); //DEBUG
            let index = 0; 
            while( index < json_counter(new_status) ) { 
               
               if (new_status[index]["topic"] == "skills") { //check if the skill already exists in the character sheet
                  
                  if (new_status[index]["name"] == selected_skill_name) {
                     
                     create_skill_block(index, new_status, skills_panel_div);
                  }
               }
               
               index++;
            }
         });
      });
   }
}

const skill_delete = (select_skill_element) => {
 
   const select = document.getElementById(select_skill_element);
   const selected_skill_name = select.value;
   const selected_skill_block = document.getElementById( "".concat( selected_skill_name, "_block" ) );

   if (selected_skill_block == null) {

      show_message('Unable to delete no such skill!', 'error');
     
   }else{

      delete_character_sheet_info("skill", selected_skill_name, "name", selected_skill_name, () =>{
         selected_skill_block.remove();
      });
   }
}


//SHEET UI - SKILL BLOCK CREATION
function create_skill_block(index, status, skills_panel_div){
   let skill_name = status[index]["name"];

   const skill_block = document.createElement("div");
   skill_block.id = "".concat(status[index]["name"],"_block");
   skill_block.className = "pc_stats_block pc_stats_block_long";
   skill_block.style.width = "100%";   
   skills_panel_div.appendChild(skill_block);

   const stat_header = document.createElement("div");
   stat_header.className = "pc_stats_block_header";
   stat_header.textContent = "".concat( status[index]["category"] , " - " , status[index]["name"] , " (x" ,status[index]["cost"] , ")" );
   skill_block.appendChild(stat_header);

   //this works as a button 
   const stat_info_div = document.createElement("div");
   stat_info_div.style.marginTop = "6px"; 
   stat_info_div.style.height = "auto"; 
   stat_info_div.style.width = "auto"; 
   stat_info_div.addEventListener("click",() => { roll_skill_value( skill_name ) },false)
   skill_block.appendChild(stat_info_div);

   var row, cel1, cel2, cel3;
   const stat_table = document.createElement("table");
   stat_table.style.width = "100%";
   row = stat_table.insertRow(0);
   cel1 = row.insertCell(0);
   cel2 = row.insertCell(1);
   cel3 = row.insertCell(2);
   stat_info_div.appendChild(stat_table);

   const cel1_label = document.createElement("label");
   cel1_label.textContent = "Level: ";
   cel1.appendChild(cel1_label);

   const cel1_input = document.createElement("input");
   cel1_input.className = "pc_stats_block_level";
   cel1_input.id = "".concat(status[index]["name"],"_value");
   cel1_input.name = "".concat(status[index]["name"],"_value");
   cel1_input.value = status[index]["value"];
   cel1.appendChild(cel1_input);

   const cel2_label = document.createElement("label");
   cel2_label.textContent = "Stat: ";
   cel2.appendChild(cel2_label);

   const cel2_input = document.createElement("input");
   cel2_input.className = "pc_stats_block_level";
   cel2_input.id = "".concat(status[index]["name"],"_type");
   cel2_input.name = "".concat(status[index]["name"],"_type");
   cel2_input.value = status[index]["stat_name"];
   cel2.appendChild(cel2_input);

   const cel3_label = document.createElement("label")
   cel3_label.textContent = "Base: ";
   cel3.appendChild(cel3_label);

   const cel3_input = document.createElement("input");
   cel3_input.className = "pc_stats_block_level";
   cel3_input.id = "".concat(status[index]["name"],"_base");
   cel3_input.name = "".concat(status[index]["name"],"_base");
   cel3_input.value = ( parseInt(status[index]["value"]) + 
   parseInt(status[index]["stat_value"]) ).toString();
   cel3.appendChild(cel3_input);

   //upbutton
   const skill_up_div = document.createElement("div");
   skill_up_div.className = "pc_stats_corner_up";
   skill_up_div.addEventListener("click",() => {  up_skill_value( skill_name ) },false);
   skill_block.appendChild(skill_up_div);
   
   //upbutton
   const skill_down_div = document.createElement("div");
   skill_down_div.className = "pc_stats_corner_down";
   skill_down_div.addEventListener("click",() => { down_skill_value( skill_name ) },false);
   skill_block.appendChild(skill_down_div);
}

//SHEET UI - WEAPON BLOCK CREATION
function create_weapon_block(index, status, weapons_panel_div){
   let weapon_name = status[index]["name"];

   const weapon_block = document.createElement("div");
   weapon_block.id = "".concat(status[index]["name"],"_block");
   weapon_block.className = "pc_stats_block pc_stats_block_long";
   weapon_block.style.width = "100%";   
   weapons_panel_div.appendChild(weapon_block);

   const weapon_header = document.createElement("div");
   weapon_header.className = "pc_stats_block_header";
   weapon_header.textContent = "".concat( status[index]["category"] , " - " , status[index]["name"] );
   weapon_block.appendChild(weapon_header);

   //this works as a button 
   const weapon_info_div = document.createElement("div");
   weapon_info_div.style.marginTop = "6px"; 
   weapon_info_div.style.height = "auto"; 
   weapon_info_div.style.width = "auto"; 
   weapon_info_div.addEventListener("click",() => { roll_skill_value( weapon_name ) },false)
   weapon_block.appendChild(weapon_info_div);

   var row, cel1, cel2, cel3;
   const weapon_table = document.createElement("table");
   weapon_table.style.width = "100%";
   row = weapon_table.insertRow(0);
   cel1 = row.insertCell(0);
   cel2 = row.insertCell(1);
   cel3 = row.insertCell(2);
   weapon_info_div.appendChild(weapon_table);

   const cel1_label = document.createElement("label");
   cel1_label.textContent = "Level: ";
   cel1.appendChild(cel1_label);

   const cel1_input = document.createElement("input");
   cel1_input.className = "pc_stats_block_level";
   cel1_input.id = "".concat(status[index]["name"],"_value");
   cel1_input.name = "".concat(status[index]["name"],"_value");
   cel1_input.value = status[index]["value"];
   cel1.appendChild(cel1_input);

   const cel2_label = document.createElement("label");
   cel2_label.textContent = "Stat: ";
   cel2.appendChild(cel2_label);

   const cel2_input = document.createElement("input");
   cel2_input.className = "pc_stats_block_level";
   cel2_input.id = "".concat(status[index]["name"],"_type");
   cel2_input.name = "".concat(status[index]["name"],"_type");
   cel2_input.value = status[index]["stat_name"];
   cel2.appendChild(cel2_input);

   const cel3_label = document.createElement("label")
   cel3_label.textContent = "Base: ";
   cel3.appendChild(cel3_label);

   const cel3_input = document.createElement("input");
   cel3_input.className = "pc_stats_block_level";
   cel3_input.id = "".concat(status[index]["name"],"_base");
   cel3_input.name = "".concat(status[index]["name"],"_base");
   cel3_input.value = ( parseInt(status[index]["value"]) + 
   parseInt(status[index]["stat_value"]) ).toString();
   cel3.appendChild(cel3_input);

   //upbutton
   const weapon_up_div = document.createElement("div");
   weapon_up_div.className = "pc_stats_corner_up";
   weapon_up_div.addEventListener("click",() => {  up_ammo_value( weapon_name ) },false);
   weapon_block.appendChild(weapon_up_div);
   
   //upbutton
   const weapon_down_div = document.createElement("div");
   weapon_down_div.className = "pc_stats_corner_down";
   weapon_down_div.addEventListener("click",() => { down_ammo_value( weapon_name ) },false);
   weapon_block.appendChild(weapon_down_div);
}


//BUILD SHEET UI - MAIN
const build_ui = (status) =>{
   console.log(status); //DEBUG

   let index = 0;

   const panel = document.getElementById("sheet_page_div");

   const sheet = document.createElement("div");
   sheet.className = "pc_intro_panel";
   panel.appendChild(sheet);

   index = 0; 
   while( index < json_counter(status) ) {
     
      if (status[index]["topic"] == "character_name") {
        
        const sheet_title = document.createElement("h3");
        sheet_title.style.textAlign = "center";
        sheet_title.textContent = status[index]["name"];
        sheet.appendChild(sheet_title);
       
      }

      index++;
   }

   const stats_sub_title = document.createElement("h4");
   stats_sub_title.className = "pc_forms_text";
   stats_sub_title.textContent = "Stats";
   sheet.appendChild(stats_sub_title);
   
   const stats_form = document.createElement("form");
   stats_form.setAttribute("method", "post"); 
   stats_form.setAttribute("action", ""); 
   stats_form.id = "stats_form";
   sheet.appendChild(stats_form);
  
   
   const stats_form_inner_div = document.createElement("div");
   stats_form_inner_div.className = "pc_stats_panel";
   stats_form.appendChild(stats_form_inner_div);

  
   index = 0; 
   while( index < json_counter(status) ) {
     
      if (status[index]["topic"] == "stats") {
      let stat_name = "".concat(status[index]["name"]);


      const stat_block = document.createElement("div");
      stat_block.className = "pc_stats_block";
      if (status[index]["name"]=="HUM" || status[index]["name"]=="HP") {
         stat_block.style.width = "175px";   
      }
      stats_form_inner_div.appendChild(stat_block);

      const stat_header = document.createElement("div");
      stat_header.className = "pc_stats_block_header";
      stat_header.textContent = status[index]["name"];
      stat_block.appendChild(stat_header);

      const stat_inner_div = document.createElement("div");
      stat_inner_div.style.marginTop = "2px";
      stat_block.appendChild(stat_inner_div);


      const max_value_div = document.createElement("div");
      max_value_div.style.height = "18px";
      max_value_div.style.width = "auto";
      if (status[index]["show_max"]==0) { //used to hide max value div
         max_value_div.style.display = "none";  
      }
      stat_inner_div.appendChild(max_value_div);
      

      //MAX VALUE CALCULATOR BUTTON
      if ( status[index]["name"] == "HP" || status[index]["name"] == "HUM") {
         const calculate_max = document.createElement("input");
         calculate_max.type = "button";
         calculate_max.className = "pc_stat_block_tiny_button";
         calculate_max.value = "C";
         calculate_max.addEventListener("click",() => { calculate_stats_max_value( stat_name ) },false);
         max_value_div.appendChild(calculate_max);
      }

      if ( status[index]["name"] == "HP" || status[index]["name"] == "HUM") {
         const  max_label = document.createElement("label");
         max_label.className = "pc_stats_block_label";
         max_label.textContent = "|"
         max_value_div.appendChild(max_label);
      }
      
      if ( status[index]["show_max"] == 1 ) {
         const reset_current = document.createElement("input");
         reset_current.type = "button";
         reset_current.className = "pc_stat_block_tiny_button";
         reset_current.value = "R";
         reset_current.addEventListener("click",() => { reset_stats_value( stat_name ) },false);
         max_value_div.appendChild(reset_current);
      }

      const  max_label = document.createElement("label");
      max_label.className = "pc_stats_block_label";
      max_label.textContent = "|"
      max_value_div.appendChild(max_label);

      //MAX VALUE INPUT
      const max_value = document.createElement("input");
      max_value.type = "text";
      max_value.className = "pc_stats_block_value_max";
      max_value.id = "".concat(status[index]["name"],"_max_value");
      max_value.name = "".concat(status[index]["name"],"_max_value");
      max_value.value = status[index]["max_value"];
      max_value.addEventListener("change",() => { oninput_stats_max_value( stat_name ) },false);
      max_value.addEventListener("blur",() => { onblur_stats_max_value( stat_name ) },false);
      max_value_div.appendChild(max_value);
      
     
      const current_value_div = document.createElement("div");
      current_value_div.className = "pc_stats_block_value_max";
      current_value_div.style.height = "auto";
      current_value_div.style.width = "auto";
      stat_inner_div.appendChild(current_value_div);
   

      //CURRENT VALUE INPUT
      const current_value = document.createElement("input");
      current_value.type = "text";
      current_value.className = "pc_stats_block_value";
      current_value.id = "".concat(status[index]["name"],"_value");
      current_value.name = "".concat(status[index]["name"],"_value");
      current_value.value = status[index]["value"];
      current_value.addEventListener("change",() => { oninput_stats_value( stat_name ) },false);
      current_value.addEventListener("blur",() => { onblur_stats_value( stat_name ) },false);
      current_value_div.appendChild(current_value);
     
      const stat_up_button = document.createElement("div");
      stat_up_button.className = "pc_stats_corner_up";
      stat_up_button.addEventListener("click",() => { up_stats_value( stat_name ) },false);
      stat_block.appendChild(stat_up_button);
      
      const stat_down_button = document.createElement("div");
      stat_down_button.className = "pc_stats_corner_down";
      stat_down_button.addEventListener("click",() => { down_stats_value( stat_name ) },false);
      stat_block.appendChild(stat_down_button);
      }

      index++;
   }

   //SKILLS
   const skill_sub_title = document.createElement("h4");
   skill_sub_title.className = "pc_forms_text";
   skill_sub_title.textContent = "Skills";
   sheet.appendChild(skill_sub_title);
   
   const skill_form = document.createElement("form");
   skill_form.setAttribute("method", "post"); 
   skill_form.setAttribute("action", ""); 
   skill_form.id = "skills_form";
   sheet.appendChild(skill_form);

   const skill_form_inner_div = document.createElement("div");
   skill_form_inner_div.className = "pc_stats_panel";
   skill_form.appendChild(skill_form_inner_div);

   const skills_div = document.createElement("div");
   skills_div.id = "skills_panel";
   skills_div.style.width = "100%";
   skills_div.style.margin = "10px";
   skill_form_inner_div.appendChild(skills_div);


   //skill block
   index = 0; 
   while( index < json_counter(status) ) {
      
      if (status[index]["topic"] == "skills") {
         
         create_skill_block(index, status, skills_div);
      }
      index++;
   }
      
   const skills_operation_div = document.createElement("div");
   skills_operation_div.style.margin = "10px";
   skills_operation_div.style.width = "100%";
   skill_form_inner_div.appendChild(skills_operation_div);

   const skills_select = document.createElement("select");
   skills_select.id = "select_skills";
   skills_select.className = "pc_selectbox pc_skill_selectbox";
   skills_select.name = "skills";
   skills_operation_div.appendChild(skills_select);
   
   index = 0; 
   while( index < json_counter(status) ) {
   
      if (status[index]["topic"] == "all_skills") {
         const skills_option = document.createElement("option");
         skills_option.className = "pc_skill_selectbox_option";
         skills_option.value = status[index]["name"];
         skills_option.textContent = status[index]["name"];
         skills_select.appendChild(skills_option);
      }

      index++;
   }
   
   const skills_delete = document.createElement("input");
   skills_delete.type = "button";
   skills_delete.className = "pc_stat_block_button";
   skills_delete.value = "Delete";
   skills_delete.addEventListener("click",() => { skill_delete( "select_skills" ) },false);
   skills_operation_div.appendChild(skills_delete);
   
   const skills_add = document.createElement("input");
   skills_add.type = "button";
   skills_add.className = "pc_stat_block_button";
   skills_add.style.margin = "0px 10px 0px 0px";
   skills_add.value = "Add";
   skills_add.addEventListener("click",() => { skill_add( "select_skills" , status, skills_div) },false);
   skills_operation_div.appendChild(skills_add);


   //WEAPONS
   const weapons_sub_title = document.createElement("h4");
   weapons_sub_title.className = "pc_forms_text";
   weapons_sub_title.textContent = "Weapons";
   sheet.appendChild(weapons_sub_title);
   
   const weapons_form = document.createElement("form");
   weapons_form.setAttribute("method", "post"); 
   weapons_form.setAttribute("action", ""); 
   weapons_form.id = "weapons_form";
   sheet.appendChild(weapons_form);

   const weapons_form_inner_div = document.createElement("div");
   weapons_form_inner_div.className = "pc_stats_panel";
   weapons_form.appendChild(weapons_form_inner_div);

   const weapons_div = document.createElement("div");
   weapons_div.id = "weapons_panel";
   weapons_div.style.width = "100%";
   weapons_div.style.margin = "10px";
   weapons_form_inner_div.appendChild(weapons_div);


   //skill block
   index = 0; 
   while( index < json_counter(status) ) {
      
      if (status[index]["topic"] == "weapons") {
         
         create_skill_block(index, status, weapons_div);
      }
      index++;
   }
      
   const weapons_operation_div = document.createElement("div");
   weapons_operation_div.style.margin = "10px";
   weapons_operation_div.style.width = "100%";
   weapons_form_inner_div.appendChild(weapons_operation_div);

   const weapons_select = document.createElement("select");
   weapons_select.id = "weapons_skills";
   weapons_select.className = "pc_selectbox pc_skill_selectbox";
   weapons_select.name = "weapons";
   weapons_operation_div.appendChild(weapons_select);
   
   index = 0; 
   while( index < json_counter(status) ) {
   
      if (status[index]["topic"] == "all_weapons") {
         const weapons_option = document.createElement("option");
         weapons_option.className = "pc_skill_selectbox_option";
         weapons_option.value = status[index]["name"];
         weapons_option.textContent = status[index]["name"];
         weapons_select.appendChild(weapons_option);
      }

      index++;
   }
   
   const weapons_delete = document.createElement("input");
   weapons_delete.type = "button";
   weapons_delete.className = "pc_stat_block_button";
   weapons_delete.value = "Delete";
   weapons_delete.addEventListener("click",() => { skill_delete( "select_skills" ) },false);
   weapons_operation_div.appendChild(weapons_delete);
   
   const weapons_add = document.createElement("input");
   weapons_add.type = "button";
   weapons_add.className = "pc_stat_block_button";
   weapons_add.style.margin = "0px 10px 0px 0px";
   weapons_add.value = "Add";
   weapons_add.addEventListener("click",() => { skill_add( "select_skills" , status, weapons_div ) },false);
   weapons_operation_div.appendChild(weapons_add);
}



   
