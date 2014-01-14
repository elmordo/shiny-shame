<?php
class Application_Model_Frames extends MP_Db_Table {
	
	protected $_name = "frames";
	
	protected $_primary = array("frame_id");
	
	protected $_sequence = true;
	
	protected $_referenceMap = array(
			"experiment" => array(
					"columns" => "experiment_id",
					"refTableClass" => "Application_Model_Experiments",
					"refColumns" => "experiment_id"
					)
			);
			
	protected $_rowClass = "Application_Model_Row_Frame";
	
    /**
     * najde snimek podle hodnot, jejich kombinace by mela byt unikatni
     * 
     * @param int $experimentId identifikacni cislo experimentu
     * @param string $tag kolekce, do ktere v zakladu spada
     * @param int $ord poradi snimku
     * @return Application_Model_Row_Frame
     */
    public function findByInfo($experimentId, $tag, $ord) {
        return $this->fetchRow(array(
            "experiment_id = ?" => $experimentId,
            "tag like ?" => $tag,
            "ord = ?" => $ord
        ));
    }
}
