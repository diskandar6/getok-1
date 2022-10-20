<?php
 /**
 * Description:  This file contains the following class:<br>
 * Imports class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage imports
 * @link http://www.steema.com
 */
 /**
 * Imports class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage imports
 * @link http://www.steema.com
 */

class Imports extends TeeBase
{

   private $template;
   private $xml;

    // Interceptors
    function __get( $property ) {
      $method ="get{$property}";
      if ( method_exists( $this, $method ) ) {
        return $this->$method();
      }
    }

    function __set ( $property,$value ) {
      $method ="set{$property}";
      if ( method_exists( $this, $method ) ) {
        return $this->$method($value);
      }
    }

   public function __construct($c)
   {
      parent::__construct($c);
   }
   
   public function __destruct()    
   {        
        parent::__destruct();       
                 
        unset($this->template);
        unset($this->xml);
   }     

   public function getTemplate()
   {
      if($this->template == null)
      {
         $this->template = new Template($this->chart);
      }

      return $this->template;
   }

   public function getXML()
   {
      if($this->xml == null)
      {
         $this->xml = new XMLImport($this->chart);
      }

      return $this->xml;
   }

}

 /**
 * Template class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage imports
 * @link http://www.steema.com
 */
class Template
{

   private $chart;
   
   function __construct ($c=null) {
      $this->chart = $c;        
   }

   public function __destruct()    
   {        
        unset($this->chart);
   }     
   
   /**
   * @return TChart Object
   */
   public function fromFile($fileName) {
       
       if (file_exists($fileName)) {              
         $str = file_get_contents($fileName);
         if ($str != false)
         {
             $newo = SerializeManager::instance()->unserializeObject($str);          
             $newo->getGraphics3D()->img = $this->chart->getGraphics3D()->img;             
             return $newo;
         }
         else
         {
             // There's not strings into the file
             echo "The Files does not contain any string to import !";             
         }
       }              
       else
       {
            // File does not exists
            echo "The File doex not exists !";
       }
   }    
    
/*   public function fromXML($fileName) /* TODO throws FileNotFoundException {
       return $this->fromXML(new BufferedInputStream(
              new FileInputStream($fileName)));
              

              return $filename;
   }
   

   public function fromXML($stream)
   {
      $decoder = new XMLDecoder($stream);

      $decoder->setExceptionListener(new ExceptionListener()
      {
         public function exceptionThrown($exception)
         {
            $exception->printStackTrace();
         }
      }
      );

      $result = null;
      try
      {
         $result = ($this->Chart)$this->decoder->readObject();
      }
      $this->finally{
      $this->decoder->close();
      }

      if(($this->chart->getParent() != null))
         (($this->com->steema->teechart->TChart)($this->chart->getParent()))->setChart($result);

      return $result;
   }
*/

/* TODO
   public function fromFile($fileName) throws FileNotFoundException,
   IOException, ClassNotFoundException{
   return fromStream(new BufferedInputStream(new FileInputStream(
   fileName)));
   }

   public function fromFile($file)throws FileNotFoundException,
   IOException, ClassNotFoundException{
   return fromFile(file . getPath());
   }

   public function fromStream($stream)throws IOException,
   ClassNotFoundException{
   ObjectInputStream in = new ObjectInputStream(stream);
   Chart result = null;
   try
   {
      result = (Chart)in . readObject();
      }finally{
      in . close();
      }
      return result;
   }
*/
}

?>