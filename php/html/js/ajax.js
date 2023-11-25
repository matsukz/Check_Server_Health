$(document).ready(function() {
    $.ajax({
        type: "GET",
        url: "http://192.168.0.102:5500/ping-ajax-get",

        //"id=loading"を表示
        beforeSend: function() {
            $("#loading").show();
        },

        //"id=loading"を隠す
        //"id=contact"を表示
        success: function (data) {
            $("#loading").hide();
            $("#contact").show().html(data.data);
        },

        //エラー
        error: function() {
            $("#contact").html("Error");
        }
    });
});
