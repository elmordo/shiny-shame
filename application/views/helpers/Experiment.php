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
class Zend_View_Helper_Experiment extends Zend_View_Helper_Abstract {
    
    /**
     * pokud neni experiment zadan, vraci instanci
     * v opacnem pripade vypise stabulku s informacemi o experimentu
     * 
     * @param Application_Model_Row_Experiment $experiment radek nebo informace o experimentu
     * @param array $config konfiguracni pole
     * @return \Zend_View_Helper_Experiment|string
     */
    public function experiment($experiment = null, array $config = array()) {
        if (is_null($experiment)) {
            return $this;
        }
        
        /* @var $tableHelper MP_View_Helper_TableLayout */
        $tableHelper = $this->view->tableLayout();
        
        $createdAt = str_replace(" ", " at ", str_replace("-", "/", $experiment->created_at));
        
        $rows = array(
            $tableHelper->row(array("Name", $experiment->name)),
            $tableHelper->row(array("Created at", $createdAt)),
            $tableHelper->row(array("User name", $experiment->username)),
            $tableHelper->row(array("Microscope", $experiment->microscope_name)),
            $tableHelper->row(array("Begins at", $experiment->begins ? $experiment->begins : "-")),
            $tableHelper->row(array("Ends at", $experiment->ends ? $experiment->ends : "-"))
        );
        
        $table = sprintf("<table class='info-table'>%s</table>", implode("", $rows));
        
        $comment = $this->view->comment($experiment->comment_html);
        
        return $table . $comment;
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
    
    /**
     * vygeneruje radek pro tabulku experimentu
     * 
     * @param Application_Model_Row_Experiment $experiment
     * @return string
     */
    public function tableRow($experiment) {
        $pattern = "<tr>
<td>%s</td>
<td>%s</td>
<td>%s</td>
<td>%s</td>
<td>%s</td>
</tr>";
        
        // vyhodnoceni akci
        $actions = array();
        
        if ($experiment->checkAccess(MP_Db_Table_Row_DataAccess::ACCESS_READ)) {
            $actions[] = sprintf("<a href='%s'>%s</a>", $this->view->url($experiment->toArray(), "get-experiment"), "Show");
        }
        
        if ($experiment->checkAccess(MP_Db_Table_Row_DataAccess::ACCESS_WRITE)) {
            $actions[] = sprintf("<a href='%s'>%s</a>", $this->view->url($experiment->toArray(), "edit-experiment"), "Edit");
        }
        
        return sprintf($pattern, $experiment->name,
                    $experiment->username,
                    $experiment->microscope_name,
                    $this->view->sqlDateTime($experiment->created_at),
                    implode(" ", $actions));
    }

    public function table($experiments, array $config = array()) {
        $header = $this->tableHeader($config);
        
        $rows = array();
        
        
        
        foreach ($experiments as $experiment) {
            $rows[] = $this->tableRow($experiment);
        }
        
        $retVal = sprintf("<table>%s<tbody>%s</tbody></table>", $header, implode("", $rows));
        
        return $retVal;
    }
}

?>
