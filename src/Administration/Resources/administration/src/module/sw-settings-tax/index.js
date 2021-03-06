import { Module } from 'src/core/shopware';

import './extension/sw-settings-index';
import './page/sw-settings-tax-list';
import './page/sw-settings-tax-detail';
import './page/sw-settings-tax-create';

Module.register('sw-settings-tax', {
    type: 'core',
    name: 'Tax settings',
    description: 'Tax section in the settings module',
    color: '#9AA8B5',
    icon: 'default-action-settings',
    entity: 'tax',

    routes: {
        index: {
            component: 'sw-settings-tax-list',
            path: 'index',
            meta: {
                parentPath: 'sw.settings.index'
            }
        },
        detail: {
            component: 'sw-settings-tax-detail',
            path: 'detail/:id',
            meta: {
                parentPath: 'sw.settings.tax.index'
            }
        },
        create: {
            component: 'sw-settings-tax-create',
            path: 'create',
            meta: {
                parentPath: 'sw.settings.tax.index'
            }
        }
    },

    navigation: [{
        label: 'sw-settings-tax.general.mainMenuItemGeneral',
        color: '#9AA8B5',
        icon: 'default-action-settings',
        path: 'sw.settings.tax.index',
        parent: 'sw-settings'
    }]
});
