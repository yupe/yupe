<?php
/**
 * Created by PhpStorm.
 * User: coder1
 * Date: 10.07.14
 * Time: 8:16
 */

class m000001_000001_cat_menu extends yupe\components\DbMigration {
    public function safeUp()
    {
        $this->insert(
            '{{menu_menu}}',
            array(
                'id'          => 2,
                'name'        => 'Меню категорий',
                'code'        => 'cat-menu',
                'description' => 'Меню категорий',
                'status'      => 1
            )
        );

        $items = array(
            array('parent_id', 'menu_id', 'title', 'href', 'class', 'title_attr', 'before_link', 'after_link', 'target', 'rel', 'condition_name', 'condition_denial', 'sort', 'status'),
            array(0, 2, 'Категория 1', '/shop', '', 'Категория 1', '', '', '', '', '', 0, 1, 1),
            array(0, 2, 'Категория 2', '/shop', '', 'Категория 2', '', '', '', '', '', 0, 2, 1),
            array(0, 2, 'Категория 3', '/shop', '', 'Категория 3', '', '', '', '', '', 0, 3, 1),
        ) ;

        $columns = array_shift($items);
        /**
         * Как нибудь описать процесс надо, для большей понятности
         */
        foreach ($items as $i) {
            $item = array();
            $n    = 0;

            foreach ($columns as $c)
                $item[$c] = $i[$n++];
            $this->insert(
                '{{menu_menu_item}}',
                $item
            );
        }
    }
} 