$(document).ready(function () {
    function displayDetailz(e) {
        $("#form-operatorid").html("<b>Operator ID: </b>" + e.opcode);
        $("#form-operatorname").html(e.fullname);
        $("#form-operatoraddress").html(e.addr);
        mob = (e.mobile_no == "" ? "N/A" : e.mobile_no);
        $("#form-operatorcontact").html(mob);

        if (e.optp != "") {
          $("#form-operatorimg").attr("src", e.optp);
        }

        $("#form-driverid").html("<b>Driver ID: </b>" + e.drivercode);
        $("#form-drivername").html(e.drname);
        $("#form-driveraddress").html(e.draddr);
        $("#form-drivercontact").html(e.drcont_no);
 
        if (e.drtp != "") {
          $("#form-driverimg").attr("src", e.drtp);
        }
        state["motorid"] = e.motorpin;
        $("#form-motorid").html(e.motorpin);
        $("#form-motortoda").html(e.tbody);
        $("#form-motormake").html(e.make);
        $("#form-motorchassis").html(e.chassis);
        $("#form-motorengine").html(e.engine);
        $("#form-motorplate").html(e.plateno);
        $("#form-motorplatecolor").html(e.platecolor);
        $("#form-motorstickerexpdate").html(e.dtexprdstick);
        $("#form-franchiseexpdate").html(e.dtexprd);

        $("#form-motormtop").html(LPAD(e.franchiseno, 4));
        $("#form-lastrenew").html(e.last_renew);
        $("#form-trcode").html(e.trcode);
        $("#form-applicationtype").html(e.appl_status);
        $("#form-applicationyear").html(e.yr);
    }
    
    
    $("#dashexprdtable tbody").on("click", "#btn-expfran-view", function () {
        var d = dashexprdtable.row($(this).closest('tr')).data();
        $.ajax({
            url: "../config/includes.php?var=getdashfrandet",
            method: "POST",
            data: {trcode: d.trcode},
            dataType: "JSON",
            success: function (e) {
                displayDetailz(e);
                $('#expfran-modal').modal('show');
            }
        });
    });
    
    $.ajax({
      url: "../config/includes.php?var=gettodaoption",
      method: "POST",
      dataType: "JSON",
      success: function (e) {
        $.map(e.data, function (x) {
          $("#wait-toda").append(
            "<option value='" + x.todacode + "'>" + x.todacode + "</option>"
          );
        });
      },
    });
    
    $("#open-wlist-modal").click(function () {
        $("#waitlist-modal").modal("show");
    });

    $("#btn-wait-save").click(function (e) {
        
        $("#waitinglist-submit").submit();
    });
    
    $("#waitinglist-submit").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "../config/includes.php?var=insertwaitlist",
            method: "POST",
            data: $("#waitinglist-submit").serialize(),
            dataType: "JSON",
            success: function (e) {
                if (e.result) {
                    Swal.fire("Saved!", e.msg, "success");
                    waitinglisttable.ajax.reload();    
                    $("#waitlist-modal").modal("hide");
                } else {
                    Swal.fire("Sorry!", e.msg, "danger");
                }
                
            }
        });
    });
    
    $("#waitinglisttable tbody").on("click", "#wait-confirm", function () {
       var d = waitinglist.row($(this).closest("td")).data();
       Swal.fire({
          title: 'Notice!',
          text: "Mark this as satisfied?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                url: "../config/includes.php?var=markwaitlist",
                method: "POST",
                data: {id: d.id},
                dataType: "JSON",
                success: function (e) {
                    if (e.result) {
                        Swal.fire(
                          'Marked!',
                          (d.fullname + " has been granted opportunity to apply for franchise."),
                          'success'
                        ) 
                        waitinglisttable.ajax.reload();  
                    } else {
                        Swal.fire("Sorry!", "Something went wrong!", "danger");
                    }
                }
            });
            
          }
        });
    });
    
    $("#waitinglisttable tbody").on("click", "#wait-cancel", function () {
       var d = waitinglist.row($(this).closest("td")).data();
       Swal.fire({
          title: 'Notice!',
          text: "Mark this as cancelled?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                url: "../config/includes.php?var=cancelwaitlist",
                method: "POST",
                data: {id: d.id},
                dataType: "JSON",
                success: function (e) {
                    if (e.result) {
                        Swal.fire(
                          'Marked!',
                          (d.fullname + " cancelled his wait spot."),
                          'success'
                        ) 
                        waitinglisttable.ajax.reload();  
                    } else {
                        Swal.fire("Sorry!", "Something went wrong!", "danger");
                    }
                }
            });
            
          }
        });
    });
});