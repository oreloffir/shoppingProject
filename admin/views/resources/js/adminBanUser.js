/**
 * Created by Orel on 6/28/2017.
 */

var adminBanUser = {
    init: function() {
        this.banBtns        = $(".banBtns");
        this.reasonsInput   = $(".reasonInputs");
        this.removeBanBtns   = $(".removeBanBtns");
        this.userId = $("#userId");
        this.bindEvent();
    },
    bindEvent: function() {
        console.log("bindEvent");
        $(this.banBtns).each(function (index, btn) {
            $(this).on("click", function (e) {
                var reason = $(adminBanUser.reasonsInput[index]).val();

                adminBanUser.banUser($(this).attr('userId') , reason);
            })
        })

        $(this.removeBanBtns).each(function () {
            $(this).on('click',function () {
                adminBanUser.removeBan($(this).attr('userId'));
            })
        })
    },

    banUser: function($userId, $reason) {
        var userId = $userId;
        var dataString = "userId="+userId+"&reason="+$reason;
        console.log(dataString);
        $.ajax({
            url: "./ajax/banUserAjax.php",
            type: "POST",
            data: dataString,
            dataType: "json",
            success: function(callback){
                console.log("callback = "+ callback);
            }
        });
    },
    removeBan: function($userId) {
        var userId = $userId;
        var dataString = "userId="+userId;
        console.log(dataString);
        $.ajax({
            url: "./ajax/removeBanAjax.php",
            type: "POST",
            data: dataString,
            dataType: "json",
            success: function(callback){
                console.log("callback = "+ callback);
            }
        });
    }

}