<?php
/* 
 * Copyright (c) 2009, Carlos André Ferrari <[carlos@]ferrari.eti.br>; Luan Almeida <[luan@]luan.eti.br>
 * All rights reserved. 
 */

/**
 * DAO class, Conteiner for recordsets
 *
 * @version	1
 * @package	Framework
 * @author	Luan Almeida <luanlmd@gmail.com>
 */
class DAO 
{
	/**
	* Recordset conteiner
	*
	* @staticvar	array
	* @access		private
	*/
	private static $rs = array();
		

    /***Retorna o nome da tabela referente à classe atual
    * @return Retorna uma string que representa o nome da tabela.
    */
    public static function getTableName() {
      $tableName = str_replace("DAO", "", get_called_class());
      $tableName = uncamelize($tableName);
      return $tableName; 
    }	
	
	/**
	* Return a recordset if exists
	*
	* @param	string	$index	Recordset nickname
	* @return	array
	*/
	public static function getRecordset($index='default')
	{
		return (isset(self::$rs[$index]))? self::$rs[$index] : NULL; 
	}
	
	/**
	* Return all recorsets
	*
	* @return	array
	*/
	public static function &getAll(){
		return self::$rs;
	}
	
	/**
	* ADD a recordset to the conteiner and Return the recordset reference
	*
	* @param	string	$index	Recordset nickname
	* @return	array
	*/
	public static function &add($rs, $index='default')
	{
		self::$rs[$index] = $rs;
		return $rs;
	}
}
