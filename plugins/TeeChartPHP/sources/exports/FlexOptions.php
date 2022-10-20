<?php
 /**
 * Description:  This file contains the following class:<br>
 * FlexOptions class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */
 /**
 * FlexOptions class
 *
 * Description: Flex options
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */

 
class FlexOptions {
    
    public static function CompileDeleteShow($chart, $width, $height, $tempDirectoryPath, $fileName, 
        $deleteTemp, $embedImages, $show)
    {
        $tmpName=null;
        
        $tmpDest = $tempDirectoryPath;
      
        //check if directory exist
        if (!is_dir($tmpDest))
        { 
          die('invalid folder given!'); 
        }       
        else
        {
            if (!file_exists($tmpDest))
              mkdir($tmpDest);
        }

        if (strlen($fileName)>0)           
          $tmpName = $fileName;
        
        if (($tmpName==null) || ($tmpName==""))
        {
          $tmpName = 'Chart1';
        }

        if (substr($tmpDest,strlen($tmpDest)-2,strlen($tmpDest))=='/')
        {
          $tmpDest .= '/' . $tmpName . '.mxml';
        }
        else
        {
          $tmpDest .= '/' . $tmpName . '.mxml';
        }
      
        $chart->getExport()->getImage()->getFlex()->setEmbeddedImages($embedImages);
        $chart->getExport()->getImage()->getFlex()->setWidth($width);
        $chart->getExport()->getImage()->getFlex()->setHeight($height);
        $chart->getExport()->getImage()->getFlex()->Save($tmpDest);

        
        self::Check_TeeSWC_Library($tempDirectoryPath . '/tee.swc');
        
        $tmpRes = self::Compile($chart, $tmpDest);

        if ($deleteTemp)
        {
          if (file_exists($tempDirectoryPath . '/tee.swc'))
          {
            // Deletes a file
            unlink($tempDirectoryPath . '/tee.swc');
          }

          if (file_exists($tmpDest))
          {
            unlink($tmpDest);
          }

          if ($embedImages)
          {
            $files = scandir($tempDirectoryPath);
            $arraySize = sizeof($files);
            for ($i=0;$i<$arraySize;$i++)
             if (ereg('TeeChart_Flex_Temp_', $files[$i])) 
             {
                unlink($tempDirectoryPath . "/" . $files[$i]);
             }
          }
        }

        if ($tmpRes && $show)
        {
          self::GenerateHTML($chart, $width, $height, $tempDirectoryPath, $tmpName);
          self::Preview($tempDirectoryPath . '/' . $tmpName . '.html');
        }
    }
    
    private static function Preview($target)
    {
        exec($target);
    }    
    
    private static function Check_TeeSWC_Library($teeSWC)
    {
            if (!file_exists($teeSWC))
            {
                // copy from sources directory.
                  if (!copy(dirname(__FILE__).'/tee.swc', dirname($teeSWC) . '/tee.swc'))
                      echo "Error copying the resource file tee.swc";                    
            }
            
    }
    
    private static function Compile($chart, $targetFile)
    {            
            $tmpPath = dirname($targetFile);
                       
            $WshShell = new COM("WScript.Shell");
            
            // Path of flex compiler must be added at enviroment variables            
            $str = "cmd.exe /c mxmlc.exe -use-network=false -library-path+=" . $tmpPath . 
                    '\tee.swc '. $targetFile;
            $oExec = $WshShell->Run($str, 0, true); 

            /* Run parameter as 3, true to wait until finish..
                0 Hide the window and activate another window.
                1 Activate and display the window. (restore size and position) Specify this flag 
                    when displaying a window for the first time.
                2 Activate & minimize.
                3 Activate & maximize.
                4 Restore. The active window remains active.
                5 Activate & Restore.
                6 Minimize & activate the next top-level window in the Z order.
                7 Minimize. The active window remains active.
                8 Display the window in its current state. The active window remains active.
                9 Restore & Activate. Specify this flag when restoring a minimized window.
                10 Sets the show-state based on the state of the program that started the application.  
            */

            if ($oExec == 0)
            {
                return true;
            }
            else
            {
                echo "Error, swf file has not been generated";
                return false;
            }            
    }

    // Returns an array    
    private static function Chart1_html() {
      return Array('<html>',
      '<head>',
      '<style type="text/css">',
      'html, body',
      '{',
        'height: 100%;',
        'margin: 0;',
        'padding: 0;',
       '}',
      '</style>' ,
      '</head>',
      '<body>',
          '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"',
                'id="Chart1" width="%WIDTH%" height="%HEIGHT%" menu="true"' ,
                'codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab"/>',
                '<param name="movie" value="%MOVIE%.swf"/>',
                '<param name="quality" value="high"/>',
                '<param name="menu\" value="true"/>',
                '<param name="bgcolor" value="FFFFFF"/>',
                '<param name="allowScriptAccess" value="sameDomain"/>' ,
                '<embed src="%MOVIE%.swf" width="%WIDTH%" height="%HEIGHT%"/>',
          '</object>',
      '</body>',
      '</html>'
      );
        
    }
        
    static function GenerateHTML($chart, $width, $height, $path, $movie)
    {                        
            //FileStream fs;
            //StreamWriter writer;
            $lines = self::Chart1_html();
            for ($i = 0; $i < sizeof($lines); $i++)
            {
                if (strpos($lines[$i],"%MOVIE%") > 0)
                {
                    $lines[$i] = str_replace('%MOVIE%', $movie, $lines[$i]);
                }
                if (strpos($lines[$i],"%WIDTH%") > 0)
                {
                    $lines[$i] = str_replace("%WIDTH%",$width, $lines[$i]);
                }
                if (strpos($lines[$i],"%HEIGHT%") > 0)
                {
                    $lines[$i] = str_replace("%HEIGHT%", $height, $lines[$i]);
                }
            }

            /* TODO remove fs = File.Create(path + "\\" + movie + ".html");
            writer = new StreamWriter(fs);

            try
            {
                foreach (string var in lines)
                {
                    writer.Write(var + "\r\n");
                }
            }
            finally
            {
                writer.Close();
                fs.Close();
            }
            */
            
            $fileName = $path . '/' . $movie . '.html';
            
            $fileHandle = fopen($fileName, 'w') or die("can't open file");

//            $together = implode("\n",$lines); 

//            fwrite($fileHandle, $lines);                
            foreach ($lines as $var) 
            {                
                fwrite($fileHandle, $var . "\n");                
            }
            fclose($fileHandle);            
        }
}  
?>