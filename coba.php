<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
        <title>random box animation with Velocity.js</title>



        <style>
            .boxy {
                width: 26px;
                height: 26px;
                display: block;
                position: absolute;
                top:30px;
                left:30px;
                background-color: "black";
            }

            .container {
                width: 100%;
                height: 100%;
            }

            body {
                text-align: center;
            }
        </style>


    </head>

    <body>
        <div class='container'>
            <div class='boxy'>A</div>


            <div class='boxy'>B</div>
            <div class='boxy'>C</div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
            <div class='boxy'></div>
        </div>
        <br><br><br><br>
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
        <script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/166569/velocity.min.js'></script>

        <script>
            var d = new Date();
            var n = d.getTime();
            var requestId;
            var animate = function() {
                $('.boxy').each(function() {
                    $(this).velocity({
                        width: "200",
                        height: "200",
                        opacity: "100",
                        top: "" + Math.floor(Math.random() * $(window).height() - 100),
                        left: "" + Math.floor(Math.random() * $(window).width() - 100),
                        backgroundColor: getRandomColor,
                    }, 500);
                });
                var i = 1;
                if(i < 2){
                    requestId = window.requestAnimationFrame(animate);
                } else {
                    window.cancelAnimationFrame(requestId);
                    requestId = undefined;
                }
                i++;
            };
            animate();

            function getRandomColor() {
                var letters = '0123456789ABCDEF'.split('');
                var color = '#';
                for (var i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }</script>

    </body>
</html>
