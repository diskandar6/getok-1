<?php

class ErrorPoint extends CustomErrorPoint
{
    private static $serialVersionUID = 1;

    public function __construct($c=null) { parent::__construct($c);}

    public function prepareForGallery($IsEnabled)
    {
      $this->getPointer()->setHorizSize(2);
      $this->getPointer()->setVertSize(2);
      parent::prepareForGallery($IsEnabled);
    }
}  
?>