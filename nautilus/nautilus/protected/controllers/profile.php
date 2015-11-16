<?php

// $model: algo que implementa a ICrugeStoredUser,
?>
<div class="division">
<?php if(Yii::app()->user->hasFlash('profile-flash')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('profile-flash'); ?>
    </div>
<?php else: ?>
    <div class="wide form" id='profile-form' >
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id'=>'crugestoreduser-form',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>false,
        )); ?>
        <div class="row form-group">
            <div class='field-group'>
                <div class='col'>
                    <?php echo $form->labelEx($model,'username'); ?>
                    <?php echo $form->textField($model,'username'); ?>
                    <?php echo $form->error($model,'username'); ?>
                </div>
                <div class='col'>
                    <?php echo $form->labelEx($model,'email'); ?>
                    <?php echo $form->textField($model,'email'); ?>
                    <?php echo $form->error($model,'email'); ?>
                </div>
                <div class='col'>
                    <?php echo $form->labelEx($model,'newPassword'); ?>
                    <?php echo $form->textField($model,'newPassword',array('size'=>10)); ?>
                    <?php echo $form->error($model,'newPassword'); ?>
                    <script>
                        function fnSuccess(data){
                            $('#CrugeStoredUser_newPassword').val(data);
                        }
                        function fnError(e){
                            alert("error: "+e.responseText);
                        }
                    </script>
                    <?php echo CHtml::ajaxbutton("Generar Clave al azahar"
                        ,Yii::app()->user->ui->ajaxGenerateNewPasswordUrl
                        ,array('success'=>new CJavaScriptExpression('fnSuccess'),
                            'error'=>new CJavaScriptExpression('fnError'))
                    ); ?>
                </div>
            </div>
        </div>
        <?php
        if(count($model->getFields()) > 0){
            echo "<div class='row form-group'>";
            foreach($model->getFields() as $f){
                //if(($f->fieldname == 'picture') || ($f->fieldname == 'bigpicture')) continue;
                echo "<div class='col' id='col_{$f->fieldname}'>";
                echo Yii::app()->user->um->getLabelField($f);
                echo Yii::app()->user->um->getInputField($model,$f);
                echo $form->error($model,$f->fieldname);
                echo "</div>";
            }
            echo "</div>";
        }
        ?>
        <div class="row buttons">
            <?php Yii::app()->user->ui->tbutton("Grabar"); ?>
        </div>
        <?php echo $form->errorSummary($model); ?>
        <?php $this->endWidget(); ?>
    </div>
<?php endif; ?>
    </div>