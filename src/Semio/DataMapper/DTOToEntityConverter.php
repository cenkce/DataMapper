<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nullcappone
 * Date: 2/12/13
 * Time: 10:18 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Semio\DataMapper;

class DTOToEntityConverter extends Mapper
{
    function __construct()
    {
    }

    public function convert($vo)
    {
        return $this->assignVars($vo);
    }

    protected function getVarValue($obj, $var)
    {
        if( is_object( $obj->$var ) )
        {
            return $this->assignVars($obj->$var);
        }
        return $obj->$var;
    }

    protected function getDTOClass($vo)
    {
        return get_class($vo);
    }

    protected function getEntityClass($dtoClass)
    {
        foreach(self::$classMap as $k=>$v)
        {
            if($v == $dtoClass)
               return $k;
        }
        return null;
    }

    protected function assignVars($vo)
    {
        $dtoClass    = $this->getDTOClass($vo);
        $entityClass = $this->getEntityClass($dtoClass);

//        if(is_array($dto)){
//            $dto   = new stdClass();
//            $vars = $voClass;
//        } else {

        $entity  = new $entityClass;
        $dtoVars = $this->getClassVars($dtoClass);
//        }

        foreach($dtoVars  as $key=>$val)
        {
            if(is_array($vo->$key))
            {
                $collection = array();

                foreach($vo->$key as $item)
                {
                    $collection[] = $this->assignVars($item);
                }
                $entity->$key = $collection;
            }
            else
                $entity->$key = $this->getVarValue($vo,$key);
        }
        return $entity;
    }
}
