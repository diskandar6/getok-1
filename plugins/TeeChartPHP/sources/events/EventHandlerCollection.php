<?php
  /**
 * Description:  This file contains the following class:<br>
 * EventHandlerCollection class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage events
 * @link http://www.steema.com
 */
 /**
 * EventHandlerCollection class
 *
 * Description:
 *
 * @author Steema Software SL
 * @copyright (c) 1995-2017 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage events
 * @link http://www.steema.com
 */

class EventHandlerCollection {
     private $handlers;

     public function __construct()
     {
        $this->handlers = new ArrayObject();
     }

     public function __destruct()    
    {        
        unset($this->handlers);
    }   

     public function Add($handler)
     {
         $this->handlers->Append($handler);
     }

     public function RaiseEvent($event, $sender, $args)
     {
          foreach ($this->handlers as $handler)
          {
              if ($handler->GetEventName() == $event)
                   $handler->Raise($sender, $args);
          }
     }
}
?>