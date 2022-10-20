<?php

      // Put user code to initialize the page here

      if ((string) $_GET['SampleID']=="0")
      {
        session_start();
        (string) $fname = (string)$_SESSION['filename'];
        (string) $path = $fname;
        header( 'Location: '. $path );
      }
      else
      {

        (string) $DemoID = $_GET['SampleID'];
        (string) $DemoParentID = $_GET['ParentID'];

        (string) $strID ="";
        (string) $strParentID="";
        (string) $strTitle="";
        (string) $strSamplePage="";
        (string) $strSeqOrd="";
        (string) $strParentNodePath="";
        (string) $val="";

        $reader = new XMLReader();
        $reader->open("SampleList.xml");

        $reader->moveToElement();
        while($reader->read())
        {
            if($reader->hasAttributes && $reader->nodeType==XMLReader::ELEMENT)
            {
              $reader->moveToElement();
              $reader->moveToElement();
              $reader->moveToAttribute("ID");
              $strID=$reader->value;

              if ($strID == $DemoID)
              {
                while($reader->read())
                {
                  if($reader->hasAttributes && $reader->nodeType==XMLReader::ELEMENT)
                  {
                    $val=$reader->name;

                    $reader->moveToAttribute("ParentID");
                    $strParentID=$reader->value;
                    $reader->moveToAttribute("ParentNodePath");
                    $strParentNodePath=$reader->value;

                    if ($strParentID==$DemoParentID)
                    {
                      $reader->read();
                      $reader->read();
                      $reader->read();
                      $strTitle=$reader->value;
                      $reader->read();
                      $reader->read();
                      $reader->read();
                      $reader->read();
                      $strSamplePage=$reader->value;
                      $reader->read();
                      $reader->read();
                      $reader->read();
           //           $reader->read();
                      $strSeqOrd=$reader->value;

                      session_start();
                      $_SESSION['filename']=$strParentNodePath . "/" . $strSamplePage;
                      header( 'Location: '. $strParentNodePath . "/" . $strSamplePage ) ;
                      break;
                    }
                  }
                }
              }
            }
        }
      }
?>