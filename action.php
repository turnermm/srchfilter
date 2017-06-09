<?php
/**
 * Action adding DW Edit button to page tools (useful with fckedit)
 *
 * @author    Myron Turner  <turnermm02@shaw.ca> 
 */

if (!defined('DOKU_INC')) 
{    
    die();
}

class action_plugin_srchfilter extends DokuWiki_Action_Plugin
{
    private $regex;
    function register(Doku_Event_Handler  $controller)
    {
       $controller->register_hook('SEARCH_QUERY_FULLPAGE', 'AFTER',$this,'_fullpage');   
    }
 
    function _fullpage(Doku_Event &$event, $param) {
                 
         $regex = $this->getConf('regex');
         if($regex)  {
             $rarr = explode(",",$regex);
             for($i=0;  $i<count($rarr); $i++) { 
                 $rarr[$i] = ltrim($rarr[$i]," :");
             }
            $regex = implode('|', $rarr);
         }   
     
       if(!$regex) return;    
      
        foreach($event->result as $entry=>$valu) {       
            if(preg_match('/^(' . $regex . ')/', $entry)){         
                unset($event->result[$entry]);
            }
        }
    }

}
?>