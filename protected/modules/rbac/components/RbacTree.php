<?php

/**
 * Класс для построения частично упорядоченной иерархии ролей для вывода в виджете CTreeView
 * Class RbacTree
 */
class RbacTree
{
    /**
     * @var array - правила, сгруппированыые по типам, формат array(2 => array(AuthItem1, AuthItem2), 1 => array(), 0 => array())
     */
    private $itemsGroupedByTypes = [
        AuthItem::TYPE_OPERATION => [],
        AuthItem::TYPE_TASK => [],
        AuthItem::TYPE_ROLE => [],
    ];
    /**
     * @var array - список правил в формате name => AuthItem object
     */
    private $itemsList = [];
    /**
     * @var array - связи элементов в формате itemName => array(itemName1, itemName2)
     */
    private $hierarchy = [];
    /**
     * @var array - список ролей, которые были в иерархии в качестве потомков
     */
    private $wereChildren = [];

    /**
     * @var User - пользователь, для которого строится дерево
     */
    private $user;

    /* кэш для доступности роли, формат 'name' => value */
    private $permissionList = [];

    public function __construct($user = null)
    {
        $this->user = $user ?: Yii::app()->user;
        $this->getData();
    }

    /**
     * Загрузка данных из бд и распределение их по спискам
     */
    private function getData()
    {
        $userAssign = CHtml::listData(
            AuthAssignment::model()->findAllByAttributes(['userid' => $this->user->id]),
            'itemname',
            'userid'
        );
        $authItems = AuthItem::model()->findAll(['order' => 'type DESC, description ASC']);
        foreach ((array)$authItems as $item) {
            $this->itemsGroupedByTypes[$item->type][$item->name] = $item;
            $this->itemsList[$item->name] = $item;
            // если проверять каждый элемент, то генерируется огромное количество запросов, но получается правильное дерево с отмеченными дочерними элементами
            // созможно стоит при сохранении ролей что-то придумать
            $this->permissionList[$item->name] = isset($userAssign[$item->name]); //Yii::app()->authManager->checkAccess($item->name, $this->user->id);
        }
        $authItemsChild = AuthItemChild::model()->findAll();
        foreach ((array)$authItemsChild as $item) {
            $this->hierarchy[$item->parent][] = $item->child;
            $this->wereChildren[] = $item->child;
        }
    }

    /**
     * Построение дерева, в качестве root узлов которого выступает указанный тип элементов.
     * Каждая элемент будет иметь свой корневой узел, в независимости от того был ли он включен в другой элемент.
     * @param $type int - роль - 2, задача - 1, операция - 0
     * @return array
     */
    private function getTextTree($type)
    {
        $tree = [];
        foreach ($this->itemsGroupedByTypes[$type] as $name => $item) {
            $tree[] = $this->getTextNode($name);
        }

        return $tree;
    }

    /**
     * Рекурсивно формирует узел дерева вместе с потомками
     * @param $itemName string - Название роли
     * @return array
     */
    private function getTextNode($itemName)
    {
        $children = $this->getTextItemChildren($itemName);

        return [
            'text' => $this->getTextItem($this->itemsList[$itemName]),
            'children' => $children,
        ];
    }

    /**
     * Получает список потомков роли в виде уже готовых узлов для дерева
     * @param $name - Название роли
     * @return array
     */
    private function getTextItemChildren($name)
    {
        $res = [];
        foreach ($this->hierarchy as $key => $items) {
            if ($key == $name) {
                foreach ($items as $item) {
                    $res[] = $this->getTextNode($item);
                }
            }
        }

        return $res;
    }

    /**
     * Генерирует html для вставки в качестве текста в узел CTreeView
     * @param $item AuthItem
     * @return string
     */
    private function getTextItem($item)
    {
        return CHtml::tag(
            'div',
            ['class' => 'checkbox'],
            CHtml::label(
                CHtml::checkBox(
                    'AuthItem[]',
                    $this->permissionList[$item['name']],
                    ['class' => 'auth-item', 'value' => $item['name'], 'id' => 'auth-item-'.uniqid()]
                ).$this->getItemDescription($item),
                null
            )
        );
    }

    private function getItemDescription($item)
    {
        return $item->description." ({$item->getType()} <span class='text-muted'>{$item->name}</span>)";
    }

    /**
     * Строит дерево для указанного типа элементов с учетом их упоминания в качестве потомков у других элементов.
     * Если элемент был потом для каких-то узлов, то он не будет иметь своего корневого узла.
     * @param $type
     * @return array
     */
    private function getTreeForUnusedElements($type)
    {
        $tree = [];

        // цикл идет по элементам определенной роли, которые не были упомянуты в качестве потомков
        foreach (array_diff(array_keys((array)$this->itemsGroupedByTypes[$type]), $this->wereChildren) as $name) {
            $tree[] = $this->getTextNode($name);
        }

        return $tree;
    }

    /**
     * Формирует готовое дерево для использования в CTreeView
     * @return array
     */
    public function getTreeRoles()
    {
        /* вершинами дерева будут роли, задачи и операции, несвязанные с ролями не будут учтены */
        // в этом случае каждая роль будет иметь свой root узел
        //$textRoles = $this->getTextTree(AuthItem::TYPE_ROLE);

        // а в этом роли, для которых есть родитель, будут только в родителях
        $textRoles = $this->getTreeForUnusedElements(AuthItem::TYPE_ROLE);

        // задачи/операции строятся через getTreeForUnusedElements для того, чтобы не повторять узлы в дереве, которые уже были использованы в ролях/задачах
        $textTasks = $this->getTreeForUnusedElements(AuthItem::TYPE_TASK);
        $textOperations = $this->getTreeForUnusedElements(AuthItem::TYPE_OPERATION);

        $result = array_merge($textRoles, $textTasks, $textOperations);

        return $result;
    }

    /**
     * Возвращает список в формате 'name' => 'description'
     * @param $type
     * @return array
     */
    public function getItemsList($type)
    {
        $res = [];
        foreach ($this->itemsGroupedByTypes[$type] as $name => $item) {
            $res[$name] = $this->getItemDescription($item);
        }

        return $res;
    }
}
