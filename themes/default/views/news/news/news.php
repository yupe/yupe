<?php $this->pageTitle = $news->title; ?>

<?php $this->renderPartial('_view', array(
                                         'data' => $news,
                                    )); ?>