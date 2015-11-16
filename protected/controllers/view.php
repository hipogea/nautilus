<?php
/* @var $this ControlActivosController */
/* @var $model ControlActivos */

$this->breadcrumbs=array(
	'Control Activoses'=>array('index'),
	$model->idformato,
);

$this->menu=array(
	array('label'=>'List ControlActivos', 'url'=>array('index')),
	array('label'=>'Create ControlActivos', 'url'=>array('create')),
	array('label'=>'Update ControlActivos', 'url'=>array('update', 'id'=>$model->idformato)),
	array('label'=>'Delete ControlActivos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idformato),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ControlActivos', 'url'=>array('admin')),
);
?>

<h1>View ControlActivos #<?php echo $model->idformato; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idactivo',
		'tipo',
		'guiaremision',
		'numerofactura',
		'fecha',
		'idemplazamientoactual',
		'idemplazamientoanterior',
		'codobraencurso',
		'ccanterior',
		'ccactual',
		'comentario',
		'numformato',
		'idformato',
		'codestado',
		'almacen',
		'valesalida',
		'ocompra',
		'creadopor',
		'creadoel',
		'modificadopor',
		'modificadoel',
		'coddocu',
		'codepanterior',
		'codep',
		'codlugaranterior',
		'codlugarnuevo',
		'codcentro',
		'solicitante',
		'documento',
		'numeroref',
	),
)); ?>
