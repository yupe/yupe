// Page.js - файл содержит все необходимые функции для работы модуля Page
var yupe;
if (!yupe)
    yupe = {};
else if (typeof yupe != 'object')
    throw new Error('yupe name exists, but is not object!');

if (!yupe.modules)
    yupe.modules = {};
else if (typeof yupe.modules != 'object')
    throw new Error('yupe.modules name exists, but is not object!');

if (yupe.modules.page)
    throw new Error('yupe.modules.page already exists!');
else
    yupe.modules.page = {
        translit: function(text) {
            alert(text);
            return text;
        }
    }