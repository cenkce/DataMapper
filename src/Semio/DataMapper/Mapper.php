<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nullcappone
 * Date: 3/20/13
 * Time: 5:28 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Semio\Datamapper;

/**
 * Class Mapper
 * @package Semio\Datamapper
 *
 * Example
 *  Mapper::addtoClassMap(array("Semio\\Modules\\User\\Entities\\User"=>"Semio\\Modules\\User\\Entities\\UserDTO"))
 */
class Mapper
{
    /** @var array */
    protected static $classMap = array();

    public static function toEntity($dto)
    {
        $converter = new DTOToEntityConverter();
        return $converter->convert($dto);
    }

    public static function toDTO($entity)
    {
        $converter = new EntityToDTOConverter();
        return $converter->convert($entity);
    }

    public static function arraytoObj($array, $obj)
    {
        foreach ($array as $k=> $v) {
            $obj->{$k} = $v;
        }

        return $obj;
    }

    public static function setClassMap($map)
    {
        self::$classMap = $map;
    }

    public static function addtoClassMap($map)
    {

        self::$classMap = array_merge(self::$classMap, $map);
    }

    public function convert($entity){}

    protected function assignVars($obj){}

    protected function getClassVars($class)
    {
        return get_class_vars( $class );
    }

    protected function getDTOClass($obj)
    {
        return self::$classMap[get_class($obj)];
    }

    protected function getEntityClass($dtoClass)
    {
        foreach(self::$classMap as $k=>$v)
        {
            if($v == $dtoClass)
            {
                return $k;
            }
        }
    }

    protected function getVarValue($obj, $var){}

    function __construct()
    {

    }

}
