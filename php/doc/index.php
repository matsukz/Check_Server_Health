<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="icon.png">
        <link href="Bootstrap5.3/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="Bootstrap5.3/js/bootstrap.min.js"></script>
        <title>サーバー稼働状況</title>
    </head>
    <body>
        <h1 class="text-center">サーバー稼働状況</h1>

        <div id="loading">
            <div class="text-center">
                <div id="Spinner" class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                  データを取得中…
            </div>
        </div>

        <div id="main" style="display: none;">
        <!-- ここにContents.phpの内容が入る -->

        <script>
            $(document).ready(function(){
                $.ajax({
                    url: "Contents.php"
                }).done(function(result){
                    $("#main").html(result).show();   
                    $("#loading").hide();
                });
            });
        </script>

    </body>
</html>
