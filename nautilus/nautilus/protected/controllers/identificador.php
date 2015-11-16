<?php
/**
 * Created by PhpStorm.
 * User: grecia
 * Date: 21/01/2015
 * Time: 13:15
 */
 
 private function proceso($idevento,$id) {
 
   switch ($idevento) {
     case 2:
     $filas=Guia::model()->findByPk($id)->detalle;
        foreach($filas as $row ) {
            if(!is_null($row->c_codactivo)){
                  $recInventario=Inventario::recordByPlate(trim($row->c_codactivo));
                  if(!is_null( $recInventario))
                     {
                        $recInventario->setScenario();
                        $recInventario->rocoto='1';
                         $recInventario->save();
                     }
            
            }
             
        
          }
     break;
     
     
     
     }
 
 }