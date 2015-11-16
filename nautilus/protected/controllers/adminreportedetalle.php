<?php

$this->Widget('ext.highcharts.HighchartsWidget', array(
    'options'=>array(
        'chart'=>array(
            'type'=>'column',
                        ),
        'title'=>array('text'=>'Distribución mensual de costos',),

        'xAxis'=>array(
            'categories'=>array('01', '02', '03', '04', '05', '06', '07','09'),
           // 'categories'=>$matrices['fechas'],
            'tickmarkPlacement'=>'on',
            'title'=>array(
                'enabled'=> false,
                        ),
                    ),

        'yAxis'=>array(
                   'title'=>array(
                      'text'=> ' Valores',
                            ),
            'min'=>array(0);
             ),

            'tooltip'=>array(
                    'headerFormat'=>'<span style="font-size:10px">{point.key}</span><table>',
                    'pointFormat'=>'<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                    'footerFormat'=>'</table>',
                     'shared'=>true,
                     'useHTML'=>true
                                ),
        ),
         'plotOptions'=>array(
                'column'=>array(
                 'pointPadding'=>0.2,
                  'borderWidth'=> 0
                      )
                        ),

                    'series'=>array(
                array('name'=>'Jurel','data'=>array(502, 635, 809, 947, 1402, 3634, 5268)),
                        ),
            );


?>





