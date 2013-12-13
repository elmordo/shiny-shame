<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Experiment
 *
 * @author petr
 */
class Zend_View_Helper_Experiment {
    
    public function experiment($experiment = null) {
        if (is_null($experiment)) {
            return $this;
        }
    }
    
    public function tableHeader(array $config = array()) {
        
        $retVal = "<thead>
<tr>
    <th>
    Name
    </th>
    <th>
    User name
    </th>
    <th>
    Microscope
    </th>
    <th>
    Created
    </th>
    <th>
    Actions
    </th>
</tr>
</thead>";
        
        return $retVal;
    }

    public function table($experiments, array $config = array()) {
        $header = $this->tableHeader($config);
        
        $retVal = sprintf("<table>%s</table>", $header);
        
        return $retVal;
    }
}

?>
