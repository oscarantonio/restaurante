<div class="container">
	<div class="row">
		<div class="col-md-6">
			<?php echo $this->Form->create('Users',array('name' => 'backup', 'id' => 'users_backup', 'target' => '_blank','type' => 'post', 'url' => array('controller' => 'users', 'action' => 'dump'))); ?>
				<fieldset>
					<h2>Respaldos</h2>
				</fieldset>
				<p>
				<?php echo $this->Form->end(array('label' => 'Generar', 'class' =>'btn btn-success')); ?>
				</p>
		</div>
	</div>
</div>
