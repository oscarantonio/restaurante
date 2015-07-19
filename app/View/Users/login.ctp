	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <?php echo $this->Html->link('Restaurante', array('controller' => 'users', 'action' => 'login'), array('class' => 'navbar-brand')) ?>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <div class="container">
		<?php echo $this->Form->create('User', array('class' => 'form-signin')); ?>
		<div class="form-group">
		<?php echo $this->Form->input('username', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Usuario')); ?>
		</div>
		<div class="form-group">
		<?php echo $this->Form->input('password', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Contraseña')); ?>
		</div>
		<?php echo $this->Form->button('Acceder', array('class' => 'btn btn-lg btn-primary btn-block')); ?>
		<?php echo $this->Form->end(); ?>
    </div>
	
      <hr>

      <footer>
        <p>&copy; Restaurante Chefcito 2015</p>
      </footer>
    </div> <!-- /container -->
