/**
 * Created by Orel on 6/29/2017.
 */

var adminReport = {
    init: function() {
        this.removeReportsBtns   = $(".removeReportsBtns");
        this.bindEvent();
        console.log("Init!");
    },
    bindEvent: function() {
        console.log("Bind!");
        $(this.removeReportsBtns).each(function () {
            $(this).on('click',function () {
                console.log("click!");
                adminReport.removeReport($(this).attr('reportId'));
            })
        })
    },

    removeReport: function($reportId) {
        var reportId = $reportId;
        var dataString = "reportId="+reportId;
        console.log(dataString);
        $.ajax({
            url: "./ajax/removeReportAjax.php",
            type: "POST",
            data: dataString,
            dataType: "json",
            success: function(callback){
                if(callback) {
                    console.log("Report has removed!");
                    $("#reportId" + reportId).remove();
                }
                else
                    console.log("Fail!");
            }
        });
    }

}