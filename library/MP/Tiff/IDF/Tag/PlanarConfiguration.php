<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PlanarConfiguration
 *
 * @author petr
 */
class MP_Tiff_IDF_Tag_PlanarConfiguration extends MP_Tiff_IDF_Tag_Abstract {
    
    const CHUNKY = 1;
    const PLANNAR = 2;
    
    protected $_allowedTypes = MP_Tiff_IDF_Entry::TYPE_SHORT;
    
    protected $_allowedValues = array(
        self::CHUNKY,
        self::PLANNAR
    );
    
    protected $_tagId = 284;
    
}

?>
