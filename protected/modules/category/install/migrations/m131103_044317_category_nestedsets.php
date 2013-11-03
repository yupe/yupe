<?php

/**
 * FileDocComment
 * Category nested set migration
 * Класс миграций для модуля Category:
 *
 * @category YupeMigration
 * @package  yupe.modules.category.install.migrations
 * @author   chemezov <michlenanosoft@gmail.com>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

class m131103_044317_category_nestedsets extends \yupe\components\DbMigration
{
	public function safeUp()
	{
		Yii::import('application.modules.category.models.Category');

		/* Добавляем необходимые колонки, дропаем foreign key для parent_id */
		$this->addColumn('{{category_category}}', 'level', 'integer DEFAULT 0');
		$this->addColumn('{{category_category}}', 'root', 'integer DEFAULT 0');
		$this->addColumn('{{category_category}}', 'lft', 'integer DEFAULT 0');
		$this->addColumn('{{category_category}}', 'rgt', 'integer DEFAULT 0');

		$this->createIndex('ix_{{category_category}}_level', '{{category_category}}', "level", false);
		$this->createIndex('ix_{{category_category}}_root', '{{category_category}}', "root", false);
		$this->createIndex('ix_{{category_category}}_lft', '{{category_category}}', "lft", false);
		$this->createIndex('ix_{{category_category}}_rgt', '{{category_category}}', "rgt", false);

		$this->dropForeignKey('fk_{{category_category}}_parent_id', '{{category_category}}');

		/* Чистим кеш, если он есть, чтобы схема БД обновилась */
		if ($cache = Yii::app()->getCache())
		{
			$cache->flush();
		}

		/* Здесь у нас будут храниться новые модели с ключом, равным id модели */
		$models = array();

		$roots = Yii::app()->db->createCommand()
			->select('*')
			->from('{{category_category}}')
			->where('parent_id IS NULL')
			->queryAll();

		$children = Yii::app()->db->createCommand()
			->select('*')
			->from('{{category_category}}')
			->where('parent_id IS NOT NULL')
			->queryAll();

		Yii::app()->db->createCommand()->truncateTable('{{category_category}}');

		/* Сначала сохраняем коренные элементы, потом циклом бегаем по дочерним и смотрим,
		 у кого родительский элемент уже в базе, сохраняем и удаляем из массива,
		 т.о. за 1 проход мы сохраняем 1 уровень дерева */

		foreach ($roots as $root)
		{
			$model = new Category();
			$model->setAttributes($root);
			$model->id = $root['id'];
			$model->saveNode(false);

			$models[$model->id] = $model;
		}

		/* Подразумевается, что цикл не зациклится, т.к. у нас был foreign key на parent_id и данные должны быть в целостности */
		while (!empty($children))
		{
			foreach ($children as $key => $child)
			{
				if (in_array($child['parent_id'], array_keys($models)))
				{
					$model = new Category();
					$model->setAttributes($child);
					$model->id = $child['id'];
					$model->appendTo($models[$child['parent_id']]);

					$models[$model->id] = $model;

					unset($children[$key]);
				}
			}
		}

		$this->dropColumn('{{category_category}}', 'parent_id');
	}

	public function safeDown()
	{
		return false;
	}
}