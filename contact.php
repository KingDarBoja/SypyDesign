<?php require_once( 'header.php'); ?>
<section id="contacto-form">
  <div class="tit-p fondo-azul">
		<div class="row">
			<div class="column">
				<h3>Contactanos</h3>
			</div>
		</div>
	</div>
  <div class="row contenido">
    <div class="small-12 column contact">
			<form id="contact-form" data-abide="ajax" action="../mail.php" method="post">
				<div class="contactForm">
					<div class="name-field">
						<label>Nombre (Requerido)</label>
						<input name="name" id="name" type="text" placeholder="Nombre" required>
						<span class="form-error">¡Tu nombre es requerido!</span>
					</div>
					<div class="email-field">
						<label>Correo electrónico (Requerido)</label>
						<input name="email" id="email" type="email" placeholder="@email.com" required>
						<span class="form-error">¡Tu dirección de correo es requerida!</span>
					</div>
					<div class="subject-field">
						<label>Titulo (Requerido)</label>
						<input name="subject" id="subject" type="text" placeholder="Sujeto" required>
						<span class="form-error">¡Debes agregar un titulo!</span>
					</div>
					<div class="text-field">
						<label>Mensaje (Requerido)</label>
						<textarea name="message" id="message" placeholder="Escribe tu mensaje" rows="8" cols="80" required></textarea>
						<span class="form-error">¡Mensaje requerido!</span>
					</div>
					<input id="submit" name="submit" type="submit" value="Enviar" class="button">
				</div>
			</form>
    </div>
  </div>
</section>
<?php require_once( 'footer.php'); ?>
