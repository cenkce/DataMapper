<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nullcappone
 * Date: 2/1/13
 * Time: 12:46 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Semio\DataMapper;



class EntityToDTOConverter extends Mapper
{

    function __construct()
    {
    }

    public function convert($entity)
    {
        return $this->assignVars($entity);
    }

    protected function getVarValue($obj, $var)
    {

        if( is_object( $obj->$var ) || is_array( $obj->$var ) )
        {
            return $this->assignVars($obj->$var);
        }


        return $obj->$var;
    }

//    protected function getDTOClass($obj)
//    {
//        parent::getDTOClass($obj);
//    }
//
//    protected function getEntityClass($dtoClass)
//    {
//        parent::getEntityClass($dtoClass);
//    }


    /**
     * @param $obj
     * @return array|stdClass|void
     * @throws \Exception
     */
    protected function assignVars($obj)
    {
        try
        {
            if(is_array($obj))
            {
                foreach($obj as $item)
                {
                    $collection[] = $this->assignVars($item);
                }
                return $collection;
            }

            $voClass = $this->getDTOClass($obj);

            if(is_array($voClass))
            {
                $vo   = new stdClass();
                $vars = $voClass;
            }
            else
            {
                $class       = $this->getDTOClass($obj);
                $vo          = new $class;
                $entityCLass = $this->getEntityClass($class);
                $vars        = $this->getClassVars(get_class($vo));
            }

            foreach($vars  as $key=>$val)
            {
                $vo->$key = $this->getVarValue($obj,$key);
            }
        }
        catch(\Exception $e)
        {
            throw new \Exception("Entity variable is not assigned to variable of DTO instance.");
        }

        return $vo;
    }

}
