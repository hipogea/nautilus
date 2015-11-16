<?php
class Motivo extends CActiveRecord
{
    public function getMotivo()
    {
        return array(
            'P' => 'Pesca',
             'T'=> 'Travesia',
			 'A'=> 'Apoyo',
			 'M' => 'Mantenimiento',
             'R'=> 'Red',
			 'O'=> 'Otro',
			 
        );
    }
}

?>