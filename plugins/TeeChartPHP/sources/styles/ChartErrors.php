<?php

class ChartErrors extends ChartErrorsBase
{
    private static $serialVersionUID = 1;
    private $format;

    public function __construct($AOwner=null)
    {
        parent::__construct($AOwner);
        $this->format = new ErrorsFormat($this->ISeries->getChart());
    }

    public function getFormat() { return $this->format; }
 }  
?>