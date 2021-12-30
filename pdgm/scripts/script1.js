$(document).ready(function(){
	
	
	
	
	
	
	
	
	 var u1 = "pdgmprouser90!";
            var p1 = "pdgmprouserpwqkj89@#";

            var url1 = 'http://pdgm/api.php/records/pdgmdata?filter=NPI,eq,1003020306&filter=Name,cs,NETWORK';
            $.ajax({
                url: url1,
                success: function(json) {
                    alert("Success", json);
                },
				headers: {"Authorization": "Basic cGRnbXByb3VzZXJwd3Frajg5QCM="},
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(textStatus, errorThrown);
                    console.log(errorThrown);
                },
               // headers: {
                //'Authorization': 'Basic bWFkaHVhOndlbGNvbWUxMjM=',
                //},
/*
                beforeSend: function(xhr) {
                   xhr.setRequestHeader("Authorization", "Basic " + btoa(u1 + ":" + p1));
                },
*/
				
                type: 'GET',
                dataType: 'json',
            });
	
	
	
	
	
	
	
	
	
	$(".pdgm-data-wrapper").hide();
	
	$("#pdgm-search-form").submit(function(e){
		e.preventDefault();
		//var url = "http://pdgm/api.php/records/pdgmdata?filter=NPI,eq,1003020306&filter=Name,cs,NETWORK";
		var url = "http://pdgm/api.php/records/pdgmdata";
		var filter = "";
		var filters = [];
		var ajax;
		var npiNum = "";
		var totPmts = "";
		var agencyName = "";
		var agencyState = "";
		var fieldToColumnName = {
			"NEURO_REHAB" : "NEURO REHAB",
			"WOUND" : "WOUNDS",
			"COMPLEX" : "COMPLEX NURSING",
			"MS_REHAB" : "MS REHAB",
			"BEHAVE_HEALTH" : "BEHAV HEALTH",
			"MMTA_AFTER" : "MMTA - SURG AFTCARE",
			"MMTA_CARDIAC" : "MMTA - CARDIAC",
			"MMTA_ENDO" : "MMTA - ENDO",
			"MMTA_GI_GU" : "MMTA - GI/GU",
			"MMTA_INFECT" : "MMTA – INFECT DISEASE",
			"MMTA_RESP": "MMTA - RESP",
			"MMTA_OTHER": "MMTA - OTHER",
			"OTHER" : "QUEST ENC",
		};
		var prColumns = [{title:"SUMMARY MEASURE", field:"SUMMARY", editor:false, align:"left"}];
		var secColumns = [{title:"DETAILS BY CLINICAL GROUP", field:"DETAILS", editor:false, align:"left"},];
		
				
		var processedData = [];
		var finalProcessedData = [];
		var totalPdcount = 0;
		var headers = ["NEURO_REHAB", "WOUND", "COMPLEX", "MS_REHAB", "BEHAVE_HEALTH", "MMTA_AFTER", "MMTA_CARDIAC", "MMTA_ENDO", "MMTA_GI_GU", "MMTA_INFECT", "MMTA_RESP", "MMTA_OTHER" , "OTHER"];
		
		
		var prDetailVal = ["% - 30-DAY PDS/CLIN GRP", "% - INSTITUTIONAL PDS", "% - COMMUNITY PDS", "% - EARLY PDS", "% -  LATE PDS", "AVG VISITS - EARLY PDS", "AVG VISITS - LATE PDS", "% - CLAIMS - NO COMORBIDITY", "% - CLAIMS INTACTIVE COMORBIDITY", "% - CLAIMS SINGLE COMORBIDITY"];
		
		var secDetailVal = ["Number of Stays", "Number of Claims", "Total Payments", "Average Payment/Claim", "Total 30-Day Periods", "Avg 30-Day Pds per Claim", "Average Episode Length", "Average Days/30-Day Pd", "Institutional 30-Day Pds", "Community 30-Day Pds", "Institutional Pds - Initial", "%  Initial Pds - Inst","Community Pds - Initial","% Initial Pds - Community", "Early 30-Day Pds","Late 30-Day Pds", "Clms - Interactive Comorbidities", "Clms - Single Comorbidities", "Clms -  No Coded Comorbidities"];
		
		
		var newHeaders = [];
		if(($("#npi").val().trim()) || ($("#name").val().trim())){
			
			//diable form
			$('#pdgm-search-form *').prop('disabled', true);
			
			//atleast on value entered
			if($("#npi").val().trim()){
				var npi = $("#npi").val().trim();
				filters.push("filter=NPI,eq,"+ npi);
			}
			if($("#name").val().trim()){
				var name = $("#name").val().trim();
				filters.push("filter=Name,cs,"+ name);
				
			}
			filters = filters.join("&");
			filter += "?"+ filters;
			url += filter;
			
			console.log(url);
			
			
			
			
			
			if (ajax) {
				ajax.abort();
   			}
			
			ajax  = $.ajax({url: url, 
				headers: {"Authorization": "Basic cGRnbXByb3VzZXJwd3Frajg5QCM="},
		      success: function(data) {
		        
		        var tdata = data.records;
				console.log(tdata);
				
				$.each( tdata, function( key, tdObj ) {
					
					
					// calculate % - 30-DAY PDS/CLIN GRP by adding all "Pdcount" --> totalPdcount
					totalPdcount += tdObj.Pdcount;
					
					
					
					// Update headers -- needed if some Clincat is not there from any Agency
					newHeaders.push(tdObj.Clincat);
					npiNum = tdObj.NPI;
					agencyName = tdObj.Name;
					totPmts = tdObj.Totpmts;
					agencyState = tdObj.State;
										
				});
				headers = headers.filter(function(n) {
					return newHeaders.indexOf(n) > -1;
				});
				
				
				//Update Table columns to if it's not inside new heade we don't want to display emplty table columns
				
				
				$.each( headers, function( key, val ) {
					var colObj = {};
					colObj.title = fieldToColumnName[val];
					colObj.field = val;
					colObj.editor= false;
					colObj.align = "left";
					colObj.formatter = function(cell, formatterParams, onRendered){
    //cell - the cell component
    //formatterParams - parameters set for the column
    //onRendered - function to call when the formatter has been rendered
	console.log(cell);
	console.log(formatterParams);
	console.log("NP HERE 1234567890");
	console.log(cell.getElement());
	cell.getElement().classList.add("custom-class-np-here");

    return cell.getValue(); 
    //return "Mr" + cell.getValue(); //return the contents of the cell;
},
					prColumns.push(colObj);
					secColumns.push(colObj);
				});
				
				
				$.each( tdata, function( key, tdObj ) {
				
						processedData[tdObj.Clincat] = [];
						
						//console.log(tdObj);
						
						// Load Primary Table Data
						// calculate % - 30-DAY PDS/CLIN GRP by adding all "Pdcount" --> totalPdcount --> column - Pdcount / totalPdcount
						processedData[tdObj.Clincat]['% - 30-DAY PDS/CLIN GRP'] = parseFloat(((tdObj.Pdcount / totalPdcount)*100).toFixed(2)) + "%";   // Not fincding this in excelsheet so Check on this .....
						processedData[tdObj.Clincat]['% - INSTITUTIONAL PDS'] = parseFloat(((tdObj.Instpct)*100).toFixed(2)) + "%"; 
						processedData[tdObj.Clincat]['% - COMMUNITY PDS'] = parseFloat(((tdObj.Commpct)*100).toFixed(2)) + "%"; 
						processedData[tdObj.Clincat]['% - EARLY PDS'] = parseFloat(((tdObj.Earlypct)*100).toFixed(2)) + "%"; 
						processedData[tdObj.Clincat]['% -  LATE PDS'] = parseFloat(((tdObj.Latepct)*100).toFixed(2)) + "%"; 
						processedData[tdObj.Clincat]['AVG VISITS - EARLY PDS'] = tdObj.Avgearlyvis; 
						processedData[tdObj.Clincat]['AVG VISITS - LATE PDS'] = tdObj.Avglatevis; 
						processedData[tdObj.Clincat]['% - CLAIMS - NO COMORBIDITY'] = parseFloat(((tdObj.Avgnocomorb)*100).toFixed(2)) + "%"; 
						processedData[tdObj.Clincat]['% - CLAIMS INTACTIVE COMORBIDITY'] = parseFloat(((tdObj.Avgintcomorb)*100).toFixed(2)) + "%"; 
						processedData[tdObj.Clincat]['% - CLAIMS SINGLE COMORBIDITY'] = parseFloat(((tdObj.Avgsinglecomorb)*100).toFixed(2)) + "%"; 
						
						
						
						// Load Secondary Table Data
						
						processedData[tdObj.Clincat]['Number of Stays'] = tdObj.Staycount; 
						processedData[tdObj.Clincat]['Number of Claims'] = tdObj.Clmcount; 
						processedData[tdObj.Clincat]['Total Payments'] = tdObj.Clmpmts.toLocaleString('en-US'); 
						processedData[tdObj.Clincat]['Average Payment/Claim'] = tdObj.Avgclmpmt;
						processedData[tdObj.Clincat]['Total 30-Day Periods'] = tdObj.Pdcount;
						processedData[tdObj.Clincat]['Avg 30-Day Pds per Claim'] = tdObj.Avgpdsclm;
						processedData[tdObj.Clincat]['Average Episode Length'] = tdObj.Avgclmdays;
						processedData[tdObj.Clincat]['Average Days/30-Day Pd'] = tdObj.Avgpddays;
						processedData[tdObj.Clincat]['Institutional 30-Day Pds'] = tdObj.Instpds;
						processedData[tdObj.Clincat]['Community 30-Day Pds'] = tdObj.Commpds;
						processedData[tdObj.Clincat]['Institutional Pds - Initial'] = tdObj.Initinstpds;
						processedData[tdObj.Clincat]['%  Initial Pds - Inst'] = parseFloat((tdObj.Initinstpct*100).toFixed(2)) + "%";
						processedData[tdObj.Clincat]['Community Pds - Initial'] = tdObj.Initcommpds;
						processedData[tdObj.Clincat]['% Initial Pds - Community'] = parseFloat((tdObj.Initcommpct*100).toFixed(2)) + "%";
						processedData[tdObj.Clincat]['Early 30-Day Pds'] = tdObj.Earlypds;
						processedData[tdObj.Clincat]['Late 30-Day Pds'] = tdObj.Latepds;
						processedData[tdObj.Clincat]['Clms - Interactive Comorbidities'] = tdObj.Interactcomorb;
						processedData[tdObj.Clincat]['Clms - Single Comorbidities'] = tdObj.Singlecomorb;
						processedData[tdObj.Clincat]['Clms -  No Coded Comorbidities'] = tdObj.Nocomorb; 
				
				});
				
				$(".pdgm-data-wrapper").show();
				//Render Primary Table -- Summary table
				$.each( prDetailVal, function( dKey, dValue ) {
					var finalProcessedObj = {};
					
					$.each( headers , function( hKey, hVal ) {
					
						finalProcessedObj['SUMMARY'] = dValue;
						finalProcessedObj[hVal] = processedData[hVal][dValue];
					});
					finalProcessedData.push(finalProcessedObj);
				});
				
				
				
				$(".npi-val").text(npiNum);
				$(".agency-name").text(agencyName);
				totPmts = Number(totPmts).toLocaleString('en-US', { style: 'currency', currency: 'USD' });
				$(".totpmts-data").text(totPmts);
				$(".agency-state").text(agencyState);
				
				new Tabulator("#primary-table", {
			        data:finalProcessedData,           //load row data from array
					layout:"fitColumns",      //fit columns to width of table
					responsiveLayout:"hide",  //hide columns that dont fit on the table
					tooltips:true,            //show tool tips on cells
					//addRowPos:"top",          //when adding a new row, add it to the top of the table
					//history:true,             //allow undo and redo actions on the table
					//pagination:"local",       //paginate the data
					//paginationSize:7,         //allow 7 rows per page of data
					movableColumns:true,      //allow column order to be changed
					resizableRows:true,       //allow row order to be changed
		/*
					initialSort:[             //set the initial sort order of the data
						{column:"name", dir:"asc"},
					],
		*/
		
/*
					columns:[                 //define the table columns
						{title:"SUMMARY MEASURE", field:"SUMMARY", editor:false, align:"left"},
						{title:"NEURO REHAB", field:"NEURO_REHAB", editor:false, align:"right"},
						{title:"WOUNDS", field:"WOUND", editor:false, align:"right"},
						{title:"COMPLEX NURSING", field:"COMPLEX",  editor:false, align:"right"},
						{title:"MS REHAB", field:"MS_REHAB", align:"right", editor:false},
						{title:"BEHAV HEALTH", field:"BEHAVE_HEALTH", editor:false, align:"right"},
						{title:"MMTA - SURG AFTCARE", field:"MMTA_AFTER",  editor:false, align:"right"},
						{title:"MMTA - CARDIAC", field:"MMTA_CARDIAC",   align:"right", editor:false},
						{title:"MMTA - ENDO", field:"MMTA_ENDO",  editor:false, align:"right"},
						{title:"MMTA - GI/GU", field:"MMTA_GI_GU", editor:false, align:"right"},
						{title:"MMTA – INFECT DISEASE", field:"MMTA_INFECT",  editor:false, align:"right"},
						{title:"MMTA - RESP", field:"MMTA_RESP",  editor:false, align:"right"},
						{title:"MMTA - OTHER", field:"MMTA_OTHER",  editor:false, align:"right"},
						{title:"QUEST ENC", field:"OTHER",  editor:false, align:"right"},
					],
*/
					columns: prColumns,
		
		         });
				
				
				
				//Render Secondary Table -- Detail table
				finalProcessedData = [];
				$.each( secDetailVal, function( dKey, dValue ) {
					var finalProcessedObj = {};
					
					$.each( headers , function( hKey, hVal ) {
					
						finalProcessedObj['DETAILS'] = dValue;
						finalProcessedObj[hVal] = processedData[hVal][dValue];
					});
					finalProcessedData.push(finalProcessedObj);
				});
				
				 
				 
				 
		
		         new Tabulator("#secondary-table", {
			        data:finalProcessedData,           //load row data from array
					layout:"fitColumns",      //fit columns to width of table
					responsiveLayout:"hide",  //hide columns that dont fit on the table
					tooltips:true,            //show tool tips on cells
					//addRowPos:"top",          //when adding a new row, add it to the top of the table
					//history:true,             //allow undo and redo actions on the table
					//pagination:"local",       //paginate the data
					//paginationSize:7,         //allow 7 rows per page of data
					movableColumns:true,      //allow column order to be changed
					resizableRows:true,       //allow row order to be changed
		/*
					initialSort:[             //set the initial sort order of the data
						{column:"name", dir:"asc"},
					],
		*/
		
/*
					columns:[                 //define the table columns
						{title:"DETAILS BY CLINICAL GROUP", field:"DETAILS", editor:false, align:"left"},
						{title:"NEURO REHAB", field:"NEURO_REHAB", editor:false, align:"right"},
						{title:"WOUNDS", field:"WOUND", editor:false, align:"right"},
						{title:"COMPLEX NURSING", field:"COMPLEX",  editor:false, align:"right"},
						{title:"MS REHAB", field:"MS_REHAB", align:"right", editor:false},
						{title:"BEHAV HEALTH", field:"BEHAVE_HEALTH", editor:false, align:"right"},
						{title:"MMTA - SURG AFTCARE", field:"MMTA_AFTER",  editor:false, align:"right"},
						{title:"MMTA - CARDIAC", field:"MMTA_CARDIAC",   align:"right", editor:false},
						{title:"MMTA - ENDO", field:"MMTA_ENDO",  editor:false, align:"right"},
						{title:"MMTA - GI/GU", field:"MMTA_GI_GU", editor:false, align:"right"},
						{title:"MMTA – INFECT DISEASE", field:"MMTA_INFECT",  editor:false, align:"right"},
						{title:"MMTA - RESP", field:"MMTA_RESP",  editor:false, align:"right"},
						{title:"MMTA - OTHER", field:"MMTA_OTHER",  editor:false, align:"right"},
						{title:"QUEST ENC", field:"OTHER",  editor:false, align:"right"},
					],
*/
					columns: secColumns,
		
		         });
		         
		         ajax = undefined;
		         //enable form
				 $("#pdgm-search-form *").prop("disabled", false);
				 
				 
		         
		      },
		      error: function(error) {
			  	console.log(error);
		         // Check what needs to happen here.
		         console.log("error occured");
		         $(".pdgm-data-wrapper").hide();
		      }
		   });	
		}
		else{
			//need better handler
			alert("Enter Either NPI or Name");
			//enable form
			$('#pdgm-search-form *').prop('disabled', false);
		}
	});
});