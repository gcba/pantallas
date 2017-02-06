<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

<?php
	$this->set('title_for_layout', 'Ingreso');
?>

<!-- USERS-LOGIN -->
	<div id="users-login" class="page-container">
		<div class="panel panel-default">

			<!-- PANEL HEADER -->
				<div class="panel-heading">
					<h1>Ingreso</h1>
				</div>

			<!-- PANEL BODY -->
				<div class="panel-body col-md-4 col-sm-12 col-xs-12">
					<?php echo $this->Form->create('User', array('inputDefaults' => array('label' => false), 'class' => 'form form-horizontal')); ?>

					<!-- CAMPOS -->
						<fieldset>
							<?php include ('fields.ctp'); ?>
						</fieldset>
					
					<!-- CAPTCHA -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div id="g-recaptcha" class="g-recaptcha"></div>
								<p id="g-recaptcha-error">Por favor, valida el captcha para continuar.</p>
							</div>
						</div>
					
					<!-- ACCIONES -->
						<div class="row login-actions">
							<div class="col-md-6 col-sm-6 col-xs-6">

								<!-- ENVIAR -->
									<?php echo $this->Form->button(
										'Ingresar',
										array(
											'type' 		=> 'submit',
											'class' 	=> 'btn btn-large btn-primary',
											'onclick' 	=> 'return (validateCaptcha() ? true : false);',
										)
									); ?>

							</div>
						</div>
					
					<?php echo $this->Form->end(); ?>
				
				</div>

		</div>
	</div>

<!-- SCRIPT RECAPTCHA -->
	<script type="text/javascript">
		var onloadCallback = function() {
			grecaptcha.render('g-recaptcha', {
				'sitekey' 	: '6LcnoQgUAAAAAHWKW6xYmfs3D_wT7SJgpc82cxnB',
				'theme' 	: 'light'
			});
		};

		var validateCaptcha = function() {
			var grecaptchaerror = document.getElementById('g-recaptcha-error');

			if(grecaptcha.getResponse() != "") {
				grecaptchaerror.style.display = "none";
				return true;
			}
			else {
				grecaptchaerror.style.display = "block";
				return false;
			}
		}
	</script>

<?php
	// if()https://www.google.com/recaptcha/api/siteverify
?>