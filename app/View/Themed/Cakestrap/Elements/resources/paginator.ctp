<!-- PAGINATOR -->
	<div class="pager">

		<!-- INFORMACIÓN SOBRE EL PAGINATOR -->
			<p>
				<small>
					<?php
						echo $this->Paginator->counter(
								array(
									'format' => __('Página {:page} de {:pages}, mostrando {:current} resultados de {:count}; empezando en {:start}, terminando en {:end}')
								)
							);
					?>
				</small>
			</p>

		<!-- PAGINACIÓN -->
			<?php if($this->Paginator->params()['pageCount'] > 1) { ?>
				<ul class="pagination">
					<?php
							echo $this->Paginator->prev('&laquo;', array('tag' => 'li', 'escape' => false), '<a>&laquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
							echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'active', 'currentTag' => 'a'));
							echo $this->Paginator->next('&raquo;', array('tag' => 'li', 'escape' => false), '<a>&raquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
					?>
				</ul>
			<?php } ?>

	</div>