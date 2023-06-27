<?php

namespace App\Console\Factory;

use App\Console\Importers\CoreAppStudentsImporter;
use App\Console\Importers\CoreAppStudentsImporterSirius;

class ImporterFactory
{

    /**
     * returns the importer with the established database
     *
     * @throws \Exception
     */
    public function getConfigs($name)
   {
       if (empty($name))
           $name = $this->getSGNameDefault();

       switch ($name) {
           case config('globalConnection.sirius.name'):
               return new CoreAppStudentsImporterSirius($name);

           case config('globalConnection.unic.name'):
           case config('globalConnection.unincol.name'):
           case config('globalConnection.guiaa.name'):
               return new CoreAppStudentsImporter($name);
           default:
               throw new \Exception('System name not found');

       }
   }

    /**
     * return Sg Name Default --> sirius
     *
     * @return string
     */
   public function getSGNameDefault()
   {
       return 'sirius';
   }

}
