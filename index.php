<?php
        function get_files( $folder, $pattern ) {
            $userdir = $folder;
            $filename_array = array();

            if ($pattern == ""){
                $pattern = "*";
            }
            $news_content = "";
            if (is_dir($userdir)){
                if ($dh = opendir($userdir)){
                    while (($filename = readdir($dh)) !== false){
                        if (fnmatch($pattern, $filename)){
                            array_push ($filename_array, $filename);
                        }
                    }
                    closedir($dh);
                }
            }
            return $filename_array;
        }
?>
<!DOCTYPE html>
<html>  
  <head>
    <title>Kaartenkist</title>
    <script type="text/javascript" src="jquery-1.10.2.js"></script>
    <script type="text/javascript" src="jquery-ui-1.10.4.js"></script>
    <style>
    html{height: 100%;}
    body{font-family: auto1;}
    strong{font-family: auto1bold;}
    h1{text-transform: uppercase;}
    
    .box {
    background: transparent;
    width:128px;
    height:170px;
    position:absolute;
    }
    .box:hover{
    background-color: rgba(255,255,255,0.8);
    box-shadow: 0 0 3px rgba(0,0,0,0.4);
    }
    .box-small {
    background: transparent;
    width:128px;
    height: 171px;
    float: left;
    }
    .box-small:hover{
    background: rgba(255,255,255,0.8);
    box-shadow: 0 0 3px rgba(0,0,0,0.4);
    }
    .new{background: #f00;}
    
    #container {
        position: relative;
        width:97%;
        height:95%;
        left: 1.5%;
        background: whitesmoke url('notes/overige/notenbalk.png') repeat;
    }
    
    #bladmuziek {
        position: absolute;
        width: 80%;
        height: 100%;
        background: whitesmoke;
        left: 10%;
        box-shadow: 0px 1px 15px rgba(0,0,0,0.3);
    }
    #noten {
        position: absolute;
        
        background: url('bg.jpg');
        clear: both;
        width: 80%;
        left: 10%;
        top: 65%;
    }
    #wrap{
        position: absolute;
        width: 100%;
        height: 58%;
        top: 5%;
    }
    #items{
        margin-top: 12px;
        width: 98%;
    }
    #kwarten, #achtsten, #akkoorden, #rusten, #overige{
        background: whitesmoke;
        position: relative;
        top: 0px;
        left: 15px;
        padding: 15px;
        height: 161px;
        overflow: auto;
        overflow-x: auto;
        border-radius: 5px;
    }
    #achtsten, #akkoorden, #rusten, #overige{
        display: none;
    }
    #knoppen{
        position: relative;
        background: white;
        float: left;
        left: 0px;
        padding-top: 5px;
        width: 30px;
    }
    #knoppen img{
        width: 30px;
        margin: 0px 0px 0px 5px;
        background: #ddd;
        border-radius: 10px;
        border-top: solid 1px #352215;
        border-left: solid 1px #352215;
        border-bottom: solid 1px #352215;
        cursor: pointer;
    }
    #knoppen img.active{
        background: white;
    }
    #notenbalk{
        position: absolute;
        right: 10%;
        height: 30px;
        padding: 0px 10px;
        background: whitesmoke;
        border: solid 1px #777;
        border-radius: 5px;
        cursor: pointer;
    }
    h1{
        width: 16%;
        margin: 0 auto;
    }
    </style>
    <!--
    background:whitesmoke url('https://s3.amazonaws.com/com.appgrinders.test/images/grid_20.png') repeat;
    -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('*').disableSelection();

            var maxZ = $("*").length+1;
            
            $("#notenbalk").click(function(){
                if($(this).attr("alt") == "on"){
                    $("#container").css("background","transparent");
                    $(this).attr("alt","off");
                } else {
                    
                    $("#container").css("background","whitesmoke url('notes/overige/notenbalk.png') repeat");
                    $(this).attr("alt","on");
                }
            });
            
            
            $('.box-small').each(function(){
                $(this).css("background-size","100% 100%");
                var imgsrc = $(this).attr("alt");
                var imgtitle = $(this).attr("title");
                $(this).click(function(){
                    var xpos = $("#container div").length;
                    $('<div/>', {
                        class: 'box new',
                        alt: imgsrc
                        }).css("background","url('"+imgsrc+"')").html("<span>"+imgtitle+"</span>").css({top: 0, left: xpos*128, position: 'absolute'}).on('mouseover',function(){
                            $(this).children().css("opacity","1");
                        }).on('mouseout',function(){
                            $(this).children().css("opacity","0");
                        }).on('dblclick',function(){
                            $(this).remove();
                        }).on('click',function(){
                            maxZ++;
                            $(this).css("zIndex",maxZ);
                        }).draggable({grid: [21,21]}).appendTo("#container");
                });
            });
            
            $('#knoppen img').each(function(){
                $(this).click(function() {
                    $('#kwarten, #achtsten, #akkoorden, #rusten, #overige').hide();
                    $('#knoppen img').removeClass("active");
                    $(this).addClass('active');
                    var item = $(this).attr("alt");
                    
                    $('#' + $(this).attr("alt")).show();
                });
            });

            /*
            // Custom grid
            $('#box-3').draggable({
                drag: function( event, ui ) {
                    var snapTolerance = $(this).draggable('option', 'snapTolerance');
                    var topRemainder = ui.position.top % 20;
                    var leftRemainder = ui.position.left % 20;
                    
                    if (topRemainder <= snapTolerance) {
                        ui.position.top = ui.position.top - topRemainder;
                    }
                    
                    if (leftRemainder <= snapTolerance) {
                        ui.position.left = ui.position.left - leftRemainder;
                    }
                }  
            });
            */
        });
    </script>
  </head>
  <body>
    <div id="hoofdknoppen">
        <img src="notes/overige/notenbalk.png" id="notenbalk" alt="on"/>
    </div>
    <div id="wrap">
        <div id="bladmuziek">
            <div id="container">
            </div>
        </div>
    </div>
    <div id="noten">
        <div id="knoppen">
            <img id="kwart" alt="kwarten" class="active" src="notes/kwarten/00-C.png"/>
            <img id="achtst" alt="achtsten" src="notes/achtsten/bw-C-1x8.png"/>
            <img id="akkoord" alt="akkoorden" src="notes/akkoorden/bw-C-maj.png"/>
            <img id="rust" alt="rusten" src="notes/rusten/rust-kwart.png"/>
            <img id="overig" alt="overige" src="notes/overige/noot-64.png"/>
        </div>
        <div id="items">
            
                <?php
                function parse_notes( $dir ){
                    echo "<div id=\"$dir\">";
                    $notes = get_files("notes/$dir","*.png");
                    sort($notes);
                    foreach($notes as $note){
                        $note_desc = str_replace($note,"-"," ");
                        $note_desc = substr(strstr($note,"-"),1,-4);
                        echo "<div class=\"box-small\" alt=\"notes/$dir/$note\" title=\"$note_desc\" style=\"background: url('notes/$dir/$note');\"><span>$note_desc</span></div>\n";
                    }
                    echo "</div>";
                }
                $notes_array = array("kwarten","achtsten","akkoorden","rusten","overige");
                foreach($notes_array as $note_dir){
                    parse_notes($note_dir);
                }
                ?>
            
        </div>
    </div>
  </body>
</html>