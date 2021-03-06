const searchPage = require('storefront/page-objects/search.page-object.js');

module.exports = {
    '@tags': ['homepage', 'homepage-open'],
    'logo found': (browser) => {
        browser
            .waitForElementVisible('body')
            .waitForElementVisible('.navbar')
            .assert.visible('.navbar-brand');
    },
    'search bar found': (browser) => {
        const page = searchPage(browser);

        browser
            .waitForElementVisible(page.elements.searchInput)
            .checkIfElementExists(page.elements.searchInput)
            .assert.visible(page.elements.searchInput);
    },
    after: (browser) => {
        browser.end();
    }
};