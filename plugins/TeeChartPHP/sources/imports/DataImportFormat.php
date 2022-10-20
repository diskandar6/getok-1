<?php
 /**
 * Description:  This file contains the following class:<br>
 * DataImportFormat class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage imports
 * @link http://www.steema.com
 */
 /**
 * DataImportFormat class
 *
 * Description: Chart data import
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage imports
 * @link http://www.steema.com
 */

 class DataImportFormat {

    public /*protected*/ $chart;
    protected $series;
    protected $stream;

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

    /** Creates a new instance of DataImportFormat */
    public function __construct($c=null,$s=null) {
        $this->chart = $c;
        if ($s!=null)
            $this->series = $s;
    }

    public function openFile($file)
    {
        $this->open($file);
    }

/*
    public function openFileName($fileName) /* TODO throws FileNotFoundException,
                IOException, ClassNotFoundException {
            BufferedInputStream bf=new BufferedInputStream(new FileInputStream(fileName));
            open(bf);
    }

    public function openFile($file) throws FileNotFoundException,
                        IOException, ClassNotFoundException {
            open(file.getPath());
    }

    /*override this method
    public function openStream($stream) throws IOException,
                        ClassNotFoundException {
    }                     */
}
?>
