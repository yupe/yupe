<?php

/**
 * Class ModuleManager
 */
class ModuleManager extends \yupe\components\ModuleManager
{
    /**
     * Функция преобразует роут в предполагаемое название правила.
     * Поэтому для правильной автоматической фильтрации стоит придерживаться правила в именовании
     * правил в виде Module.ControllerBackend.Action
     *
     * @param $route - строка в формате user/userBackend/create
     * @return string - строка в формате User.UserBackend.Create
     */
    private function getRoleByRoute($route)
    {
        $route = trim($route, '/');
        $routeArray = preg_split('/\//', $route, -1, PREG_SPLIT_NO_EMPTY);
        $routeArray = array_map(
            function ($x) {
                return ucfirst($x);
            },
            $routeArray
        );

        return join('.', $routeArray);
    }

    /**
     * Обходит дерево меню и вычисляет доступность элемента для пользователя.
     * Если параметр visible уже установлен, то проверка не осуществляется.
     *
     * @param $menu array - Меню
     * @return array - Меню с проставленным атрибутом visible
     */
    public function filterMenuVisibilityByUserRoles(array $menu)
    {
        foreach ($menu as $key => $item) {
            $visible = true;
            if (isset($item['url']) && is_array($item['url'])) {
                $route = $item['url'][0];
                $role = $this->getRoleByRoute($route);
                if (!isset($menu[$key]['visible'])) {
                    $menu[$key]['visible'] = Yii::app()->getUser()->checkAccess(AuthItem::ROLE_ADMIN) || Yii::app(
                        )->getUser()->checkAccess(
                            $role
                        );
                }
                $visible = $menu[$key]['visible'];
            }
            if (isset($item['items']) && is_array($item['items']) && $visible) {
                $menu[$key]['items'] = $this->filterMenuVisibilityByUserRoles($menu[$key]['items']);
            }
        }

        return $menu;
    }

    public function checkModuleRights(CWebModule $module)
    {
        $items = $module->getAuthItems();

        if (empty($items) || Yii::app()->getUser()->checkAccess(AuthItem::ROLE_ADMIN)) {
            return true;
        }

        foreach ($items as $task) {
            if (Yii::app()->getUser()->checkAccess($task['name'])) {
                return true;
            }

            foreach ($task['items'] as $item) {
                if (Yii::app()->getUser()->checkAccess($item['name'])) {
                    return true;
                }
            }
        }

        return false;
    }

    public function filterModulesListByUserRoles(array $modules)
    {
        foreach ($modules as $id => $module) {
            if (!$this->checkModuleRights($module)) {
                unset($modules[$id]);
            }
        }

        return $modules;
    }

    /**
     * @param  bool $navigationOnly
     * @param  bool $disableModule
     * @return array|mixed
     */
    public function getModules($navigationOnly = false, $disableModule = false)
    {
        $modules = parent::getModules($navigationOnly, $disableModule);

        if (true === $navigationOnly) {
            return $this->filterMenuVisibilityByUserRoles($modules);
        }

        $modules['modulesNavigation'] = $this->filterMenuVisibilityByUserRoles($modules['modulesNavigation']);
        $modules['modules'] = $this->filterModulesListByUserRoles($modules['modules']);

        return $modules;
    }
}
