
<?php

    
    function writeValue($hub, $key, $value){
    
        $ManubPath = './manubs';
        $ManubEveryObj = ':^^:';
        $ManubEverySets = ':*:';
        $ManubThisPath = "${ManubPath}/${hub}.mub";
        $WriteCon = "${key}${ManubEverySets}${value}${ManubEveryObj}";
        if (is_readable($ManubThisPath) == false) {
            fclose($hubObject);
            return 'write.Readable.Hub';
        }
        
        $hubObject = fopen($ManubThisPath, "r") or die('write.FOPEN.Hub');
        $hubContent = fread($hubObject,filesize($ManubThisPath));
        if (strpos($hubContent,$key) != false){
            fclose($hubObject);
            return 'write.Key.Exist';
        }
        
        $WriteCons = "${hubContent}${WriteCon}";
        $hubObject = fopen($ManubThisPath, "w") or die('write.FOPEN.Hub');
        fwrite($hubObject, $WriteCons) or die('write.FWRITE.Key');
        fclose($hubObject);
        return 'OK';
    
    }
    
    function writeHub($hub){
        
        $ManubPath = './manubs';
        $ManubThisPath = "${ManubPath}/${hub}.mub";
        $ManubEveryObj = ':^^:';
        $ManubEverySets = ':*:';
        $WriteCon = "hubName.Sys${ManubEverySets}${hub}${ManubEveryObj}";
        if (is_readable($ManubThisPath)) {
            fclose($hubObject);
            return 'write.Hub.Exist';
        }
        $hubObject = fopen($ManubThisPath, "w") or die('write.FOPEN.Hub');
        fwrite($hubObject, $WriteCon) or die('write.FWRITE.Inti.Hub');
        fclose($hubObject);
        return 'OK';
        
    }
    
    function read($hub, $key){
        
        $ManubPath = './manubs';
        $ManubEveryObj = ':^^:';
        $ManubEverySets = ':*:';
        $ManubThisPath = "${ManubPath}/${hub}.mub";
        $WriteCon = "${key}${ManubEverySets}${value}${ManubEveryObj}";
        if (is_readable($ManubThisPath) == false) {
            fclose($hubObject);
            return 'write.Readable.Hub';
        }
        
        $hubObject = fopen($ManubThisPath, "r") or die('write.FOPEN.Hub');
        $hubContent = fread($hubObject,filesize($ManubThisPath));
        if (strpos($hubContent,$key) != false){
            fclose($hubObject);
            return 'write.Key.NoExist';
        }
        
        $everyObj = explode($ManubEveryObj,$hubContent);
        foreach ($everyObj as $Everyset) {
            $everySets = explode($ManubEverySets,$Everyset);
            if ($everySets['0'] == $key){
                fclose($hubObject);
                return $everySets['1'];
                break;
            }
            fclose($hubObject);
            return 'read.Key.Notfound';
        }
        
    }
    
?>
