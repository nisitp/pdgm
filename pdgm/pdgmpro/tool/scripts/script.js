var showForm = 0;

jQuery(document).ready(function($) {
  	$(".pdgm-data-wrapper").hide();
	
//	$("#pdgm-search-form").submit();
//	$("#pdgm-search-form").submit(function(e){
//		e.preventDefault();
		//var url = "api.php/records/pdgmdata?filter=NPI,eq,1003020306&filter=Name,cs,NETWORK";
		var url = "/pdgmtool/api.php/records/pdgmdata";
		var filter = "";
		var filters = [];
		var ajax;
		var npiNum = "";
		var totPmts = "";
		var agencyName = "";
		var agencyState = "";
		
		// define columns -- can add options from http://tabulator.info/docs/4.1/columns to govern display
		var fieldDetails = {
			"NEURO_REHAB" : {'title' : "NEURO REHAB", 'headerTooltip': "Neuro/Stroke Rehab: Therapy (physical, occupational or speech) for a neurological condition or stroke."},
			"WOUND" : {'title' : "WOUNDS", 'headerTooltip': "Wounds – Post-Op Wound Aftercare and Skin/Non-Surgical Wound Care: Assessment, treatment and evaluation of a surgical wound(s); assessment, treatment and evaluation of non-surgical wounds, ulcers, burns and other lesions."},
			"COMPLEX" : {'title' : "COMPLEX NURSING", 'headerTooltip': "Complex Nursing Interventions: Assessment, treatment and evaluation of complex medical and surgical conditions including IV, TPN, enteral nutrition, ventilator and ostomies."},
			"MS_REHAB" : {'title' : "MS REHAB", 'headerTooltip': "Muscoskeletal Rehab: Therapy (physical, occupational or speech) for a musculoskeletal condition."},
			"BEHAVE_HEALTH" : {'title' : "BEHAV HEALTH", 'headerTooltip': "Behavioral Health Care: Assessment, treatment and evaluation of psychiatric conditions."},
			"MMTA_AFTER" : {'title' : "MMTA - SURG AFTCARE", 'headerTooltip': "MMTA - Surgical Aftercare: Assessment, evaluation, teaching and medication management for surgical aftercare."},
			"MMTA_CARDIAC" : {'title' : "MMTA - CARDIAC", 'headerTooltip': "MMTA - Cardiac/Circulatory: Assessment, evaluation, teaching and medication management for cardiac or other circulatory related conditions."},
			"MMTA_ENDO" : {'title' : "MMTA - ENDO", 'headerTooltip': "MMTA - Endocrine: Assessment, evaluation, teaching and medication management for endocrine related conditions."},
			"MMTA_GI_GU" : {'title' : "MMTA - GI/GU", 'headerTooltip': "MMTA - GI / GU: Assessment, evaluation, teaching and medication management for gastrointestinal or genitourinary related conditions."},
			"MMTA_INFECT" : {'title' : "MMTA – INFECT DISEASE", 'headerTooltip': "MMTA - Infectious Disease/Neoplasms/Blood-forming Diseases: Assessment, evaluation, teaching and medication management for conditions related to infectious disease, neoplasms, and blood forming diseases."},
			"MMTA_RESP": {'title' : "MMTA - RESP", 'headerTooltip': "MMTA - Respiratory: Assessment, evaluation, teaching and medication management for respiratory related conditions."},
			"MMTA_OTHER": {'title' : "MMTA - OTHER", 'headerTooltip': "MMTA - Other: Assessment, evaluation, teaching and medication management for a variety of medical and surgical conditions not classified in one of the previously listed groups."},
			"OTHER" : {'title' : "QUEST ENC", 'headerTooltip': "Questionable Encounter: Measures associated with services that could not be classified using a PDGM accepted primary diagnosis code.  For example, if the primary diagnosis on the 2017 claim is not one of the approximately 38,000 identified HH PDGM diagnoses, the claim would be designated as a potentially Questionable Encounter.", 'responsive': 0},
		};

		var prColumns = [{title:"SUMMARY MEASURE", field:"SUMMARY", editor:false, align:"left", minWidth: 260, responsive:0}];
		var secColumns = [{title:"DETAILS BY CLINICAL GROUP", field:"DETAILS", editor:false, align:"left", minWidth: 260},];
		
				
		var processedData = [];
		var finalProcessedData = [];
		var totalPdcount = 0;
		var headers = ["NEURO_REHAB", "WOUND", "COMPLEX", "MS_REHAB", "BEHAVE_HEALTH", "MMTA_AFTER", "MMTA_CARDIAC", "MMTA_ENDO", "MMTA_GI_GU", "MMTA_INFECT", "MMTA_RESP", "MMTA_OTHER" , "OTHER"];
		
		
		var prDetailVal = {
  		
  		"% 30-DAY PERIODS/CLIN GRP": {
    		'title': "% 30-DAY PERIODS/CLIN GRP",
    		'tooltip' : 'The proportion of 30-day payment periods from agency claims that are classified into each of the 12 Clinical Groupings or the “Other – Questionable Encounter” category. ',
      }, 
      "% INSTITUTIONAL PERIODS": {
        'title': "% INSTITUTIONAL PERIODS",
        'tooltip' : 'The proportion of 30-day payment periods that would qualify as an Institutional “Admission Source” under PDGM. These are periods for which the patient had a qualified inpatient stay that ended within 14 days of the home health start of care.',
      },
      "% COMMUNITY PERIODS": {
        'title': "% COMMUNITY PERIODS",
        'tooltip' : 'The portion of 30-day payment periods for which there was no preceding, qualifying inpatient stay.',
      },
      "% EARLY PERIODS" : {
         'title':  "% EARLY PERIODS",
         'tooltip' : 'The proportion of the agency’s 30-day payment periods that would be considered early.  This equates to the first 30-day period in a contiguous series',
      },
      "% LATE PERIODS" : {
        'title': "% LATE PERIODS",
        'tooltip' : 'The proportion of the agency’s 30-day payment periods that would be considered late.  This means that the period is a second or subsequent 30-day period.',
      },
      "AVG VISITS - EARLY PERIODS" : {
        'title': "AVG VISITS - EARLY PERIODS",
        'tooltip' : 'This is the average number of visits, for all disciplines, that occurred in the agency’s early – or first – payment period.',
      },
      "AVG VISITS - LATE PERIODS" : {
        'title':  "AVG VISITS - LATE PERIODS",
        'tooltip': 'This is the average number of visits, for all disciplines, that occurred in a late – second or subsequent contiguous – payment period.',
      },
      "% CLAIMS - NO COMORBIDITY" : 
      {
        'title': "% CLAIMS - NO COMORBIDITY",
        'tooltip' : 'This is the percentage of the agency’s claims that had no coded, qualified single comorbid diagnosis or qualified multiple/interactive comorbid diagnoses.',
      },
      "% CLAIMS INTERACTIVE COMORBIDITY" : {
        'title': "% CLAIMS INTERACTIVE COMORBIDITY",
        'tooltip' : 'This is the percentage of the agency’s claims that had more than one qualified comorbid diagnosis from among the CMS Interactive Comorbidity grouping.',
      },
      "% CLAIMS SINGLE COMORBIDITY" : {
        'title' : "% CLAIMS SINGLE COMORBIDITY",
        'tooltip' : 'This is the percentage of the agency’s claims that had a single secondary diagnosis from among the group of PDGM single comorbidities.',
      }    
    };
		
		var secDetailVal = {
  		
  		"Number of Stays": {
    		'title': "Number of Stays",
    		'tooltip' : "The count of stays, defined as the uninterrupted period during which services were provided, beginning with the Start of Care and ending with the patient’s Discharge  shown by Clinical Grouping.",
      },
      "Number of Claims" : {
        'title': "Number of Claims",
        'tooltip' : "The count of traditional Medicare final claims that were submitted and paid by CMS for 2017 services through the first quarter of 2018 shown by Clinical Grouping.",
      }, 
      "Total Payments" : {
        'title': "Total Payments",
        'tooltip' : "Total agency payments on traditional Medicare final claims for 2017 services for claims submitted through the first quarter of 2018 shown by Clinical Grouping.",
      }, 
      "Average Payment/Claim" : {
        'title': "Average Payment/Claim",
        'tooltip' : "Average episode payments by claim and Clinical Grouping.",
      }, 
      "Total 30-Day Periods" : {
        'title': "Total 30-Day Periods",
        'tooltip' : "The total number of claims divided into first and, as applicable, second thirty day periods by Clinical Grouping",
      }, 
      "Avg 30-Day Periods per Claim" : {
        'title': "Avg 30-Day Periods per Claim",
        'tooltip' : "Average number of periods by claim.  This value cannot exceed 2 and can correlate to the average episode length under PPS.  This value is divided and shown by Clinical Grouping.",
      },
      "Average Episode Length" : {
        'title': "Average Episode Length",
        'tooltip' : "The average number of days in each PPS episode divided by Clinical Grouping.",
      }, 
      "Average Days/30-Day Period" : {
        'title': "Average Days/30-Day Period",
        'tooltip' : "The average number of days in each PDGM 30-day period shown by Clinical Grouping.",
      }, 
      "Institutional 30-Day Periods" : {
        'title': "Institutional 30-Day Periods",
        'tooltip' : "The count of 30-day periods that were preceded by a qualified institutional inpatient stay shown by Clinical Grouping.",
      }, 
      "Community 30-Day Periods" : {
        'title': "Community 30-Day Periods",
        'tooltip' : "The count of 30-day periods that were not preceded by a qualified institutional inpatient stay shown by Clinical Grouping.",
      }, 
      "Institutional Periods - Initial" : {
        'title': "Institutional Periods - Initial",
        'tooltip' : "The count of initial, early, 30-day payment periods that were classified as Institutional Admission Sources shown by Clinical Grouping.",
      }, 
      "% Initial Periods - Inst" : {
        'title': "% Initial Periods - Inst",
        'tooltip' : "The percentage of 30-day payment periods that were classified as Institutional Admission Sources by Clinical Grouping.",
      }, 
      "Community Periods - Initial" : {
        'title': "Community Periods - Initial",
        'tooltip' : "The count of first 30-day payment periods that would be classified as a Community Admission Source by Clinical Grouping. ",
      }, 
      "% Initial Periods - Community" : {
        'title': "% Initial Periods - Community",
        'tooltip' : "The percentage of initial 30-day payment periods that would have been classified as Community Admission Sources by Clinical Grouping.",
      },  
      "Early 30-Day Periods" : {
        'title': "Early 30-Day Periods",
        'tooltip' : "The count of early 30-day payment periods by Clinical Grouping.",
      }, 
      "Late 30-Day Periods" : {
        'title': "Late 30-Day Periods",
        'tooltip' : "The count of second and subsequent, late, 30-day payment periods by Clinical Grouping.",
      }, 
      "Clms - Interactive Comorbidities" : {
        'title': "Clms - Interactive Comorbidities",
        'tooltip' : "The count of claims with multiple, qualified interactive comorbid diagnoses based on the CMS PDGM criteria shown by Clinical Grouping.",
      },  
      "Clms - Single Comorbidities" : {
        'title': "Clms - Single Comorbidities",
        'tooltip' : "The count of claims with single qualified comorbid diagnosis from the CMS PDGM listing shown by Clinical Grouping.",
      },  
      "Clms -  No Coded Comorbidities" : {
        'title': "Clms -  No Coded Comorbidities",
        'tooltip' : "The count of claims for which there was no qualified, coded comorbid diagnosis from the CMS PDGM list",
      },
    }; 
		
		
		var newHeaders = [];
     // no form
			var npi = window.pdgmdata.npi;
			url = "/pdgmtool/?npi="+npi;

			ajax  = $.ajax(url, {
		      success: function(data) {
  		      data = JSON.parse(data);
		        var tdata = data.records;

//				console.log(tdata);
				
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
          var colObj = fieldDetails[val];
					colObj.field = val;
					colObj.editor= false;
					colObj.align = "left";
					colObj.headerVertical = true;
										
					colObj.formatter = function(cell, formatterParams, onRendered){
              //cell - the cell component
              //formatterParams - parameters set for the column
              //onRendered - function to call when the formatter has been rendered
          //	console.log(cell.getElement());
          //	cell.getElement().classList.add("custom-class-np-here");
          
              return cell.getValue(); 
              //return "Mr" + cell.getValue(); //return the contents of the cell;
          },
					prColumns.push(colObj);
					secColumns.push(colObj);
				}); // end iterating over the headers
				
				console.log(prColumns);
				
				$.each( tdata, function( key, tdObj ) {
				
						processedData[tdObj.Clincat] = [];
						
						//console.log(tdObj);
						
						// Load Primary Table Data
						// calculate % - 30-DAY PDS/CLIN GRP by adding all "Pdcount" --> totalPdcount --> column - Pdcount / totalPdcount
						processedData[tdObj.Clincat]['% 30-DAY PERIODS/CLIN GRP'] = parseFloat(((tdObj.Pdcount / totalPdcount)*100).toFixed(2)) > 0 ? (parseFloat(((tdObj.Pdcount / totalPdcount)*100).toFixed(2)) + "%") :  "<span class='warning'></span>";   // Not finding this in excelsheet so Check on this .....
						processedData[tdObj.Clincat]['% INSTITUTIONAL PERIODS'] = parseFloat(((tdObj.Instpct)*100).toFixed(2)) > 0 ? ( parseFloat(((tdObj.Instpct)*100).toFixed(2)) + "%" ) : "<span class='warning'></span>"; 
						processedData[tdObj.Clincat]['% COMMUNITY PERIODS'] = parseFloat(((tdObj.Commpct)*100).toFixed(2)) > 0 ? (parseFloat(((tdObj.Commpct)*100).toFixed(2)) + "%") : "<span class='warning'></span>"; 
						processedData[tdObj.Clincat]['% EARLY PERIODS'] = parseFloat(((tdObj.Earlypct)*100).toFixed(2)) > 0 ? (parseFloat(((tdObj.Earlypct)*100).toFixed(2)) + "%" ) : "<span class='warning'></span>"; 
						processedData[tdObj.Clincat]['% LATE PERIODS'] = parseFloat(((tdObj.Latepct)*100).toFixed(2)) > 0 ? ( parseFloat(((tdObj.Latepct)*100).toFixed(2)) +"%" ) : "<span class='warning'></span>"; 
						processedData[tdObj.Clincat]['AVG VISITS - EARLY PERIODS'] = tdObj.Avgearlyvis > 0 ? tdObj.Avgearlyvis : "<span class='warning'></span>"; 
						processedData[tdObj.Clincat]['AVG VISITS - LATE PERIODS'] = tdObj.Avglatevis > 0 ? tdObj.Avglatevis : "<span class='warning'></span>"; 
; 
						processedData[tdObj.Clincat]['% CLAIMS - NO COMORBIDITY'] = parseFloat(((tdObj.Avgnocomorb)*100).toFixed(2)) > 0 ? ( parseFloat(((tdObj.Avgnocomorb)*100).toFixed(2)) + "%") : "<span class='warning'></span>"; 
						processedData[tdObj.Clincat]['% CLAIMS INTERACTIVE COMORBIDITY'] = parseFloat(((tdObj.Avgintcomorb)*100).toFixed(2)) > 0 ? ( parseFloat(((tdObj.Avgintcomorb)*100).toFixed(2))+ "%" ) : "<span class='warning'></span>"; 
						processedData[tdObj.Clincat]['% CLAIMS SINGLE COMORBIDITY'] = parseFloat(((tdObj.Avgsinglecomorb)*100).toFixed(2)) > 0 ? ( parseFloat(((tdObj.Avgsinglecomorb)*100).toFixed(2)) + "%" ) : "<span class='warning'></span>"; 
				
						
						// Load Secondary Table Data
						
						processedData[tdObj.Clincat]['Number of Stays'] = tdObj.Staycount > 0 ? tdObj.Staycount : "<span class='warning'></span>"; 
						processedData[tdObj.Clincat]['Number of Claims'] = tdObj.Clmcount > 0 ? tdObj.Clmcount  : "<span class='warning'></span>"; ; 
						processedData[tdObj.Clincat]['Total Payments'] = tdObj.Clmpmts > 0 ? tdObj.Clmpmts.toLocaleString('en-US')  : "<span class='warning'></span>"; ; 
						processedData[tdObj.Clincat]['Average Payment/Claim'] = tdObj.Avgclmpmt > 0 ? tdObj.Avgclmpmt  : "<span class='warning'></span>"; ;
						processedData[tdObj.Clincat]['Total 30-Day Periods'] = tdObj.Pdcount > 0 ? tdObj.Pdcount  : "<span class='warning'></span>"; ;
						processedData[tdObj.Clincat]['Avg 30-Day Periods per Claim'] = tdObj.Avgpdsclm > 0 ? tdObj.Avgpdsclm  : "<span class='warning'></span>"; ;
						processedData[tdObj.Clincat]['Average Episode Length'] = tdObj.Avgclmdays > 0 ? tdObj.Avgclmdays  : "<span class='warning'></span>"; ;
						processedData[tdObj.Clincat]['Average Days/30-Day Period'] = tdObj.Avgpddays > 0 ? tdObj.Avgpddays : "<span class='warning'></span>"; ;
						processedData[tdObj.Clincat]['Institutional 30-Day Periods'] = tdObj.Instpds > 0 ? tdObj.Instpds : "<span class='warning'></span>"; ;
						processedData[tdObj.Clincat]['Community 30-Day Periods'] = tdObj.Commpds > 0 ? tdObj.Commpds : "<span class='warning'></span>"; ;
						processedData[tdObj.Clincat]['Institutional Periods - Initial'] = tdObj.Initinstpds > 0 ? tdObj.Initinstpds : "<span class='warning'></span>"; ;
						processedData[tdObj.Clincat]['% Initial Periods - Inst'] = tdObj.Initinstpct > 0 ? parseFloat((tdObj.Initinstpct*100).toFixed(2)) + "%"  : "<span class='warning'></span>"; ;
						processedData[tdObj.Clincat]['Community Periods - Initial'] = tdObj.Initcommpds > 0 ? tdObj.Initcommpds  : "<span class='warning'></span>"; ;
						processedData[tdObj.Clincat]['% Initial Periods - Community'] = tdObj.Initcommpct > 0 ? parseFloat((tdObj.Initcommpct*100).toFixed(2)) + "%"  : "<span class='warning'></span>"; ;
						processedData[tdObj.Clincat]['Early 30-Day Periods'] = tdObj.Earlypds > 0 ? tdObj.Earlypds  : "<span class='warning'></span>"; ;
						processedData[tdObj.Clincat]['Late 30-Day Periods'] = tdObj.Latepds > 0 ? tdObj.Latepds  : "<span class='warning'></span>"; ;
						processedData[tdObj.Clincat]['Clms - Interactive Comorbidities'] = tdObj.Interactcomorb > 0 ? tdObj.Interactcomorb : "<span class='warning'></span>"; ;
						processedData[tdObj.Clincat]['Clms - Single Comorbidities'] = tdObj.Singlecomorb >0 ? tdObj.Singlecomorb : "<span class='warning'></span>"; ;
						processedData[tdObj.Clincat]['Clms -  No Coded Comorbidities'] = tdObj.Nocomorb > 0 ? tdObj.Nocomorb : "<span class='warning'></span>"; ; 
				
				});
				
				// GC adds to flag "other" / questionable data
				
				$(".pdgm-data-wrapper").show();
				
				//Render Primary Table -- Summary table
				$.each( prDetailVal, function( dKey, dValue ) {
					var finalProcessedObj = {};
					
					$.each( headers , function( hKey, hVal ) {
					
						finalProcessedObj['SUMMARY'] = dValue["title"];
						finalProcessedObj[hVal] = processedData[hVal][dValue["title"]];
					});
					finalProcessedData.push(finalProcessedObj);
				});

//				console.log(finalProcessedData);
				
				
				// Set the placeholder values
				$(".npi-val").text(npiNum);
				$(".agency-name").text(agencyName);
				totPmts = Number(totPmts).toLocaleString('en-US', { style: 'currency', currency: 'USD' });
				$(".totpmts-data").text(totPmts);
				$(".agency-state").text(agencyState);
				
				
				// Now create the table
				
				new Tabulator(".primary-table", {
			    data:finalProcessedData,           //load row data from array
					layout:"fitColumns",      //fit columns to width of table
					responsiveLayout:"hide",  //hide columns that dont fit on the table
					tooltipsHeader:true,      // and on columns
					//addRowPos:"top",          //when adding a new row, add it to the top of the table
					//history:true,             //allow undo and redo actions on the table
					//pagination:"local",       //paginate the data
					//paginationSize:7,         //allow 7 rows per page of data
					movableColumns:true,      //allow column order to be changed
					resizableRows:false,       //allow row order to be changed
					columns: prColumns,
					tooltips:function(cell) {
  					// Generate the tooltip
  					
  					// If we're in the first row
  					var col = cell.getColumn().getDefinition();
  					var rowData = prDetailVal[cell.getRow().getData()["SUMMARY"]];

  					if (col.field == "SUMMARY") { 
				              return rowData.tooltip;
  					} else {
    					       return col.field + " : " + rowData.title + " = " + cell.getValue();
  					}

					},
          
		    });

				//Render Secondary Table -- Detail table
				finalProcessedData = [];
				$.each( secDetailVal, function( dKey, dValue ) {
					var finalProcessedObj = {};
					
					$.each( headers , function( hKey, hVal ) {
					
						finalProcessedObj['DETAILS'] = dValue["title"];
            finalProcessedObj[hVal] = processedData[hVal][dValue["title"]];
//						finalProcessedObj[hVal] = processedData[hVal][dValue];
					});
					finalProcessedData.push(finalProcessedObj);
				});
				
				 
				 
				 
            //Should DRY this up
		         new Tabulator(".secondary-table", {
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
    					columns: secColumns,
    					tooltips:function(cell) {
      					// Generate the tooltip

      					var col = cell.getColumn().getDefinition();
      					var rowData = secDetailVal[cell.getRow().getData()["DETAILS"]];
//      					console.log(col);
//      					console.log()
      					// If we're in the first row      					
      					if (col.field == "DETAILS") { 
//        					console.log("returning " + rowData.tooltip);
                  return rowData.tooltip;
      					} else {
                  if (String(cell.getValue()).search("warning") > -1) {
                    // Provide error message
                    return col.field + " : " + rowData.title + " = " + "Insufficient data available to provide a value"; 
                  } else {
          					return col.field + " : " + rowData.title + " = " + cell.getValue();
          				}
      					}
    					},
		
		         });
		         
		         ajax = undefined;
		         //enable form
				 $("#pdgm-search-form *").prop("disabled", false);
				 
				 
		         
		      },
		      error: function() {
		         // Check what needs to happen here.
//		         console.log("error occured");
		         $(".pdgm-data-wrapper").hide();
		      }
		   });	
		
	;
});
