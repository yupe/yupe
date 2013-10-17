<?php
class DefaultController extends yupe\components\controllers\FrontController
{
	/**
	 * By default wiki displays page with unique id = 'index'
	 */
	public function actionIndex()
	{
		$this->actionView('index');
	}

	/**
	 * Handles viewing a page
	 *
	 * @param string $uid unique id of a page
	 * @param int $rev revision number, optional
	 * @throws CHttpException if page wasn't found
	 */
	public function actionView($uid, $rev = null)
	{
		$page = WikiPage::model()->findByWikiUid($uid);
		if($page)
		{
			if($rev)
			{
				$revision = WikiPageRevision::model()->findByAttributes(array(
					'page_id' => $page->id,
					'id' => $rev,
				));

				if(!$revision)
				{
					throw new CHttpException(404);
				}

				$cacheId = $revision->getCacheKey();
			}
			else
			{
				$cacheId = $page->getCacheKey();
			}

			if(!($text = Yii::app()->cache->get($cacheId)))
			{
				if($rev)
				{
					$text = $revision->content;
				}
				else
				{
					$text = $page->content;
				}

				/** @var $markupProcessors AbstractMarkup[] */
				$markupProcessors = $this->getModule()->getMarkupProcessors();
				foreach($markupProcessors as $markupProcessor)
				{
					$text = $markupProcessor->process($text);
				}

				$text = $this->replaceWikiLinks($text);

				Yii::app()->cache->set($cacheId, $text);
			}

			$text = trim($text);
			if(empty($text))
			{
				$this->render('no_page',array(
					'uid' => $uid,
				));
			}
			else
			{
				$this->render('view', array(
					'page' => $page,
					'text' => $text,
				));
			}
		}
		else
		{
			$this->render('no_page',array(
				'uid' => $uid,
			));
		}
	}

	/**
	 * Handles page edit
	 *
	 * @param string $uid
	 */
	public function actionEdit($uid)
	{
		$page = WikiPage::model()->findByWikiUid($uid);
		$comment = '';
		if(!$page)
		{
			$page = new WikiPage();
			$comment = Yii::t('WikiModule.wiki', 'Created new page');
		}

		$page->setWikiUid($uid);

		if(Yii::app()->getRequest()->getPost('WikiPage'))
		{
			$comment = Yii::app()->getRequest()->getPost('comment', '');
			$page->setAttributes(Yii::app()->getRequest()->getPost('WikiPage'));

			/** @var $auth IWikiAuth */
			$auth = $this->getModule()->getAuth();
			if(!$auth->isGuest())
			{
				$page->user_id = $auth->getUserId();
			}

			$trans = $page->dbConnection->beginTransaction();

			$justCreated = false;
			if($page->isNewRecord)
			{
				$justCreated = true;
				$page->save();
			}

			$revId = $this->addPageRevision($page, $comment);
			if($revId)
			{
				$page->revision_id = $revId;
				if($page->save())
				{
					if($this->updateWikiLinks($page, $justCreated))
					{
						$trans->commit();
						Yii::app()->cache->delete($page->getCacheKey());
						$this->deleteLinksourceCache($page);
						$this->redirect(array('view', 'uid' => $uid));
					}
				}
			}
		}

		$this->render('edit', array(
			'page' => $page,
			'comment' => $comment,
		));
	}

	/**
	 * Adds new page revision
	 *
	 * @param WikiPage $page
	 * @param string $comment
	 * @return bool|int revision id or false if failed to save revision
	 */
	private function addPageRevision(WikiPage $page, $comment)
	{
		$revision = new WikiPageRevision();
		$revision->comment = $comment;
		$revision->content = $page->content;
		$revision->page_id = $page->id;

		/** @var $auth IWikiAuth */
		$auth = $this->getModule()->getAuth();
		if(!$auth->isGuest())
		{
			$revision->user_id = $auth->getUserId();
		}

		if($revision->save())
		{
			return $revision->id;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Shows page revision history
	 *
	 * @param string $uid unique id of a page
	 * @throws CHttpException if there is no page with uid provided
	 */
	public function actionHistory($uid)
	{
		$page = WikiPage::model()->findByWikiUid($uid);
		if(!$page)
		{
			throw new CHttpException(404);
		}

		if(!empty($_POST))
		{
			$revs = array_keys($_POST);
			$revs = array_filter($revs, create_function('$var', 'return $var[0]=="r";'));
			sort($revs);

			if(count($revs)>=2)
			{
				$r1 = mb_substr($revs[0], 1, mb_strlen($revs[0]), Yii::app()->charset);
				$r2 = mb_substr($revs[1], 1, mb_strlen($revs[1]), Yii::app()->charset);
				$this->redirect(array('diff', 'rev1' => $r1, 'rev2' => $r2, 'uid' => $uid));
			}
		}

		$revisions = WikiPageRevision::model()->findAllByAttributes(array(
			'page_id' => $page->id,
		), array('order' => 'id DESC'));

		$this->render('history', array(
			'page' => $page,
			'revisions' => $revisions,
		));
	}

	/**
	 * Displays difference between two page revisions
	 *
	 * @param string $uid unique wiki id
	 * @param string $rev1 page revision
	 * @param string $rev2 page revision
	 */
	public function actionDiff($uid, $rev1, $rev2)
	{
		$r1 = WikiPageRevision::model()->findByPk($rev1);
		if(!$r1)
		{
			throw new CHttpException(404);
		}
		$r2 = WikiPageRevision::model()->findByPk($rev2);
		if(!$r2)
		{
			throw new CHttpException(404);
		}

		$this->render('diff', array(
			'diff' => TextDiff::compare($r1->content, $r2->content),
			'r1' => $r1,
			'r2' => $r2,
			'uid' => $uid,
		));
	}

	/**
	 * This action lists all pages
	 */
	public function actionPageIndex()
	{
		$pages = WikiPage::model()->findAll(array(
			'order' => 'namespace, page_uid',
		));
		$this->render('page_index', array(
			'pages' => $pages,
		));
	}

	/**
	 * Replaces wiki-links in a text provided
	 *
	 * @param string $text
	 * @return string
	 */
	private function replaceWikiLinks($text)
	{
		$links = $this->getWikiLinks($text);
		foreach($links as $search => $link)
		{
			$htmlOptions = array();
			$wikiLink = WikiLink::model()->findByWikiUid($link['wiki_uid']);
			$htmlOptions['class'] = $wikiLink->page_to_id ? 'existing' : 'nonexisting';
			$replace = CHtml::link($link['title'], array('view', 'uid' => $link['wiki_uid']), $htmlOptions);
			$text = str_replace($search, $replace, $text);
		}

		return $text;
	}

	/**
	 * Deletes cache for all pages with links to specified one
	 *
	 * @param WikiPage $page
	 */
	private function deleteLinksourceCache(WikiPage $page)
	{
		$links = WikiLink::model()->findAllByAttributes(array(
			'wiki_uid' => $page->getWikiUid(),
		));

		if(!$links)
		{
			return;
		}

		foreach($links as $link)
		{
			$fromPage = WikiPage::model()->with('revisions')->findByPk($link->page_from_id);
			Yii::app()->cache->delete($fromPage->getCacheKey());
			foreach($fromPage->revisions as $revision)
			{
				Yii::app()->cache->delete($revision->getCacheKey());
			}
		}
	}

	/**
	 * Updates wiki-links of a page
	 *
	 * @param WikiPage $page
	 * @param bool $justCreated if page was just created
	 * @return bool
	 */
	private function updateWikiLinks(WikiPage $page, $justCreated = false)
	{
		if($justCreated)
		{
			$criteria = new CDbCriteria();
			$criteria->compare('wiki_uid', $page->getWikiUid());
			WikiLink::model()->updateAll(array('page_to_id' => $page->id), $criteria);
		}

		WikiLink::model()->deleteAllByAttributes(array(
			'page_from_id' => $page->id,
		));

		$links = $this->getWikiLinks($page->content);
		foreach($links as $link)
		{
			$wikiLink = new WikiLink();
			$wikiLink->page_from_id = $page->id;
			$wikiLink->wiki_uid = $link['wiki_uid'];
			$wikiLink->title = $link['title'];

			$linkedPage = WikiPage::model()->findByWikiUid($link['wiki_uid']);
			if($linkedPage)
			{
				$wikiLink->page_to_id = $linkedPage->id;
			}

			if(!$wikiLink->save())
			{
				return false;
			}
		}
		return true;
	}

	/**
	 * Gets info about all wiki-links found in text
	 *
	 * @param string $input
	 * @return array
	 */
	private function getWikiLinks($input)
	{
		$links = array();
		preg_match_all('~\[\[(.*?)\]\]~', $input, $matches);
		foreach($matches[0] as $i => $fullMatch)
		{
			$contentMatch = $matches[1][$i];
			$parts = explode('|', $contentMatch);
			$first = array_shift($parts);
			if(count($parts))
			{
				$links[$fullMatch] = array(
					'title' => implode('', $parts),
					'wiki_uid' => $first,
				);
			}
			else
			{
				$links[$fullMatch] = array(
					'title' => $first,
					'wiki_uid' => $first,
				);
			}
		}
		return $links;
	}
}