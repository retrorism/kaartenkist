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
        $notes = get_files("notes","*.png");
        foreach($notes as $note){
            //$img = file_get_contents("notes/$note");
            rename("notes/$note","notes/".substr($note,6,strlen($note)));
        }

?>