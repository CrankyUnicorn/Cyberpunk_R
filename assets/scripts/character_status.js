const submit_stats = () =>{
   document.getElementById("status_form").submit(); 

};

const up_value = (stat_name) => {
   let status = stat_name;
   let sufix = "_value";
   let max_sufix = "_max_value";

   let stat_max_value = parseInt(document.getElementById(status.concat(max_sufix)).value);
   let stat_value = parseInt(document.getElementById(status.concat(sufix)).value);
   
   if( stat_value < stat_max_value ){
      stat_value += 1;
   }
   
   document.getElementById(status.concat(sufix)).value = stat_value.toString();

   submit_stats();
};


const down_value = (stat_name) => {
   let status = stat_name;
   let sufix = "_value";
   
   let stat_value = parseInt(document.getElementById(status.concat(sufix)).value);
   
   if( stat_value > 0 ){
      stat_value -= 1;
   }
   
   document.getElementById(status.concat(sufix)).value = stat_value.toString();

   submit_stats();
};