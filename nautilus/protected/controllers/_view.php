<?php
/* @var $this ControlActivosController */
/* @var $data ControlActivos */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idformato')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idformato), array('view', 'id'=>$data->idformato)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idactivo')); ?>:</b>
	<?php echo CHtml::encode($data->idactivo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo')); ?>:</b>
	<?php echo CHtml::encode($data->tipo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('guiaremision')); ?>:</b>
	<?php echo CHtml::encode($data->guiaremision); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('numerofactura')); ?>:</b>
	<?php echo CHtml::encode($data->numerofactura); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idemplazamientoactual')); ?>:</b>
	<?php echo CHtml::encode($data->idemplazamientoactual); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('idemplazamientoanterior')); ?>:</b>
	<?php echo CHtml::encode($data->idemplazamientoanterior); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codobraencurso')); ?>:</b>
	<?php echo CHtml::encode($data->codobraencurso); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ccanterior')); ?>:</b>
	<?php echo CHtml::encode($data->ccanterior); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ccactual')); ?>:</b>
	<?php echo CHtml::encode($data->ccactual); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comentario')); ?>:</b>
	<?php echo CHtml::encode($data->comentario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('numformato')); ?>:</b>
	<?php echo CHtml::encode($data->numformato); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codestado')); ?>:</b>
	<?php echo CHtml::encode($data->codestado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('almacen')); ?>:</b>
	<?php echo CHtml::encode($data->almacen); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valesalida')); ?>:</b>
	<?php echo CHtml::encode($data->valesalida); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ocompra')); ?>:</b>
	<?php echo CHtml::encode($data->ocompra); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creadopor')); ?>:</b>
	<?php echo CHtml::encode($data->creadopor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creadoel')); ?>:</b>
	<?php echo CHtml::encode($data->creadoel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modificadopor')); ?>:</b>
	<?php echo CHtml::encode($data->modificadopor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modificadoel')); ?>:</b>
	<?php echo CHtml::encode($data->modificadoel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('coddocu')); ?>:</b>
	<?php echo CHtml::encode($data->coddocu); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codepanterior')); ?>:</b>
	<?php echo CHtml::encode($data->codepanterior); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codep')); ?>:</b>
	<?php echo CHtml::encode($data->codep); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codlugaranterior')); ?>:</b>
	<?php echo CHtml::encode($data->codlugaranterior); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codlugarnuevo')); ?>:</b>
	<?php echo CHtml::encode($data->codlugarnuevo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codcentro')); ?>:</b>
	<?php echo CHtml::encode($data->codcentro); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('solicitante')); ?>:</b>
	<?php echo CHtml::encode($data->solicitante); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('documento')); ?>:</b>
	<?php echo CHtml::encode($data->documento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('numeroref')); ?>:</b>
	<?php echo CHtml::encode($data->numeroref); ?>
	<br />

	*/ ?>

</div>