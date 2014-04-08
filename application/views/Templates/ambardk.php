<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" href="favicon.ico" type="image/ico">
        <title>AM Bar</title>
        <link href='http://fonts.googleapis.com/css?family=Forum' rel='stylesheet' type='text/css'>
        <?= $this->headerqueue->flush_header_queue(); ?>
        <style>
            * { margin: 0; padding: 0; font-family: forum; font-size: 12px; color: white;}

            html { 
                background-color: black; 
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }

            body {
            }

            #header-wrapper { width: 980px; margin: 0px auto 50px; margin-bottom: 20px; padding: 20px; }

            #logo {
                font-size: 4em;
                text-align: center;
                color: white;
                text-shadow: 2px 2px black;
                margin-bottom: 5px;
            }

            #navigation hr {
                height: 0px;
                border: 2px solid #2C2828;
            }

            #navigation ul {
                text-align: center;
            }

            #navigation li {
                display: inline-block;
                margin: 5px 10px;
            }

            #navigation li a {
                font-size: 1.5em;
                color: white;
                text-decoration: none;
            }

            #navigation li a:hover {
                color: rgb(248, 237, 165);
                transition: color 0.4s ease 0s;
                -webkit-transition: color 0.4s ease 0s;
            }

            #page-wrapper { width: 960px; margin: 50px auto; margin-bottom: 20px; padding: 20px; background: white; -moz-box-shadow: 0 0 10px black; -webkit-box-shadow: 0 0 10px black; box-shadow: 0 0 10px black; }

            #content-wrapper {
                margin: 0 auto;
                width: 950px;
                margin-bottom: 50px;
                min-height: 160px;
            }

            #facebook_like, #facebook_page {
                width: 100%;
                text-align: center;
                margin-bottom: 50px;
            }

        </style>
    </head>
    <body>
        <div id="fb-root"></div>
            <script>
                (function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/da_DK/all.js#xfbml=1";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            </script>


        <div id="header-wrapper">
            
            <div id="logo">
                <img src="/assets/ambardk/images/logo.png" /></div>
            <div id="navigation">
                <hr>
                    <?= (isset($menu) ? $menu : ''); ?>
                
                <hr>
            </div>
        </div>

    <div id="content-wrapper">
       <?= $main_content; ?>
    </div>
    <div id="facebook_page">
        <div class="fb-like-box" data-href="https://www.facebook.com/ambarcph?fref=ts" data-colorscheme="dark" data-show-faces="true" data-header="false" data-stream="false" data-show-border="true"></div>
    </div>
    <div id="facebook_like">
        <div class="fb-like" data-href="http://ambar.dk/" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
        
    </div>
    </body>
</html>
