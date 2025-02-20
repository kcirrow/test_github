//=========================================================================================================
//	FUNCTIONS AND VARIABLE (FAV)
//=========================================================================================================

var state = {};
var operatortable = "";
var drivertable = "";
var assessmenttable = "";
var releasingttable = "";
var motortable = "";
var signatoriestable = "";
var dashboardtable = "";
var feestable = "";
var settingsreq = "";
var reqapptable = "";
var motoroperatortable = "";
var regCode = "04";
var provCode = "0458";
var citymunCode = "045809";
var brgyCode = "";
var makesettingstable = "";
var baseurl = "/mtop_morong";

var totamt = 0;

var getUrlParameter = function getUrlParameter(sParam) {
  var sPageURL = window.location.search.substring(1),
    sURLVariables = sPageURL.split("&"),
    sParameterName,
    i;

  for (i = 0; i < sURLVariables.length; i++) {
    sParameterName = sURLVariables[i].split("=");

    if (sParameterName[0] === sParam) {
      return sParameterName[1] === undefined
        ? true
        : decodeURIComponent(sParameterName[1]);
    }
  }
};

(function($){
    var proxy = $.fn.serializeArray;
    $.fn.serializeArray = function(){
        var inputs = this.find(':disabled');
        inputs.prop('disabled', false);
        var serialized = proxy.apply( this, arguments );
        inputs.prop('disabled', true);
        return serialized;
    };
})(jQuery);

function LPAD (str, max) {
  str = str.toString();
  return str.length < max ? LPAD("0" + str, max) : str;
}

$("input[type=text]").on("input", function () {
  $(this).val($(this).val().toUpperCase());
});

$(function() {
    $('[data-toggle="tooltip"]').tooltip({
        container : 'body'
    });
});


function statusButton(status, type) {
  switch (type) {
    case "franchise":
      if (status == "FOR ASSESSMENT") {
        return "<button class='btn btn-primary' id='btn-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button> <button class='btn btn-warning' id='btn-operator-inspection' data-toggle='tooltip' data-placement='top' title='Inspection'><i class='fa fa-eye'></i></button> <button class='btn btn-info' id='btn-operator-assessment' data-toggle='tooltip' data-placement='top' title='Assessment'><i class='fa fa-book-open'></i></button> <button class='btn btn-danger' id='btn-cancel' data-toggle='tooltip' data-placement='top' title='Cancel'><i class='fa fa-times'></i></button>";
      } else if (status == "FOR INSPECTION" || status == "DENIED") {
        return "<button class='btn btn-primary' id='btn-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button> <button class='btn btn-warning' id='btn-operator-inspection' data-toggle='tooltip' data-placement='top' title='Inspection'><i class='fa fa-eye'></i></button> <button class='btn btn-danger' id='btn-cancel' data-toggle='tooltip' data-placement='top' title='Cancel'><i class='fa fa-times'></i></button>";
        // return "<button class='btn btn-info' id='btn-view'><i class='fa fa-book-open'></i></button> <button class='btn btn-success' id='btn-payment'><i class='fa fa-money-bill'></i></button>";
      } else if (status == "FOR PAYMENT") {
        return "<button class='btn btn-primary' id='btn-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button> <button class='btn btn-warning' id='btn-operator-inspection' data-toggle='tooltip' data-placement='top' title='Inspection'><i class='fa fa-eye'></i></button> <button class='btn btn-info' id='btn-operator-assessment' data-toggle='tooltip' data-placement='top' title='Assessment'><i class='fa fa-book-open'></i></button> <button class='btn btn-danger' id='btn-cancel' data-toggle='tooltip' data-placement='top' title='Cancel'><i class='fa fa-times'></i></button>";
        // return "<button class='btn btn-info' id='btn-view'><i class='fa fa-book-open'></i></button> <button class='btn btn-success' id='btn-payment'><i class='fa fa-money-bill'></i></button>";
      } else if (status == "FOR RELEASING" || status == "RELEASED") {
        return "<button class='btn btn-primary' id='btn-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button> <button class='btn btn-warning' id='btn-operator-inspection' data-toggle='tooltip' data-placement='top' title='Inspection'><i class='fa fa-eye'></i></button> <button class='btn btn-info' id='btn-operator-release' data-toggle='tooltip' data-placement='top' title='Release'><i class='fa fa-check'></i></button> <button class='btn btn-danger' id='btn-cancel' data-toggle='tooltip' data-placement='top' title='Cancel'><i class='fa fa-times'></i></button>";
        // return "<button class='btn btn-info' id='btn-view'><i class='fa fa-book-open'></i></button> <button class='btn btn-success' id='btn-payment'><i class='fa fa-money-bill'></i></button>";
      }
      break;

    case "changemotor":
      if (status == "FOR ASSESSMENT") {
        return "<button class='btn btn-primary' id='btn-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button> <button class='btn btn-warning' id='btn-changemotor-inspection' data-toggle='tooltip' data-placement='top' title='Inspection'><i class='fa fa-eye'></i></button> <button class='btn btn-info' id='btn-changemotor-assessment' data-toggle='tooltip' data-placement='top' title='Assessment'><i class='fa fa-book-open'></i></button> <button class='btn btn-danger' id='btn-cancel' data-toggle='tooltip' data-placement='top' title='Cancel'><i class='fa fa-times'></i></button>";
      } else if (status == "FOR INSPECTION" || status == "DENIED") {
        return "<button class='btn btn-primary' id='btn-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button> <button class='btn btn-warning' id='btn-changemotor-inspection' data-toggle='tooltip' data-placement='top' title='Inspection'><i class='fa fa-eye'></i></button> <button class='btn btn-danger' id='btn-cancel' data-toggle='tooltip' data-placement='top' title='Cancel'><i class='fa fa-times'></i></button>";
        // return "<button class='btn btn-info' id='btn-view'><i class='fa fa-book-open'></i></button> <button class='btn btn-success' id='btn-payment'><i class='fa fa-money-bill'></i></button>";
      } else if (status == "FOR PAYMENT") {
        return "<button class='btn btn-primary' id='btn-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button> <button class='btn btn-warning' id='btn-changemotor-inspection' data-toggle='tooltip' data-placement='top' title='Inspection'><i class='fa fa-eye'></i></button> <button class='btn btn-info' id='btn-changemotor-assessment' data-toggle='tooltip' data-placement='top' title='Assessment'><i class='fa fa-book-open'></i></button> <button class='btn btn-danger' id='btn-cancel' data-toggle='tooltip' data-placement='top' title='Cancel'><i class='fa fa-times'></i></button>";
        // return "<button class='btn btn-info' id='btn-view'><i class='fa fa-book-open'></i></button> <button class='btn btn-success' id='btn-payment'><i class='fa fa-money-bill'></i></button>";
      } else if (status == "FOR RELEASING" || status == "RELEASED") {
        return "<button class='btn btn-primary' id='btn-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button> <button class='btn btn-warning' id='btn-changemotor-inspection' data-toggle='tooltip' data-placement='top' title='Inspection'><i class='fa fa-eye'></i></button> <button class='btn btn-info' id='btn-changemotor-release' data-toggle='tooltip' data-placement='top' title='Release'><i class='fa fa-check'></i></button> <button class='btn btn-danger' id='btn-cancel' data-toggle='tooltip' data-placement='top' title='Cancel'><i class='fa fa-times'></i></button>";
        // return "<button class='btn btn-info' id='btn-view'><i class='fa fa-book-open'></i></button> <button class='btn btn-success' id='btn-payment'><i class='fa fa-money-bill'></i></button>";
      }
      break;

    case "changeownership":
      if (status == "FOR ASSESSMENT") {
        return "<button class='btn btn-primary' id='btn-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button> <button class='btn btn-warning' id='btn-changeownership-inspection' data-toggle='tooltip' data-placement='top' title='Inspection'><i class='fa fa-eye'></i></button> <button class='btn btn-info' id='btn-changeownership-assessment' data-toggle='tooltip' data-placement='top' title='Assessment'><i class='fa fa-book-open'></i></button> <button class='btn btn-danger' id='btn-cancel' data-toggle='tooltip' data-placement='top' title='Cancel'><i class='fa fa-times'></i></button>";
      } else if (status == "FOR INSPECTION" || status == "DENIED") {
        return "<button class='btn btn-primary' id='btn-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button> <button class='btn btn-warning' id='btn-changeownership-inspection' data-toggle='tooltip' data-placement='top' title='Inspection'><i class='fa fa-eye'></i></button> <button class='btn btn-danger' id='btn-cancel' data-toggle='tooltip' data-placement='top' title='Cancel'><i class='fa fa-times'></i></button>";
        // return "<button class='btn btn-info' id='btn-view'><i class='fa fa-book-open'></i></button> <button class='btn btn-success' id='btn-payment'><i class='fa fa-money-bill'></i></button>";
      } else if (status == "FOR PAYMENT") {
        return "<button class='btn btn-primary' id='btn-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button> <button class='btn btn-warning' id='btn-changeownership-inspection' data-toggle='tooltip' data-placement='top' title='Inspection'><i class='fa fa-eye'></i></button> <button class='btn btn-info' id='btn-changeownership-assessment' data-toggle='tooltip' data-placement='top' title='Assessment'><i class='fa fa-book-open'></i></button> <button class='btn btn-danger' id='btn-cancel' data-toggle='tooltip' data-placement='top' title='Cancel'><i class='fa fa-times'></i></button>";
        // return "<button class='btn btn-info' id='btn-view'><i class='fa fa-book-open'></i></button> <button class='btn btn-success' id='btn-payment'><i class='fa fa-money-bill'></i></button>";
      } else if (status == "FOR RELEASING" || status == "RELEASED") {
        return "<button class='btn btn-primary' id='btn-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button> <button class='btn btn-warning' id='btn-changeownership-inspection' data-toggle='tooltip' data-placement='top' title='Inspection'><i class='fa fa-eye'></i></button> <button class='btn btn-info' id='btn-changeownership-release' data-toggle='tooltip' data-placement='top' title='Release'><i class='fa fa-check'></i></button> <button class='btn btn-danger' id='btn-cancel' data-toggle='tooltip' data-placement='top' title='Cancel'><i class='fa fa-times'></i></button>";
        // return "<button class='btn btn-info' id='btn-view'><i class='fa fa-book-open'></i></button> <button class='btn btn-success' id='btn-payment'><i class='fa fa-money-bill'></i></button>";
      }
      break;

    case "dropping":
      if (status == "FOR ASSESSMENT") {
        return "<button class='btn btn-primary' id='btn-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button> <button class='btn btn-warning' id='btn-dropping-inspection' data-toggle='tooltip' data-placement='top' title='Inspection'><i class='fa fa-eye'></i></button> <button class='btn btn-info' id='btn-dropping-assessment' data-toggle='tooltip' data-placement='top' title='Assessment'><i class='fa fa-book-open'></i></button> <button class='btn btn-danger' id='btn-cancel' data-toggle='tooltip' data-placement='top' title='Cancel'><i class='fa fa-times'></i></button>";
      } else if (status == "FOR INSPECTION" || status == "DENIED") {
        return "<button class='btn btn-primary' id='btn-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button> <button class='btn btn-warning' id='btn-dropping-inspection' data-toggle='tooltip' data-placement='top' title='Inspection'><i class='fa fa-eye'></i></button> <button class='btn btn-danger' id='btn-cancel' data-toggle='tooltip' data-placement='top' title='Cancel'><i class='fa fa-times'></i></button>";
      } else if (status == "FOR PAYMENT") {
        return "<button class='btn btn-primary' id='btn-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button> <button class='btn btn-warning' id='btn-dropping-inspection' data-toggle='tooltip' data-placement='top' title='Inspection'><i class='fa fa-eye'></i></button> <button class='btn btn-info' id='btn-dropping-assessment' data-toggle='tooltip' data-placement='top' title='Assessment'><i class='fa fa-book-open'></i></button> <button class='btn btn-danger' id='btn-cancel' data-toggle='tooltip' data-placement='top' title='Cancel'><i class='fa fa-times'></i></button>";
      } else if (status == "FOR RELEASING" || status == "RELEASED") {
        return "<button class='btn btn-primary' id='btn-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button> <button class='btn btn-warning' id='btn-dropping-inspection' data-toggle='tooltip' data-placement='top' title='Inspection'><i class='fa fa-eye'></i></button> <button class='btn btn-info' id='btn-dropping-release' data-toggle='tooltip' data-placement='top' title='Release'><i class='fa fa-check'></i></button> <button class='btn btn-danger' id='btn-cancel' data-toggle='tooltip' data-placement='top' title='Cancel'><i class='fa fa-times'></i></button>";
      }
      break;
    default:
      return "";
  }
}

function statusDisplay(status) {
  if (status == "RELEASED") {
    return "<span class='badge badge-info'>RELEASED</span>";
  } else if (status == "FOR INSPECTION") {
    return "<span class='badge badge-warning'>FOR INSPECTION</span>";
  } else if (status == "FOR ASSESSMENT") {
    return "<span class='badge badge-warning'>FOR ASSESSMENT</span>";
  } else if (status == "FOR PAYMENT") {
    return "<span class='badge badge-success'>FOR PAYMENT</span>";
  } else if (status == "FOR RELEASING") {
    return "<span class='badge badge-warning'>FOR RELEASING</span>";
  } else if (status == "DENIED") {
    return "<span class='badge badge-danger'>DENIED</span>";
  } else {
    return "<span class='badge badge-secondary'>UNDEFINED</span>";
  }
}

function franDisplay(lastrenew, status, remarks) {
  var td = TodayDate();
  var today = new Date(td);
  var lastrenew = new Date(lastrenew);
  var ex = new Date("1990-01-01");
  if (lastrenew.valueOf() != ex.valueOf()) {
      if (status == "UNAVAILABLE") {
        return "<span class='badge badge-danger'>" + remarks + "</span>";
      } else {
        if (today > lastrenew) {
          return "<span class='badge badge-danger'>FRANCHISE EXPIRED</span>";
        }
      }
  }
}

function TodayDate() {
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, "0");
  var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
  var yyyy = today.getFullYear();

  today = yyyy + "-" + mm + "-" + dd;
  return today;
}

function getExprDate() {
  $.ajax({
    url: "../config/includes.php?var=getfranexpdate",
    method: "POST",
    dataType: "JSON",
    success: function (e) {
      if (e.expmode == 0) {
        var exprd = new Date();
        var dd = String(exprd.getDate()).padStart(2, "0");
        var mm = String(exprd.getMonth() + 1).padStart(2, "0"); //January is 0!
        var yyyy = exprd.getFullYear() + 1;

        exprd = yyyy + "-" + mm + "-" + dd;
        return exprd;
      } else {
        var exprd = new Date();
        var yyyy = exprd.getFullYear();
        return yyyy + "-12-31";
      }
    }
  });
}

function printAssessment(data) {
  const printPage = async (sURL) => {
    var oHiddFrame = document.createElement("iframe");
    const printPromise = new Promise((resolve, reject) => {
      oHiddFrame.onload = function () {
        try {
          oHiddFrame.contentWindow.focus(); // Required for IE
          oHiddFrame.contentWindow.print();
          resolve();
        } catch (error) {
          reject(error);
        }
      };
    });
    oHiddFrame.style.position = "fixed";
    oHiddFrame.style.right = "0";
    oHiddFrame.style.bottom = "0";
    oHiddFrame.style.width = "0";
    oHiddFrame.style.height = "0";
    oHiddFrame.style.border = "0";
    oHiddFrame.src = sURL;
    document.body.appendChild(oHiddFrame);
    await printPromise;
  };

  var doc = new jsPDF("p", "mm");
  doc.setFontSize(15);
  doc.text(67, 15, "REPUBLIC OF THE PHILIPPINES");
  doc.text(69, 20, "TRICYCLE REGULATORY UNIT");
  doc.setFontSize(10);
  doc.text(90, 25, "Municipality of Morong");
  doc.setFontSize(18);
  doc.text(75, 35, "ORDER OF PAYMENT");
  doc.text(150, 25, data.application.trcode);
  doc.setFontSize(10);
  doc.text(150, 30, data.application.appl_status);
  doc.setFontSize(13);
  doc.text(10, 45, "Name:");
  doc.text(30, 45, data.application.fullname);
  doc.text(10, 50, "Address:");
  doc.text(30, 50, data.application.addr);
  doc.text(10, 60, "TODA:");
  doc.text(27, 60, data.application.tbody);
  doc.text(10, 65, "Make:");
  doc.text(27, 65, data.application.make);
  doc.text(10, 70, "Model:");
  doc.text(27, 70, data.application.yearmodel);
  doc.text(100, 60, "Motor #:");
  doc.text(125, 60, data.application.engine);
  doc.text(100, 65, "Chassis #:");
  doc.text(125, 65, data.application.chassis);
  doc.text(100, 70, "Plate #:");
  doc.text(125, 70, data.application.plateno);
  doc.text(10, 80, "Description");
  doc.text(150, 80, "Amount");
  doc.line(10, 82, 180, 82);
  y = 87;
  total = 0;
  $.map(data.assessment, function (items) {
    doc.text(10, y, items.Fees);
    doc.text(150, y, items.AmtDue);
    y += 5;
    total += parseFloat(items.AmtDue);
  });
  doc.text(10, 120, "Assessed By:");
  doc.text(40, 120, data.application.assby);
  doc.text(115, 120, "Total Amount:");
  doc.text(150, 120, total.toString());
  doc.text(20, 130, "*THIS ORDER OF PAYMENT ALSO SERVES AS CLAIM STUB*");

  printPage(doc.output("bloburl")).catch((error) => {
    // Fallback printing method
    doc.autoPrint();
    doc.output("dataurlnewwindow");
  });
}

var $body = $("body"),
  curPos = 0,
  isOpened = false,
  isOpenedTwice = false;
$body.off("shown.bs.modal hidden.bs.modal", ".modal");
$body.on("shown.bs.modal", ".modal", function () {
  if (isOpened) {
    isOpenedTwice = true;
  } else {
    isOpened = true;
    curPos = $(window).scrollTop();
    $body.css("overflow", "hidden");
  }
});
$body.on("hidden.bs.modal", ".modal", function () {
  if (!isOpenedTwice) {
    $(window).scrollTop(curPos);
    $body.css("overflow", "visible");
    isOpened = false;
  } else {
    $(".modal").css("overflow", "auto");
  }
  isOpenedTwice = false;
});

async function toDataUrl(src, callback, outputFormat) {
  // Create an Image object
  var img = new Image();
  // Add CORS approval to prevent a tainted canvas
  img.crossOrigin = "Anonymous";
  img.onload = function () {
    // Create an html canvas element
    var canvas = document.createElement("CANVAS");
    // Create a 2d context
    var ctx = canvas.getContext("2d");
    var dataURL;
    // Resize the canavas to the original image dimensions
    canvas.height = this.naturalHeight;
    canvas.width = this.naturalWidth;
    // Draw the image to a canvas
    ctx.drawImage(this, 0, 0);
    // Convert the canvas to a data url
    dataURL = canvas.toDataURL(outputFormat);
    // Return the data url via callback
    callback(dataURL);
    // Mark the canvas to be ready for garbage
    // collection
    canvas = null;
  };
  // Load the image
  img.src = src;
  // make sure the load event fires for cached images too
  if (img.complete || img.complete === undefined) {
    // Flush cache
    img.src =
      "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
    // Try again
    img.src = src;
  }
}
var shit = "";
function printReleasePermit(data) {
  const printPage = async (sURL) => {
    var oHiddFrame = document.createElement("iframe");
    const printPromise = new Promise((resolve, reject) => {
      oHiddFrame.onload = function () {
        try {
          oHiddFrame.contentWindow.focus(); // Required for IE
          oHiddFrame.contentWindow.print();
          resolve();
        } catch (error) {
          reject(error);
        }
      };
    });
    oHiddFrame.style.position = "fixed";
    oHiddFrame.style.right = "0";
    oHiddFrame.style.bottom = "0";
    oHiddFrame.style.width = "0";
    oHiddFrame.style.height = "0";
    oHiddFrame.style.border = "0";
    oHiddFrame.src = sURL;
    document.body.appendChild(oHiddFrame);
    await printPromise;
  };
  // You'll need to make your image into a Data URL
  // Use http://dataurl.net/#dataurlmaker
  var doc = new jsPDF();

  // function converttobase64 (imgpath) {
  //        var img = new Image();
  //        img.src = imgpath;
  //        return img;
  //    };

  //  var imgData = converttobase64(data.target_path);

  // var imgData = converttobase64(data.target_path);

  doc.setFontSize(12);
  doc.text(52, 68, "Morong, Rizal");
  doc.text(52, 78, data.fullname);
  doc.setFontSize(10);
  doc.text(52, 89, data.addr);

  doc.addImage(shit, "JPEG", 155, 52, 35, 35);

  doc.setFontSize(12);
  doc.text(165, 96, LPAD(data.franchise_no, 4));
  doc.text(20, 108, data.toda);
  doc.text(20, 128, data.make);
//   doc.text(15, 128, data.yearmodel);
  doc.text(65, 128, data.engine);
  doc.text(115, 128, data.chassis);
  doc.text(165, 128, data.plateno);
  doc.setFontSize(8);
  doc.text(168, 160, data.ltobranch);
  doc.setFontSize(12);
  doc.text(32, 227, data.or_number);
  doc.text(32, 235, data.dtexprd);
  
  printPage(doc.output("bloburl")).catch((error) => {
    // Fallback printing method
    doc.autoPrint();
    doc.output("dataurlnewwindow");
  });
}

function callOperatorTable() {
  $("#operatortable").DataTable().destroy();
  operatortable = $("#operatortable").DataTable({
    ajax: {
      url: "../config/includes.php?var=getoperators",
      method: "POST",
    },
    columns: [{
        data: function () {
            return "<button class='btn btn-primary btn-sm' id='btn-operator-select'>Select</button>";
        }
    }, { data: "humanpin" }, { data: "fullname" }, { data: "addr" }],
    order: [[0, "desc"]],
  });
}

function callMotorOperatorTable() {
  $("#motoroperatortable").DataTable().destroy();
  motoroperatortable = $("#motoroperatortable").DataTable({
    ajax: {
      url: "../config/includes.php?var=getoperators",
      method: "POST",
    },
    columns: [{ data: "humanpin" }, { data: "fullname" }, { data: "addr" }],
    order: [[0, "desc"]],
  });
}

function callDriverTable() {
  $("#drivertable").DataTable().destroy();
  drivertable = $("#drivertable").DataTable({
    ajax: {
      url: "../config/includes.php?var=getdrivers",
      method: "POST",
    },
    columns: [{
        data: function () {
            return "<button class='btn btn-primary btn-sm' id='btn-driver-select'>Select</button>";
        }
    },{ data: "humanpin" }, { data: "fullname" }, { data: "addr" }],
    order: [[0, "desc"]],
  });
}

function callMotorTable() {
  $("#motortable").DataTable().destroy();
  motortable = $("#motortable").DataTable({
    ajax: {
      url: "../config/includes.php?var=getmotor",
      method: "POST",
    },
    columns: [{
            data: function () {
                return "<button class='btn btn-primary btn-sm' id='btn-motor-select'>Select</button>";
            }
        },
      { data: "motorpin" },
      { data: "opname" },
      { data: "todabody" },
      { data: "last_renew" },
      { data: "dtexprd" },
      { data: function (e) {
            return (e.franchiseno != "" ? LPAD(e.franchiseno, 4) : "");
      } },
      { data: "engine" },
      { data: "plateno" },
      { data: "ophumanpin" },
      { data: "drname" },
      { data: "status" },
    ],
    order: [[0, "desc"]],
    oSearch: { sSearch: state.opcode },
  });
  $("#motor-modal").modal("show");
}

function callReqApplication(apptype) {
  cc = 0;
  reqapptable = $("#req-application-datatable").DataTable({
    destroy: true,
    ajax: {
      url:
        "../config/includes.php?var=getreqapplication&trcode=" +
        getUrlParameter("trcode") +
        "&apptype=" +
        apptype,
      method: "POST",
    },
    columns: [
      {
        data: function ( e, type, val, meta ) {
          return (
            "<button class='btn btn-secondary' id='btn-open-pics'><i class='fa fa-images'></i></button> <input type='file' class='btn btn-info' id='repapp-picture-" +
            (meta.row + 1) +
            "'>"
          );
        },
      },
      { data: function (e) {
          if (e.target_path != null) {
            return "<img alt='Req' class='table-avatar' id='btn-open-pics' src='"+e.target_path+"'>";    
          } else {
              return "";
          }
          
      }},
      { data: "reqdesc" },
      {
        data: function (e) {
          if (e.target_path === null) {
            return "<span class='badge badge-danger' style='font-size: 20px'><i class='fa fa-times'></i></span>";
          } else {
            return "<span class='badge badge-success' style='font-size: 17px'><i class='fa fa-check'></i></span>";
          }
        },
        className: "text-center",
      },
    ],
    idSrc: "reqid",
    filter: false,
    bInfo: false,
    sort: false,
    paging: false,
  });
}

function callAssessmentTable(x, y) {
  totamt = 0;
  $("#tdpyr").val(1);
  curass = {};
  $.ajax({
      url: "../config/includes.php?var=getcurassfees&trcode=" + y,
      method: "GET",
      dataType: "JSON",
      success: function (e) {
        curass = e.curass;
          assessmenttable = $("#assessment-datatable").DataTable({
            destroy: true,
            ajax: {
              url: "../config/includes.php?var=getassfees&type=" + x + "&code=" + y,
              method: "GET",
              complete: function (e) {
                // curass = e.responseJSON.curass;
                // state.tdpcost = e.responseJSON.data[0].AmtDue;
                // if (x != "TDP") {
                //   $("#tdpyr").remove();
                // }
              },
            },
            columns: [
              {
                data: function (e) {
                  if (e.collnature != "21672") {
                    return "<input type='checkbox' id='selectpay'>";
                  } else {
                    return "";
                  }
                },
                className: "text-center",
              },
              { data: "Fees" },
              { data: "AmtDue" },
            ],
            createdRow: function (row, data, index) {
              if (data.collnature == "21672") {
                $(row).addClass("selected pen");
                totamt += parseFloat(data.AmtDue);
                $("#total-assess").html(totamt);
              }
               $.map(curass, function (item) {
                   if (item.feesid == data.ID && !$(row).hasClass("pen")) {
                       $('#selectpay', row).prop("checked", true);
                       $(row).addClass("selected");
                        totamt += parseFloat(data.AmtDue);
                   }
                   $("#total-assess").html(totamt);
               });
            },
            filter: false,
            bInfo: false,
            sort: false,
            paging: false,
          });
      }
  });
  

  $("#assessment-datatable_wrapper").css("width", "100%");
  $("#assessment-modal").modal("show");
}

function callReleasingTable(x, y) {
  $("#releasing-datatable").DataTable().destroy();
  releasingttable = $("#releasing-datatable").DataTable({
    ajax: {
      url: baseurl + "/config/includes.php?var=getdetassrelease",
      method: "POST",
      data: { trans: y, trcode: x },
      complete: function (e) {
        if (state.appl_status != "TDP") {
            var exfran = e.responseJSON.info.franchise_no;
            var mk = e.responseJSON.info.make;
            var nmtp = e.responseJSON.info.next_mtop
;
          $("#relmtp").val(e.responseJSON.info.franchise_no);
          if (e.responseJSON.info.dtexprd == "" || e.responseJSON.info.dtexprd == "1990-01-01") {
            $("#relfranexp").val(getExprDate());
          } else {
            $("#relfranexp").val(e.responseJSON.info.dtexprd);
          }
          //  $("#relprovi").val(e.responseJSON.data[0]["isprovi"]);
          //  $("#relissticker").val(e.responseJSON.data[0]["issticker"]);
          //  $("#relsticker").val(e.responseJSON.data[0]["stickerno"]);
          $("#reltrcode").val(e.responseJSON.info.trcode);
          $("#relfullname").val(e.responseJSON.info.opname);
          $("#reltbody").val(e.responseJSON.info.tbody);
          $("#reladdress").val(e.responseJSON.info.addr);
          $("#relmake").val(e.responseJSON.info.make);
          state['toda'] = e.responseJSON.info.toda;
          $("#relmtp").attr('disabled', false);
          
          if ($("#relmtp").hasClass("select2")) {
                $('#relmtp').select2('destroy');
            }
         $("#relmtp").remove();
          $("#relmtp-div").append("<input type='text' class='form-control' id='relmtp'>");
          if (exfran != "") {
              $("#relmtp").attr("disabled", true);
              $("#relmtp").val(exfran);
          } else {
              $("#relmtp").val(nmtp);
          }
        }
      },
    },
    columns: [
      { data: "Fees" },
      { data: "AmtDue" },
      { data: "or_number" },
      { data: "or_date" },
    ],
    filter: false,
    bInfo: false,
    sort: false,
    paging: false,
  });
  if (state.appl_status == "TDP") {
    $("#div-operator-release-bar").remove();
    $("#btn-operator-save-release").remove();
  } else {
    $("#div-driverpermit-release-bar").remove();
    $("#btn-driver-save-release").remove();
  }
}

function callDropReleasingTable(x) {
  $("#releasing-datatable").DataTable().destroy();
  releasingttable = $("#releasing-datatable").DataTable({
    ajax: {
      url: baseurl + "/config/includes.php?var=getdetdropassrelease",
      method: "POST",
      data: { trcode: x },
    },
    columns: [
      { data: "Fees" },
      { data: "AmtDue" },
      { data: "or_number" },
      { data: "or_date" },
    ],
    filter: false,
    bInfo: false,
    sort: false,
    paging: false,
  });
  if (state.appl_status == "TDP") {
    $("#div-operator-release-bar").remove();
    $("#btn-operator-save-release").remove();
  } else {
    $("#div-driverpermit-release-bar").remove();
    $("#btn-driver-save-release").remove();
  }
}

function callSignatoriesTable() {
  $("#settings-signatories-datatable").DataTable().destroy();
  signatoriestable = $("#settings-signatories-datatable").DataTable({
    ajax: {
      url: "../config/includes.php?var=getsignatories",
      method: "POST",
    },
    columns: [
      {
        data: function (e) {
          return "<button class='btn btn-info' id='btn-settings-signatories-view'><i class='fa fa-folder-open' data-toggle='tooltip' data-placement='top' title='View'></i></button>";
        },
      },
      { data: "nm" },
      { data: "position" },
    ],
  });
  $("#settings-signatories-datatable_wrapper").css("width", "100%");
}

function callMakeSettingsTable() {
  $("#settings-make-datatable").DataTable().destroy();
  makesettingstable = $("#settings-make-datatable").DataTable({
    ajax: {
      url: "../config/includes.php?var=getmake",
      method: "POST",
    },
    columns: [
      {
        data: function (e) {
          return "<button class='btn btn-info' id='btn-settings-make-view'><i class='fa fa-folder-open' data-toggle='tooltip' data-placement='top' title='View'></i></button>";
        },
      },
      { data: "decription" },
    ],
  });
  $("#settings-make-datatable_wrapper").css("width", "100%");
}

function callFeesTable(x) {
  $("#settings-fees-datatable").DataTable().destroy();
  feestable = $("#settings-fees-datatable").DataTable({
    ajax: {
      url: "../config/includes.php?var=getfees&category=" + x,
      method: "POST",
    },
    columns: [
      {
        data: function (e) {
          return "<button class='btn btn-info' id='btn-settings-fees-view'><i class='fa fa-folder-open' data-toggle='tooltip' data-placement='top' title='View'></i></button>";
        },
      },
      { data: "collnature" },
      { data: "Fees" },
      { data: "AmtDue" },
    ],
    bInfo: false,
    paging: false,
    filter: false,
  });

  $.ajax({
    url: "../config/includes.php?var=getfeesoption",
    method: "POST",
    dataType: "JSON",
    success: function (e) {
      $(".fees-option").remove();
      $.map(e.data, function (x) {
        $("#fees-option").append(
          "<option class='fees-option' value='" + x.collnature + "'>" + x.descript + "</option>"
        );
      });
    },
  });
  $("#settings-fees-datatable_wrapper").css("width", "100%");
}

function callReqTable(x) {
  settingsreq = $("#settingsreqtable").DataTable({
    destroy: true,
    ajax: {
      url: "../config/includes.php?var=getallrequirements&category=" + x,
      method: "POST",
    },
    columns: [
      {
        data: function (e) {
          return "<button type='button' class='btn btn-info' id='btn-settings-req-view'><i class='fa fa-folder-open' data-toggle='tooltip' data-placement='top' title='View'></i></button>";
        },
      },
      { data: "reqdesc" },
      { data: "trans" },
    ],
  });
}

function loadPSGC(type) {
  var psgcarr = [];
  if (type == 0) {
    psgcarr["reg"] = "region";
    psgcarr["brgy"] = "brgy";
    psgcarr["prov"] = "prov";
    psgcarr["mun"] = "mun";
  } else if (type == 1) {
    psgcarr["reg"] = "dregion";
    psgcarr["brgy"] = "dbrgy";
    psgcarr["prov"] = "dprov";
    psgcarr["mun"] = "dmun";
  }

  xreg = state["region"] === undefined ? regCode : state["region"];
  $.ajax({
    url: "/morong_bpladmin/reference/referencePSGCRegion",
    method: "get",
    dataType: "JSON",
    success: function (data) {
      $.map(data.result, function (item) {
        if (item.regCode == xreg) {
          $("#" + psgcarr.reg).append(
            '<option selected class="' +
              psgcarr.reg +
              '-opt" value="' +
              item.regCode +
              '">' +
              item.regDesc +
              "</option>"
          );
          state["region"] = item.regCode;
          state["regiondesc"] = item.regDesc;
        } else {
          $("#" + psgcarr.reg).append(
            '<option class="' +
              psgcarr.reg +
              '-opt" value="' +
              item.regCode +
              '">' +
              item.regDesc +
              "</option>"
          );
        }
      });
      $("#" + psgcarr.reg).trigger("change");
    },
  });

  $("#" + psgcarr.reg).change(function (e) {
    e.stopImmediatePropagation();
    xprov = state["prov"] === undefined ? provCode : state["prov"];
    $.ajax({
      url: "/morong_bpladmin/reference/referencePSGCProvince?regCode=" + $(this).val(),
      method: "GET",
      dataType: "JSON",
      success: function (data) {
        $("." + psgcarr.prov + "-opt").remove();
        $.map(data.result, function (item) {
          if (item.provCode == xprov) {
            $("#" + psgcarr.prov).append(
              '<option selected class="' +
                psgcarr.prov +
                '-opt" value="' +
                item.provCode +
                '">' +
                item.provDesc +
                "</option>"
            );
            state["prov"] = item.provCode;
            state["provdesc"] = item.provDesc;
          } else {
            $("#" + psgcarr.prov).append(
              '<option class="' +
                psgcarr.prov +
                '-opt" value="' +
                item.provCode +
                '">' +
                item.provDesc +
                "</option>"
            );
          }
        });
        $("#" + psgcarr.prov).trigger("change");
      },
    });
  });

  $("#" + psgcarr.prov).change(function (e) {
      e.stopImmediatePropagation();
    xmun = state["mun"] === undefined ? citymunCode : state["mun"];
    $.ajax({
      url: "/morong_bpladmin/reference/referencePSGCCity?provCode=" + $(this).val(),
      method: "GET",
      dataType: "JSON",
      success: function (data) {
        $("." + psgcarr.mun + "-opt").remove();
        $.map(data.result, function (item) {
          if (item.citymunCode == xmun) {
            $("#" + psgcarr.mun).append(
              '<option selected class="' +
                psgcarr.mun +
                '-opt" value="' +
                item.citymunCode +
                '">' +
                item.citymunDesc +
                "</option>"
            );
            state["mun"] = item.citymunCode;
            state["mundesc"] = item.citymunDesc;
          } else {
            $("#" + psgcarr.mun).append(
              '<option class="' +
                psgcarr.mun +
                '-opt" value="' +
                item.citymunCode +
                '">' +
                item.citymunDesc +
                "</option>"
            );
          }
        });
        $("#" + psgcarr.mun).trigger("change");
      },
    });
  });

  $("#" + psgcarr.mun).change(function (e) {
      e.stopImmediatePropagation();
    xbrgy = state["brgy"] === undefined ? brgyCode : state["brgy"];
    $.ajax({
      url:
        "/morong_bpladmin/reference/referencePSGCBarangay?citymunCode=" +
        $(this).val(),
      method: "GET",
      dataType: "JSON",
      success: function (data) {
        $("." + psgcarr.brgy + "-opt").remove();
        $.map(data.result, function (item) {
          if (item.brgyCode == xbrgy) {
            $("#" + psgcarr.brgy).append(
              '<option selected class="' +
                psgcarr.brgy +
                '-opt" value="' +
                item.brgyCode +
                '">' +
                item.brgyDesc +
                "</option>"
            );
            state["brgy"] = item.brgyCode;
            state["brgydesc"] = item.brgyDesc;
          } else {
            $("#" + psgcarr.brgy).append(
              '<option class="' +
                psgcarr.brgy +
                '-opt" value="' +
                item.brgyCode +
                '">' +
                item.brgyDesc +
                "</option>"
            );
          }
        });
      },
    });
  });
}

var dashboardtable = $("#dashboardtable").DataTable({
  ajax: {
    url: "../config/includes.php?var=getrecentapplication",
    method: "POST",
  },
  columns: [
    {
      data: function (e) {
        if (e.appl_status == "CHANGE OWNERSHIP") {
          return (
            "<a href='"+baseurl+"/admin/changeownership-table.php?trcode=" +
            e.trcode +
            "'>" +
            e.trcode +
            "</a>"
          );
        } else if (e.appl_status == "CHANGE MOTOR") {
          return (
            "<a href='"+baseurl+"/admin/changemotor-table.php?trcode=" +
            e.trcode +
            "'>" +
            e.trcode +
            "</a>"
          );
        } else if (e.appl_status == "DROPPING") {
          return (
            "<a href='"+baseurl+"/admin/dropping-table.php?trcode=" +
            e.trcode +
            "'>" +
            e.trcode +
            "</a>"
          );
        } else {
          return (
            "<a href='"+baseurl+"/admin/franchise-table.php?trcode=" +
            e.trcode +
            "'>" +
            e.trcode +
            "</a>"
          );
        }
      },
    },
    { data: "fullname" },
    {
      data: function (e) {
        return statusDisplay(e.Tags);
      },
    },
    { data: "appl_status" },
  ],
  initComplete: function () {
    this.api()
      .columns([2])
      .every(function (d) {
        //THis is used for specific column
        var column = this;
        var select =
          '<select class="form-control form-control-sm" style="display: inline-flex; width: fit-content; margin-left: 3px;" id="frantrstats">' +
          '<option value="">ALL</option>' +
          '<option value="FOR INSPECTION">FOR INSPECTION</option>' +
          '<option value="DENIED">DENIED</option>' +
          '<option value="FOR ASSESSMENT">FOR ASSESSMENT</option>' +
          '<option value="FOR PAYMENT">FOR PAYMENT</option>' +
          '<option value="FOR RELEASING">FOR RELEASING</option>' +
          '<option value="RELEASED">RELEASED</option>' + 
          "</select>";

        $(select)
          .appendTo("#dashboardtable_filter label")
          .on("change", function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            column.search(val ? "^" + val + "$" : "", true, false).draw();
          });

      });
  },
});

var dashexprdtable = $("#dashexprdtable").DataTable({
  ajax: {
    url: "../config/includes.php?var=getexpfran",
    method: "POST",
  },
  columns: [
    {
      data: function (e) {
        return "<button class='btn btn-warning btn-sm' id='btn-expfran-view'><i class='fa fa-eye'></i></button>";
      }, 
      orderable: false,
    },
    { data: "opercode" },
    { data: "franchiseno" },
    { data: "todacode" },
  ],
  order: [[2, "asc"]],
});

var waitinglisttable = $("#waitinglisttable").DataTable({
  ajax: {
    url: "../config/includes.php?var=getwaitinglist",
    method: "POST",
  }, 
  columns: [
    { data: null, defaultContent: "<button class='btn btn-success btn-sm' id='wait-confirm' data-toggle='tooltip' data-placement='top' title='Confirm'><i class='fa fa-check'></i></button> <button class='btn btn-danger btn-sm' id='wait-cancel' data-toggle='tooltip' data-placement='top' title='Cancel'><i class='fa fa-times'></i></button>" },
    { data: "fullname", },
    { data: "contactno" },
    { data: "toda" },
    { data: "status" }, 
    { data: "datereg" },
  ],
  order: [[5, "asc"]],
  drawCallback: function (settings) {
      $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });
  }
});

const m = new Date();

var franchisetable = $("#franchisetable").DataTable({
  processing: true,
  serverSide: true,
  ajax: {
    url:
      "../config/includes.php?var=getfranchise&yr=" +
      (getUrlParameter("trcode") != undefined
        ? getUrlParameter("trcode").split("-")[0]
        : m.getFullYear()),
    method: "GET",
  },
  oSearch: { sSearch: getUrlParameter("trcode") },
  columns: [

    {
      data: "buttons",
      orderable: false,
    },
    { data: "trcode" },
    {
      data: function (e) {
        return statusDisplay(e.Tags);
      },
      orderable: false,
    },
    { data: "appl_status" },
    { data: "franchise_no" },
    { data: "motorid" },
    { data: "opcode" },
    { data: "fullname" },
    { data: "addr" },
    { data: "make" },
    { data: "dttm" },
  ],
  order: [[10, "desc"]],
  initComplete: function () {
    this.api()
      .columns([2])
      .every(function (d) {
        //THis is used for specific column
        var column = this;
        var select =
          '<select class="form-control form-control-sm" style="display: inline-flex; width: fit-content; margin-left: 3px;" id="frantrstats">' +
          '<option value="">ALL</option>' +
          '<option value="FOR INSPECTION">FOR INSPECTION</option>' +
          '<option value="FOR ASSESSMENT">FOR ASSESSMENT</option>' +
          '<option value="FOR PAYMENT">FOR PAYMENT</option>' +
          '<option value="FOR RELEASING">FOR RELEASING</option>' +
          '<option value="RELEASED">RELEASED</option>' +
          "</select>";
        var select2 =
          '<select class="form-control form-control-sm" style="display: inline-flex; width: fit-content; margin-left: 3px;" id="franyr">';
        for (let i = m.getFullYear(); i >= 2015; i--) {
          if (getUrlParameter("trcode") != undefined) {
            var z = getUrlParameter("trcode").split("-");
            if (z[0] == i) {
              select2 +=
                '<option value="' + i + '" selected>' + i + "</option>";
            } else {
              select2 += '<option value="' + i + '">' + i + "</option>";
            }
          } else {
            select2 += '<option value="' + i + '">' + i + "</option>";
          }
        }

        select2 += "</select>";

        $(select)
          .appendTo("#franchisetable_filter label")
          .on("change", function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            column.search(val ? "^" + val + "$" : "", true, false).draw();
          });

        $(select2)
          .appendTo("#franchisetable_filter label")
          .on("change", function () {
            var newurl =
              "../config/includes.php?var=getfranchise&yr=" + $(this).val();
            franchisetable.ajax.url(newurl).load();
          });
      });
  },
  drawCallback: function (settings) {
      $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });
  }
});

var changemotortable = $("#changemotortable").DataTable({
  processing: true,
  serverSide: true,
  ajax: {
    url:
      "../config/includes.php?var=getchangemotor&yr=" +
      (getUrlParameter("trcode") !== undefined
        ? getUrlParameter("trcode").split("-")[0]
        : m.getFullYear()),
    method: "GET",
  },
  oSearch: { sSearch: getUrlParameter("trcode") },
  columns: [
    {
      data: "buttons",
      orderable: false,
    },
    { data: "trcode" },
    {
      data: function (e) {
        return statusDisplay(e.Tags);
      },
      orderable: false,
    },
    { data: "appl_status" },
    { data: "fullname" },
    { data: "motorid" },
    { data: "newmotorid" },
    { data: "addr" },
    { data: "dttm" },
  ],
  order: [[8, "desc"]],
  initComplete: function () {
    this.api()
      .columns([2])
      .every(function (d) {
        //THis is used for specific column
        var column = this;
        var select =
          '<select class="form-control form-control-sm" style="display: inline-flex; width: fit-content; margin-left: 3px;" id="frantrstats">' +
          '<option value="">ALL</option>' +
          '<option value="FOR INSPECTION">FOR INSPECTION</option>' +
          '<option value="FOR ASSESSMENT">FOR ASSESSMENT</option>' +
          '<option value="FOR PAYMENT">FOR PAYMENT</option>' +
          '<option value="FOR RELEASING">FOR RELEASING</option>' +
          '<option value="RELEASED">RELEASED</option>' +
          "</select>";
        var select2 =
          '<select class="form-control form-control-sm" style="display: inline-flex; width: fit-content; margin-left: 3px;" id="franyr">';
        for (let i = m.getFullYear(); i >= 2015; i--) {
          if (getUrlParameter("trcode") != undefined) {
            var z = getUrlParameter("trcode").split("-");
            if (z[0] == i) {
              select2 +=
                '<option value="' + i + '" selected>' + i + "</option>";
            } else {
              select2 += '<option value="' + i + '">' + i + "</option>";
            }
          } else {
            select2 += '<option value="' + i + '">' + i + "</option>";
          }
        }

        select2 += "</select>";

        $(select)
          .appendTo("#changemotortable_filter label")
          .on("change", function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            column.search(val ? "^" + val + "$" : "", true, false).draw();
          });

        $(select2)
          .appendTo("#changemotortable_filter label")
          .on("change", function () {
            var newurl =
              "../config/includes.php?var=getchangemotor&yr=" + $(this).val();
            changemotortable.ajax.url(newurl).load();
          });
      });
  },
  drawCallback: function (settings) {
      $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });
  }
});

var changeownershiptable = $("#changeownershiptable").DataTable({
  processing: true,
  serverSide: true,
  ajax: {
    url:
      "../config/includes.php?var=getchangeownership&yr=" +
      (getUrlParameter("trcode") !== undefined
        ? getUrlParameter("trcode").split("-")[0]
        : m.getFullYear()),
    method: "GET",
  },
  oSearch: { sSearch: getUrlParameter("trcode") },
  columns: [
    {
      data: "buttons",
      orderable: false,
    },
    { data: "trcode" },
    {
      data: function (e) {
        return statusDisplay(e.Tags);
      },
      orderable: false,
    },
    { data: "appl_status" },
    { data: "fullname" },
    { data: "motorid" },
    { data: "newopcode" },
    { data: "addr" },
    { data: "dttm" },
  ],
  order: [[8, "desc"]],
  initComplete: function () {
    this.api()
      .columns([2])
      .every(function (d) {
        //THis is used for specific column
        var column = this;
        var select =
          '<select class="form-control form-control-sm" style="display: inline-flex; width: fit-content; margin-left: 3px;" id="frantrstats">' +
          '<option value="">ALL</option>' +
          '<option value="FOR INSPECTION">FOR INSPECTION</option>' +
          '<option value="FOR ASSESSMENT">FOR ASSESSMENT</option>' +
          '<option value="FOR PAYMENT">FOR PAYMENT</option>' +
          '<option value="FOR RELEASING">FOR RELEASING</option>' +
          '<option value="RELEASED">RELEASED</option>' +
          "</select>";
        var select2 =
          '<select class="form-control form-control-sm" style="display: inline-flex; width: fit-content; margin-left: 3px;" id="franyr">';
        for (let i = m.getFullYear(); i >= 2015; i--) {
          if (getUrlParameter("trcode") != undefined) {
            var z = getUrlParameter("trcode").split("-");
            if (z[0] == i) {
              select2 +=
                '<option value="' + i + '" selected>' + i + "</option>";
            } else {
              select2 += '<option value="' + i + '">' + i + "</option>";
            }
          } else {
            select2 += '<option value="' + i + '">' + i + "</option>";
          }
        }

        select2 += "</select>";

        $(select)
          .appendTo("#changeownershiptable_filter label")
          .on("change", function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            column.search(val ? "^" + val + "$" : "", true, false).draw();
          });

        $(select2)
          .appendTo("#changeownershiptable_filter label")
          .on("change", function () {
            var newurl =
              "../config/includes.php?var=getchangeownership&yr=" +
              $(this).val();
            changeownershiptable.ajax.url(newurl).load();
          });
      });
  },
  drawCallback: function (settings) {
      $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });
  }
});

//carlo

var changedrivertable = $("#changedrivertable").DataTable({
  processing: true,
  serverSide: true,
  ajax: {
    url:
      "../config/includes.php?var=getchangedriver&yr=" +
      (getUrlParameter("trcode") !== undefined
        ? getUrlParameter("trcode").split("-")[0]
        : m.getFullYear()),
    method: "GET",
  },
  oSearch: { sSearch: getUrlParameter("trcode") },
  columns: [
    {
      data: "buttons",
      orderable: false,
    },
    { data: "trcode" },
    {
      data: function (e) {
        return statusDisplay(e.Tags);
      },
      orderable: false,
    },
    { data: "appl_status" },
    { data: "fullname" },
    { data: "motorid" },
    { data: "newopcode" },
    { data: "addr" },
    { data: "dttm" },
  ],
  order: [[8, "desc"]],
  initComplete: function () {
    this.api()
      .columns([2])
      .every(function (d) {
        //THis is used for specific column
        var column = this;
        var select =
          '<select class="form-control form-control-sm" style="display: inline-flex; width: fit-content; margin-left: 3px;" id="frantrstats">' +
          '<option value="">ALL</option>' +
          '<option value="FOR INSPECTION">FOR INSPECTION</option>' +
          '<option value="FOR ASSESSMENT">FOR ASSESSMENT</option>' +
          '<option value="FOR PAYMENT">FOR PAYMENT</option>' +
          '<option value="FOR RELEASING">FOR RELEASING</option>' +
          '<option value="RELEASED">RELEASED</option>' +
          "</select>";
        var select2 =
          '<select class="form-control form-control-sm" style="display: inline-flex; width: fit-content; margin-left: 3px;" id="franyr">';
        for (let i = m.getFullYear(); i >= 2015; i--) {
          if (getUrlParameter("trcode") != undefined) {
            var z = getUrlParameter("trcode").split("-");
            if (z[0] == i) {
              select2 +=
                '<option value="' + i + '" selected>' + i + "</option>";
            } else {
              select2 += '<option value="' + i + '">' + i + "</option>";
            }
          } else {
            select2 += '<option value="' + i + '">' + i + "</option>";
          }
        }

        select2 += "</select>";

        $(select)
          .appendTo("#changedrivertable_filter label")
          .on("change", function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            column.search(val ? "^" + val + "$" : "", true, false).draw();
          });

        $(select2)
          .appendTo("#changedrivertable_filter label")
          .on("change", function () {
            var newurl =
              "../config/includes.php?var=getchangedriver&yr=" +
              $(this).val();
            changedrivertable.ajax.url(newurl).load();
          });
      });
  },
  drawCallback: function (settings) {
      $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });
  }
});

//carlo

var driverspermittable = $("#driverspermittable").DataTable({
  processing: true,
  serverSide: true,
  ajax: {
    url:
      "../config/includes.php?var=getdriverspermit&yr=" +
      (getUrlParameter("trcode") != undefined
        ? getUrlParameter("trcode").split("-")[0]
        : m.getFullYear()),
    method: "GET",
  },
  oSearch: { sSearch: getUrlParameter("trcode") },
  columns: [
    {
      data: function (e) {
        return "<button class='btn btn-info' id='btn-view'><i class='fa fa-folder-open'></i></button> <button class='btn btn-danger' id='btn-cancel'><i class='fa fa-times'></i></button>";
      },
      orderable: false,
    },
    { data: "trcode" },
    {
      data: function (e) {
        return statusDisplay(e.Tags);
      },
    },
    { data: "appl_status" },
    { data: "franchise_no" },
    { data: "fullname" },
    { data: "addr" },
    { data: "dttm" },
  ],
  order: [[7, "desc"]],
  initComplete: function () {
    this.api()
      .columns([2])
      .every(function (d) {
        //THis is used for specific column
        var column = this;
        var select =
          '<select class="form-control form-control-sm" style="display: inline-flex; width: fit-content; margin-left: 3px;" id="frantrstats">' +
          '<option value="">ALL</option>' +
          '<option value="FOR ASSESSMENT">FOR ASSESSMENT</option>' +
          '<option value="FOR PAYMENT">FOR PAYMENT</option>' +
          '<option value="FOR RELEASING">FOR RELEASING</option>' +
          '<option value="RELEASED">RELEASED</option>' +
          "</select>";
        var select2 =
          '<select class="form-control form-control-sm" style="display: inline-flex; width: fit-content; margin-left: 3px;" id="franyr">';
        for (let i = m.getFullYear(); i >= 2015; i--) {
          if (getUrlParameter("trcode") != undefined) {
            var z = getUrlParameter("trcode").split("-");
            if (z[0] == i) {
              select2 +=
                '<option value="' + i + '" selected>' + i + "</option>";
            } else {
              select2 += '<option value="' + i + '">' + i + "</option>";
            }
          } else {
            select2 += '<option value="' + i + '">' + i + "</option>";
          }
        }

        select2 += "</select>";

        $(select)
          .appendTo("#driverspermittable_filter label")
          .on("change", function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            column.search(val ? "^" + val + "$" : "", true, false).draw();
          });

        $(select2)
          .appendTo("#driverspermittable_filter label")
          .on("change", function () {
            var newurl =
              "../config/includes.php?var=getdriverspermit&yr=" + $(this).val();
            driverspermittable.ajax.url(newurl).load();
          });
      });
  },
});

var droppingtable = $("#droppingtable").DataTable({
  processing: true,
  serverSide: true,
  ajax: {
    url:
      "../config/includes.php?var=getdrop&yr=" +
      (getUrlParameter("trcode") != undefined
        ? getUrlParameter("trcode").split("-")[0]
        : m.getFullYear()),
    method: "GET",
  },
  oSearch: { sSearch: getUrlParameter("trcode") },
  columns: [
    {
      data: "buttons",
      orderable: false,
    },
    { data: "trcode" },
    {
      data: function (e) {
        return statusDisplay(e.Tags);
      },
      orderable: false,
    },
    { data: "fullname" },
    { data: "todabody" },
    { data: "engine" },
    { data: "reason" },
    { data: "dttm" },
  ],
  order: [[7, "desc"]],
  initComplete: function () {
    this.api()
      .columns([2])
      .every(function (d) {
        //THis is used for specific column
        var column = this;
        var select =
          '<select class="form-control form-control-sm" style="display: inline-flex; width: fit-content; margin-left: 3px;" id="frantrstats">' +
          '<option value="">ALL</option>' +
          '<option value="FOR INSPECTION">FOR INSPECTION</option>' +
          '<option value="FOR ASSESSMENT">FOR ASSESSMENT</option>' +
          '<option value="FOR PAYMENT">FOR PAYMENT</option>' +
          '<option value="FOR RELEASING">FOR RELEASING</option>' +
          '<option value="RELEASED">RELEASED</option>' +
          "</select>";
        var select2 =
          '<select class="form-control form-control-sm" style="display: inline-flex; width: fit-content; margin-left: 3px;" id="franyr">';
        for (let i = m.getFullYear(); i >= 2015; i--) {
          if (getUrlParameter("trcode") != undefined) {
            var z = getUrlParameter("trcode").split("-");
            if (z[0] == i) {
              select2 +=
                '<option value="' + i + '" selected>' + i + "</option>";
            } else {
              select2 += '<option value="' + i + '">' + i + "</option>";
            }
          } else {
            select2 += '<option value="' + i + '">' + i + "</option>";
          }
        }

        select2 += "</select>";

        $(select)
          .appendTo("#droppingtable_filter label")
          .on("change", function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            column.search(val ? "^" + val + "$" : "", true, false).draw();
          });

        $(select2)
          .appendTo("#droppingtable_filter label")
          .on("change", function () {
            var newurl =
              "../config/includes.php?var=getdrop&yr=" + $(this).val();
            droppingtable.ajax.url(newurl).load();
          });
      });
  },
  drawCallback: function (settings) {
      $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });
  }
});

var settingsoperator = $("#settingsoperatortable").DataTable({
  ajax: {
    url: "../config/includes.php?var=getoperators",
    method: "POST",
  },
  columns: [
    {
      data: function (e) {
        return "<button class='btn btn-info' id='btn-settings-operator-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button> <button class='btn btn-warning' id='btn-settings-operator-history' data-toggle='tooltip' data-placement='top' title='History'><i class='fa fa-history'></i></button> <button class='btn btn-danger' id='btn-settings-operator-delete' data-toggle='tooltip' data-placement='top' title='Delete'><i class='fa fa-trash'></i></button>";
      },
    },
    { data: "humanpin" },
    { data: "fullname" },
    { data: "addr" },
    { data: "mobile_no" },
    { data: "sex" },
  ],
  drawCallback: function (settings) {
      $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });
  }
});
//carlo
var settingsstatus = $("#settingsstatustable").DataTable({
  ajax: {
    url: "../config/includes.php?var=getstatus",
    method: "POST",
  },
  columns: [
    {
      data: function (e) {
        return "<button class='btn btn-info' id='btn-settings-status-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button> <button class='btn btn-warning' id='btn-settings-operator-history' data-toggle='tooltip' data-placement='top' title='History'><i class='fa fa-history'></i></button> <button class='btn btn-danger' id='btn-settings-operator-delete' data-toggle='tooltip' data-placement='top' title='Delete'><i class='fa fa-trash'></i></button>";
      },
    },
    { data: "trcode" },
    { data: "Tags" },
    { data: "appl_status" },
    { data: "franchise_no" },
    { data: "motorcode" },
    { data: "humanpin" },
    { data: "fullname" },
    { data: "addr" },
    { data: "make" },
    { data: "dttm" },
    

  ],
  drawCallback: function (settings) {
      $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });
  }
});
//carlo
var settingsdriver = $("#settingsdrivertable").DataTable({
  ajax: {
    url: "../config/includes.php?var=getdrivers",
    method: "POST",
  },
  columns: [
    {
      data: function (e) {
        return "<button class='btn btn-info' id='btn-settings-driver-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button>";
      },
    },
    { data: "fullname" },
    { data: "addr" },
    { data: "cont_no" },
    { data: "drivlis" },
  ],
});

var settingsmotor = $("#settingsmotortable").DataTable({
  ajax: {
    url: "../config/includes.php?var=getmotor",
    method: "POST",
  },
  columns: [
    {
      data: function (e) {
        return "<button class='btn btn-info' id='btn-settings-motor-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button> <button class='btn btn-danger' id='btn-settings-motor-delete' data-toggle='tooltip' data-placement='top' title='Delete'><i class='fa fa-trash'></i></button>";
      },
    },
    { data: "motorpin" },
    { data: "opercode" },
    { data: "opname" },
    { data: "drname" },
    { data: "todabody" },
    { data: "engine" },
    { data: "chassis" },
    { data: "last_renew" },
  ],
  drawCallback: function (settings) {
      $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });
  }
});

var settingstoda = $("#settingstodatable").DataTable({
  ajax: {
    url: "../config/includes.php?var=getalltodadetails",
    method: "POST",
  },
  columns: [
    {
      data: function (e) {
        return "<button class='btn btn-info' id='btn-settings-toda-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button>";
      },
    },
    { data: "todacode" },
    { data: "todaRoute" },
    { data: "todaRemarks" },
    { data: "franchiseAllowed" },
    { data: function (e) {
        return e.franchiseAllowed - e.ctoda;
    } },
    {
      data: function (e) {
        return e.rangelow + "-" + e.rangehigh;
      },
    },
    { data: "ctoda" },
    { data: "todaPres" },
    { data: "contactno" },
  ],
  drawCallback: function (settings) {
      $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });
  }
});

var settingstodaperfran = $("#settingstodaperfrantable").DataTable({
  ajax: {
    url: "../config/includes.php?var=gettodaperfran",
    method: "POST",
  },
  columns: [
    { data: "todacode" },
    { data: function (e) {
        return LPAD(e.franchiseno, 4);
    } },
    { data: function (e) {
      return "<a href='#' id='view-fpt-operator'>"+e.opercode+"</a>"
    } },
    { data: function (e) {
      return "<a href='#' id='view-fpt-motor'>"+e.motorid+"</a>"
    } },
    { data: "trcode" },
    { data: "status" },
    { data: "dtissue" },
    { data: "dtexprd" },
  ],
});

var settingslto = $("#settingsltotable").DataTable({
  ajax: {
    url: "../config/includes.php?var=getlto",
    method: "POST",
  },
  columns: [
    {
      data: function (e) {
        return "<button class='btn btn-info' id='btn-settings-lto-view' data-toggle='tooltip' data-placement='top' title='View'><i class='fa fa-folder-open'></i></button>";
      },
    },
    { data: "nm" }
  ],
  drawCallback: function (settings) {
      $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });
  }
});

//============================================================================================================================
// Assessment Functions
//============================================================================================================================

var assyes = "";

$("#assessment-datatable tbody").on("click", "#selectpay", function () {
  var tr = $(this).closest("tr");
  var idx = assessmenttable.row(tr).index();
  var data = assessmenttable.row(tr).data();
  if ($(this).is(":checked")) {
    $("#assessment-datatable tbody tr:eq(" + idx + ")").addClass("selected");
    if (state.appl_status != "TDP") {
      totamt += parseFloat(data.AmtDue);
    } else {
      totamt = parseFloat(data.AmtDue);
    }
  } else {
    $("#assessment-datatable tbody tr:eq(" + idx + ")").removeClass("selected");
    totamt -= parseFloat(data.AmtDue);
  }
  $("#total-assess").html(totamt);
});

$("#btn-assessment-save").click(function () {
  var data = assessmenttable.rows(".selected").data();
  var spay = [];
  $.map(data, function (item) {
    spay.push(item);
  });

  if (spay.length == 0) {
    alert("No fees checked has been detected. Please select fees.");
    return;
  }
  
  $.ajax({
    url: baseurl + "/config/includes.php?var=saveassessment",
    method: "POST",
    data: { spay: spay, trcode: state.trcode },
    dataType: "json",
    success: function (data) {
      if (data["result"]) {
        Swal.fire({
          icon: "success",
          text: data.msg,
          title: "Done!",
          showDenyButton: false,
          confirmButtonText: "Ok",
        }).then((result) => {
          if (result.isConfirmed) {
            assyes.ajax.reload();
          }
        });
      } else if (!data["result"]) {
        Swal.fire("Ops!", data.msg, "error");
      } else {
        Swal.fire("Ops!", data.msg, "error");
      }
    },
  });
});

$("#btn-assessment-saveprint").click(function () {
  var data = assessmenttable.rows(".selected").data();
  var spay = [];
  $.map(data, function (item) {
    spay.push(item);
  });

  if (spay.length == 0) {
    alert("No fees checked has been detected. Please select fees.");
    return;
  }
  $.ajax({
    url: baseurl + "/config/includes.php?var=saveassessment",
    method: "POST",
    data: { spay: spay, trcode: state.trcode },
    dataType: "json",
    success: function (data) {
      if (data["result"]) {
        Swal.fire({
          icon: "success",
          text: data.msg,
          title: "Done!",
          showDenyButton: false,
          confirmButtonText: "Ok",
        }).then((result) => {
          if (result.isConfirmed) {
            assyes.ajax.reload();
          }
        });
        $("#btn-assessment-print").trigger("click");
      } else if (!data["result"]) {
        Swal.fire("Ops!", data.msg, "error");
      } else {
        Swal.fire("Ops!", data.msg, "error");
      }
    },
  });
});


$("#btn-assessment-print").click(function () {
  $.ajax({
    url: baseurl + "/config/includes.php?var=getassforprint",
    method: "POST",
    data: { type: state.appl_status, trcode: state.trcode },
    dataType: "JSON",
    success: function (e) {
      if (e.result) {
        printAssessment(e.data);
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});

$("#tdpyr").change(function () {
  assessmenttable
    .cell(":eq(2)", null, { page: "current" })
    .data(parseInt(state.tdpcost) * parseInt($(this).val()))
    .draw();
  var idx = assessmenttable.row(0).index();
  var data = assessmenttable.row(0).data();
  totamt = parseInt(state.tdpcost) * parseInt($(this).val());
  if ($("#assessment-datatable tbody tr:eq(0) input").is(":checked")) {
    $("#total-assess").html(totamt);
  }
});

//==============================================================================================================================
// Signatories
//==============================================================================================================================

$("#vert-tabs-profile-tab").click(function () {
  callSignatoriesTable();
//   $("#signatories-modal").modal("show");
});

$("#btn-signatories-edit").click(function () {
  var d = signatoriestable.row(".selected").data();
  $.ajax({
    url: "../config/includes.php?var=updatesignatories",
    method: "POST",
    data: $("#signatories-form-submit").serialize() + "&signa-id=" + d.ID,
    dataType: "JSON",
    success: function (e) {
      if (e.result) {
        Swal.fire("Done!", e.msg, "success");
        signatoriestable.ajax.reload();
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});

$("#btn-signatories-save").click(function () {
  $.ajax({
    url: "../config/includes.php?var=savesignatories",
    method: "POST",
    data: $("#signatories-form-submit").serialize(),
    dataType: "JSON",
    success: function (e) {
      if (e.result) {
        Swal.fire("Done!", e.msg, "success");
        signatoriestable.ajax.reload();
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});

$("#settings-signatories-datatable tbody").on(
  "click",
  "#btn-settings-signatories-view",
  function () {
    var d = signatoriestable.row($(this).closest("tr")).data();
    $("#settings-signatories-datatable tbody tr").removeClass("selected");
    $(this).closest("tr").addClass("selected");
    $.ajax({
      url: "../config/includes.php?var=getdetsignatories",
      method: "POST",
      data: { id: d.ID },
      dataType: "JSON",
      success: function (e) {
        $("#signa-fullname").val(e.data.nm);
        $("#signa-position").val(e.data.position);
        $("#div-settings-signatories-table, #btn-signatories-save").hide();
        $("#div-settings-signatories-form, #btn-signatories-edit").show();
      },
    });
  }
);

$("#btn-signatories-back").click(function () {
  $("#div-settings-signatories-form").hide();
  $("#div-settings-signatories-table").show();
});

$("#btn-settings-signatories-add").click(function (e) {
  e.preventDefault();
  $("#div-settings-signatories-table, #btn-signatories-edit").hide();
  $("#div-settings-signatories-form, #btn-signatories-save").show();
});



//==============================================================================================================================
// Make Settings
//==============================================================================================================================

$("#vert-tabs-settings-tab").click(function () {
  callMakeSettingsTable();
//   $("#signatories-modal").modal("show");
});

$("#btn-make-edit").click(function () {
  var d = makesettingstable.row(".selected").data();
  $.ajax({
    url: "../config/includes.php?var=updatemake",
    method: "POST",
    data: $("#make-form-submit").serialize() + "&make-id=" + d.makeid,
    dataType: "JSON",
    success: function (e) {
      if (e.result) {
        Swal.fire("Done!", e.msg, "success");
        makesettingstable.ajax.reload();
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});

$("#btn-make-save").click(function () {
  $.ajax({
    url: "../config/includes.php?var=savemake",
    method: "POST",
    data: $("#make-form-submit").serialize(),
    dataType: "JSON",
    success: function (e) {
      if (e.result) {
        Swal.fire("Done!", e.msg, "success");
        makesettingstable.ajax.reload();
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});

$("#settings-make-datatable tbody").on(
  "click",
  "#btn-settings-make-view",
  function () {
    var d = makesettingstable.row($(this).closest("tr")).data();
    $("#settings-make-datatable tbody tr").removeClass("selected");
    $(this).closest("tr").addClass("selected");
    
    $("#make-description").val(d.decription);
    $("#div-settings-make-table, #btn-make-save").hide();
    $("#div-settings-make-form, #btn-make-edit").show();
  }
);

$("#btn-make-back").click(function () {
  $("#div-settings-make-form").hide();
  $("#div-settings-make-table").show();
});

$("#btn-settings-make-add").click(function (e) {
  e.preventDefault();
  $("#div-settings-make-table, #btn-make-edit").hide();
  $("#div-settings-make-form, #btn-make-save").show();
});

//==============================================================================================================================
// LTO Settings
//==============================================================================================================================

$("#btn-lto-edit").click(function () {
  var d = settingslto.row(".selected").data();
  $.ajax({
    url: "../config/includes.php?var=updatelto",
    method: "POST",
    data: $("#lto-form-submit").serialize() + "&lto-id=" + d.ID,
    dataType: "JSON",
    success: function (e) {
      if (e.result) {
        Swal.fire("Done!", e.msg, "success");
        settingslto.ajax.reload();
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});

$("#btn-lto-save").click(function () {
  $.ajax({
    url: "../config/includes.php?var=savelto",
    method: "POST",
    data: $("#lto-form-submit").serialize(),
    dataType: "JSON",
    success: function (e) {
      if (e.result) {
        Swal.fire("Done!", e.msg, "success");
        settingslto.ajax.reload();
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});

$("#settingsltotable tbody").on(
  "click",
  "#btn-settings-lto-view",
  function () {
    var d = settingslto.row($(this).closest("tr")).data();
    $("#settingsltotable tbody tr").removeClass("selected");
    $(this).closest("tr").addClass("selected");
    
    $("#lto-loc").val(d.nm);
    $("#div-settings-lto-table, #btn-lto-save").hide();
    $("#div-settings-lto-form, #btn-lto-edit").show();
  }
);

$("#btn-lto-back").click(function () {
  $("#div-settings-lto-form").hide();
  $("#div-settings-lto-table").show();
});

$("#btn-settings-lto-create").click(function (e) {
  e.preventDefault();
  $("#div-settings-lto-table, #btn-lto-edit").hide();
  $("#div-settings-lto-form, #btn-lto-save").show();
});


//==============================================================================================================================
// Fees Settings
//==============================================================================================================================

$("#vert-tabs-messages-tab").click(function () {
  callFeesTable($("#fees-category").val());
});

$("#fees-category").change(function () {
  callFeesTable($("#fees-category").val());
});

$("#btn-fees-edit").click(function () {
  var d = feestable.row(".selected").data();
  $.ajax({
    url: "../config/includes.php?var=updatefees",
    method: "POST",
    data: $("#fees-form-submit").serialize() + "&fees-id=" + d.ID,
    dataType: "JSON",
    success: function (e) {
      if (e.result) {
        Swal.fire("Done!", e.msg, "success");
        feestable.ajax.reload();
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});

$("#btn-fees-save").click(function () {
  $.ajax({
    url: "../config/includes.php?var=savefees",
    method: "POST",
    data:
      $("#fees-form-submit").serialize() +
      "&fees-category=" +
      $("#fees-category").val(),
    dataType: "JSON",
    success: function (e) {
      if (e.result) {
        Swal.fire("Done!", e.msg, "success");
        feestable.ajax.reload();
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});

$("#settings-fees-datatable tbody").on(
  "click",
  "#btn-settings-fees-view",
  function () {
    var d = feestable.row($(this).closest("tr")).data();
    $("#settings-fees-datatable tbody tr").removeClass("selected");
    $(this).closest("tr").addClass("selected");
    $("#fees-category").attr("disabled", true);
    $("#fees-option").val(d.collnature);
    $("#fees-amount").val(d.AmtDue);
    $("#div-settings-fees-table, #btn-fees-save, #btn-fees-add").hide();
    $("#div-settings-fees-form, #btn-fees-edit").show();
  }
);

$("#btn-fees-back").click(function (e) {
  e.preventDefault();
  $("#fees-category").attr("disabled", false);
  $("#div-settings-fees-form").hide();
  $("#div-settings-fees-table, #btn-fees-add").show();
});

$("#btn-fees-add").click(function (e) {
  e.preventDefault();
  $("#fees-category").attr("disabled", true);
  $("#fees-amount").val("");
  $("#div-settings-fees-table, #btn-fees-edit").hide();
  $("#div-settings-fees-form, #btn-fees-save").show();
});

//==============================================================================================================================
// Franchise Expiry
//==============================================================================================================================

$("#open-fran-exp").on("click", function (e) {
  $.ajax({
    url: "../config/includes.php?var=getfranexpdate",
    method: "POST",
    dataType: "JSON",
    success: function (e) {
      if (e.result) {
        $("#fran-exp").val(e.data.noofyr);
        $("#fran-exp-modal").modal("show");
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});

//==============================================================================================================================
// Requirements Application
//==============================================================================================================================

$("#req-application-datatable tbody").on(
  "click",
  "#btn-open-pics",
  function (e) {
    e.preventDefault();
    var d = reqapptable.row($(this).closest("tr")).data();
    if (d.target_path === null) {
      d.target_path = "images/imgnotavail.png";
    }
    new PhotoViewer([
      {
        src: d.target_path,
        title: d.reqdesc,
      },
    ]);
  }
);

//==============================================================================================================================
// Pay Encode
//==============================================================================================================================

var payencodedatatable = "";
$("#payencode-search").click(function () {
    payencodedatatable = $("#payencode-datatable").DataTable({
      destroy: true,
      ajax: {
        url: "../config/includes.php?var=searchpayencode",
        method: "POST",
        data: {orno: $("#payencode-or").val()},
        complete: function (e) {
            state['orinfo'] = e.responseJSON.info;
            state['payment'] = e.responseJSON.data;
            
            if (e.responseJSON.info.payor !== undefined) {
                $("#payencode-payor").html("Payor:<u>" + e.responseJSON.info.payor + "</u>");
            }
        }
      },
      columns: [
        { data: "descript" },
        { data: "amount" },
        { data: "orno" },
        { data: "datecreate" },
      ],
      sort: false,
      filter: false,
      search: false,
      info: false,
      paging: false,
    });
});

$("#franchisetable tbody").on('click', '#btn-payencode',function () {
    var d = franchisetable.row($(this).closest('tr')).data();
    $("#payencode-or").val("");
    $("#payencode-search").click();
    $("#payencode-payor").html("Payor:");
    state = d;
    $("#payencode-modal").modal('show');
});

$("#changemotortable tbody").on('click', '#btn-payencode',function () {
    var d = changemotortable.row($(this).closest('tr')).data();
    $("#payencode-or").val("");
    $("#payencode-search").click();
    $("#payencode-payor").html("Payor:");
    state = d;
    $("#payencode-modal").modal('show');
});


$("#changeownershiptable tbody").on('click', '#btn-payencode',function () {
    var d = changeownershiptable.row($(this).closest('tr')).data();
    $("#payencode-or").val("");
    $("#payencode-search").click();
    $("#payencode-payor").html("Payor:");
    state = d;
    $("#payencode-modal").modal('show');
});
//carlo

$("#changedrivertable tbody").on('click', '#btn-payencode',function () {
    var d = changedrivertable.row($(this).closest('tr')).data();
    $("#payencode-or").val("");
    $("#payencode-search").click();
    $("#payencode-payor").html("Payor:");
    state = d;
    $("#payencode-modal").modal('show');
});

//carlo

$("#droppingtable tbody").on('click', '#btn-payencode',function () {
    var d = droppingtable.row($(this).closest('tr')).data();
    $("#payencode-or").val("");
    $("#payencode-search").click();
    $("#payencode-payor").html("Payor:");
    state = d;
    $("#payencode-modal").modal('show');
});


$("#btn-save-payencode").click(function () {
    $.ajax({
        url: "../config/includes.php?var=savepayencode",
        method: "POST",
        data: {
            trcode: state.trcode,
            or_no: state.orinfo.orno,
            or_date: state.orinfo.ordate,
            nname: state.orinfo.payor,
            appl_status: state.appl_status,
            payment: state.payment
        },
        dataType: "JSON",
        success: function (e) {
            if (e.result) {
                Swal.fire("Saved!", e.msg, "success");
                franchisetable.ajax.reload();
                $("#payencode-modal").modal('hide');
            } else {
                Swal.fire("Ops!", e.msg, "error");
            }
        }
    });
});

//==============================================================================================================================
// Stupid global events
//==============================================================================================================================
$("#orcr-name-switch").change(function () {
  if ($(this).is(":checked")) {
    $("#morcrname").attr("readonly", false);
  } else {
    $("#morcrname").attr("readonly", true);
  }
});

$("#ctc").change(function () {
    if ($(this).val() != "") {
        $.ajax({
            url: "../config/includes.php?var=verifyctc",
            method: "POST",
            data: {ctc: $(this).val()},
            dataType: "JSON", 
            success: function (e) {
                if (e.result) {
                    var ms = e.data.ctcno + " is issued to " + e.data.fullname + " dated " + e.data.dateissued;
                    Swal.fire("Notice!", ms, "warning");
                    $("#ctcissue").val(e.data.dateissued);
                    $("#ctcplace").val("Morong, Rizal");
                }
            }
        });
    }
});
jQuery.validator.addMethod("phonenu", function(value, element) {
    if (value.substr(0, 2) == "09" && value.replace('_', '').length == 13) {
        return true;
    } else {
        return false;
    };
}, "Invalid phone number");

$("#operator-form-submit").validate({
    rules: {
        "contact": {
            required: true,
            minlength: 13,
            maxlength: 13,
            phonenu: true
        },
        // "cin": {
        //     minlength: 22,
        //     maxlength: 23,
        // },
        // "drivlic": {
        //     minlength: 13,
        //     maxlength: 13,
        // },
    },
    errorElement: 'span',
    errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
    },
    highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
    }
});

$("#driver-form-submit").validate({
    rules: {
        "dcontact": {
            required: true,
            minlength: 13,
            maxlength: 13,
            phonenu: true
        },
        // "dcin": {
        //     minlength: 22,
        //     maxlength: 23,
        // },
        "ddrivlic": {
            required: true,
            minlength: 13,
            maxlength: 13,
        },
        "ddrivissue": {
            required: true,
        },
        "ddrivplace": {
            required: true,
        },
    },
    errorElement: 'span',
    errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
    },
    highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
    }
});

$("#motor-form-submit").validate({
    rules: {
        "mengine": {
            required: true,
            minlength: 10,
            maxlength: 23,
        },
        "mchassis": {
            required: true,
            minlength: 6,
            maxlength: 20,
        },
        "mplate": {
            required: true,
        },
        "mmvno": {
            required: true,
            minlength: 15,
            maxlength: 15,
        },
        "mcert": {
            required: true,
            minlength: 8,
            maxlength: 17,
        },
        "morcr": {
            required: true,
        },
        "morcrdate": {
            required: true,
        },
    },
    errorElement: 'span',
    errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
    },
    highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');

    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
    }
});

$('.numonly').on('input', function (event) { 
    this.value = this.value.replace(/[^0-9]/g, '');
});

$('.txtonly').on('input', function (event) { 
    this.value = this.value.replace(/[^a-zA-Z]/g, '');
});

$("#btn-inspection-checkall").click(function (e) {
    e.preventDefault();
    $("#inspect-headlight-switch, #inspect-signallight-switch, #inspect-stoplight-switch, #inspect-handfootbrake-switch, #inspect-lightinsidecar-switch, #inspect-trashcan-switch, #inspect-plate-switch, #inspect-drivlis-switch").prop("checked", true)
});

$("#btn-inspection-uncheckall").click(function (e) {
    e.preventDefault();
    $("#inspect-headlight-switch, #inspect-signallight-switch, #inspect-stoplight-switch, #inspect-handfootbrake-switch, #inspect-lightinsidecar-switch, #inspect-trashcan-switch, #inspect-plate-switch, #inspect-drivlis-switch").prop("checked", false)
});


//==============================================================================================================================
// Photo Operator
//==============================================================================================================================
$("#open-photo").click(function (e) {
    e.preventDefault();
    Webcam.set({
    	width: 300,
    	height: 240,
    	image_format: 'jpeg',
    	jpeg_quality: 90,
    	enable_flash: false
    });
    Webcam.attach( '#my_camera' );
    document.getElementById('results').innerHTML = ""; 
    $("#photo-modal").modal("show");
});

$("#photo-modal").on("hidden.bs.modal", function () {
    Webcam.reset();
});

$("#takesnapshot").click(function () {
    // take snapshot and get image data
	Webcam.snap( function(data_uri) {
		// display results in page
		document.getElementById('results').innerHTML = 
		    '<img src="'+data_uri+'"/>' +
			'<p>Here is your image:</p>'; 
			
		
		$("#oper-img-alt").attr("src", data_uri);
		
		$("#oper-img")[0].files[0] = data_uri;
		
// 		var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
		
		document.getElementById('hiddenimage').value = data_uri;
	});
});

$("#oper-img").change(function () {
    $("#hiddenimage").val("");
});


//==============================================================================================================================
// Photo Driver
//==============================================================================================================================
$("#open-photo-dr").click(function (e) {
    e.preventDefault();
    Webcam.set({
    	width: 300,
    	height: 240,
    	image_format: 'jpeg',
    	jpeg_quality: 90,
    	enable_flash: false
    });
    Webcam.attach( '#my_camera-dr' );
    document.getElementById('results-dr').innerHTML = ""; 
    $("#photo-dr-modal").modal("show");
});

$("#photo-dr-modal").on("hidden.bs.modal", function () {
    Webcam.reset();
});

$("#takesnapshot-dr").click(function () {
    // take snapshot and get image data
	Webcam.snap( function(data_uri) {
		// display results in page
		document.getElementById('results-dr').innerHTML = 
		    '<img src="'+data_uri+'"/>' +
			'<p>Here is your image:</p>'; 
			
		
		$("#driver-img-alt").attr("src", data_uri);
		
		$("#driver-img")[0].files[0] = data_uri;
		
		document.getElementById('drhiddenimage').value = data_uri;
	});
});

$("#driver-img").change(function () {
    $("#drhiddenimage").val("");
});
