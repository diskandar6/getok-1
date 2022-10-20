<?php
  /**
 * Description:  This file contains the following class:<br>
 * EventListenerList class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage events
 * @link http://www.steema.com
 */
 /**
 * EventListenerList class
 *
 * Description:
 *
 * @author Steema Software SL
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage events
 * @link http://www.steema.com
 */

class EventListenerList {
     private $events;

     public function __construct()
     {
          $this->events = new ArrayObject();
     }

    public function __destruct()    
    {        
        unset($this->events);
    }       
         
     public function Add($event)
     {
          if (!$this->Contains($event))
              $this->events->Append($event);
     }

     public function Contains($event)
     {
          foreach ($this->events as $e)
          {
              if ($e->GetName() == $event)
                   return true;
          }
     }

}
?>