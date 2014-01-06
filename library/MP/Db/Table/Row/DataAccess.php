<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author petr
 */
interface MP_Db_Table_Row_DataAccess {
    
    /*
     * rozsahy planosti
     */
    const ACCESS_USER = 0;
    const ACCESS_GROUP = 3;
    const ACCESS_OTHER = 6;
    
    /*
     * offsety prav
     */
    const ACCESS_READ = 0;
    const ACCESS_WRITE = 1;
    const ACCESS_DELETE = 2;
    
    /*
     * hodnoty prav
     */
    const VALUE_READ = "r";
    const VALUE_WRITE = "w";
    const VALUE_DELETE = "d";
    const VALUE_NO = "-";
    
    /**
     * vraci id vlastnika
     * 
     * @return int;
     */
    public function getOwnerId();
    
    /**
     * vraci id skupiny, do ktere prvek nalezi
     * 
     * @return int
     */
    public function getGroupId();
}

?>
