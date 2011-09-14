<?php
class CommentController extends YFrontController
{
	 public function actions()
     {
	    return array(
			'add' => array(
				'class' => 'application.modules.comment.controllers.AddCommentAction'
			)
		);
	 }
}
?>