

<div> 

	<div style="float: left; clear:right; width:380px;">
				<?php 
					echo CHtml::image($ruta.$inventario->codigosap.".JPG",'yu',array('id'=>'gatito','border'=>0,'width'=>200,'height'=>180));
								
								?>  
   </div>
   <div style="float: left; width:380px;">
		<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$inventario,
	'attributes'=>array(		
		//'codigo',
		//	'tipo',
		'codigosap',
		'codigoaf',
		'descripcion',
		'marca',
		'modelo',
		'serie',
		'barcoactual.nomep',		
		'fecha',
		'documento.desdocu',		
		'lugares.deslugar',
			
	),
)); ?>
   </div>
	
   
			
 </div>

