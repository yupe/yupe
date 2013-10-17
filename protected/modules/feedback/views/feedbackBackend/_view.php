<div class="list-cell">
	<div class="row-fluid">
		<div class="pull-right btn-item">
			<a class="btn btn-link hide loader"><i class="icon-repeat icon-spin"></i></a>
			<?php CHtml::$liveEvents = true; ?>
			<?php
			$this->widget(
			    'bootstrap.widgets.TbButton',
			    array(
			        'icon' => 0 == $data->is_faq ? 'question-sign' : 'check',
			        'type'        => 'link',
					'htmlOptions' => array(
						'title'        => $data->is_faq ? Yii::t('FeedbackModule.feedback', 'In FAQ') : Yii::t('FeedbackModule.feedback', 'Add this message to FAQ?'),
						'data-is_faq'  => $data->is_faq ? 0 : 1,
						'id'           => 'isFaq' . $data->id,
						'data-id'      => $data->id,
						'data-action'  => 'toggle-faq',
						'data-url'     => $this->createUrl('update', array('id' => $data->id)),
						'data-confirm' => $data->is_faq
										? Yii::t('FeedbackModule.feedback', 'Remove this message from FAQ?')
										: Yii::t('FeedbackModule.feedback', 'Add this message to FAQ?'),
						'data-params'  => Yii::app()->getRequest()->csrfTokenName
				        				. '='
				        				. Yii::app()->getRequest()->csrfToken
				        				. '&submit-type=index'
				        				. '&FeedBack[is_faq]=' . ($data->is_faq ? 0 : 1),
				        'class'        => 'btn-link',
			        ),
			        'visible'          => !empty($data->answer),
			    )
			);
			$this->widget(
			    'bootstrap.widgets.TbButton',
			    array(
			        'icon' => 'envelope',
			        'type' => 'link',
			        'htmlOptions' => array(
			        	'title'        => Yii::t('FeedbackModule.feedback', 'Reply for message'),
			            'data-id'      => $data->id,
						'data-action'  => 'answer',
						'data-return'  => true,
						'data-title'   => Yii::t('FeedbackModule.feedback', 'Reply for message'),
						'data-url'     => $this->createUrl('answer', array('id' => $data->id)),
						'data-params'  => Yii::app()->getRequest()->csrfTokenName
				        				. '='
				        				. Yii::app()->getRequest()->csrfToken,
			        ),
			        'visible'          => $data->status != FeedBack::STATUS_ANSWER_SENDED,
			    )
			);
			$this->widget(
			    'bootstrap.widgets.TbButton',
			    array(
			        'icon' => 'eye-open',
			        'type' => 'link',
			        'htmlOptions' => array(
			        	'title'        => Yii::t('FeedbackModule.feedback', 'View message'),
			            'data-id'      => $data->id,
						'data-action'  => 'show',
						'data-return'  => true,
						'data-title'   => Yii::t('FeedbackModule.feedback', 'View message'),
						'data-url'     => $this->createUrl('view', array('id' => $data->id)),
						'data-params'  => Yii::app()->getRequest()->csrfTokenName
				        				. '='
				        				. Yii::app()->getRequest()->csrfToken,
			        ),
			    )
			);
			$this->widget(
			    'bootstrap.widgets.TbButton',
			    array(
			        'icon' => 'pencil',
			        'type' => 'link',
			        'url'  => array('update', 'id' => $data->id),
			        'htmlOptions' => array(
			        	'title'          => Yii::t('FeedbackModule.feedback', 'Change message '),
			        ),
			    )
			);
			$this->widget(
			    'bootstrap.widgets.TbButton',
			    array(
					'icon'        => 'trash',
					'type'        => 'ajaxSubmit',
					'htmlOptions' => array(
						'title'       => Yii::t('FeedbackModule.feedback', 'Remove message '),
						'data-id'      => $data->id,
						'data-action'  => 'delete',
						'data-url'     => $this->createUrl('delete', array('id' => $data->id)),
						'data-confirm' => Yii::t('FeedbackModule.feedback', 'Do you really want to remove message?'),
						'data-params'  => Yii::app()->getRequest()->csrfTokenName
				        				. '='
				        				. Yii::app()->getRequest()->csrfToken,
				        'class'   => 'btn-link',
			        ),
			    )
			); ?>
		</div>
		<div class="message-info">
			<span class="pull-left right-margin">
				# <?php echo $data->id; ?>
			</span>
			<span class="pull-left label label-<?php echo $data->getStatusClass(); ?>">
				<?php echo $data->getStatus(); ?>
			</span>
			&nbsp;| <?php echo '<i class="icon-time"></i> ' . Yii::app()->getDateFormatter()->format('yyyy-MM-dd H:mm', $data->creation_date); ?>		
			| <?php echo '<i class="icon-user"></i> ' . $data->name . ' &laquo;' . $data->email . '&raquo; '; ?>
		</div>
		<div class="text-item">
			<?php echo $data->getText(300); ?>
		</div>
	</div>
</div>