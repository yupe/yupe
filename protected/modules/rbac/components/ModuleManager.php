<?php

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
    public function filterMenuVisibilityByUserRoles($menu)
    {
        foreach ($menu as $key => $item) {
            $visible = true;
            if (isset($item['url']) && is_array($item['url'])) {
                $route = $item['url'][0];
                $role = $this->getRoleByRoute($route);
                if (!isset($menu[$key]['visible'])) {
                    $menu[$key]['visible'] = Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess(
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

    public function getModules($navigationOnly = false, $disableModule = false)
    {
        $modules = parent::getModules($navigationOnly, $disableModule);

        $modules['modulesNavigation'] = $this->filterMenuVisibilityByUserRoles($modules['modulesNavigation']);

        return $modules;
    }
} 