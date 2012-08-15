Добавить в конец файла bootstrap.css
В версии 2.1.0-wip данная функция реализуется.

/*************************************** FIX ***************************************************/
.dropdown-menu .caret {
    border-left: 4px solid black !important;
    border-right: 0 !important;
    border-top: 4px solid transparent !important;
    border-bottom: 4px solid transparent !important;
    position: absolute;
    right: 10px;
    left: auto;
}

.nav li.dropdown ul.dropdown-menu li:HOVER ul.dropdown-menu li:HOVER.dropdown > ul.dropdown-menu,
.nav li.dropdown ul.dropdown-menu li:HOVER ul.dropdown-menu {
    display:block;
    position:absolute;
    left:100%;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
}
.nav li.dropdown ul.dropdown-menu li:HOVER ul.dropdown-menu li.dropdown > ul.dropdown-menu, 
.nav li.dropdown ul.dropdown-menu ul.dropdown-menu {
    display: none;
    float:right;
    position: relative;
    top: auto;
    margin-top: -30px;
}

.nav li.dropdown ul.dropdown-menu .dropdown-menu::before {
    content: '';
    display: inline-block;
    border-top: 7px solid transparent;
    border-bottom: 7px solid transparent; 
    border-right:7px solid #CCC;
    border-right-color: rgba(0, 0, 0, 0.2);
    position: absolute;
    top: 9px;
    left: -14px;
}

.nav li.dropdown ul.dropdown-menu .dropdown-menu::after {
    content: '';
    display: inline-block;
    border-top: 6px solid transparent;
    border-bottom: 6px solid transparent; 
    border-right:6px solid white;
    position: absolute;
    top: 10px;
    left: -12px;
}

.navbar .nav .dropdown-menu .active > a {
    color: #FFF !important;
}