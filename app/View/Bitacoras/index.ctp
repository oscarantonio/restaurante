<div class="page-header">
	<h2>Bitacoras</h2>
</div>

<div class="col-md-12">

	<table class="table table-striped">
	<thead>
	<tr>
		<th>Mensaje</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($bitacoras as $data): ?>
	<?php
		$fecha = date( 'd-m-Y h:i A', strtotime( $data['Bitacora']['created'] ) );
	?>
	<tr>
		<td><?php echo $fecha; ?>&nbsp;El&nbsp;Usuario&nbsp;<?php echo $data['Bitacora']['user']; ?>&nbsp;accede&nbsp;Modulo&nbsp;<?php echo $data['Bitacora']['controller']; ?>&nbsp;con&nbsp;la&nbsp;acci&oacute;n&nbsp;<?php echo $data['Bitacora']['actions']; ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<nav>
		<ul class="pagination">
			<li> <?php echo $this->Paginator->prev('< ' . __('previous'), array('tag' => false), null, array('class' => 'prev disabled')); ?> </li>
			<?php echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'active')); ?>
			<li> <?php echo $this->Paginator->next(__('next') . ' >', array('tag' => false), null, array('class' => 'next disabled')); ?> </li>
		</ul>
	</nav>
