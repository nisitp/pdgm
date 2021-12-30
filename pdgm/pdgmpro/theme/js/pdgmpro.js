var $buoop = {required:{e:17,f:-3,o:-3,s:-2,c:-3},insecure:true,unsupported:true,api:2019.03 }; 
function $buo_f(){ 
 var e = document.createElement("script"); 
 e.src = "//browser-update.org/update.min.js"; 
 document.body.appendChild(e);
};
try {document.addEventListener("DOMContentLoaded", $buo_f,false)}
catch(e){window.attachEvent("onload", $buo_f)}

jQuery(document).ready(function($) {
  
  
  // NOTE - there is server-side validation too, so this will need to be changed in both places!  
    if ($("#form_user-registration").length) {
    $("#form_user-registration #field_agency_npi").change(function() {
      var npi = $(this).val();
      if (npi.length) {
        ajax  = $.ajax('/pdgmtool/?npi='+npi+"&function=count", {
          success: function(data) {
            if (data == 0) {
              // make an error thing like the others
              $error = '<div class="npi_error frm_error">' + npi + ' does not appear to be a valid NPI. Please check and try again.</div>';
              $("#field_agency_npi").parent().append($error);
    //              $("#form_3_1 .agency_npi").addClass("rm-form-field-invalid-msg");
            } else {
              $("#field_agency_npi").parent().find(".npi_error").remove();
            }
            
          }
        });
      } else { // if no npi length remove our custom error 
        $("#field_agency_npi").parent().find(".npi_error").remove();        
      }
    });
  }
  
  // topbar alerts
  if ($(".topbar__alert").length) {
    // open it
    var alertID = $(".topbar__alert").attr("id");
    var alertStatus = Cookies.get("tophat_alert");
    if (alertStatus != alertID) {

      $(".topbar__alert").delay(1500).queue(function(next) { $(this).addClass("open"); next(); });
    
      $(".topbar__alert__close").click(function() {
          $(".topbar__alert").removeClass("open");
          Cookies.set("tophat_alert", alertID);
      });
    }
  }      
      
});